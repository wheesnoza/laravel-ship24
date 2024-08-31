<?php

namespace Wheesnoza\Ship24\Requests;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

abstract class Request
{
    public function __construct(
        protected readonly string $accessToken,
        protected readonly string $uri,
    ) {
    }

    protected function http(): PendingRequest
    {
        return Http::withToken($this->accessToken);
    }

    /**
     * @param array<string, mixed> $extra
     * @return array<string, mixed>
     */
    protected function query(array $extra = []): array
    {
        return [
          ...$extra,
        ];
    }

    protected function url(string $path): string
    {
        return "{$this->uri}/public/v1/$path";
    }
}
