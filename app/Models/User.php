<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        'daily_target'
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
        ];
    }

    // Get user's friends
    public function friends()
    {
        return $this->belongsToMany(User::class, 'friendships', 'sender_id', 'recipient_id')->where('status', 'accepted')->get();
    }

    public function verb()
    {
        return $this->belongsToMany(Verb::class);
    }

    public function category()
    {
        return $this->belongsToMany(Category::class);
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class);
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
        return $this->belongsToMany(Verb::class, 'daily_verbs')
            ->withPivot('is_learned', 'day')
            ->wherePivot('day', now()->toDateString());
    }

    public function generateDailyVerbs()
    {
        // If user hasn't already dailyverbs
        if ($this->dailyVerbs()->count() === 0) {

            // (Pour simplifier ici, on prend juste 5 verbes aléatoires)
            $verbs = Verb::inRandomOrder()->take(5)->get();

            foreach ($verbs as $verb) {
                $this->dailyVerbs()->attach($verb->id, ['day' => now()->toDateString()]);
            }
        }
    }

    public function masteredVerbs()
    {
        return $this->verb()
        ->wherePivot('mastered', true);
    }

    public function canAccessCategory(Category $category): bool
    {
        // The first category is always unlocekd
        if ($category->order === 0) return true;

        $userUnclockedCategories = $this->category()
            ->wherePivot('user_id', $this->id)
            ->withPivotValue('category_id', $category->id)
            ->get()->toArray();
        
        // If user had paid this category
        if (count($userUnclockedCategories) > 0) {
            foreach ($userUnclockedCategories as $userUnclockedCategory) {
                if ($userUnclockedCategory['pivot']['category_id'] === $category->id) {
                    return true;
                };
            }
        };

        $previousCategory = Category::where('order', $category->order - 1)->first();
        if (!$previousCategory) return true;

        // If he have done 70% of one category
        $totalVerbs = $previousCategory->verbs()->count();
        $masteredVerbs = $this->masteredVerbs()
            ->whereHas('categories', function ($q) use ($previousCategory) {
                $q->where('categories.id', $previousCategory->id);
            })->count();
        $masteryRate = ($totalVerbs > 0) ? ($masteredVerbs / $totalVerbs) * 100 : 0;

        return $masteryRate >= 70;
    }
}
