<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public function render(): View
    {
        $user = Auth::user();
        // Ensure daily verbs are generated and available
        if (method_exists($user, 'generateDailyVerbs')) {
            $user->generateDailyVerbs();
            $dailyVerbs = $user->dailyVerbs;
        } else {
            $dailyVerbs = collect();
        }
        return view('livewire.dashboard', [
            'dailyVerbs' => $dailyVerbs,
        ]);
    }

    public function unlockCategory(int $categoryId, int $categoryCout)
    {
        $user = Auth::user();
        if ($user->xp_balance >= $categoryCout) {
            $user->decrement('xp_balance', $categoryCout);
            DB::insert('INSERT INTO category_user (category_id, user_id, created_at, updated_at) VALUES (:category_id, :user_id, CURRENT_DATETIME, CURRENT_DATETIME) ', [
                'category_id' => $categoryId,
                'user_id' => $user->id,
            ]);
            session()->flash('success', 'Catégorie débloquée !');
            return $this->render();
        } else {
            session()->flash('error', 'XP insuffisants...');
        }
    }
}
