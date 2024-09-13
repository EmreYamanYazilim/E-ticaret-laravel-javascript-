<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

class RateLimitServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register limitlendirme
        RateLimiter::for('registration', function ($job) {
            return Limit::perHour(150)->by($job->ip());
        });
        // Login Limitlendirme
        RateLimiter::for('login', function ($job) {
            return Limit::perHour(10)->by($job->ip());
        });
        // Yüksek Trafiği olan sayfaları Limitlendirme
        RateLimiter::for('high-traffic', function ($job) {
            return Limit::perMinute(100)->by($job->ip());
        });
    }
}