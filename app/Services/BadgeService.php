<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\User;
use App\Notifications\BadgeEarnedNotification;

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

        $categories = \App\Models\Category::all();
        foreach ($categories as $category) {
            $totalVerbs = $category->verbs()->count();
            if ($totalVerbs === 0) continue;

            $masteredVerbs = $user->masteredVerbs()
                ->whereHas('categories', fn($q) => $q->where('categories.id', $category->id))
                ->count();

            $masteryRate = ($masteredVerbs / $totalVerbs) * 100;
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
}
