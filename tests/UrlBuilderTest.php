<?php

namespace Tests;

use Wheesnoza\Ship24\Requests\UrlBuilder;

class UrlBuilderTest extends TestCase
{
    public function test_builds_url_with_base_uri(): void
    {
        $builder = new UrlBuilder('https://example.test');

        $this->assertSame('https://example.test/public/v1/trackers/123', $builder->buildUrl('trackers/123'));
    }

    public function test_builds_query_without_modification(): void
    {
        $builder = new UrlBuilder('https://example.test');
        $query = ['page' => 2, 'limit' => 40];

        $this->assertSame($query, $builder->buildQuery($query));
    }
}
