<?php

namespace Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Wheesnoza\Ship24\Providers\Ship24ServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            Ship24ServiceProvider::class
        ];
    }
}
