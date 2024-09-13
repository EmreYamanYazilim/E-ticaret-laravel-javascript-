<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //migrate hatasını gidermek için
        Schema::defaultStringLength(191);
        // Register limitlendirme
        RateLimiter::for('registiration', function ($job) {
            return Limit::perHour(5)->by($job->ip());
        });
        // Login Limitlendirme
        RateLimiter::for('login', function ($job) {
            return Limit::perHour(10)->by($job->ip());
        });
        // Yüksek Trafiği olan sayfaları Limitlendirme
        RateLimiter::for('high-traffic', function ($job) {
            return Limit::perMinute(10)->by($job->ip());
        });
    }
}