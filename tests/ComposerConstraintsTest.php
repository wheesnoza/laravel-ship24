<?php

namespace Tests;

class ComposerConstraintsTest extends TestCase
{
    public function test_requires_php_82_or_higher(): void
    {
        $composer = $this->composerJson();

        $this->assertSame('^8.2', $composer['require']['php']);
    }

    public function test_requires_laravel_11_or_12_contracts(): void
    {
        $composer = $this->composerJson();

        $this->assertSame('^11.0|^12.0', $composer['require']['illuminate/contracts']);
    }

    public function test_requires_latest_spatie_laravel_data(): void
    {
        $composer = $this->composerJson();

        $this->assertSame('^4.19.1', $composer['require']['spatie/laravel-data']);
    }

    public function test_uses_testbench_10_for_laravel_12(): void
    {
        $composer = $this->composerJson();

        $this->assertSame('^10.9.0', $composer['require-dev']['orchestra/testbench']);
    }

    public function test_uses_compatible_phpunit_version(): void
    {
        $composer = $this->composerJson();

        $this->assertSame('^11.5.3', $composer['require-dev']['phpunit/phpunit']);
    }

    /**
     * @return array<string, mixed>
     */
    private function composerJson(): array
    {
        $path = __DIR__.'/../composer.json';
        $contents = file_get_contents($path);

        $this->assertNotFalse($contents);

        /** @var array<string, mixed> $decoded */
        $decoded = json_decode($contents, true, 512, JSON_THROW_ON_ERROR);

        return $decoded;
    }
}
