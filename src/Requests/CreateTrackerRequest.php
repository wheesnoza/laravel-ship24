<?php

namespace Wheesnoza\Ship24\Requests;

use Wheesnoza\Ship24\Data\CreateTrackerData;
use Wheesnoza\Ship24\Data\TrackerData;

class CreateTrackerRequest extends Request
{
    public function send(CreateTrackerData $data): TrackerData
    {
        $response = $this->http()
            ->post($this->url("trackers"), $data->toArray())
             ->throw();

        return TrackerData::from($response->json('data.tracker'));
    }
}
