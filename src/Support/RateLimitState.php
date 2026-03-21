<?php

namespace Wheesnoza\Ship24\Support;

use Wheesnoza\Ship24\Data\RateLimitContext;

final class RateLimitState
{
    private static ?RateLimitContext $latest = null;

    public static function set(?RateLimitContext $context): void
    {
        self::$latest = $context;
    }

    public static function latest(): ?RateLimitContext
    {
        return self::$latest;
    }
}
