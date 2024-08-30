<?php

namespace Wheesnoza\Ship24;

use Wheesnoza\Ship24\Data\TrackerData;
use Wheesnoza\Ship24\Requests\GetTrackerRequest;

class Ship24Service
{
    public function tracker(string $trackerId): TrackerData
    {
        return app(GetTrackerRequest::class)->send($trackerId); 
    }
}