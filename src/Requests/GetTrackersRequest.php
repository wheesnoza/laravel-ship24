<?php

namespace Wheesnoza\Ship24\Requests;

use Illuminate\Support\Facades\Http;
use Wheesnoza\Ship24\Collections\TrackerCollection;
use Wheesnoza\Ship24\Data\TrackerData;

class GetTrackersRequest extends Request
{
    public function send(): TrackerCollection
    {
        $response = Http::get(
            $this->url("/trackers"),
            $this->query(),
        )->throw();

        return TrackerCollection::make($response->collect('data.trackers')->mapInto(TrackerData::class));
    }
}
