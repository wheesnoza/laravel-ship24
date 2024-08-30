<?php

namespace Wheesnoza\Ship24\Requests;

abstract class Request
{
    public function __construct(
        protected readonly string $accessToken,
        protected readonly string $uri,
    ) {
    }

    protected function query(array $extra = []): array
    {
        return [
          'access_token' => $this->accessToken,
          ...$extra,
        ];
    }

    protected function url(string $path): string
    {
        return "{$this->uri}/$path";
    }
}
