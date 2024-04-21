<?php

namespace App\Providers;

use App\Services\Transistor;
use App\Services\ZohoCrmApi;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ZohoCrmApi::class, function ($app) {
            return new ZohoCrmApi();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
