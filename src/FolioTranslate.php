<?php

namespace Beholdr\FolioTranslate;

use Beholdr\FolioTranslate\Actions\GetFolioTranslations;
use Beholdr\FolioTranslate\Actions\GetFolioView;
use Beholdr\FolioTranslate\Actions\SetSupportedLanguagesKeys;

class FolioTranslate
{
    public function getFolioTranslations(string $url): array
    {
        return app(GetFolioTranslations::class)($url);
    }

    public function getFolioView(string $url): ?string
    {
        return app(GetFolioView::class)($url);
    }

    public function setSupportedLanguagesKeys(array $langs = []): void
    {
        app(SetSupportedLanguagesKeys::class)($langs);
    }
}
