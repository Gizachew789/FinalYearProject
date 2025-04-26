<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // You can register services or bindings here if needed.
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Place code here for bootstrapping Blade components, view composers, etc., if needed.
    }
}
