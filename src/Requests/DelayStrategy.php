<?php

namespace Wheesnoza\Ship24\Requests;

interface DelayStrategy
{
    public function sleep(int $seconds): void;
}
