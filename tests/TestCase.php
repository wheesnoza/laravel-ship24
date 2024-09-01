<?php

namespace Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\LaravelData\LaravelDataServiceProvider;
use Wheesnoza\Ship24\Providers\Ship24ServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            LaravelDataServiceProvider::class,
            Ship24ServiceProvider::class,
        ];
    }

    protected function fixture(string $name)
    {
        return file_get_contents("Fixtures/$name.json", true);
    }
}
