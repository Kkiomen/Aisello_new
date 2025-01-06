<?php

declare(strict_types=1);

namespace App\Services\Generator;

use App\Models\Article;
use App\Prompts\ArticleUrlKeyPrompt;
use Illuminate\Support\Str;

class InternalUrlsGenerator
{
    public static function generate(): void
    {
        static::generateUrlLinksKeys();
        static::generateHrefInArticles();
    }

    /**
     * Generuje klucze, pod którym danym artykułom będą dostępne linki
     * @return void
     */
    protected static function generateUrlLinksKeys()
    {
        $articles = Article::where('keys_link', null)->get();

        foreach ($articles as $article) {
            if(empty($article->contents)){
                continue;
            }

            $contents = implode(' ', array_column($article->contents, 'content'));
            $generatedKeys = ArticleUrlKeyPrompt::generateContentTextErrorsLoop(
                userContent: 'Nazwa artykułu: '.$article->name . '\n Treść: \n' .$contents,
                dataPrompt: ['language' => $article->language]
            );
            $generatedKeys = str_replace(['"', 'Linki wewnętrzne:', 'Klucze do linków wewnętrznych', '**Klucze do podlinkowania:**', 'Klucze do podlinkowania:', '**Klucze:**', '**Klucze do podlinkowania:**', 'klucze', 'Klucze', ':'], '', $generatedKeys);


            $article->keys_link = trim($generatedKeys);

            $article->save();
        }
    }

    /**
     * Umieszcza w artykułach linki do innych artykułów (linki wewnętrzne)
     * @return void
     */
    protected static function generateHrefInArticles(): void
    {
        $currentLanguage = env('APP_LOCALE');

        // Przygotowanie kluczy
        $articles = Article::where('language', $currentLanguage)->orderBy('id', 'asc')->get();

        $urlKeysList = [];

        /** @var Article $article */
        foreach ($articles as $article) {
            if(empty($article->keys_link)){
                continue;
            }


            foreach (explode(',', $article->keys_link) as $urlKey) {
                $urlKey = trim($urlKey);

                $urlKeysList[$urlKey] = $article->getRoute();
            }
        }


        // Uzupełnianie
        foreach ($articles as $article){
            static::updateInternalLinks($article, $urlKeysList);
        }
    }

    /**
     * Aktualizuje linki wewnętrzne w artykule
     * @param Article $article
     * @param $urlKeysList
     * @return void
     */
    public static function updateInternalLinks(Article $article, $urlKeysList): void
    {
        if($article->contents === null){
            return;
        }

        $hasChanges = false;
        $allContents = $article->contents;

        foreach ($allContents as &$content){
            if(empty($content['content'])){
                continue;
            }

            $updatedContents = $content['content'];


            if(str_contains($updatedContents, '<a href=\"https://oatllo.pl/abstrakcja-programowanie-php\">PHP</a>')){
                $updatedContents = str_replace('<a href=\"https://oatllo.pl/abstrakcja-programowanie-php\">PHP</a>', 'PHP', $updatedContents);
                $hasChanges = true;
            }
            if(str_contains($updatedContents, '<a href="https://oatllo.pl/abstrakcja-programowanie-php">PHP</a>')){
                $updatedContents = str_replace('<a href="https://oatllo.pl/abstrakcja-programowanie-php">PHP</a>', 'PHP', $updatedContents);
                $hasChanges = true;
            }

            // Wyrażenie regularne do znalezienia wszystkich sekcji <pre><code>
            preg_match_all('/<pre><code.*?>.*?<\/code><\/pre>/s', $updatedContents, $codeBlocks);

            // Tymczasowo zastępujemy sekcje kodu, unikalnym placeholderem
            $placeholders = [];
            foreach ($codeBlocks[0] as $index => $block) {
                $placeholder = "__CODE_BLOCK_{$index}__";
                $placeholders[$placeholder] = $block;
                $updatedContents = str_replace($block, $placeholder, $updatedContents);
            }



            // Wyrażenie regularne do znalezienia wszystkich nagłówków (<h1>, <h2>, <h3>, itd.)
            preg_match_all('/<h[1-6].*?>.*?<\/h[1-6]>/s', $updatedContents, $headerBlocks);

            // Tymczasowo zastępujemy nagłówki unikalnym placeholderem
            foreach ($headerBlocks[0] as $index => $block) {
                $placeholder = "__HEADER_BLOCK_{$index}__";
                $placeholders[$placeholder] = $block;
                $updatedContents = str_replace($block, $placeholder, $updatedContents);
            }





            foreach ($urlKeysList as $key => $url) {
                if($article->getRoute() === $url || in_array($key, ['PHP'])){
                    continue;
                }

                // Check if the key exists in the contents and is not already linked
                if (Str::contains($updatedContents, $key)) {

                    // Replace the first occurrence of the key with the link
                    $updatedContents = preg_replace_callback(
                        '/\b' . preg_quote($key, '/') . '\b/i', // Ignorowanie wielkości liter
                        function ($matches) use ($url) {
                            // Zachowaj oryginalny case i otocz go linkiem
                            return '<a href="' . $url . '">' . $matches[0] . '</a>';
                        },
                        $updatedContents
                    );
                }
            }

            // Przywracamy sekcje kodu na ich miejsce
            foreach ($placeholders as $placeholder => $block) {
                $updatedContents = str_replace($placeholder, $block, $updatedContents);
            }

            if($content['content'] !== $updatedContents){
                $hasChanges = true;
                $content['content'] = $updatedContents;
            }
        }

        if($hasChanges){
            $article->contents = $allContents;
            $article->save();
        }
    }
}
