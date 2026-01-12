<?php

namespace App\Listeners;

use App\Events\ExerciseCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class UpdateUserStats implements ShouldQueue
{
    use InteractsWithQueue;

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
        $user = $event->user;

        // 1. Update XP
        $user->increment('xp_balance', $event->xp);
        $user->increment('xp_total', $event->xp);
        $user->increment('xp_weekly', $event->xp);

        // 2. Update Mastery
        if (! empty($event->masteredVerbIds)) {
            $syncData = [];
            foreach ($event->masteredVerbIds as $id) {
                $syncData[$id] = ['mastered' => true];
            }
            $user->verb()->syncWithoutDetaching($syncData);
        }

        // 3. Cache Clearing
        Cache::forget("user_stats_{$user->id}");
        Cache::forget("user_categories_progress_{$user->id}");
        Cache::forget('leaderboard_weekly');
        Cache::forget('leaderboard_global');
    }
}
