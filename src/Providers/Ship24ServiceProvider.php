<?php

namespace Wheesnoza\Ship24\Providers;

use Wheesnoza\Ship24\Requests\GetTrackerRequest;
use Illuminate\Support\ServiceProvider;

class Ship24ServiceProvider extends ServiceProvider
{
    public function register()
    {
        $requests = [
            GetTrackerRequest::class,
          ];
      
          foreach ($requests as $requestClass) {
            $this->app->singleton($requestClass, fn () => new $requestClass(
                config('services.ship24.access_token'),
                config('services.ship24.uri')
              )
            );
          }
    }
}