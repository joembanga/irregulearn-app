<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DailyVerbs extends Component
{
    public $dailyVerbs = null;

    public function mount($dailyVerbs)
    {
        $this->dailyVerbs = $dailyVerbs;
    }

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
        return view('livewire.daily-verbs', [
            'dailyVerbs' => $dailyVerbs,
        ]);
    }
}
