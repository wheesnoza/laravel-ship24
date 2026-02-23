<?php

namespace Wheesnoza\Ship24\Requests;

class UrlBuilder
{
    public function __construct(private readonly string $baseUri)
    {
    }

    public function buildUrl(string $path): string
    {
        return "$this->baseUri/public/v1/$path";
    }

    /**
     * @param array<string, mixed> $extra
     * @return array<string, mixed>
     */
    public function buildQuery(array $extra = []): array
    {
        return [
            ...$extra,
        ];
    }
}
