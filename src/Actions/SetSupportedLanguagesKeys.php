<?php

namespace Beholdr\FolioTranslate\Actions;

use Illuminate\Support\Arr;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SetSupportedLanguagesKeys
{
    public function __invoke(array $langs = []): void
    {
        $supported = Arr::map(LaravelLocalization::getSupportedLocales(), function ($locale, $key) use ($langs) {
            $locale['hidden'] = ! in_array($key, $langs, true);

            return $locale;
        });

        LaravelLocalization::setSupportedLocales($supported);
    }
}
