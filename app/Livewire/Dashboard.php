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
        $categories = Category::orderBy('order')->get()->map(function ($category) use ($user) {
            // On calcule le % de maîtrise (verbes réussis / total verbes)
            $totalVerbs = $category->verbs()->count();

            // On suppose que tu as une table 'verb_user' ou 'progress'
            // Ici, on compte les verbes de la catégorie déjà maîtrisés par l'user
            $masteredCount = $user->verb()
                ->wherePivot('mastered', true)
                ->whereHas('categories', function ($q) use ($category) {
                    $q->where('categories.id', $category->id);
                })->count();
            $category->progress = ($totalVerbs > 0) ? round(($masteredCount / $totalVerbs) * 100) : 0;
            $category->is_locked = !$user->canAccessCategory($category);
            return $category;
        });

        return view('livewire.dashboard', [
            'categories' => $categories
        ]);
    }

    public function unlockCategory(int $categoryId, int $categoryCout)
    {
        $user = Auth::user();
        if ($user->xp_balance >= $categoryCout) {
            $user->decrement('xp_balance', $categoryCout);
            DB::insert('INSERT INTO category_user (category_id, user_id, created_at, updated_at) VALUES (:category_id, :user_id, CURRENT_DATE, CURRENT_DATE) ', [
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