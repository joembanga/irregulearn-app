<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Exercise;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class QuizEngine extends Component
{
    // Paramètres de filtrage
    public $restrictToVerbIds = [];
    public $level = null;

    public $currentExercise;
    public $userAnswer = '';
    public $feedback = '';
    public $isCorrect = null;

    public function mount($restrictToVerbIds = [], $level = null)
    {
        auth()->user()->refreshLives();
        $this->restrictToVerbIds = $restrictToVerbIds;
        $this->level = $level;
        $this->getNextExercise();
    }

    public function getNextExercise()
    {
        $query = Exercise::query();

        // Filtre 1 : Par IDs spécifiques (pour /learn)
        if (!empty($this->restrictToVerbIds)) {
            $query->whereIn('id', $this->restrictToVerbIds);
        }

        // Filtre 2 : Par niveau (pour /practice)
        if ($this->level) {
            $query->whereHas('verbs', function ($q) {
                $q->where('level', $this->level);
            });
        }

        $this->currentExercise = $query->inRandomOrder()->first();
        $this->userAnswer = '';
        $this->isCorrect = null;
    }

    public function checkAnswer()
    {
        $user = User::find(Auth::id());

        // Sécurité : stop si plus de vies
        if ($user->lives <= 0) {
            $this->feedback = "Tu n'as plus de vies ! Recharge-les dans la boutique.";
            return;
        }

        $cleanAnswer = trim(strtolower($this->userAnswer));
        $correctAnswer = trim(strtolower($this->currentExercise->correct_answer));

        if ($cleanAnswer === $correctAnswer) {
            $this->isCorrect = true;
            $this->feedback = "Excellent ! +{$this->currentExercise->points} XP";

            // Mise à jour XP
            $user->increment('xp_total', $this->currentExercise->points);
            $user->increment('xp_weekly', $this->currentExercise->points);
            $user->increment('xp_balance', $this->currentExercise->points);

            // Si on est sur /learn, on marque le verbe comme appris
            if (!empty($this->restrictToVerbIds)) {
                $user->dailyVerbs()->updateExistingPivot($this->currentExercise->verb_id, [
                    'is_learned' => true
                ]);
            }
        } else {
            $this->isCorrect = false;
            $this->feedback = "Oups ! La réponse était : {$this->currentExercise->correct_answer}";

            // Perte de vie
            $user->decrement('lives');
            if ($user->last_life_lost_at === null) {
                $user->update(['last_life_lost_at' => now()]);
            }
        }
    }

    public function render()
    {
        return view('livewire.quiz-engine');
    }
}