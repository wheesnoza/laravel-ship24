<?php

namespace Wheesnoza\Ship24\Requests;

use Wheesnoza\Ship24\Collections\TrackingCollection;
use Wheesnoza\Ship24\Data\Tracking;

class GetTrackingResultsByTrackingNumberRequest extends Request
{
    public function send(string $trackingNumber): TrackingCollection
    {
        $response = $this->get("trackers/search/$trackingNumber/results");

        /** @var TrackingCollection $trackings */
        $trackings = Tracking::collect($response->collect('data.trackings'), TrackingCollection::class);

        return $trackings;
    }
}
