<?php

namespace Wheesnoza\Ship24\Transformers;

use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Support\Transformation\TransformationContext;
use Spatie\LaravelData\Transformers\Transformer;

class SortedArrayTransformer implements Transformer
{
    public function transform(DataProperty $property, mixed $value, TransformationContext $context): mixed
    {
        if (!is_array($value)) {
            return $value;
        }

        return $this->sortRecursive($value);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    private function sortRecursive(array $data): array
    {
        ksort($data);

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->sortRecursive($value);
            }
        }

        return $data;
    }
}
