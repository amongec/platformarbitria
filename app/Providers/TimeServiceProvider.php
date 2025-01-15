<?php

namespace App\Providers;

use App\Interfaces\TimeServiceInterface;
use App\Services\TimeService;
use Illuminate\Support\ServiceProvider;

class TimeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
      $this->app->bind(TimeServiceInterface::class, TimeService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
