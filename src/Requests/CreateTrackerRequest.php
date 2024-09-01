<?php

namespace Wheesnoza\Ship24\Requests;

use Wheesnoza\Ship24\Data\CreateTrackerData;
use Wheesnoza\Ship24\Data\Tracker;

class CreateTrackerRequest extends Request
{
    public function send(CreateTrackerData $data): Tracker
    {
        $response = $this->http()
            ->post($this->url("trackers"), $data->toArray())
             ->throw();

        return Tracker::from($response->json('data.tracker'));
    }
}
