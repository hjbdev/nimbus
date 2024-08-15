<?php

namespace Hjbdev\Nimbus;

use Hjbdev\Nimbus\Commands\NimbusCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class NimbusServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('nimbus')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_nimbus_table')
            ->hasCommand(NimbusCommand::class);
    }
}
