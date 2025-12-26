<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use App\Models\Exercise;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use function Laravel\Prompts\table;

class QuizEngine extends Component
{
    // Paramètres de filtrage
    public $restrictToVerbIds = [];
    public $exercisesId = [];
    public $exerciseVerbTable = null;
    public $category = null;
    public $verbsToLearn = null;

    public $currentExercise;
    public $userAnswer = '';
    public $feedback = '';
    public $isCorrect = null;

    // Dans ton composant de Quiz/Learning
    public function mount($categorySlug)
    {
        $this->category = Category::where('slug', $categorySlug)->firstOrFail();

        // On ne charge que les verbes de CETTE catégorie
        $this->verbsToLearn = $this->category->verbs()
            ->wherePivotMastered(false) // Optionnel : verbes non maîtrisés
            ->get();
    }
    
    public function __construct()
    {
        $user = Auth::user();
        foreach ($user->dailyVerbs as $dailyVerb) {
            $this->restrictToVerbIds[] = $dailyVerb->id;
        }
        $this->getNextExercise();
    }

    public function getNextExercise()
    {
        $query = Exercise::query();
        $this->exerciseVerbTable = DB::table('exercise_verb')->select()->whereIn('exercise_verb.verb_id', $this->restrictToVerbIds)->join('daily_verbs', 'daily_verbs.verb_id', '=', 'exercise_verb.verb_id', 'left')->where('is_learned', false)->get();
        // dd($this->exerciseVerbTable);
        $this->exercisesId = [];
        foreach ($this->exerciseVerbTable->toArray() as $exerciseVerbLigne) {
            $this->exercisesId[] = $exerciseVerbLigne->exercise_id;
        }

        // Filtre 1 : Par IDs spécifiques (pour /learn)
        if (!empty($this->restrictToVerbIds)) {
            $query->whereIn('id', $this->exercisesId);
        }

        $this->currentExercise = $query->inRandomOrder()->first();
        $this->userAnswer = '';
        $this->isCorrect = null;
    }

    public function checkAnswer()
    {
        $user = User::find(Auth::id());

        $cleanAnswer = trim(Str::lower($this->userAnswer));
        $correctAnswer = trim(Str::lower($this->currentExercise->correct_answer));
        $correctAnswers = explode('/', $correctAnswer);

        if (in_array($cleanAnswer, $correctAnswers)) {
            $this->isCorrect = true;
            $this->feedback = "Excellent ! +{$this->currentExercise->points} XP";

            // Mise à jour XP
            $user->increment('xp_weekly', $this->currentExercise->points);
            $user->increment('xp_total', $this->currentExercise->points);
            $user->increment('xp_balance', $this->currentExercise->points);

            // Si on est sur /learn, on marque le verbe comme appris
            if (!empty($this->restrictToVerbIds)) {
                $currentVerbId = DB::table('exercise_verb')->select('verb_id')->where('exercise_id', $this->currentExercise->id)->get()->toArray();
                DB::table('daily_verbs')->where('verb_id', $currentVerbId[0]->verb_id)->update(['is_learned' => true]);
            }
        } else {
            $this->isCorrect = false;
            $this->feedback = "Oups ! La réponse était : {$this->currentExercise->correct_answer}";
        }
    }

    public function render()
    {
        return view('livewire.quiz-engine');
    }
}