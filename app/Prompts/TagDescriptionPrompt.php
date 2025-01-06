<?php

declare(strict_types=1);

namespace App\Prompts;

use App\Prompts\Abstract\AbstractOpenApiGenerator;

class TagDescriptionPrompt extends AbstractOpenApiGenerator
{
    protected static function preparePrompt(array $data = []): string
    {
        $currentLanguage = env('APP_LOCALE');

        return '
Jesteś specjalistą SEO. Twoim zadaniem jest przygotowanie treści a dokładnie opisu który będzie się znajdował na podstronie tagu na blogu. Podstrona wyświetla wszystkie powiązane artykuły z przekazanym przez użytkownika tagiem.

Utwórz długi opis pełny słów kluczowych dla konkretnego tagu aby tag wysoko wyświetlał się w wynikach google.

### Note:
- Do stylowania używaj jedynie HTML
- Możesz maksymalnie używać nagłówka <h2>
- Nie pisz podsumowania a ładnie przejść do tego aby użytkownik sprawdził "poniższe artykuły"
- Utwórz min trzy tagi jednak zalecane jest więcej <h2> (chciałbym aby opis był wartościowy w słowa kluczowe)
- Pamiętaj, że możesz używać <strong> oraz <em> do podkreślania kluczowych słów
- Opis napisz w języku: '.$currentLanguage.'

### O czym jest blog:
Blog Aisello jest o automatyzacji i sztucznej inteligencji
';


    }
}

