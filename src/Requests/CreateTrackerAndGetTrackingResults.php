<?php

namespace Wheesnoza\Ship24\Requests;

use Wheesnoza\Ship24\Collections\TrackingCollection;
use Wheesnoza\Ship24\Data\CreateTrackerData;
use Wheesnoza\Ship24\Data\Tracking;

class CreateTrackerAndGetTrackingResults extends Request
{
    public function send(CreateTrackerData $data): TrackingCollection
    {
        $response = $this->http()
            ->post($this->url("trackers/track"), $data->toArray())
             ->throw();

        /** @var TrackingCollection $trackings */
        $trackings = Tracking::collect($response->collect('data.trackings'), TrackingCollection::class);

        return $trackings;
    }
}
