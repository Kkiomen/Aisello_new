<?php

declare(strict_types=1);

namespace App\Services\Generator;

use App\Models\Article;
use App\Prompts\Abstract\Enums\OpenApiResultType;
use App\Prompts\GenerateArticleContentPrompt;
use App\Prompts\GenerateArticleDecorateTextPrompt;
use App\Prompts\GenerateArticlePropertiesPrompt;
use App\Prompts\GenerateArticleQueryImagesPrompt;
use App\Prompts\GenerateConspectusArticlePrompt;
use App\Services\Article\ArticleService;
use App\Services\Helper\GeneratorHelper;
use App\Services\ImageService;

class GeneratorArticleService
{
    protected const AI_GENERATE_TYPE = 'ai_generator';
    public function __construct(
        private readonly ArticleService $articleService,
        private readonly ImageService $imageService
    ){}

    /**
     * Create article in mode AI generate
     * @param string $topicArticle
     * @return int
     */
    public function createArticle(string $topicArticle): int
    {
        $article = $this->articleService->getOrCreateArticleInModeAiGenerate();
        $article->ai_content = $topicArticle;
        $article->contents = null;
        $article->schema_ai = null;
        $article->save();

        return $article->id;
    }

    /**
     * Generate basic information for article
     * Subject, seo, openGraph image, schema
     * @return int
     */
    public function generateBasicInformation(): int
    {
        // Get article
        $article = $this->articleService->getOrCreateArticleInModeAiGenerate();

        // Break when article was generated basic information
        if(!empty($article->contents) && !empty($article->schema_ai)){
            return $article->id;
        }

        // ============ Generate basic info ============
        $content = GenerateArticlePropertiesPrompt::generateContent(
            userContent: $article->ai_content,
            resultType: OpenApiResultType::JSON_OBJECT
        );

        // Update article
        $content = json_decode($content, true);
        foreach ($content as $key => $value) {
            $this->articleService->updateKey($article, $key .'0001000', $value);
        }
        // ============ Generate basic info ============



        // ============ Generate image ============
        $queryImage = GenerateArticleQueryImagesPrompt::generateContent(userContent: $article->name);
        $imagePath = $this->imageService->generateImageByQuery($queryImage);
        if(!empty($imagePath)){
            $this->articleService->updateKey($article, 'basic_website_structure_image'. '0001000file', $imagePath);
        }
        // ============ Generate image ============



        // ============ Generate schema content ============
        $schemaResult = GenerateConspectusArticlePrompt::generateContent(userContent: $article->name, resultType: OpenApiResultType::JSON_OBJECT);
        $schema = json_decode($schemaResult, true)['outline'];
        $contents = [];
        foreach ($schema as &$element){
            $id = '_'.GeneratorHelper::randomPassword(9);
            $element['isGenerated'] = false;
            $element['id'] = $id;
            $contents[] = [
                'type' => 'text',
                'content' => null,
                'id' => $id,
                'isGenerated' => false
            ];
        }
        // ============ Generate schema content ============

        // Update article with chema
        $article->schema_ai = $schema;
        $article->contents = $contents;
        $article->save();

        $this->checkIfAllContentsAreGenerated($article);

        return $article->id;
    }

