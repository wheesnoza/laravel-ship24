<?php

namespace Wheesnoza\Ship24\Requests;

use Illuminate\Http\Client\Response;
use Wheesnoza\Ship24\Support\UrlBuilder;

abstract class Request
{
    public function __construct(
        protected readonly string $accessToken,
        protected readonly string $uri,
        protected readonly UrlBuilder $urlBuilder,
        protected readonly RateLimitHandler $rateLimitHandler,
        protected readonly RequestTransport $transport,
        protected readonly CacheAwareTransport $cacheTransport,
    ) {
    }

    /**
     * @param array<string, mixed> $extra
     * @return array<string, mixed>
     */
    protected function query(array $extra = []): array
    {
        return $this->urlBuilder->buildQuery($extra);
    }

    protected function url(string $path): string
    {
        return $this->urlBuilder->buildUrl($path);
    }

    /**
     * @param callable(): Response $request
     */
    protected function sendWithRateLimit(callable $request): Response
    {
        return $this->rateLimitHandler->handle($request);
    }

    /**
     * @param array<string, mixed> $query
     */
    protected function get(string $path, array $query = []): Response
    {
        $url = $this->urlBuilder->buildUrl($path);
        $query = $this->urlBuilder->buildQuery($query);

        return $this->cacheTransport->get($url, $query);
    }

    /**
     * @param array<string, mixed> $payload
     */
    protected function post(string $path, array $payload = []): Response
    {
        $url = $this->urlBuilder->buildUrl($path);

        return $this->cacheTransport->post($url, $payload);
    }
}
