<?php

namespace Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use Wheesnoza\Ship24\Data\CacheKeyInput;
use Wheesnoza\Ship24\Data\CacheOptions;
use Wheesnoza\Ship24\Services\CacheKeyFactory;
use Wheesnoza\Ship24\Services\CacheOptionsResolver;

#[CoversClass(CacheKeyFactory::class)]
class CacheKeyFactoryTest extends TestCase
{
    public function test_generates_stable_key_for_same_input(): void
    {
        $resolver = $this->fakeResolver(new CacheOptions(true, 300, null, 'ship24'));
        $factory = new CacheKeyFactory($resolver);

        $inputA = new CacheKeyInput(
            'GET',
            'https://example.test',
            '/trackers',
            ['b' => '2', 'a' => '1'],
            ['foo' => 'bar']
        );
        $inputB = new CacheKeyInput(
            'GET',
            'https://example.test',
            '/trackers',
            ['a' => '1', 'b' => '2'],
            ['foo' => 'bar']
        );

        $keyA = $factory->make($inputA);
        $keyB = $factory->make($inputB);

        $this->assertSame($keyA->value, $keyB->value);
    }

    public function test_generates_different_key_for_different_input(): void
    {
        $resolver = $this->fakeResolver(new CacheOptions(true, 300, null, 'ship24'));
        $factory = new CacheKeyFactory($resolver);

        $inputA = new CacheKeyInput('GET', 'https://example.test', '/trackers', ['a' => '1'], []);
        $inputB = new CacheKeyInput('GET', 'https://example.test', '/trackers', ['a' => '2'], []);

        $keyA = $factory->make($inputA);
        $keyB = $factory->make($inputB);

        $this->assertNotSame($keyA->value, $keyB->value);
    }

    private function fakeResolver(CacheOptions $options): CacheOptionsResolver
    {
        return new class ($options) extends CacheOptionsResolver {
            public function __construct(private CacheOptions $options)
            {
            }

            public function resolve(): CacheOptions
            {
                return $this->options;
            }
        };
    }
}
