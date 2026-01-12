<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::command('app:reset-weekly-x-p')->weeklyOn(1, '00:00');

Schedule::command('app:send-daily-verbs')->dailyAt('07:15');

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
