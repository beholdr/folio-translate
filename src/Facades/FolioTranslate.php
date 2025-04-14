<?php

namespace Beholdr\FolioTranslate\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Beholdr\FolioTranslate\FolioTranslate
 */
class FolioTranslate extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Beholdr\FolioTranslate\FolioTranslate::class;
    }
}
