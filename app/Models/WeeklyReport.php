<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string $week_start_date
 * @property string $week_end_date
 * @property int $verbs_mastered_count
 * @property int $xp_earned
 * @property int $streak_at_start
 * @property int $streak_at_end
 * @property int|null $leaderboard_rank_start
 * @property int|null $leaderboard_rank_end
 * @property bool $image_generated
 * @property int $shared_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 */
class WeeklyReport extends Model
{
    protected $fillable = [
        'user_id',
        'week_start_date',
        'week_end_date',
        'verbs_mastered_count',
        'xp_earned',
        'streak_at_start',
        'streak_at_end',
        'leaderboard_rank_start',
        'leaderboard_rank_end',
        'image_generated',
        'shared_count',
    ];

    protected $casts = [
        'week_start_date' => 'date',
        'week_end_date' => 'date',
        'image_generated' => 'boolean',
    ];

    /**
     * Get the user that owns the weekly report.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the rank change for this week.
     */
    public function getRankChangeAttribute(): ?int
    {
        if ($this->leaderboard_rank_start === null || $this->leaderboard_rank_end === null) {
            return null;
        }

        // Positive means improved (went up in ranking, lower number)
        return $this->leaderboard_rank_start - $this->leaderboard_rank_end;
    }

    /**
     * Get the streak change for this week.
     */
    public function getStreakChangeAttribute(): int
    {
        return $this->streak_at_end - $this->streak_at_start;
    }

    /**
     * Scope to get the latest report for a user.
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('week_start_date', 'desc');
    }

    /**
     * Scope to get reports within a date range.
     */
    public function scopeInDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('week_start_date', [$startDate, $endDate]);
    }

    /**
     * Increment the shared count.
     */
    public function incrementSharedCount(): void
    {
        $this->increment('shared_count');
    }
}
