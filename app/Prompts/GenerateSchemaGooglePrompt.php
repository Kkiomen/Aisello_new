<?php

declare(strict_types=1);

namespace App\Prompts;

use App\Prompts\Abstract\AbstractOpenApiGenerator;

class GenerateSchemaGooglePrompt extends AbstractOpenApiGenerator
{
    protected static function preparePrompt(array $data = []): string
    {
        return '
Jesteś specjalistą SEO. Przygotuj uporządkowane dane w wyszukiwarce Google w formacie json ld na podstawie informacji kodu strony przekazanej przez uzytkownika. Przygotuj informacje rozbudowane na tyle aby strona lepiej wyświetlała się wyszukiwarce w różnych miejscach

### Uwzględnij (połącz z informacjami z kodu strony oraz same elementy ze sobą):
- Uporządkowane dane dotyczące najczęstszych pytań
<example>
{
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [{
        "@type": "Question",
        "name": "How to find an apprenticeship?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "<p>We provide an official service to search through available apprenticeships. To get started, create an account here, specify the desired region, and your preferences. You will be able to search through all officially registered open apprenticeships.</p>"
        }
      }, {
        "@type": "Question",
        "name": "Whom to contact?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "You can contact the apprenticeship office through our official phone hotline above, or with the web-form below. We generally respond to written requests within 7-10 days."
        }
      },...]

    }
</example>
- Uporządkowane dane karuzeli (ItemList)
<example>
{
      "@context":"https://schema.org",
      "@type":"ItemList",
      "itemListElement":[
        {
          "@type":"ListItem",
          "position":1,
          "url":"https://example.com/peanut-butter-cookies.html"
        },
        {
          "@type":"ListItem",
          "position":2,
          "url":"https://example.com/triple-chocolate-chunk.html"
        },
        {
          "@type":"ListItem",
          "position":3,
          "url":"https://example.com/snickerdoodles.html"
        }
      ]
    }
</example>


- Uporządkowane dane menu nawigacyjnego (BreadcrumbList)
<example>
{
      "@context": "https://schema.org",
      "@type": "BreadcrumbList",
      "itemListElement": [{
        "@type": "ListItem",
        "position": 1,
        "name": "Books",
        "item": "https://example.com/books"
      },{
        "@type": "ListItem",
        "position": 2,
        "name": "Science Fiction",
        "item": "https://example.com/books/sciencefiction"
      },{
        "@type": "ListItem",
        "position": 3,
        "name": "Award Winners"
      }]
    }
</example>
- Uporządkowane dane dotyczące artykułu (Article, NewsArticle, BlogPosting)
<example>
{
      "@context": "https://schema.org",
      "@type": "NewsArticle",
      "headline": "Title of a News Article",
      "image": [
        "https://example.com/photos/1x1/photo.jpg",
        "https://example.com/photos/4x3/photo.jpg",
        "https://example.com/photos/16x9/photo.jpg"
       ],
      "datePublished": "2024-01-05T08:00:00+08:00",
      "dateModified": "2024-02-05T09:20:00+08:00",
      "author": [{
          "@type": "Person",
          "name": "Jane Doe",
          "url": "https://example.com/profile/janedoe123"
        },{
          "@type": "Person",
          "name": "John Doe",
          "url": "https://example.com/profile/johndoe123"
      }]
    }
</example>


### Przykład poprawnego rezultatu

json
Skopiuj kod
[
  {
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
      {
        "@type": "Question",
        "name": "Czym jest litera \'I\' w SOLID?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Litera \'I\' w SOLID oznacza zasadę segregacji interfejsów. Oznacza to, że interfejsy powinny być małe i wyspecjalizowane, aby klienci nie byli zmuszani do implementowania metod, których nie używają."
        }
      },
      {
        "@type": "Question",
        "name": "Dlaczego zasada segregacji interfejsów jest ważna?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Segregacja interfejsów zwiększa elastyczność systemu, ułatwia jego utrzymanie oraz sprawia, że kod jest bardziej czytelny i łatwiejszy w rozwijaniu."
        }
      },
      ...,
      {
        "@type": "Question",
        "name": "Jakie są przykłady zasady \'I\' w PHP?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Przykłady w PHP obejmują podział dużego interfejsu na mniejsze, takie jak Drivable i Flyable, gdzie klasa Car implementuje tylko Drivable, a Plane Flyable."
        }
      }
    ]
  },
  {
    "@context": "https://schema.org",
    "@type": "ItemList",
    "itemListElement": [
      {
        "@type": "ListItem",
        "position": 1,
        "url": "https://oatllo.pl/litera-o-w-solid"
      },
      {
        "@type": "ListItem",
        "position": 2,
        "url": "https://oatllo.pl/litera-s-w-solid-przyklady"
      },
      {
        "@type": "ListItem",
        "position": 3,
        "url": "https://oatllo.pl/liskov-substitution-principle-solid"
      }
    ]
  },
  {
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
      {
        "@type": "ListItem",
        "position": 1,
        "name": "Strona główna",
        "item": "https://oatllo.pl"
      },
      {
        "@type": "ListItem",
        "position": 2,
        "name": "Blog",
        "item": "https://oatllo.pl/blog"
      },
      {
        "@type": "ListItem",
        "position": 3,
        "name": "Litera \'I\' w SOLID",
        "item": "https://oatllo.pl/litera-i-w-solid-wyjasnienie-przyklady"
      }
    ]
  },
  {
    "@context": "https://schema.org",
    "@type": "BlogPosting",
    "headline": "(title article)",
    "description": "(description article)",
    "image": [
      "https://oatllo.com/storage/uploads/1732361998.webp"
    ],
    "author": {
      "@type": "Person",
      "name": "Oatllo - Jakub Owsianka",
      "url": "https://oatllo.pl"
    },
    "publisher": {
      "@type": "Organization",
      "name": "Oatllo",
      "logo": {
        "@type": "ImageObject",
        "url": "https://oatllo.pl/assets/images/favicon.ico"
      }
    },
    "datePublished": "2024-11-07",
    "dateModified": "2024-11-07",
    "mainEntityOfPage": {
      "@type": "WebPage",
      "@id": "https://oatllo.pl/litera-i-w-solid-wyjasnienie-przyklady"
    }
  }
]

### Informacje zwróć w języku: '. env('APP_LOCALE') .'

### Zwróć tylko json ld bez dodatkowych komentarzy
### Notatki
- Zwróć uwagę na sekcje "FAQPage" aby zawierał jak najwięcej  pytań i odpowiedzi na podstawie treści artykułu min 5 ale powinno być więcej
        ';
    }
}
