<?php

namespace Wheesnoza\Ship24\Requests;

use Illuminate\Support\Facades\Http;
use Wheesnoza\Ship24\Data\TrackerData;

class GetTrackerRequest extends Request
{
    public function send(string $id): TrackerData
    {
        $data = Http::get(
            $this->url("/trackers/$id"),
            $this->query(),
        )->throw();

        return TrackerData::from($data->json('data.tracker'));
    }
}
