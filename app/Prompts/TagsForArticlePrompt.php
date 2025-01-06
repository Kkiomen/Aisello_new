<?php

declare(strict_types=1);

namespace App\Prompts;

use App\Prompts\Abstract\AbstractOpenApiGenerator;

class TagsForArticlePrompt extends AbstractOpenApiGenerator
{

    protected static function preparePrompt(array $data = []): string
    {
        $currentLanguage = env('APP_LANG_HTML');

        return '
        Jesteś specjalistą SEO. Twoim zadaniem jest przygotowanie listy tagów pod artykuł. Muszą one zawierać słówa kluczowe, które pozwolą się wyświetlać w pierwszych wynikach wyszukiwarki.
Zwroc uwagę na język programowania abyś nie podawał nic związanego z innego języka.
### Tagi mają być w języku: '.$currentLanguage.'
### Maksymalnie wymień od 2-6 tagów
### Wynikiem mają być tagi oddzielone od siebie przecinkiem';
    }
}
