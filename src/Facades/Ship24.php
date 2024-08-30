<?php

namespace Wheesnoza\Ship24\Facades;

use Wheesnoza\Ship24\Ship24Service;
use Illuminate\Support\Facades\Facade;

class Ship24 extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Ship24Service::class;
    }
}