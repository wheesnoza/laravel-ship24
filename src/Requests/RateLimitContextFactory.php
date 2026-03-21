<?php

namespace Wheesnoza\Ship24\Requests;

use Illuminate\Http\Client\Response;
use Wheesnoza\Ship24\Data\RateLimitContext;
use Wheesnoza\Ship24\Data\RateLimitHeaders;

final class RateLimitContextFactory
{
    public function fromResponse(Response $response): RateLimitContext
    {
        /** @var array<string, array<int, string>> $headers */
        $headers = $response->headers();
        $headers = array_change_key_case($headers, CASE_LOWER);
        $rateLimitHeaders = RateLimitHeaders::from([
            'limit' => $this->firstHeaderValue($headers, 'ratelimit-limit'),
            'remaining' => $this->firstHeaderValue($headers, 'ratelimit-remaining'),
            'reset' => $this->firstHeaderValue($headers, 'ratelimit-reset'),
            'retryAfter' => $this->firstHeaderValue($headers, 'retry-after'),
        ]);

        $source = 'none';
        $limit = $rateLimitHeaders->limit;
        $remaining = $rateLimitHeaders->remaining;
        $reset = $rateLimitHeaders->reset;

        if ($limit !== null || $remaining !== null || $reset !== null) {
            $source = 'ratelimit';
        }

        return new RateLimitContext(
            $limit,
            $remaining,
            $reset,
            $this->retryAfterSeconds($rateLimitHeaders),
            $source,
            $rateLimitHeaders,
        );
    }

    /**
     * @param array<string, array<int, string>> $headers
     */
    private function firstHeaderValue(array $headers, string $key): ?string
    {
        if (! array_key_exists($key, $headers)) {
            return null;
        }

        return $headers[$key][0] ?? null;
    }

    private function retryAfterSeconds(RateLimitHeaders $headers): ?int
    {
        if ($headers->retryAfter === null || ! is_numeric($headers->retryAfter)) {
            return null;
        }

        return (int) $headers->retryAfter;
    }
}
