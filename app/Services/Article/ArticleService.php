<?php

declare(strict_types=1);

namespace App\Services\Article;

use App\Models\Article;
use App\Prompts\Abstract\Enums\OpenApiResultType;
use App\Prompts\GenerateArticleBasicInformationToOtherLanguagePrompt;
use App\Prompts\GenerateArticleContentPrompt;
use App\Prompts\GenerateArticleContentToOtherLanguagePrompt;
use App\Prompts\GenerateArticleDecorateTextPrompt;
use App\Services\CmsPageService;
use App\Services\Generator\GeneratorArticleService;
use App\Services\Generator\InternalUrlsGenerator;
use App\Services\Generator\TagForArticleGenerator;
use App\Services\Helper\GeneratorHelper;
use App\Services\Helper\LanguageHelper;
use App\Services\SitemapService;
use Illuminate\Support\Str;

class ArticleService
{
    public function __construct(
        private readonly CmsPageService $cmsPageService
    ){}

    /**
     * Zwraca artykuł w trybie tworzenia, jeśli istnieje, bądź go tworzy i zwraca
     * @return Article
     */
    public function getOrCreateArticleInModeCreate(): Article
    {
        $type = 'create';
        $article = Article::where('type', $type)->first();

        if($article === null) {
            $article = Article::create([
                'name' => 'Nazwa artykułu',
                'slug' => 'nowy-artykul',
                'is_published' => false,
                'json_content' => ArticleContentBuilder::getCreateContent(),
                'type' => $type,
                'view_content' => null
            ]);
        }

        return $article;
    }

    public function getOrCreateArticleInModeAiGenerate(): Article
    {
        $type = 'ai_generator';
        $article = Article::where('type', $type)->first();

        if($article === null) {
            $article = $this->createArticleInModeAiGenerate();
        }

        return $article;
    }

    public function createArticleInModeAiGenerate(): Article
    {
        return Article::create([
            'name' => 'Artykuł wygenerowany przy pomocy AI',
            'slug' => 'new-ai-article',
            'is_published' => false,
            'json_content' => ArticleContentBuilder::getCreateContent(),
            'type' => GeneratorArticleService::AI_GENERATE_TYPE,
            'view_content' => null
        ]);
    }

    public function updateKey(Article $article, string $key, string $value, bool $saveArticleOnFinish = true): ?array
    {
        $jsonContents = $article->json_content;

        $splitKey = $this->cmsPageService->splitKey($key);
        if(empty($splitKey)){
            return null;
        }

        $info = [
            'changes' => false,
            'skip' => false
        ];

        foreach ($jsonContents as &$element) {
            if ($info['skip']) {
                break;
            }

            $this->changeJson($element, $splitKey, $value, $info);
        }

        if($info['changes'] && $saveArticleOnFinish){
            $article->json_content = $jsonContents;
            $article->view_content = $this->prepareViewContentForArticle($jsonContents);

            if(!empty($article->view_content['basic_article_information_category'])){
                $article->category_id = intval($article->view_content['basic_article_information_category']);
            }
            if(!empty($article->view_content['basic_article_information_title'])){
                $article->name = $article->view_content['basic_article_information_title'];
            }
            if(!empty($article->view_content['basic_article_information_slug'])){
                $article->slug = Str::slug($article->view_content['basic_article_information_slug']);
            }
            if(!empty($article->view_content['basic_website_structure_image_img_file'])){
                $article->image = $article->view_content['basic_website_structure_image_img_file'];
            }
            if(!empty($article->view_content['basic_article_information_description'])){
                $article->short_description = $article->view_content['basic_article_information_description'];
            }
            if(isset($article->view_content['basic_website_structure_is_published'])){
                $article->is_published = boolval($article->view_content['basic_website_structure_is_published']);
                TagForArticleGenerator::generate();
                InternalUrlsGenerator::generate();
            }

            $article->save();
        }

        SitemapService::generateSitemap();

        return $info;
    }

    /**
     * Wyszukuje w tablicy JSON odpowiedni klucz i podmienia wartość
     * @param array $element
     * @param array|null $splitKey
     * @param string $value
     * @param array $info
     * @return void
     */
    protected function changeJson(array &$element, ?array $splitKey, string $value, array &$info): void
    {
        if (is_array($element) && isset($element[0])) {
            foreach ($element as &$content) {
                if ($info['skip']) {
                    break;
                }

                $this->changeJson($content, $splitKey, $value, $info);
            }
        }

        if (array_key_exists('content', $element) && is_array($element['content']) && isset($element['content'][0])) {
            foreach ($element['content'] as &$content) {
                if ($info['skip']) {
                    break;
                }

                $this->changeJson($content, $splitKey, $value, $info);
            }
        }


        // Jeśli jest normalnym elementem
        if (isset($element['key']) && isset($element['type']) && !isset($element['content'])) {
            if ($element['key'] === $splitKey['key']) {
                $this->cmsPageService->changeJsonContent($element, $splitKey, $value, $info);
                $info['skip'] = true;
            }
        }
    }

    /**
     * Przygotowuje tablice kluczy dla widoku
     * @param array $jsonData
     * @return array
     */
    public function prepareViewContentForArticle(array $jsonData): array
    {
        $result = [];
        foreach ($jsonData as $element) {
            $this->prepareViewContentForElement($element, $result);
        }

        return $result;
    }


