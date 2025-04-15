<?php

namespace Beholdr\FolioTranslate\Middleware;

use Beholdr\FolioTranslate\Actions\GetFolioTranslations;
use Beholdr\FolioTranslate\Actions\SetSupportedLanguagesKeys;
use Closure;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationMiddlewareBase;
use Symfony\Component\HttpFoundation\Response;

class SupportedLocales extends LaravelLocalizationMiddlewareBase
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$locales): Response
    {
        if ($this->shouldIgnore($request)) {
            return $next($request);
        }

        $default = app()->getFallbackLocale();

        if (empty($locales)) {
            $translations = array_keys(app(GetFolioTranslations::class)(request()->path()));
            $locales = ! empty($translations) ? $translations : [$default];
        }

        if ($redirect = app(SetSupportedLanguagesKeys::class)($locales)) {
            return $redirect;
        }

        return $next($request);
    }
}
