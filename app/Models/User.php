<?php

namespace App\Models;

use App\Events\StreakUpdated;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

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
class User extends Authenticatable /* implements MustVerifyEmail */
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
            return User::whereIn('id', $friendIds)->limit($limit);
        }

        return User::whereIn('id', $friendIds);
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

    // Weekly mastery reports
    public function weeklyReports()
    {
        return $this->hasMany(WeeklyReport::class)->latest();
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

    public function hadLearnedTodaysVerbs()
    {
        $timezone = $this->timezone ?? 'UTC';
        return (
                $this->belongsToMany(Verb::class, 'daily_verbs')
                ->withPivot('is_learned', 'day')
                ->wherePivot('day', now($timezone)->toDateString())
                ->wherePivot('is_learned', true)
                ->count()
            ) === $this->daily_target;
    }

    /**
     * Generate daily verbs for the user if not already present.
     */
    public function generateDailyVerbs(): void
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

    public function masteredVerbs(): BelongsToMany
    {
        return $this->verb()
            ->wherePivot('mastered', true);
    }

    /**
     * Check if the streak has expired and reset it to 0 if necessary.
     * Can be called independently (e.g., on dashboard load).
     */
    public function checkStreak()
    {
        $timezone = $this->timezone ?? 'UTC';
        $localNow = now()->setTimezone($timezone);
        $localToday = $localNow->toDateString();
        $localYesterday = $localNow->copy()->subDay()->toDateString();

        $lastActivity = $this->last_activity_local_date ? Carbon::parse($this->last_activity_local_date) : null;
        if (!$lastActivity) return;

        $lastDate = $lastActivity->toDateString();

        // If last activity was before yesterday, and he hasn't practiced yet today
        if ($lastDate !== $localToday && $lastDate !== $localYesterday) {
            // Gap detected! (He missed yesterday)
            $missedDays = Carbon::parse($lastDate)->diffInDays(Carbon::parse($localToday)) - 1;
            if ($missedDays > 0) {
                if ($this->streak_freezes >= $missedDays) {
                    // Saved by freezes!
                    $this->decrement('streak_freezes', $missedDays);
                    // Move last activity to "Yesterday" so it's ready to be continued
                    $this->last_activity_local_date = $localNow->copy()->subDay()->startOfDay();
                    $this->save();
                } else {
                    // Streak lost :(
                    if ($this->current_streak > 0) {
                        $this->current_streak = 0;
                        $this->save();
                        StreakUpdated::dispatch($this, 0);
                    }
                }
            }
        }
    }

    /**
     * Update the user's login streak based on local timezone.
     * Called when a session is finished.
     */
    public function updateStreak()
    {
        // 1. First, make sure we catch up on missed days
        $this->checkStreak();

        $timezone = $this->timezone ?? 'UTC';
        $localNow = now()->setTimezone($timezone);
        $localToday = $localNow->toDateString();

        $lastActivity = $this->last_activity_local_date ? Carbon::parse($this->last_activity_local_date) : null;
        $lastDate = $lastActivity ? $lastActivity->toDateString() : null;

        // 2. If already practiced today, nothing more to do
        if ($lastDate === $localToday) {
            return;
        }

        // 3. At this point, we are practicing for the first time today.
        // checkStreak already handled gaps, so it's either yesterday or he was reset to 0.
        $this->current_streak++;

        // 4. Update best streak
        if ($this->current_streak > $this->best_streak) {
            $this->best_streak = $this->current_streak;
        }

        // 5. Store activity and save
        $this->last_activity_local_date = $localNow;
        $this->save();

        // 6. Notify for milestones/badges
        StreakUpdated::dispatch($this, $this->current_streak);
    }

    /**
     * Check if the user can access a specific category.
     */
    public function canAccessCategory(Category $category): bool
    {
        // Identify the first category (minimal order)
        $firstCategoryOrder = Category::min('order');
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
        // 1. Check for local file first (Performance & Reliability)
        if ($this->avatar_url && Storage::disk('public')->exists($this->avatar_url)) {
            return asset('storage/' . $this->avatar_url);
        }

        // 2. Fallback to external API
        if ($this->avatar_code) {
            $options = [];
            parse_str($this->avatar_code, $options);
            return 'https://avataaars.io/?' . http_build_query($options);
        }

        return '';
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

    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmailNotification());
    }

    /**
     * Calculate when the streak will expire based on user's timezone.
     */
    public function getStreakExpiresAtAttribute(): ?Carbon
    {
        $timezone = $this->timezone ?? 'UTC';
        $localNow = Carbon::now($timezone);
        $localToday = $localNow->toDateString();

        if (! $this->last_activity_local_date) {
            return null;
        }

        $lastActivityDate = Carbon::parse($this->last_activity_local_date)->toDateString();

        // If user played today, they have until the end of tomorrow to play again.
        if ($lastActivityDate === $localToday) {
            return $localNow->copy()->addDay()->endOfDay();
        }

        // If they played yesterday, they have until the end of today.
        $localYesterday = $localNow->copy()->subDay()->toDateString();
        if ($lastActivityDate === $localYesterday) {
            return $localNow->copy()->endOfDay();
        }

        // Otherwise, the streak is already technically expired (awaiting next login to reset).
        return null;
    }
}
