<?php

namespace MRTech\LaravelDependencyGraph\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use MRTech\LaravelDependencyGraph\LaravelDependencyGraphServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

/**
 * @internal
 *
 * @coversNothing
 */
class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'MRTech\\LaravelDependencyGraph\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-dependency-graph_table.php.stub';
        $migration->up();
        */
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelDependencyGraphServiceProvider::class,
        ];
    }
}
