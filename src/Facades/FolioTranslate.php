<?php

namespace Beholdr\FolioTranslate\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array getFolioTranslations(string $url)
 * @method static ?string getFolioView(string $url)
 * @method static void setSupportedLanguagesKeys(array $langs = [])
 *
 * @see \Beholdr\FolioTranslate\FolioTranslate
 */
class FolioTranslate extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Beholdr\FolioTranslate\FolioTranslate::class;
    }
}
