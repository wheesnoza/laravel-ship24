<?php

namespace Wheesnoza\Ship24\Providers;

use Illuminate\Support\ServiceProvider;
use Wheesnoza\Ship24\Requests\GetTrackerRequest;

class Ship24ServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/ship24.php', 'ship24');

        $requests = [
            GetTrackerRequest::class,
        ];

        /** @var string $accessToken */
        $accessToken = config('ship24.access_token');
        /** @var string $uri */
        $uri = config('ship24.uri');

        foreach ($requests as $requestClass) {
            $this->app->singleton($requestClass, fn () => new $requestClass(
                $accessToken,
                $uri
            ));
        }
    }

    public function boot(): void
    {
        $this->publishes([__DIR__.'/../../config/ship24.php' => config_path('ship24.php')], 'config');
    }
}
