<?php

namespace Wheesnoza\Ship24\Exceptions;

use RuntimeException;
use Wheesnoza\Ship24\RateLimit\RateLimitContext;

class RateLimitExceededException extends RuntimeException
{
    public function __construct(private readonly ?RateLimitContext $context, string $message = 'Rate limit exceeded.')
    {
        parent::__construct($message);
    }

    public function context(): ?RateLimitContext
    {
        return $this->context;
    }
}
