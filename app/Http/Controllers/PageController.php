<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Prompts\Abstract\Enums\OpenApiResultType;
use App\Prompts\GenerateArticleContentPrompt;
use App\Prompts\GenerateArticleDecorateTextPrompt;
use App\Prompts\GenerateConspectusArticlePrompt;
use App\Services\Article\ArticleService;
use App\Services\Generator\GeneratorArticleService;
use App\Services\Helper\GeneratorHelper;
use App\Services\Helper\LanguageHelper;
use App\Services\ImageService;
use App\Services\StructureDataGoogleSearchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(Request $request)
    {
        // Pobieranie wartości wyszukiwania z zapytania
        $search = $request->input('search');
        $language = $request->input('language');

        // Filtracja artykułów na podstawie tytułu, jeśli pole wyszukiwania nie jest puste
        $articles = Article::when($search, function ($query, $search) {
                                return $query->where('name', 'like', '%' . $search . '%')->orWhere('slug', 'like', '%' . $search . '%');
                             })
                            ->when($language, function ($query, $language) {
                                if($language === 'all'){
                                    return $query;
                                }

                                return $query->where('language', 'like', '%' . $language . '%');
                            })
                            ->orderBy('created_at', 'desc')
                            ->whereIn('type', ['normal', 'ai_generator'])
                            ->paginate(10);

        return view('pages.index', [
            'pages' => $articles,
            'search' => $search,
        ]);
    }

    public function createMethods()
    {
        return view('pages.create-methods');
    }

    public function create(Request $request, ArticleService $articleService)
    {
        $article = $articleService->getOrCreateArticleInModeCreate();

        return view('pages.create', [
            'contents' => $article->json_content,
            'article' => $article,
            'languages' => null
        ]);
    }

    public function store(Request $request)
    {
        $page = Article::create($request->only(['name', 'slug']));
        $slug = $request->get('slug');
        $page->slug = Str::slug(str_replace('/', '-', strtolower($slug)));
        $page->is_published = $request->get('is_published') ? true : false;
        $page->save();
        return redirect()->route('pages.edit', $page->id);
    }

    public function edit(int $page)
    {
        $article = Article::findOrFail($page);
        $languages = LanguageHelper::prepareLanguagesForArticle($article);
        $languages = $languages === [] ? null : $languages;

        return view('pages.create', [
            'contents' => $article->json_content,
            'article' => $article,
            'languages' => $languages,
        ]);
    }

    public function update(Request $request, Article $page)
    {
        $page->update($request->only(['name', 'slug']));
        $slug = $request->get('slug');
        $page->slug = Str::slug(str_replace('/', '-', strtolower($slug)));
        $page->is_published = $request->get('is_published') ? true : false;
        $page->save();
        return Redirect::back();
    }

    public function destroy(Article $page)
    {
        $page->delete();
        return redirect()->route('pages.index');
    }

    public function updateArticleKey(Request $request, ?Article $article, ArticleService $articleService): JsonResponse
    {
        if($article === null) {
            return response()->json(['error' => 'Article not found'], 404);
        }

        $result = null;

        foreach ($request->all() as $key => $value) {
            $result = $articleService->updateKey($article, $key, $value);
        }

        return response()->json(['success' => 'Key updated','data' => $request->all(), 'articleId' => $article->id, 'result' => $result]);
    }

    public function updateImage(Request $request, Article $article, ImageService $imageService, ArticleService $articleService): JsonResponse
    {
        $data = $request->all();

        // Przechowywanie obrazu
        $file = $request->file('file');
        if ($file) {
            $filePath = $imageService->uploadImage($file);

            if($filePath == null){
                return response()->json(['status' => 'error']);
            }

            // Update the CMS with the WebP file path
            $articleService->updateKey($article, $data['key'] . '0001000file', $filePath);

            return response()->json(['filePath' => asset($filePath)]);
        }

        return response()->json(['status' => 'error']);
    }

    public function saveContents(Request $request, Article $article)
    {
        $contents = $request->input('contents');
        $article->contents = $contents;
        $article->type = 'normal';
        $article->save();

        // Generate schema Google
        $schemaGoogle = StructureDataGoogleSearchService::generateStructureData($article);
        $article->structure_data_google = $schemaGoogle;
        $article->save();

        return response()->json(['status' => 'success']);
    }

    public function saveContentsImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $url = Storage::url($path);
            return response()->json(['url' => asset($url)]);
        }
        return response()->json(['error' => 'No image uploaded'], 400);
    }

    // =============== GENEROWANIE AI ================
    public function createAi(Request $request): View
    {
        return view('pages.create-ai');
    }

    public function createArticle(Request $request, GeneratorArticleService $generatorArticleService): JsonResponse
    {
        $options = $request->all();
        unset($options['about']);

        $articleId = $generatorArticleService->createArticle($request->input('about'), $options ?? []);

        return response()->json(['status' => 'success', 'articleId' => $articleId]);
    }

    public function generateBasicInfo(Request $request, GeneratorArticleService $generatorArticleService): JsonResponse
    {
        $articleId = $generatorArticleService->generateBasicInformation($request->query->getInt('articleId'));

        return response()->json(['status' => 'success', 'articleId' => $articleId]);
    }

    public function generateContent(Request $request, ArticleService $articleService)
    {
        $article = $articleService->getOrCreateArticleInModeAiGenerate();
        $article->type = 'normal';
        $article->save();

        $synopsisResult = GenerateConspectusArticlePrompt::generateContent(userContent: $article->name, resultType: OpenApiResultType::JSON_OBJECT);
        $synopsis = json_decode($synopsisResult, true)['outline'];


        $countOfArticleParts = count($synopsis);
        $contentArticle = [];
        $i = 1;
        foreach ($synopsis as $element){
            $prompt = '- Tytuł artykułu: "'. $article->name .'"\n';
            if($i > 1){
                $prompt .= '- Ostatnie 40 znaków ostatnio wygenerowanej części: "'.  substr($contentArticle[$i-2], -40) .'"\n';
            }
            $prompt = '- O czym napisać: "'. $element['heading'] .'" ('. $element['content'] .') \n';
            $prompt .= '- Aktualna część: '. $i . ' z ' . $countOfArticleParts;

            $content = GenerateArticleContentPrompt::generateContent($prompt);
            $content = GenerateArticleDecorateTextPrompt::generateContent($content);
            $content = str_replace(['```html','```','``', '` `html', '``html', '`html', '`'], '', $content);

            $contentArticle[] = $content;
            $i++;
        }

        $contents = [];
        foreach ($contentArticle as $item){
            $contents[] = [
                'type' => 'text',
                'content' => $item,
                'id' => GeneratorHelper::randomPassword(15)
            ];
        }

        $article->contents = $contents;
        $article->save();

        return response()->json(['status' => 'success']);
    }

    public function getToGenerateContent(Request $request, Article $article): JsonResponse
    {
        $type = 'ai_generator';
        if($article->type === $type){
            $schemaList = [];
            foreach ($article->schema_ai as $schema){
                if(array_key_exists('image', $schema)){
                    $schema['heading'] = 'Generowanie zdjęcia';
                    $schema['content'] = 'Przygotowanie obrazu';
                }

                $schemaList[] = $schema;
            }

            return response()->json(['status' => 'success', 'contents' => $schemaList]);
        }

        return response()->json(['status' => 'success', 'contents' => null]);
    }

    public function generateContentByIdSchema(Request $request, Article $article, string $schemaId, GeneratorArticleService $generatorArticleService): JsonResponse
    {
        $result = $generatorArticleService->generateContentByKey($article->id, $schemaId);

        return response()->json(['status' => 'success', 'generatedKey' => $schemaId, 'nextKey' => $result['nextKey'], 'content' => $result['content'] ?? '' ]);
    }

    public function generateContentInOtherLanguage(Request $request, ArticleService $articleService)
    {
        $request->validate([
            'name' => 'required|string',
            'articleIdd' => 'required|integer',
        ]);

        $article = $articleService->generateArticleInOtherLanguage(intval($request->input('articleIdd')), $request->input('name'));

//        return response()->json(['url' => 'http://localhost/automatyka/public/pages/39/edit']);
        return response()->json(['url' => route('pages.edit', $article)]);
    }
}
