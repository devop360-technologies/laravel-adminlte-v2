<?php

namespace Devop360Technologies\LaravelAdminLte\Tests\Feature;

use Devop360Technologies\LaravelAdminLte\Tests\TestCase;

class InstallCommandTest extends TestCase
{
    public function test_install_command_exists()
    {
        $exitCode = $this->artisan('adminlte:install', ['--help' => true]);
        $exitCode->assertExitCode(0);
    }

    public function test_install_command_with_basic_option()
    {
        $exitCode = $this->artisan('adminlte:install', ['--basic' => true]);
        $exitCode->assertExitCode(0);
    }
}