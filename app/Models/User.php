<?php

namespace App\Models;

use App\Events\StreakUpdated;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

use function Illuminate\Support\now;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

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
    public function friends(int|null $limit = null)
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
                 $daysMissed = Carbon::parse($lastActivityDate)->diffInDays(Carbon::parse($localNow));
                 $missedDays = $localNow->diffInDays(Carbon::parse($lastActivityDate)) - 1;
                 
                 if ($missedDays <= $this->streak_freezes) {
                     // Saved!
                     $this->decrement('streak_freezes', $missedDays);
                     $currentStreak++;
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
     *
     * @param Category $category
     * @return bool
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

        if (!$previousCategory) {
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
        if (!empty($this->avatar_url)) {
            return $this->avatar_url;
        }
        
        if (empty($this->avatar_code)) {
            return '';
        }
        return "https://avataaars.io/?" . $this->avatar_code;
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
