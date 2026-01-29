<?php

namespace App\Listeners;

use App\Events\ExerciseCompleted;
use App\Services\BadgeService;
class CheckBadges
{

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ExerciseCompleted $event): void
    {
        app(BadgeService::class)->checkAndAwardBadges($event->user);
    }
}
