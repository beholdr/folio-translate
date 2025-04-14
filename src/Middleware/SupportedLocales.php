<?php

namespace Beholdr\FolioTranslate\Middleware;

use Beholdr\FolioTranslate\Actions\GetFolioTranslations;
use Beholdr\FolioTranslate\Actions\SetSupportedLanguagesKeys;
use Closure;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
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

        $current = app()->getLocale();
        $default = app()->getFallbackLocale();

        if (empty($locales)) {
            $translations = array_keys(app(GetFolioTranslations::class)(request()->path()));
            $locales = ! empty($translations) ? $translations : [$default];
        }

        // redirect to default locale if current locale not found
        // e.g. when navigate to a frontpage from localized country page
        if (! in_array($current, $locales, true) && $current !== $default) {
            return redirect(
                LaravelLocalization::getLocalizedURL($default, forceDefaultLocation: true), Response::HTTP_MOVED_PERMANENTLY
            );
        }

        app(SetSupportedLanguagesKeys::class)($locales);

        return $next($request);
    }
}
