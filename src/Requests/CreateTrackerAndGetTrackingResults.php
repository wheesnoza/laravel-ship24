<?php

namespace Wheesnoza\Ship24\Requests;

use Wheesnoza\Ship24\Collections\TrackingCollection;
use Wheesnoza\Ship24\Data\CreateTrackerData;
use Wheesnoza\Ship24\Data\TrackingData;

class CreateTrackerAndGetTrackingResults extends Request
{
    public function send(CreateTrackerData $data): TrackingCollection
    {
        $response = $this->http()
            ->post($this->url("trackers/track"), $data->toArray())
             ->throw();

        return TrackingCollection::make(
            $response->collect('data.trackings')
                 ->map(fn ($tracking) => TrackingData::from($tracking))->all()
        );
    }
}
