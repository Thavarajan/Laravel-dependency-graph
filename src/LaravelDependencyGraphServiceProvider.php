<?php

namespace MRTech\LaravelDependencyGraph;

use MRTech\LaravelDependencyGraph\Commands\LaravelDependencyGraphCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelDependencyGraphServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-dependency-graph')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-dependency-graph_table')
            ->hasCommand(LaravelDependencyGraphCommand::class);
    }
}
