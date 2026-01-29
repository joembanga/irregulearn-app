<?php

namespace App\Listeners;

use App\Events\StreakUpdated;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class HandleStreakMilestones
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
    public function handle(StreakUpdated $event): void
    {
        $user = $event->user;
        $streak = $event->newStreak;

        // Example: Bonus XP for every 5 days of streak
        if ($streak > 0 && $streak % 5 === 0) {
            $bonus = 100 * ($streak / 5);
            $user->increment('xp_balance', $bonus);
            $user->increment('xp_total', $bonus);

            // Log for debugging
            Log::info("User {$user->id} earned {$bonus} XP for {$streak} day streak!");
        }

        Cache::forget("user_stats_{$user->id}");
    }
}
