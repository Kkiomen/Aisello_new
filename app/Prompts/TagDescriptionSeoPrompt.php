<?php

declare(strict_types=1);

namespace App\Prompts;

use App\Prompts\Abstract\AbstractOpenApiGenerator;

class TagDescriptionSeoPrompt extends AbstractOpenApiGenerator
{
    protected static function preparePrompt(array $data = []): string
    {
        $currentLanguage = env('APP_LOCALE');

        return '
        Jesteś specjalistą SEO. Twoim zadaniem jest przygotowanie opis SEO (meta description) dla tagu. Musi on zawierać słowa kluczowe, które pozwolą się wyświetlać w pierwszych wynikach wyszukiwarki.
        Maksymalnie 150 znaków.

        ### Zwróć gotowy opis SEO dla tagu
        ### Opis SEO ma być w języku: '.$currentLanguage.'
        ';
    }
}