    public function generateContentByKey(int $articleId, string $currentContentId): array
    {
        $currentContentId = str_replace([' '], '', $currentContentId);
        $article = Article::find($articleId);
        $contents = $article->contents;
        $listOfIds = $this->getListOfIds($contents);
        $currentIndex = $listOfIds[$currentContentId];
        $beforeIndex = isset($contents[$currentIndex - 1]) ? $currentIndex - 1 : null;

        // Check if all contents are generated
        $this->checkIfAllContentsAreGenerated($article);

        if($article->schema_ai == null || $this->isGeneratedAllContents($contents) || $contents[$currentIndex]['content'] !== null){
            return [
                'errors' => 0,
                'isGeneratedAll' => $this->isGeneratedAllContents($contents),
                'isCurrentGenerated' => $contents[$currentIndex]['content'] !== null,
                'currentKey' => $currentContentId,
                'nextKey' => isset($contents[$currentIndex + 1]) ? $contents[$currentIndex + 1]['id'] : null,
            ];
        }

        // Generate prompt
        $prompt = $this->createPrompt($contents, $beforeIndex, $currentContentId, $article->name, $article->schema_ai);

        // Generate Content
        $content = $this->generateContentByOpenAi($prompt);


        //  ==== Aktualizacja kontentu ====
        $contents[$currentIndex]['content'] = $content;
        $contents[$currentIndex]['isGenerated'] = true;

        // ==== Aktualizacja schemy ====
        $schemaContents = $article->schema_ai;
        $schemaContents[$currentIndex]['isGenerated'] = true;


        //  ==== Aktualizacja artykułu ====
        $article->contents = $contents;
        $article->schema_ai = $schemaContents;
        $article->save();

        $this->checkIfAllContentsAreGenerated($article);

        return [
            'errors' => 0,
            'isGeneratedAll' => $this->isGeneratedAllContents($contents),
            'isCurrentGenerated' => true,
            'currentKey' => $currentContentId,
            'nextKey' => isset($contents[$currentIndex + 1]) ? $contents[$currentIndex + 1]['id'] : null,
            'content' => $content
        ];
    }

    /**
     * Generate content by OpenAI
     * @param string $prompt
     * @return string
     */
    protected function generateContentByOpenAi(string $prompt): string
    {
        $content = GenerateArticleContentPrompt::generateContent($prompt);
        $content = GenerateArticleDecorateTextPrompt::generateContent($content);
        $content = str_replace(['```html', '```', '`html', '``', '`'], '', $content);

        return $content;
    }

    /**
     * Create prompt for create content
     * @param array|null $articleContents
     * @param int|null $beforeIndex
     * @param string|null $currentId
     * @param string $articleTopic
     * @param array $schemaList
     * @return string
     */
    protected function createPrompt(?array $articleContents, ?int $beforeIndex, ?string $currentId, string $articleTopic, array $schemaList): string
    {
        $lastIndexContent = $beforeIndex !== null && !empty($articleContents[$beforeIndex]['content']) ? $articleContents[$beforeIndex]['content'] : null;
        $lastIndexContent = $lastIndexContent !== null && $beforeIndex !== null  ? substr($lastIndexContent, -80) : null;
        $schemaInformation = $this->findElementById($schemaList, $currentId);

        $prompt = '- Tytuł artykułu: "'. $articleTopic .'"\n';
        if($beforeIndex !== null && $lastIndexContent !== null){
            $prompt .= '- Ostatnie 40 znaków ostatnio wygenerowanej części: "'.  $lastIndexContent .'"\n';
        }

        if($schemaInformation !== null && !empty($schemaInformation['heading']) && !empty($schemaInformation['content'])){
            $prompt .= '- O czym napisać: "'. $schemaInformation['heading'] .'" ('. $schemaInformation['content'] .') \n';
        }

        $actualPartIndex = $beforeIndex !== null ? $beforeIndex + 2 : 1;

        $prompt .= '- Aktualna część: '. $actualPartIndex . ' z ' . count($schemaList);

        return $prompt;
    }

    /**
     * Find element by id
     * @param array $items
     * @param string $searchId
     * @return mixed|null
     */
    protected function findElementById(array $items, string $searchId): mixed
    {
        foreach ($items as $item) {
            if ($item['id'] === $searchId) {
                return $item;
            }
        }
        return null;
    }

    /**
     * Get list of ids
     * @param array $contents
     * @return array
     */
    protected function getListOfIds(array $contents): array
    {
        $indexedIds = [];

        foreach ($contents as $index => $item) {
            $indexedIds[$item['id']] = $index;
        }

        return $indexedIds;
    }

    /**
     * Check if all contents are generated
     * @param array $contents
     * @return bool
     */
    protected function isGeneratedAllContents(array $contents): bool
    {
        foreach ($contents as $content) {
            if($content['content'] === null){
                return false;
            }
        }

        return true;
    }

    /**
     * Check if all contents are generated
     * @param Article $article
     */
    protected function checkIfAllContentsAreGenerated(Article $article): void
    {
        if($this->isGeneratedAllContents($article->contents)){
            $article->type = 'normal';
            $article->save();
        }
    }
}