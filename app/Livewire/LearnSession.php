<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Verb;
use Illuminate\Support\Facades\Auth;

class LearnSession extends Component
{
    public $step = 'list'; // 'list' ou 'quiz'
    public $currentVerbIndex = 0;

    public function startQuiz()
    {
        $this->step = 'quiz';
    }

    public function render()
    {
        $user = Auth::user();
        $user->generateDailyVerbs(); // S'assure que les verbes existent

        return view('livewire.learn-session', [
            'dailyVerbs' => $user->dailyVerbs
        ]);
    }
}
