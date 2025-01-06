<?php

declare(strict_types=1);

namespace App\Prompts;

use App\Prompts\Abstract\AbstractOpenApiGenerator;

class TagTitleSeoPrompt extends AbstractOpenApiGenerator
{

    protected static function preparePrompt(array $data = []): string
    {
        $currentLanguage = env('APP_LOCALE');

        return '
        Jesteś specjalistą SEO. Twoim zadaniem jest przygotowanie tytułu SEO dla tagu. Musi on zawierać słowa kluczowe, które pozwolą się wyświetlać w pierwszych wynikach wyszukiwarki.
        Maksymalnie 60 znaków.

        ### Zwróć gotowy tytuł SEO dla tagu
        ### Tytuł SEO ma być w języku: '.$currentLanguage.'
        ';
    }
}
