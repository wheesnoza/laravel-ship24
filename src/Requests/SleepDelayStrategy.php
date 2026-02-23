<?php

namespace Wheesnoza\Ship24\Requests;

class SleepDelayStrategy implements DelayStrategy
{
    public function sleep(int $seconds): void
    {
        if ($seconds <= 0) {
            return;
        }

        sleep($seconds);
    }
}
