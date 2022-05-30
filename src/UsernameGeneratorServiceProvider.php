<?php

namespace ZedanLab\UsernameGenerator;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use ZedanLab\UsernameGenerator\Commands\UsernameGeneratorCommand;

class UsernameGeneratorServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-username-generator')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-username-generator_table')
            ->hasCommand(UsernameGeneratorCommand::class);
    }
}
