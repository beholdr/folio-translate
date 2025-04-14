<?php

namespace Beholdr\FolioTranslate;

use Beholdr\FolioTranslate\Actions\GetFolioTranslations;
use Illuminate\Container\Container;
use Illuminate\View\View;
use Laravel\Folio\InlineMetadataInterceptor;
use Laravel\Folio\Metadata;
use Laravel\Folio\Options\PageOptions;

function translate(?string $default = null): PageOptions
{
    Container::getInstance()->make(InlineMetadataInterceptor::class)->whenListening(
        fn () => Metadata::instance()->renderUsing = function (View $view) use ($default) {
            $current = app()->currentLocale();
            $default ??= app()->getFallbackLocale();
            $translations = app(GetFolioTranslations::class)(request()->path());

            $view->setPath($translations[$current] ?? $translations[$default]);
        },
    );

    return new PageOptions;
}
