<?php

namespace Wheesnoza\Ship24\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Wheesnoza\Ship24\Data\RateLimitConfig;
use Wheesnoza\Ship24\Repositories\CacheRepository;
use Wheesnoza\Ship24\Requests\CacheAwareTransport;
use Wheesnoza\Ship24\Requests\CreateTrackerAndGetTrackingResults;
use Wheesnoza\Ship24\Requests\CreateTrackerRequest;
use Wheesnoza\Ship24\Requests\GetTrackerRequest;
use Wheesnoza\Ship24\Requests\GetTrackersRequest;
use Wheesnoza\Ship24\Requests\GetTrackingResultsByTrackerIdRequest;
use Wheesnoza\Ship24\Requests\GetTrackingResultsByTrackingNumberRequest;
use Wheesnoza\Ship24\Requests\RateLimitContextFactory;
use Wheesnoza\Ship24\Requests\RateLimitHandler;
use Wheesnoza\Ship24\Requests\RequestTransport;
use Wheesnoza\Ship24\Requests\SleepDelayStrategy;
use Wheesnoza\Ship24\Services\CacheKeyFactory;
use Wheesnoza\Ship24\Services\CacheOptionsResolver;
use Wheesnoza\Ship24\Services\CachePolicy;
use Wheesnoza\Ship24\Support\UrlBuilder;

class Ship24ServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/ship24.php', 'ship24');

        $this->app->singleton(CacheOptionsResolver::class, fn () => new CacheOptionsResolver());
        $this->app->singleton(CachePolicy::class, fn ($app) => new CachePolicy(
            $app->make(CacheOptionsResolver::class)
        ));
        $this->app->singleton(CacheKeyFactory::class, fn ($app) => new CacheKeyFactory(
            $app->make(CacheOptionsResolver::class)
        ));
        $this->app->singleton(CacheRepository::class, fn ($app) => new CacheRepository(
            $app->make(CacheOptionsResolver::class)
        ));

        $requests = [
            GetTrackerRequest::class,
            GetTrackersRequest::class,
            CreateTrackerRequest::class,
            CreateTrackerAndGetTrackingResults::class,
            GetTrackingResultsByTrackerIdRequest::class,
            GetTrackingResultsByTrackingNumberRequest::class,
        ];

        foreach ($requests as $requestClass) {
            $this->app->singleton($requestClass, function () use ($requestClass) {
                $accessToken = config()->string('ship24.access_token');
                $uri = config()->string('ship24.uri');
                $urlBuilder = new UrlBuilder($uri);
                $rateLimitHandler = new RateLimitHandler(
                    new RateLimitConfig(
                        config()->boolean('ship24.rate_limit.enabled', true),
                        config()->integer('ship24.rate_limit.max_attempts', 3),
                        config()->integer('ship24.rate_limit.base_delay_seconds', 2),
                        config()->integer('ship24.rate_limit.max_delay_seconds', 60),
                    ),
                    new SleepDelayStrategy(),
                    new RateLimitContextFactory()
                );
                $transport = new RequestTransport(Http::withToken($accessToken));
                $cachePolicy = $this->app->make(CachePolicy::class);
                $cacheKeyFactory = $this->app->make(CacheKeyFactory::class);
                $cacheRepository = $this->app->make(CacheRepository::class);
                $cacheTransport = new CacheAwareTransport(
                    $cachePolicy,
                    $cacheKeyFactory,
                    $cacheRepository,
                    $transport,
                    $rateLimitHandler
                );

                return new $requestClass(
                    $accessToken,
                    $uri,
                    $urlBuilder,
                    $rateLimitHandler,
                    $transport,
                    $cacheTransport,
                );
            });
        }
    }

    public function boot(): void
    {
        $this->publishes([__DIR__.'/../../config/ship24.php' => config_path('ship24.php')], 'config');
    }
}
