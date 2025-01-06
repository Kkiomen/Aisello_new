<?php

declare(strict_types=1);

namespace App\Services;

class HomeService
{

    public static function getTagManagerHEAD(): string
    {
        $defaultLangue = env('APP_LOCALE');
        if($defaultLangue == 'pl'){
            return "

";
        }
        return "

";
    }

    public static function getTagManagerBODY(): string
    {
        $defaultLangue = env('APP_LOCALE');
        if($defaultLangue == 'pl'){
            return '

            ';
        }
        return '';
    }
}
