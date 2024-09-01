<?php

namespace Wheesnoza\Ship24\Requests;

use Wheesnoza\Ship24\Collections\TrackingCollection;
use Wheesnoza\Ship24\Data\TrackingData;

class GetTrackingResultsByTrackingNumberRequest extends Request
{
    public function send(string $trackingNumber): TrackingCollection
    {
        $response = $this->http()
            ->get($this->url("trackers/search/$trackingNumber/results"), $this->query())
            ->throw();

        /** @var TrackingCollection $trackings */
        $trackings = TrackingData::collect($response->collect('data.trackings'), TrackingCollection::class);

        return $trackings;
    }
}
