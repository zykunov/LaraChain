<?php

namespace App\Providers;

use App\Services\Chain\Storage\DatabaseStorage;
use App\Services\Chain\Storage\StorageInterface;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(StorageInterface::class, function ($app) {
            return new DatabaseStorage();
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