    /**
     * Przeszukuje i dopisuje klucze (stworzona do celów rekurencyjnych)
     * @param array $element
     * @param array $result
     * @return void
     */
    public function prepareViewContentForElement(array $element, array &$result): void
    {
        if (is_array($element) && isset($element[0])) {
            foreach ($element as &$content) {
                $this->prepareViewContentForElement($content, $result);
            }
        }

        if (array_key_exists('content', $element) && is_array($element['content']) && isset($element['content'][0])) {
            foreach ($element['content'] as &$content) {
                $this->prepareViewContentForElement($content, $result);
            }
        }


        // Jeśli jest normalnym elementem
        if (isset($element['key']) && isset($element['type']) && !isset($element['content'])) {

            if($element['type'] == 'string' || $element['type'] == 'textarea' || $element['type'] == 'text' || $element['type'] == 'boolean' || $element['type'] == 'category'){
                $result[$element['key']] = empty($element['value']) ? '' : $element['value'];
            }

            if($element['type'] == 'image'){
                $currentImage = empty($element['file']) ? 'storage/uploads/empty_image.jpg' : $element['file'];
                $pattern = "/asset\('(.+?)'\)/";
                if (preg_match($pattern, $currentImage, $matches)) {
                    $currentImage = $matches[1];
                }
                $currentImage = str_contains($currentImage, 'http') ? $currentImage : asset($currentImage);

                $result[$element['key'].'_img_file'] = $currentImage;
                $result[$element['key'].'_img_alt'] = !empty($element['alt']) ? $element['alt'] : '';
                $result[$element['key'].'_img_has_link'] = !empty($element['hasLink']) ? $element['hasLink'] : '';
                $result[$element['key'].'_img_link_redirect'] = !empty($element['linkRedirect']) ? $element['linkRedirect'] : '';
            }

            if($element['type'] == 'button'){

                $url = !empty($element['link']) ? $element['link'] : '#';
                $pattern = "/ route\('(.+?)'\)/";
                if (preg_match($pattern, $url, $matches)) {
                    $url = route($matches[1]);
                }

                $result[$element['key'].'_btn_link'] = $url;
                $result[$element['key'].'_btn_text'] = $element['text'];
                $result[$element['key'].'_btn_has_link'] = !empty($element['hasLink']) ? $element['hasLink'] : '';
                $result[$element['key'].'_btn_link_redirect'] = !empty($element['linkRedirect']) ? $element['linkRedirect'] : '';
            }

            if($element['type'] == 'link'){

                $url = !empty($element['href']) ? $element['href'] : '#';
                $pattern = "/ route\('(.+?)'\)/";
                if (preg_match($pattern, $url, $matches)) {
                    $url = route($matches[1]);
                }

                $result[$element['key'].'_link'] = $url;
            }
        }
    }

    public function generateArticleInOtherLanguage(int $articleId, string $language): Article
    {
        $article = Article::findOrFail($articleId);
        $articleNewLanguage = new Article();
        $incorrect = true;
        $errors = 0;
        do{
            try{

                do{
                    $jsonContent = GenerateArticleBasicInformationToOtherLanguagePrompt::generateContent(
                        userContent: json_encode($article->json_content),
                        resultType: OpenApiResultType::JSON_OBJECT,
                        dataPrompt: ['language' => $language]
                    );
                    $jsonContent = json_decode($jsonContent, true);
                }while($jsonContent === null);

                if(isset($jsonContent['content'])){
                    $jsonContent = $jsonContent['content'];
                }
                if(isset($jsonContent['data'])){
                    $jsonContent = $jsonContent['data'];
                }

                $viewContent = $this->prepareViewContentForArticle($jsonContent);
                $incorrect = false;

            }catch (\Exception $exception){
                $errors++;
            }

        }while($incorrect && $errors < 3);


        $articleNewLanguage->json_content = $jsonContent;
        $articleNewLanguage->language = LanguageHelper::getShortFromName($language);
        $articleNewLanguage->is_published = false;
        $articleNewLanguage->options_ai = $article->options_ai;
        $articleNewLanguage->image = $article->image;
        $articleNewLanguage->ai_content = $article->ai_content;
        $articleNewLanguage->category_id = $article->category_id;
        $articleNewLanguage->type = $article->type;
        $articleNewLanguage->view_content = $viewContent;

        if (!empty($articleNewLanguage->view_content['basic_article_information_title'])) {
            $articleNewLanguage->name = $articleNewLanguage->view_content['basic_article_information_title'];
        }
        if (!empty($articleNewLanguage->view_content['basic_article_information_slug'])) {
            $articleNewLanguage->slug = Str::slug($articleNewLanguage->view_content['basic_article_information_slug']);
        }
        if (!empty($articleNewLanguage->view_content['basic_website_structure_image_img_file'])) {
            $articleNewLanguage->image = $articleNewLanguage->view_content['basic_website_structure_image_img_file'];
        }
        if (!empty($articleNewLanguage->view_content['basic_article_information_description'])) {
            $articleNewLanguage->short_description = $articleNewLanguage->view_content['basic_article_information_description'];
        }

        $contents = [];
        foreach ($article->contents as $key => $content) {
            if ($content['type'] === 'text') {
                $currentTranslatedContent = GenerateArticleContentToOtherLanguagePrompt::generateContent(userContent: $content['content'], dataPrompt: ['language' => $language]);
                $currentTranslatedContent = str_replace(['```html','```','``', '` `html', '``html', '`html', '`'], '', $currentTranslatedContent);

                $content['content'] = $currentTranslatedContent;
                $contents[$key] = $content;
            }else if($content['type'] === 'image'){
                $currentTranslatedContent = GenerateArticleContentToOtherLanguagePrompt::generateContent(userContent: $content['alt'], dataPrompt: ['language' => $language]);
                $content['alt'] = $currentTranslatedContent;
                $contents[$key] = $content;
            }
        }

        $articleNewLanguage->connection_article_id = $article->id;
        $articleNewLanguage->contents = $contents;
        $articleNewLanguage->save();


        return $articleNewLanguage;
    }
}
