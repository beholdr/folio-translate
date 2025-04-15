<?php

namespace Beholdr\FolioTranslate\Actions;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SetSupportedLanguagesKeys
{
    public function __invoke(array $langs = []): ?RedirectResponse
    {
        $current = app()->getLocale();
        $default = app()->getFallbackLocale();

        $supported = Arr::where(
            LaravelLocalization::getSupportedLocales(),
            fn ($locale, $key) => in_array($key, $langs, true)
        );

        // redirect to default locale if translation for current locale not found
        if (empty($supported[$current]) && $current !== $default) {
            return redirect(
                LaravelLocalization::getLocalizedURL($default, forceDefaultLocation: true), Response::HTTP_MOVED_PERMANENTLY
            );
        }

        LaravelLocalization::setSupportedLocales($supported);

        return null;
    }
}
