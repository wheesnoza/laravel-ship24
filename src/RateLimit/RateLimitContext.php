<?php

namespace Wheesnoza\Ship24\RateLimit;

use Illuminate\Http\Client\Response;

class RateLimitContext
{
    /** @var array<string, array<int, string>> */
    private array $rawHeaders;

    /**
     * @param array<string, array<int, string>> $rawHeaders
     */
    public function __construct(
        private readonly ?int $limit,
        private readonly ?int $remaining,
        private readonly ?int $resetSeconds,
        private readonly ?int $retryAfterSeconds,
        private readonly string $headerSource,
        array $rawHeaders
    ) {
        $this->rawHeaders = $rawHeaders;
    }

    public static function fromResponse(Response $response): self
    {
        /** @var array<string, array<int, string>> $headers */
        $headers = $response->headers();
        $headers = array_change_key_case($headers, CASE_LOWER);

        $source = 'none';
        $limit = self::headerInt($headers, 'ratelimit-limit');
        $remaining = self::headerInt($headers, 'ratelimit-remaining');
        $reset = self::headerInt($headers, 'ratelimit-reset');

        if ($limit !== null || $remaining !== null || $reset !== null) {
            $source = 'ratelimit';
        } else {
            $limit = self::headerInt($headers, 'x-ratelimit-limit');
            $remaining = self::headerInt($headers, 'x-ratelimit-remaining');
            $reset = self::headerInt($headers, 'x-ratelimit-reset');

            if ($limit !== null || $remaining !== null || $reset !== null) {
                $source = 'x-ratelimit';
            }
        }

        $retryAfter = self::headerInt($headers, 'retry-after');

        return new self($limit, $remaining, $reset, $retryAfter, $source, $headers);
    }

    public function limit(): ?int
    {
        return $this->limit;
    }

    public function remaining(): ?int
    {
        return $this->remaining;
    }

    public function resetSeconds(): ?int
    {
        return $this->resetSeconds;
    }

    public function retryAfterSeconds(): ?int
    {
        return $this->retryAfterSeconds;
    }

    public function headerSource(): string
    {
        return $this->headerSource;
    }

    /** @return array<string, array<int, string>> */
    public function rawHeaders(): array
    {
        return $this->rawHeaders;
    }

    /**
     * @param array<string, array<int, string>> $headers
     */
    private static function headerInt(array $headers, string $key): ?int
    {
        if (! array_key_exists($key, $headers)) {
            return null;
        }

        $value = $headers[$key][0] ?? null;
        if ($value === null) {
            return null;
        }

        if (! is_numeric($value)) {
            return null;
        }

        return (int) $value;
    }
}
