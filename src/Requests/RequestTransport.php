<?php

namespace Wheesnoza\Ship24\Requests;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;

class RequestTransport
{
    /** @var PendingRequest<false> */
    private readonly PendingRequest $client;

    /**
     * @param PendingRequest<false> $client
     */
    public function __construct(PendingRequest $client)
    {
        $this->client = $client;
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
