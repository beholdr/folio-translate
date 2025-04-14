<?php

namespace Beholdr\FolioTranslate;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Beholdr\FolioTranslate\Commands\FolioTranslateCommand;

class FolioTranslateServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('folio-translate')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_folio_translate_table')
            ->hasCommand(FolioTranslateCommand::class);
    }
}
