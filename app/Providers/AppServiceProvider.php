<?php

namespace App\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
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
        if (!app()->isLocal()) {
            URL::forceScheme('https');
        }

        if (!Cache::has('last-scheduler-run')) {
            try {
                Artisan::call('schedule:run');
                Cache::put('last-scheduler-run', true, now()->addMinutes(5));
            } catch (\Exception $e) {
                Log::error("Cron fail: " . $e->getMessage());
            }
        }
    }
}
