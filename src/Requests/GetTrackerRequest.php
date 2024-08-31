<?php

namespace Wheesnoza\Ship24\Requests;

use Wheesnoza\Ship24\Data\TrackerData;

class GetTrackerRequest extends Request
{
    public function send(string $trackerId): TrackerData
    {
        $response = $this->http()
            ->get($this->url("trackers/$trackerId"), $this->query())
            ->throw();

        return TrackerData::from($response->json('data.tracker'));
    }
}
