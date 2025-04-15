# Folio Translate

Easy translation for Laravel Folio pages.
This package based on [mcamara/laravel-localization](https://github.com/mcamara/laravel-localization).

This package extends `laravel-localization` with these features:

- translate Folio content via files in the same folder
- check and hide unsupported locales in a language switcher
- redirect to a default locale if a page does not support current locale

## Installation

You can install the package via composer:

```bash
composer require beholdr/folio-translate
```

## Usage

Add middleware alias in your `bootstrap/app.php`:

```php
return Application::configure(basePath: dirname(__DIR__))
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            // other middleware aliases...
            'supportedLocales' => \Beholdr\FolioTranslate\Middleware\SupportedLocales::class,
        ]);
```

Add middlewares in your `app/Providers/FolioServiceProvider.php`:

```php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Folio\Folio;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class FolioServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $locale = LaravelLocalization::setLocale();

        Folio::path(resource_path('views/pages'))->middleware([
            '*' => [
                'localeSessionRedirect',
                'localizationRedirect',
                'supportedLocales',
            ],
        ])->uri($locale ?? '');
    }
}
```

### Content translation

Given you have a page `views/pages/index.blade.php` and want to translate it to `english` and `russian` languages.

1. Call `translate` function in `views/pages/index.blade.php` file:

```php
<?php

use function Beholdr\FolioTranslate\translate;

translate();

?>
```

2. Create `views/pages/index-en.blade.php` and `views/pages/index-ru.blade.php` files in the same directory with original file. Translated files should have the same prefix as the original file, for example:

```
views
  pages
    some-path
      filename.blade.php
      filename-en.blade.php
      filename-ru.blade.php
    index.blade.php
    index-en.blade.php
    index-ru.blade.php
```

3. Put your translated content in these files. They will be rendered for each corresponding locale.
For example `views/pages/index-en.blade.php`:

```blade
<x-layouts.base title="English page">
    English content...
</x-layouts.base>
```

### Fallback locale

You can pass an optional argument to `translate` function to specify default (fallback) locale: `translate('en')`.
This locale will be used to load content if there is no translation for a current locale.

If not specified, it equals to a system `APP_FALLBACK_LOCALE`.

### Define supported languages manually

Sometimes you need to define supported languages for page manually. It even could be non-Folio page.
In this case you can use middleware `supportedLocales` or a helper method `setSupportedLanguagesKeys`.

#### Middleware

You can add `supportedLocales` middleware with a list of supported languages to any route:

```php
Route::get('/news', NewsController::class)
    ->middleware('supportedLocales:en,ru');
```

In this case a page will support passed languages.

#### Helper method

Also you can programmatically set supported languages, using `FolioTranslate::setSupportedLanguagesKeys()` method:

```php
if ($redirect = FolioTranslate::setSupportedLanguagesKeys(['ru', 'en'])) {
    return $redirect;
}
```

In case of absent translation for current language, `setSupportedLanguagesKeys` will return redirect to a default locale version.

## Testing

```bash
composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
