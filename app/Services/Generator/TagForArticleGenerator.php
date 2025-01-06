<?php

declare(strict_types=1);

namespace App\Services\Generator;

use App\Models\Article;
use App\Models\Tag;
use App\Models\TagArticle;
use App\Prompts\TagDescriptionPrompt;
use App\Prompts\TagDescriptionSeoPrompt;
use App\Prompts\TagsForArticlePrompt;
use App\Prompts\TagTitleSeoPrompt;

class TagForArticleGenerator
{
    /**
     * Generuje tagi dla artykułów
     * @return void
     */
    public static function generate(): void
    {
        $currentLanguage = env('APP_LOCALE');
        $articles = Article::where('language', $currentLanguage)->where('is_published', true)->inRandomOrder()->get();
        $tagsArticles = TagArticle::whereIn('article_id', $articles->pluck('id'))->get();
        // Pobranie ID artykułów, dla których znaleziono TagArticle
        $taggedArticleIds = $tagsArticles->pluck('article_id');

        // Usunięcie z kolekcji $articles tych, które mają ID w $taggedArticleIds
        $articlesWithoutTags = $articles->reject(function ($article) use ($taggedArticleIds) {
            return $taggedArticleIds->contains($article->id);
        });

        // Jeśli potrzebujesz zwykłej kolekcji po usunięciu:
        $articlesWithoutTags = $articlesWithoutTags->values();


        foreach ($articlesWithoutTags as $article){
            static::generateTagForArticle($article);
        }
    }

    /**
     * Tworzy informacje SEO dla tagu
     * @param Tag $tag
     * @return void
     */
    public static function createSeoInformation(Tag $tag): void
    {
        if($tag->title_seo === null){
            $tag->title_seo = str_replace(['"', 'Tytuł SEO:', 'Tytuł:', 'Tytuł SEO: ', 'Tytuł SEO: '], '', TagTitleSeoPrompt::generateContentTextErrorsLoop('Nazwa tagu: '.$tag->name));
            $tag->save();
        }

        if($tag->description_seo === null){
            $tag->description_seo = str_replace(['"'], '', TagDescriptionSeoPrompt::generateContentTextErrorsLoop('Nazwa tagu: '.$tag->name));
            $tag->save();
        }
    }

    /**
     * Generuje tagi dla artykułu
     * @param mixed $article
     * @return void
     */
    protected static function generateTagForArticle(Article $article): void
    {
        if(empty($article->contents) || TagArticle::where('article_id', $article->id)->exists()){
            return;
        }
        $contents = implode(' ', array_column($article->contents, 'content'));

        $tags = TagsForArticlePrompt::generateContentTextErrorsLoop('Nazwa artykułu: '.$article->name . '\n Treść: \n' .$contents);
        $tags = explode(',', $tags);

        foreach ($tags as $tag){
            $tag = static::getOrCreateTag($tag);
            TagArticle::create([
                'article_id' => $article->id,
                'tag_id' => $tag->id
            ]);
        }
    }

    /**
     * Pobiera lub tworzy tag
     * @param string $tagName
     * @return Tag
     */
    protected static function getOrCreateTag(string $tagName): Tag
    {
        $tagName = ucfirst(trim($tagName));

        $tag = null;

        if(Tag::where('name', $tagName)->exists()){
            $tag = Tag::where('name', $tagName)->first();
        }

        if($tag === null){
            $tag =  Tag::create([
                'name' => $tagName,
                'language' => env('APP_LOCALE')
            ]);
        }

        if($tag->description === null){
            $tag->description = TagDescriptionPrompt::generateContentTextErrorsLoop($tagName);
            $tag->save();
        }

        static::createSeoInformation($tag);

        return $tag;
    }
}
