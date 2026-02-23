<?php

namespace Wheesnoza\Ship24\Requests;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;

class RequestTransport
{
    public function __construct(private readonly PendingRequest $client)
    {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function get(string $url, array $payload = []): Response
    {
        return $this->client->get($url, $payload);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function post(string $url, array $payload = []): Response
    {
        return $this->client->post($url, $payload);
    }
}
