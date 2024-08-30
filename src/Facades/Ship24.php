<?php

namespace Wheesnoza\Ship24\Facades;

use Illuminate\Support\Facades\Facade;
use Wheesnoza\Ship24\Ship24Service;

/**
 * @method static \Wheesnoza\Ship24\Ship24Service tracker(string $trackerId)
 * @method static \Wheesnoza\Ship24\Ship24Service trackers()
 */
class Ship24 extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Ship24Service::class;
    }
}
