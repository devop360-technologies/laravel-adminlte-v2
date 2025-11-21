<?php

namespace Devop360Technologies\LaravelAdminLte\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Devop360Technologies\LaravelAdminLte\AdminLteServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            AdminLteServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }
}