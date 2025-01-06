<?php

namespace App\Http\Controllers;

use App\Mail\InformationContact;
use App\Models\Category;
use App\Models\CmsPage;
use App\Models\Article;
use App\Models\Tag;
use App\Models\TagArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $info = CmsPage::find(1);

        if(env('LANGUAGE_MODE') == 'strict'){
            $defaultLangue = env('APP_LOCALE');

            $randomArticles = Article::where('is_published', true)->where('language', $defaultLangue)->inRandomOrder()->take(3)->get();
        }else{
            $randomArticles = Article::where('is_published', true)->inRandomOrder()->take(3)->get();
        }

        if($info->to_view === null){
            dd('WYGENERUJ CMS PAGE');
        }


        return view('views_basic.welcome', array_merge(
            $info->to_view,
            [
                'randomArticles' => $randomArticles
            ]
        ));
    }



    public function page(string $slug): View
    {
        $page = Article::with('sections.contents')->where('slug', $slug)->first();
        return view('home.index', compact('page'));
    }



    // ============== ARTICLE ==============

    public function articleWithCategory(Request $request, string $categorySlug, string $articleSlug): View
    {
        $article = Article::where('slug', $articleSlug)->first();
        if(!$article || $article->contents == null){
            abort(404);
        }
        $randomArticles = Article::where('id', '!=', $article->id)->where('is_published', true)->where('type', 'normal')->inRandomOrder()->take(3)->get();
        $category = Category::where('slug', $categorySlug)->first();

        return view('views_basic.article', [
            'article' => $article,
            'category' => $category,
            'randomArticles' => $randomArticles
        ]);
    }
    public function article(Request $request, string $articleSlug): View
    {
        $defaultLangue = env('APP_LOCALE');
        $article = Article::where('slug', $articleSlug)->where('language', $defaultLangue)->first();
        if(!$article || $article->contents == null){
            abort(404);
        }

        if(env('LANGUAGE_MODE') == 'strict'){
            $randomArticles = Article::where('id', '!=', $article->id)->where('is_published', true)->where('language', $defaultLangue)->inRandomOrder()->take(3)->get();

        }else{
            $randomArticles = Article::where('id', '!=', $article->id)->where('is_published', true)->inRandomOrder()->take(3)->get();
        }

        return view('views_basic.article', [
            'article' => $article,
            'category' => null,
            'randomArticles' => $randomArticles
        ]);
    }


    // ============== BLOG ==============
    public function blog(): View
    {
        $uniqueCategoryIds = Article::whereNotNull('category_id')->where('is_published', true)
            ->distinct()
            ->pluck('category_id');

        $categories = Category::whereIn('id', $uniqueCategoryIds)->get();

        if(env('LANGUAGE_MODE') == 'strict') {

            $articles = Article::where('is_published', true)
                ->where('language', env('APP_LOCALE'))
                ->orderBy('created_at', 'desc')->paginate(10);
        }else{
            $articles = Article::where('is_published', true)
                ->orderBy('created_at', 'desc')->paginate(10);
        }


        $info = CmsPage::find(1);

        return view('views_basic.blog',array_merge(
            $info->to_view,
            [
                'categories' => $categories,
                'articles' => $articles,
                'currentCategory' => null
            ]
        ));
    }

    public function blogTag(string $slug): View
    {
        $tag = Tag::where('slug', $slug)->where('language', env('APP_LOCALE'))->first();

        if(!$tag){
            $tags = Tag::where('language', env('APP_LOCALE'))->get();

            foreach ($tags as $currentTag){
                if(Str::slug($currentTag->name) == $slug){
                    $currentTag->slug = $slug;
                    $currentTag->save();

                    $tag = $currentTag;
                    break;
                }
            }

        }

        if(!$tag){
            abort(404);
        }

        $articleTagIds = TagArticle::where('tag_id', $tag->id)->pluck('article_id');

        $uniqueCategoryIds = Article::whereNotNull('category_id')->whereIn('id', $articleTagIds->toArray())->where('is_published', true)
            ->distinct()
            ->pluck('category_id');


        $categories = Category::whereIn('id', $uniqueCategoryIds)->get();
        $coursesLesson = [];
        $normalArticles = [];

        if(env('LANGUAGE_MODE') == 'strict') {
            $articles = Article::where('is_published', true)
                ->where('language', env('APP_LOCALE'))
                ->whereIn('id', $articleTagIds->toArray())
                ->orderBy('created_at', 'desc')->paginate(10);


            foreach ($articles as $article){
                $normalArticles[] = $article;
            }

        }else{
            $articles = Article::where('is_published', true)
                ->whereIn('id', $articleTagIds->toArray())
                ->orderBy('created_at', 'desc')->paginate(10);

            foreach ($articles as $article){
                $normalArticles[] = $article;
            }
        }

        $info = CmsPage::find(1);

        return view('views_basic.blog_tag',array_merge(
            $info->to_view,
            [
                'categories' => $categories,
                'articles' => $normalArticles,
                'coursesLesson' => $coursesLesson,
                'currentCategory' => null,
                'tag' => $tag
            ]
        ));
    }


    public function blogListCategory(string $slug): View
    {
        $currentCategory = Category::where('slug', $slug)->first();
        if(!$currentCategory){
            abort(404);
        }

        $articles = Article::where('type', 'normal')
                            ->where('is_published', true)
                            ->where('category_id', $currentCategory->id)
                            ->orderBy('created_at', 'desc')->paginate(10);

        $currentCategory = $currentCategory->name;

        $uniqueCategoryIds = Article::whereNotNull('category_id')
            ->where('is_published', true)
            ->distinct()
            ->pluck('category_id');

        $categories = Category::whereIn('id', $uniqueCategoryIds)->get();
        $info = CmsPage::find(1);


        return view('views_basic.blog', array_merge(
            $info->to_view,
            [
                'categories' => $categories,
                'articles' => $articles,
                'currentCategory' => $currentCategory
            ]
        ));
    }

    public function sendEmail(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'first-name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'topic' => 'required|string|max:255',
            'message' => 'required|string',
            'g-recaptcha-response' => 'required|captcha'
        ]);

//        $to = 'kurytplagain@gmail.com';
        $to = 'kontakt@serwis-elektroniki-bartlomiej-biernat.pl';

        Mail::to($to)->send(new InformationContact([
            'first-name' => $request->get('first-name'),
            'last-name' => $request->get('last-name'),
            'email' => $request->get('email'),
            'topic' => $request->get('topic'),
            'message' => $request->get('message')
        ]));


        return response()->json(['success' => true]);
    }
}
