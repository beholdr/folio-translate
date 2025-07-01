<?php

namespace Beholdr\FolioTranslate\Actions;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SetSupportedLanguagesKeys
{
    public function __invoke(array $langs = []): ?RedirectResponse
    {
        $supported = LaravelLocalization::getSupportedLocales();
        $translated = Arr::where($supported, fn ($locale, $key) => in_array($key, $langs, true));

        if ($redirect = $this->checkInternalLocaleSuffix($supported)) {
            return redirect($redirect, Response::HTTP_MOVED_PERMANENTLY);
        }

        if ($redirect = $this->checkCurrentLocaleIsTranslated($translated)) {
            return redirect($redirect, Response::HTTP_MOVED_PERMANENTLY);
        }

        LaravelLocalization::setSupportedLocales($translated);

        return null;
    }

    // check if page has locale suffix like `/transfers/moldova/index-en`
    protected function checkInternalLocaleSuffix(array $supported)
    {
        $suffixes = Arr::map(array_keys($supported), fn ($el) => '-'.$el);

        if (! Str::endsWith(request()->path(), $suffixes)) {
            return null;
        }

        $lang = Str::take(request()->path(), -2);
        $url = Str::chopEnd(request()->path(), '-'.$lang);

        return LaravelLocalization::getLocalizedURL($lang, $url, forceDefaultLocation: true);
    }

    // check if translation for current locale is not found
    protected function checkCurrentLocaleIsTranslated(array $translated)
    {
        $current = app()->getLocale();
        $default = app()->getFallbackLocale();

        return (empty($translated[$current]) && $current !== $default)
            ? LaravelLocalization::getLocalizedURL($default, forceDefaultLocation: true)
            : null;
    }
}
