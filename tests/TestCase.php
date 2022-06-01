<?php

namespace ZedanLab\UsernameGenerator\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Illuminate\Database\Eloquent\Factories\Factory;
use ZedanLab\UsernameGenerator\UsernameGeneratorServiceProvider;

class TestCase extends Orchestra
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn(string $modelName) => 'ZedanLab\\UsernameGenerator\\Tests\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            UsernameGeneratorServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        $migration = include __DIR__ . '/database/migrations/2022_05_30_000000_create_users_table.php';
        $migration->up();
    }
}
