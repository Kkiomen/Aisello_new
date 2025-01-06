<?php

declare(strict_types=1);

namespace App\Prompts;

use App\Prompts\Abstract\AbstractOpenApiGenerator;

class ArticleUrlKeyPrompt extends AbstractOpenApiGenerator
{
    protected static function preparePrompt(array $data = []): string
    {
        return 'Jesteś specjalistą SEO. Wiesz, że linki wewnętrzne są ważne dla pozycjonowania. Wygeneruj na podstawie treści artykułu 3-4 klucze, oddzielone przecinkiem. Jeśli w innych artykułach będą wygenerowane przez Ciebie klucze automatycznie zostaną podlinkowane do tego artykułu. \n
        ### Zwróć uwagę aby klucz bezpośrednio odnosił się do treści artykułu. Jeśli artykuł jest o Liskov to nie zwracaj SOLID ponieważ nie chciałbym mając 5 artykułów o poszczególnych literach SOLID aby odsyłało do jakiegoś konkretnego bo mam oddzielny artykuł o SOLID i oddzielne dla każdej litery.\n

        ### Przykłady:

        U: Zasada Inwersji Zależności (Dependency Inversion Principle) w SOLID
        A: Zasada Inwersji Zależności, DIP, Dependency Inversion, Dependency Inversion Principle

        U: Zasada Liskov Substitution w SOLID
        A: Zasada Liskov Substitution, Liskov Substitution, Liskov Substitution Principle, LSP

        U: Zasada Otwartego/Zamkniętego (Open/Closed Principle) w SOLID
        A: Zasada Otwartego/Zamkniętego, Open/Closed Principle, OCP, Open Closed Principle

        U: Czego unikać w PHP? Sposoby na przyspieszenie kodu
        A: Czego unikać w PHP, przyspieszenie kodu, optymalizacja kodu

        U: Zmienne i typy danych
        A: Zmienne, typy danych, zmienne w PHP, typy danych w PHP

        U: Pętla for w PHP
        A: Pętla for, pętla for w PHP, pętla for przykłady

        U: Klasy i obiekty w PHP: Wprowadzenie do Programowania Obiektowego
        A: Klasy i obiekty, programowanie obiektowe, obiekty w PHP, klasy w PHP, programowanie obiektowe w PHP

        U: Podstawowe instrukcje warunkowe: if, else, elseif
        A: Instrukcje warunkowe, if, else, elseif, instrukcje warunkowe w PHP


        ### Klucze wygeneruj w języku:  '. $data['language'] .'.';
    }
}
