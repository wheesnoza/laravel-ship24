<?php

namespace Wheesnoza\Ship24\Services;

use Wheesnoza\Ship24\Data\CacheKey;
use Wheesnoza\Ship24\Data\CacheKeyInput;
use Wheesnoza\Ship24\Data\CacheOptions;

class CacheKeyFactory
{
    private ?CacheOptions $options = null;

    public function __construct(private readonly CacheOptionsResolver $resolver)
    {
    }

    public function make(CacheKeyInput $input): CacheKey
    {
        $payload = json_encode($input->toArray(), JSON_THROW_ON_ERROR);
        $hash = hash('sha256', $payload);
        $prefix = $this->options()->prefix;
        $method = strtolower($input->method);

        return new CacheKey("{$prefix}:{$method}:{$hash}");
    }

    private function options(): CacheOptions
    {
        if ($this->options === null) {
            $this->options = $this->resolver->resolve();
        }

        return $this->options;
    }
}
