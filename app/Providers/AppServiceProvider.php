<?php

namespace App\Providers;


use App\Contracts\CategoryItemServiceInterface;
use App\Contracts\ImageServiceInterface;
use App\Services\CategoryItemService;
use App\Services\ImageService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ImageServiceInterface::class,
            ImageService::class
        );

        $this->app->bind(
            CategoryItemServiceInterface::class,
            CategoryItemService::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {}
}
