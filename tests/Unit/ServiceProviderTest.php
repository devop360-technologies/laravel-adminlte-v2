<?php

namespace Devop360Technologies\LaravelAdminLte\Tests\Unit;

use Devop360Technologies\LaravelAdminLte\Tests\TestCase;
use Devop360Technologies\LaravelAdminLte\AdminLte;
use Devop360Technologies\LaravelAdminLte\AdminLteServiceProvider;

class ServiceProviderTest extends TestCase
{
    public function test_service_provider_is_registered()
    {
        $this->assertTrue($this->app->providerIsLoaded(AdminLteServiceProvider::class));
    }

    public function test_adminlte_service_is_bound()
    {
        $this->assertTrue($this->app->bound(AdminLte::class));
    }

    public function test_adminlte_service_is_singleton()
    {
        $instance1 = $this->app->make(AdminLte::class);
        $instance2 = $this->app->make(AdminLte::class);
        
        $this->assertSame($instance1, $instance2);
    }

    public function test_views_are_loaded()
    {
        $this->assertTrue(view()->exists('adminlte::page'));
        $this->assertTrue(view()->exists('adminlte::master'));
    }

    public function test_config_is_merged()
    {
        $title = config('adminlte.title');
        $this->assertNotNull($title);
        $this->assertEquals('AdminLTE 2', $title);
    }
}