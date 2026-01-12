<?php

namespace App\Models;

use App\Events\StreakUpdated;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use function Illuminate\Support\now;

/**
 * @property int $id
 * @property string $username
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string|null $google_id
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property int $xp_weekly
 * @property int $xp_total
 * @property int $xp_balance
 * @property int $current_streak
 * @property int $streak_is_freezed
 * @property string|null $streak_freezed_at
 * @property int $streak_freezes
 * @property int $best_streak
 * @property array<array-key, mixed>|null $search_history
 * @property string $timezone
 * @property string|null $last_activity_local_date
 * @property int $daily_target
 * @property string|null $avatar_code
 * @property string|null $avatar_url
 * @property array<array-key, mixed>|null $unlocked_items
 * @property string $role
 * @property int $is_premium
 * @property int|null $referred_by
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Badge> $badges
 * @property-read int|null $badges_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $category
 * @property-read int|null $category_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Verb> $dailyVerbs
 * @property-read int|null $daily_verbs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Verb> $favorites
 * @property-read int|null $favorites_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Friendship> $friendRequests
 * @property-read int|null $friend_requests_count
 * @property-read string $level_name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VerbExample> $likedExamples
 * @property-read int|null $liked_examples_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PointTransfer> $receivedTransfers
 * @property-read int|null $received_transfers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Verb> $verb
 * @property-read int|null $verb_count
 *
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAvatarCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAvatarUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereBestStreak($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCurrentStreak($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDailyTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereGoogleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsPremium($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastActivityLocalDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereReferredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereSearchHistory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStreakFreezedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStreakFreezes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStreakIsFreezed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUnlockedItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereXpBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereXpTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereXpWeekly($value)
 *
 * @mixin \Eloquent
 */
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'firstname',
        'lastname',
        'email',
        'password',
        'role',
        'avatar',
        'daily_target',
        'timezone',
        'google_id',
        'avatar_url',
        'unlocked_items',
        'best_streak',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'search_history' => 'array',
            'unlocked_items' => 'array',
        ];
    }

    /**
     * Get the friends of the user where the friendship status is accepted.
     */
    public function friends(?int $limit = null)
    {
        // Returns a collection of friend users (status = accepted) regardless of direction
        $friendships = Friendship::where('status', 'accepted')
            ->where(function ($q) {
                $q->where('sender_id', $this->id)->orWhere('recipient_id', $this->id);
            })->get();

        $friendIds = $friendships->map(function ($f) {
            return $f->sender_id === $this->id ? $f->recipient_id : $f->sender_id;
        })->unique()->toArray();

        if ($limit) {
            return User::whereIn('id', $friendIds)->limit($limit)->get();
        }

        return User::whereIn('id', $friendIds)->get();
    }

    public function verb()
    {
        return $this->belongsToMany(Verb::class)->withPivot('mastered');
    }

    public function category()
    {
        return $this->belongsToMany(Category::class);
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class)->withTimestamps();
    }

    /**
     * Check if user has a specific badge.
     */
    public function hasBadge(Badge $badge): bool
    {
        return $this->badges()->where('badges.id', $badge->id)->exists();
    }

    public function favorites()
    {
        return $this->belongsToMany(Verb::class, 'stared_verbs')->withTimestamps();
    }

    public function likedExamples()
    {
        return $this->belongsToMany(VerbExample::class, 'example_like_user', 'user_id', 'example_id')
            ->withTimestamps();
    }

    public function hasLikedExample(VerbExample $example)
    {
        return $this->likedExamples()->where('example_id', $example->id)->exists();
    }

    // Get user's friend requests
    public function friendRequests()
    {
        return $this->hasMany(Friendship::class, 'recipient_id')
            ->where('status', 'pending');
    }

    // Point's received history
    public function receivedTransfers()
    {
        return $this->hasMany(PointTransfer::class, 'receiver_id');
    }

    public function dailyVerbs()
    {
        $timezone = $this->timezone ?? 'UTC';

        return $this->belongsToMany(Verb::class, 'daily_verbs')
            ->withPivot('is_learned', 'day')
            ->wherePivot('day', now($timezone)->toDateString());
    }

    public function learnedVerbs(bool $haveLearned = true)
    {
        return $this->belongsToMany(Verb::class, 'daily_verbs')
            ->withPivot('is_learned', 'day')
            ->wherePivot('is_learned', $haveLearned);
    }

    /**
     * Generate daily verbs for the user if not already present.
     */
    public function generateDailyVerbs()
    {
        // If user hasn't already dailyverbs
        if ($this->dailyVerbs()->count() === 0) {
            $learnedVerbsId = $this->learnedVerbs(true)->pluck('verb_id')->toArray();
            $query = Verb::whereNotIn('id', $learnedVerbsId)->inRandomOrder();
            if ($this->daily_target) {
                $verbs = $query->limit($this->daily_target)->get();
            } else {
                $verbs = $query->limit(5)->get();
            }
            if ($verbs->isEmpty()) {
                return;
            }
            foreach ($verbs as $verb) {
                $timezone = $this->timezone ?? 'UTC';
                $this->dailyVerbs()->attach($verb->id, ['day' => now($timezone)->toDateString()]);
            }
        }
    }

    public function masteredVerbs()
    {
        return $this->verb()
            ->wherePivot('mastered', true);
    }

    /**
     * Update the user's login streak based on local timezone.
     */
    public function updateStreak()
    {
        // 1. Get "Now" in the user's timezone
        $timezone = $this->timezone ?? 'UTC';
        $localNow = Carbon::now()->setTimezone($timezone);
        $localToday = $localNow->toDateString(); // Use date only (YYYY-MM-DD)

        // 2. Get stored last activity date (extract date part if stored as datetime)
        $lastActivityDate = $this->last_activity_local_date
            ? Carbon::parse($this->last_activity_local_date)->toDateString()
            : null;

        // 3. If streak is already validated for today, do nothing
        if ($lastActivityDate === $localToday) {
            return;
        }

        // 4. Calculate yesterday's date (local)
        $localYesterday = $localNow->copy()->subDay()->toDateString();

        $currentStreak = $this->current_streak;

        // 5. Comparison logic
        if ($lastActivityDate === $localYesterday) {
            // It was yesterday, continue the streak!
            $currentStreak++;
            $this->increment('current_streak');
        } else {
            // It was before yesterday or never -> Reset :(
            // Check for STREAK FREEZE
            if ($this->streak_freezes > 0) {
                // Consumer a freeze
                $this->decrement('streak_freezes');
                // Do NOT reset streak, keep it as is
                // BUT we must verify if he missed more than 1 day?
                // The logic "It was before yesterday" implies he missed strictly > 1 day.
                // If he has a freeze, we save the streak for the *missed* day.
                // To make it simple: if he has a freeze, we consider the streak "frozen"
                // so we don't reset it to 1, but we don't increment it either for the missing days.

                // However, usually a freeze saves you from reset ONCE.
                // So we use 1 freeze. And we keep the current_streak value.

                // If he comes back after 10 days, 1 freeze shouldn't save him.
                // Simplified logic: If the gap is exactly 2 days (missed 1 day), use freeze.
                // If gap > 2 days (missed > 1 day), we need > 1 freeze?
                // Let's stick to: He missed yesterday.

                $daysMissed = Carbon::parse($lastActivityDate)->diffInDays(Carbon::parse($localNow));
                // if last activity = 2023-01-01. Today = 2023-01-03. Diff = 2. Missed 1 day (02).
                // if last activity = 2023-01-01. Today = 2023-01-04. Diff = 3. Missed 2 days (02, 03).

                // We can consume 1 freeze per missed day?
                // Let's implement: If he has enough freezes to cover the gap, use them.
                // gap - 1 = number of missed days.

                $missedDays = $localNow->diffInDays(Carbon::parse($lastActivityDate)) - 1;

                if ($missedDays <= $this->streak_freezes) {
                    // Saved!
                    $this->decrement('streak_freezes', $missedDays);
                    // Streak continues (we don't increment because he didn't play yesterday, or maybe we do?
                    // Usually freezes just prevent reset. The streak count stays same.)
                    // But since he played TODAY, we should increment or just keep?
                    // Duolingo logic: Freeze used = streak maintained.
                    // And doing a lesson today = streak + 1.
                    $this->increment('current_streak');
                } else {
                    // Not enough freezes
                    $currentStreak = 1;
                    $this->current_streak = 1;
                }
            } else {
                $currentStreak = 1;
                $this->current_streak = 1;
            }
        }

        // Update best streak
        if ($currentStreak > $this->best_streak) {
            $this->best_streak = $currentStreak;
        }

        // 6. Save today's date (store as date only for consistency)
        $this->last_activity_local_date = $localToday;
        $this->save();

        // 7. Dispatch event for background logic (milestones, badges)
        StreakUpdated::dispatch($this, $this->current_streak);
    }

    /**
     * Check if the user can access a specific category.
     */
    public function canAccessCategory(Category $category): bool
    {
        // Identify the first category (minimal order)
        $firstCategoryOrder = \App\Models\Category::min('order');
        if ($category->order === $firstCategoryOrder) {
            return true;
        }

        // Check if user has explicitly unlocked it (historical or purchase etc)
        $isManuallyUnlocked = $this->category()
            ->where('category_id', $category->id)
            ->exists();

        if ($isManuallyUnlocked) {
            return true;
        }

        // Automatic logic: Check previous category mastery
        $previousCategory = Category::where('order', '<', $category->order)
            ->orderBy('order', 'desc')
            ->first();

        if (! $previousCategory) {
            return true;
        }

        $totalVerbs = $previousCategory->verbs()->count();
        if ($totalVerbs === 0) {
            return true;
        }

        $masteredVerbs = $this->masteredVerbs()
            ->whereHas('categories', function ($q) use ($previousCategory) {
                $q->where('categories.id', $previousCategory->id);
            })->count();

        $masteryRate = ($masteredVerbs / $totalVerbs) * 100;

        return $masteryRate >= 80;
    }

    /**
     * Get the full URL for the user's avatar.
     */
    public function getAvatarUrl(): string
    {
        if (! empty($this->avatar_url)) {
            return $this->avatar_url;
        }

        if (empty($this->avatar_code)) {
            return '';
        }

        return 'https://avataaars.io/?'.$this->avatar_code;
    }

    /**
     * Get a human friendly level name based on numeric level.
     * Usage: $user->level_name
     */
    public function getLevelNameAttribute(): string
    {
        $level = $this->attributes['level'] ?? null;

        if ($level === null) {
            // Fallback: if xp_total exists, derive a rough level (safe fallback)
            if (isset($this->attributes['xp_total'])) {
                // simple heuristic: 1000 XP per level (only for fallback display)
                $level = (int) floor($this->attributes['xp_total'] / 1000) + 1;
            } else {
                $level = 1;
            }
        }

        $level = (int) $level;

        return match (true) {
            $level >= 91 => 'God',
            $level >= 76 => 'Legend',
            $level >= 51 => 'Expert',
            $level >= 31 => 'Advanced',
            $level >= 16 => 'Intermediate',
            $level >= 6 => 'Beginner',
            default => 'Starter',
        };
    }
}
