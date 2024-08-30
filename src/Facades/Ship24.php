<?php

namespace Wheesnoza\Ship24\Facades;

use Illuminate\Support\Facades\Facade;
use Wheesnoza\Ship24\Ship24Service;

class Ship24 extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Ship24Service::class;
    }
}
