<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\OpenAiModel;
use App\Models\Article;
use App\Prompts\GenerateSchemaGooglePrompt;
use Illuminate\Support\Facades\Http;

class StructureDataGoogleSearchService
{
    public static function generateStructureData(Article $article): string
    {
        $articleData = Http::get($article->getRoute());

        $userPrompt = '### Url do strony: ' . $article->getRoute() . '### Kod strony: ' . $articleData->body();

        $result = GenerateSchemaGooglePrompt::generateContent(
            userContent: $userPrompt,
            model: OpenAiModel::GPT4O,
        );

        return str_replace(['```json', '```'], '', $result);
    }
}
