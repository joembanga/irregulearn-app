<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::command('app:reset-weekly-x-p')->weeklyOn(1, '00:00');

Schedule::command('app:generate-weekly-reports')->weeklyOn(1, '00:05');

Schedule::command('app:send-daily-verbs')->dailyAt('07:15');

// Schedule::command('session:gc')->daily();

// Schedule::command('queue:work --stop-when-empty --max-time=20')->everyMinute();

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');