<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\Category;
use App\Models\User;
use App\Notifications\BadgeEarnedNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BadgeService
{
    /**
     * Check and award all applicable badges for a user.
     */
    public function checkAndAwardBadges(User $user): void
    {
        $this->checkXpBadges($user);
        $this->checkStreakBadges($user);
        $this->checkCategoryBadges($user);
        $this->checkSearchBadges($user);
    }

    /**
     * Check and award XP-based badges.
     */
    protected function checkXpBadges(User $user): void
    {
        $badges = Badge::where('requirement_type', 'xp')
            ->where('requirement_value', '<=', $user->xp_total)
            ->get();


        foreach ($badges as $badge) {
            $this->awardBadgeIfNotEarned($user, $badge);
        }
    }

    /**
     * Check and award streak-based badges.
     */
    protected function checkStreakBadges(User $user): void
    {
        $badges = Badge::where('requirement_type', 'streak')
            ->where('requirement_value', '<=', $user->current_streak)
            ->get();

        foreach ($badges as $badge) {
            $this->awardBadgeIfNotEarned($user, $badge);
        }
    }

    /**
     * Check and award category completion badges.
     */
    protected function checkCategoryBadges(User $user): void
    {
        // Count categories where user has mastered >= 70% of verbs
        $completedCategories = 0;

        // Efficiently count completed categories in one go
        $categoriesData = Category::withCount('verbs')->get();
        if ($categoriesData->isEmpty()) {
            return;
        }

        // Efficiently get mastery counts per category for this user using a single query
        $categoryMasteryCounts = DB::table('category_verb')
            ->join('verb_user', 'category_verb.verb_id', '=', 'verb_user.verb_id')
            ->where('verb_user.user_id', $user->id)
            ->where('verb_user.mastered', true)
            ->select('category_verb.category_id', DB::raw('count(*) as mastered_count'))
            ->groupBy('category_verb.category_id')
            ->get()
            ->keyBy('category_id');

        foreach ($categoriesData as $category) {
            $totalVerbs = $category->verbs_count;
            if ($totalVerbs === 0) {
                continue;
            }

            $masteredCount = $categoryMasteryCounts->get($category->id)->mastered_count ?? 0;

            $masteryRate = ($masteredCount / $totalVerbs) * 100;
            if ($masteryRate >= 70) {
                $completedCategories++;
            }
        }

        $badges = Badge::where('requirement_type', 'category_complete')
            ->where('requirement_value', '<=', $completedCategories)
            ->get();

        foreach ($badges as $badge) {
            $this->awardBadgeIfNotEarned($user, $badge);
        }
    }

    /**
     * Check and award search-based badges.
     */
    protected function checkSearchBadges(User $user): void
    {
        $searchCount = is_array($user->search_history) ? count($user->search_history) : 0;

        $badges = Badge::where('requirement_type', 'search')
            ->where('requirement_value', '<=', $searchCount)
            ->get();

        foreach ($badges as $badge) {
            $this->awardBadgeIfNotEarned($user, $badge);
        }
    }

    /**
     * Award a badge to a user if they haven't already earned it.
     */
    protected function awardBadgeIfNotEarned(User $user, Badge $badge): void
    {
        if ($user->badges()->where('badge_id', $badge->id)->exists()) {
            return;
        }

        $user->badges()->attach($badge->id);
        $user->notify(new BadgeEarnedNotification($badge));
    }

    /**
     * Handle job failure.
     */
    public function failed(\Throwable $exception): void
    {
        \Illuminate\Support\Facades\Log::error('BadgeService error: ' . $exception->getMessage());
    }
}
