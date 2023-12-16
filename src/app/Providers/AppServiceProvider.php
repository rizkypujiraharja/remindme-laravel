<?php

namespace App\Providers;

use App\Interfaces\AuthServiceInterface;
use App\Interfaces\ReminderServiceInterface;
use App\Services\AuthService;
use App\Services\ReminderService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AuthServiceInterface::class, AuthService::class);
        $this->app->singleton(ReminderServiceInterface::class, ReminderService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
