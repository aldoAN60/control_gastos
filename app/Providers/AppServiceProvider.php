<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Validaciones;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Validaciones::class, function ($app) {
            return new Validaciones();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
