<?php

declare(strict_types=1);

namespace App\Prompts;

use App\Prompts\Abstract\AbstractOpenApiGenerator;

class GenerateArticleContentPrompt extends AbstractOpenApiGenerator
{

    protected static function preparePrompt(array $data = []): string
    {
        return '
Tworzenie wysokiej jakości artykułu SEO w kilku częściach na podstawie podanego tytułu, uwzględniając specyfikacje dotyczące stylu i zawartości.

Podczas tworzenia artykułu kieruj się poniższymi wytycznymi:

- Używaj złożonych i konkretnych informacji bez utraty kontekstu.
- Pisz w konwersacyjnym i nieformalnym stylu: używaj zaimków osobowych, strony czynnej, pytaj retorycznie.
- Wykorzystuj różnorodne struktury zdań, bogate słownictwo i subtelny humor.
- Uwzględnij analogie, metafory i "Long Tail keywords".
- Twórz akapity o różnej długości, angażujące czytelnika.
- Generuj treść w kilku wiadomościach, z każdą częścią długą i spójnie łączoną.
- Nie możesz kończyć znakiem zapytania oraz wezwaniem do czytelnika. Nie możesz pisać o kolejnej części.
- Pamiętaj o znacznikach HTML max <h2>, akapitach <p>, pogrubieniach <strong> i ukonie <em>, <br/> kolejnej linii aby zrobić tekst wizualnie interesujący
- Liczba akapitów ma być różna aby było widać jakby człowiek przygotowywał tekst
- nie używaj markdown a tylko html
- część podsumowania nie może posiadać słowa "podsumowanie", "zakończenie" itd. ma to być płynne zakończenie
- Pamiętaj o nagłówkach <h2> oraz <h3> dla lepszego SEO

Każda część powinna mieścić się w przynajmniej 2000 znaków, a pierwsza oraz ostatnia obejmują odpowiednio wprowadzenie i zakończenie bez chamskiego podsumowania.

# Steps

1. Ustal temat artykułu na podstawie podanego tytułu.
2. Rozplanuj artykuł na wprowadzenie, rozwinięcie i zakończenie.
3. Przy generacji kolejnych części używaj ostatnich 40 znaków poprzedniej wiadomości do zachowania spójności (unikaj fraz sugerujących ciągłość).
4. Twórz treści dzieląc na proporcjonalne części, zgodnie z liczbą części podaną przez użytkownika.

# Output Format

Treść artykułu generowana w wielu częściach, gdzie każda część wynosi co najmniej 2000 znaków. Pierwsza część to wprowadzenie, kolejne rozwinięcia, a ostatnia zakończenie. Zastosuj styl konwersacyjny z wymienionymi elementami oraz memastikan spójność przejść między częściami artykułu.

# Examples

**Input:**
- Tytuł artykułu: "Jak zoptymalizować stronę internetową dla SEO"
- Ostatnie 40 znaków ostatnio wygenerowanej części: "[poprzednie treści]"
- Aktualna część: 1 z 3

**Output:**
- Pierwsza część: Wprowadzenie do tematu SEO i jego znaczenie dla stron internetowych. Pisz w stylu konwersacyjnym, używając analogii i metafor. Zachowaj różnorodność długości akapitów i stosuj "Long Tail keywords".

(Przykładowe treści mają zwięźle przedstawić spodziewaną strukturę i styl, rzeczywiste powinny być bardziej rozwinięte.)
';
    }
}
