<?php

namespace Tests;

class DocumentationCompatibilityTest extends TestCase
{
    public function test_readme_contains_compatibility_and_support_policy(): void
    {
        $readme = $this->readFileContents(__DIR__.'/../README.md');

        $this->assertStringContainsString('## Compatibility', $readme);
        $this->assertStringContainsString('Laravel 12', $readme);
        $this->assertStringContainsString('PHP: 8.2', $readme);
        $this->assertStringContainsString('## Support Policy', $readme);
        $this->assertStringContainsString('## Verification Status', $readme);
        $this->assertStringContainsString('## Known Limitations', $readme);
        $this->assertStringContainsString('## Breaking Changes', $readme);
    }

    public function test_changelog_mentions_laravel_12_compatibility(): void
    {
        $changelog = $this->readFileContents(__DIR__.'/../CHANGELOG.md');

        $this->assertStringContainsString('Laravel 12', $changelog);
        $this->assertStringContainsString('Compatibility', $changelog);
    }

    private function readFileContents(string $path): string
    {
        $contents = file_get_contents($path);

        $this->assertNotFalse($contents);

        return $contents;
    }
}
