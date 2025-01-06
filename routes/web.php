<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContentGeneratorController;
use App\Http\Controllers\GeneratedContentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\SectionContentController;
use App\Http\Controllers\SectionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CmsPageController;




Route::get('/p/{slug}', [\App\Http\Controllers\HomeController::class, 'page'])->name('home.page');
Route::get('/blog', [\App\Http\Controllers\HomeController::class, 'blog'])->name('blog');
Route::get('/blog/tag/{tag}', [\App\Http\Controllers\HomeController::class, 'blogTag'])->name('blogTag');
Route::get('/blog/lista/{slug}', [\App\Http\Controllers\HomeController::class, 'blogListCategory'])->name('blog.list.category');
Route::post('/send/email', [\App\Http\Controllers\HomeController::class, 'sendEmail'])->name('send.email');
//Route::get('/blog/', [\App\Http\Controllers\HomeController::class, 'blog'])->name('blog');

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/kontakt', [HomeController::class, 'contact'])->name('contact');
Route::get('/about-us', [HomeController::class, 'aboutUs'])->name('about.us');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/test', [\App\Http\Controllers\TestController::class, 'test'])->name('test');


Route::get('/content-generators', [ContentGeneratorController::class, 'index'])->name('content_generators.index');
Route::post('/content-generators', [ContentGeneratorController::class, 'store'])->name('content_generators.store');
Route::get('/content-generators/{id}/edit', [ContentGeneratorController::class, 'edit'])->name('content_generators.edit');
Route::put('/content-generators/{id}', [ContentGeneratorController::class, 'update'])->name('content_generators.update');
Route::delete('/content-generators/{id}', [ContentGeneratorController::class, 'destroy'])->name('content_generators.destroy');

Route::get('/content-generators/{id}/generated-contents', [GeneratedContentController::class, 'index'])->name('generated_contents.index');
Route::post('/generated-contents', [GeneratedContentController::class, 'store'])->name('generated_contents.store');
Route::get('/generated-contents/{id}', [GeneratedContentController::class, 'show'])->name('generated_contents.show');
Route::delete('/generated-contents/{id}', [GeneratedContentController::class, 'destroy'])->name('generated_contents.destroy');
Route::post('/generated-contents/{id}/regenerate', [GeneratedContentController::class, 'regenerate'])->name('generated_contents.regenerate');

Route::post('/pages/generate-article/other-language', [PageController::class, 'generateContentInOtherLanguage'])->name('generate.contentInOtherLanguage');
Route::post('/articles/{article}', [PageController::class, 'saveContents'])->name('articles.saveContents');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');




    // ======== Articles =========

    Route::get('/pages/create-methods', [PageController::class, 'createMethods'])->name('pages.createMethods');
    Route::resource('pages', PageController::class);
    Route::post('/pages/update/key/{article}', [PageController::class, 'updateArticleKey'])->name('pages.updateKey');
    Route::post('/pages/update/key/{article}/image', [PageController::class, 'updateImage'])->name('pages.updateImage');
    Route::post('/articles/{id}/contents', [PageController::class, 'saveContents'])->name('article.saveContents');
    Route::post('/image/upload', [PageController::class, 'saveContentsImage'])->name('articles.saveContentsImage');



    Route::get('/pages/create/ai', [PageController::class, 'createAi'])->name('pages.createAi');
    Route::post('/pages/create-article', [PageController::class, 'createArticle'])->name('pages.createArticle');
    Route::post('/pages/generate-basic-info', [PageController::class, 'generateBasicInfo'])->name('pages.generateBasicInfo');
    Route::post('/pages/generate-content', [PageController::class, 'generateContent'])->name('pages.generateContent');
    Route::get('/pages/to-generate-content/{article}', [PageController::class, 'getToGenerateContent'])->name('pages.toGenerateContent');
    Route::get('/pages/generate-article-content/{article}/{schemaId}', [PageController::class, 'generateContentByIdSchema'])->name('pages.generateContentByIdSchema');


    // ======== Categories =========


    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.fetch');
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);







    Route::post('pages/{page}/sections', [SectionController::class, 'store'])->name('sections.store');
    Route::post('pages/{page}/sections/order', [SectionController::class, 'updateOrder'])->name('sections.updateOrder');
    Route::delete('sections/{section}', [SectionController::class, 'destroy'])->name('sections.destroy');

    Route::post('section-contents', [SectionContentController::class, 'store'])->name('section_contents.store');
    Route::delete('section-contents/{content}', [SectionContentController::class, 'destroy'])->name('section_contents.destroy');
    Route::get('pages/{page}/sections', [SectionController::class, 'fetchSections'])->name('sections.fetch');

    Route::post('pages/{page}/sections/save', [SectionController::class, 'save'])->name('sections.save');


    Route::get('/cmspage/{slug}', [CmsPageController::class, 'edit'])->name('cmspage.edit');
    Route::post('/cmspage/image/uplaod', [CmsPageController::class, 'uploadImage'])->name('upload.image');



    Route::post('/cmspage/update', [CmsPageController::class, 'update'])->name('cmspage.update');



});
require __DIR__.'/auth.php';


Route::get('/{categorySlug}/{articleSlug}', [\App\Http\Controllers\HomeController::class, 'articleWithCategory'])->name('home.article_with_category');
Route::get('/{articleSlug}', [\App\Http\Controllers\HomeController::class, 'article'])->name('home.article');
