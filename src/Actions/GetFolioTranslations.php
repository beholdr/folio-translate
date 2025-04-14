<?php

namespace Beholdr\FolioTranslate\Actions;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Uri;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class GetFolioTranslations
{
    public function __invoke(string $url): array
    {
        $path = Uri::of(LaravelLocalization::getNonLocalizedURL($url))->path();

        if (! $view = app(GetFolioView::class)($path)) {
            return [];
        }

        return collect(LaravelLocalization::getSupportedLanguagesKeys())
            ->mapWithKeys(fn ($item) => [$item => Str::replaceLast('.blade.php', "-{$item}.blade.php", $view)])
            ->filter(fn ($item) => File::exists($item))
            ->toArray();
    }
}
