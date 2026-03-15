<?php

namespace Wheesnoza\Ship24\Services;

use Wheesnoza\Ship24\Data\CacheOptions;

class CachePolicy
{
    private ?CacheOptions $options = null;

    public function __construct(private readonly CacheOptionsResolver $resolver)
    {
    }

    public function isEnabled(): bool
    {
        return $this->options()->enabled;
    }

    public function ttlSeconds(): int
    {
        return $this->options()->ttlSeconds;
    }

    private function options(): CacheOptions
    {
        if ($this->options === null) {
            $this->options = $this->resolver->resolve();
        }

        return $this->options;
    }

}
