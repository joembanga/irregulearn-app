<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Verb;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class CategoryLearn extends Component
{
    public Category $category;
    public $verbs = [];
    public $currentVerb;
    public $currentIndex = 0;
    
    // État du jeu
    public $answer = '';        // Pour Input
    public $choices = [];       // Pour QCM
    public $jumbledLetters = []; // Pour Jumble (lettres disponibles)
    public $selectedLetters = []; // Pour Jumble (lettres choisies)
    
    public $currentType = 'input'; // 'input', 'quiz', 'jumble'
    public $targetForm = 'past_simple'; // ou 'past_participle' (pour varier plus tard)
    
    public $isCorrect = null;
    public $finished = false;

    public function mount($slug)
    {
        $this->category = Category::where('slug', $slug)->firstOrFail();
        $this->verbs = $this->category->verbs()->inRandomOrder()->limit(10)->get(); 
        if ($this->verbs->isEmpty()) {
            return redirect()->route('dashboard');
        }

        $this->loadQuestion();
    }

    public function loadQuestion()
    {
        $this->currentVerb = $this->verbs[$this->currentIndex];
        
        // 1. Choix aléatoire du type d'exercice
        $types = ['input', 'quiz', 'jumble'];
        $this->currentType = $types[array_rand($types)];
        
        // Reset des variables
        $this->answer = '';
        $this->isCorrect = null;
        $this->selectedLetters = [];
        
        // 2. Préparation selon le type
        $correctAnswer = $this->currentVerb->past_simple; // On cible le Past Simple pour l'instant

        if ($this->currentType === 'quiz') {
            // On prend la bonne réponse
            $options = [$correctAnswer];
            
            // On cherche 3 autres verbes aléatoires pour faire les leurres
            $distractors = Verb::inRandomOrder()
                ->where('id', '!=', $this->currentVerb->id)
                ->limit(3)
                ->pluck('past_simple') // On prend leur past simple comme piège
                ->toArray();
                
            $this->choices = array_merge($options, $distractors);
            shuffle($this->choices);
            
        } elseif ($this->currentType === 'jumble') {
            // On éclate le mot en tableau de lettres et on mélange
            $letters = str_split($correctAnswer);
            shuffle($letters);
            $this->jumbledLetters = $letters;
        }
    }

    // Méthode spécifique pour le Jumble : Cliquer sur une lettre
    public function selectLetter($index)
    {
        if (isset($this->jumbledLetters[$index])) {
            $this->selectedLetters[] = $this->jumbledLetters[$index];
            unset($this->jumbledLetters[$index]);
            // Re-index pour éviter les trous dans le tableau Livewire
            $this->jumbledLetters = array_values($this->jumbledLetters);
        }
    }

    // Méthode spécifique pour le Jumble : Retirer une lettre (correction)
    public function unselectLetter($index)
    {
        if (isset($this->selectedLetters[$index])) {
            $this->jumbledLetters[] = $this->selectedLetters[$index];
            unset($this->selectedLetters[$index]);
            $this->selectedLetters = array_values($this->selectedLetters);
        }
    }

    public function checkAnswer($submittedAnswer = null)
    {
        // Si c'est un QCM, l'argument est passé. Sinon on prend la propriété.
        if ($this->currentType === 'jumble') {
            $attempt = implode('', $this->selectedLetters);
        } else {
            $attempt = $submittedAnswer ?? $this->answer;
        }

        $correct = $this->currentVerb->past_simple;

        if (trim(Str::lower($attempt)) === Str::lower($correct)) {
            $this->handleSuccess();
        } else {
            $this->isCorrect = false;
        }
    }

    public function handleSuccess()
    {
        $this->isCorrect = true;
        Auth::user()->increment('xp_balance', 10);
        Auth::user()->increment('xp_total', 10);
        Auth::user()->increment('xp_weekly', 10);
        
        // Marquer comme maîtrisé
        Auth::user()->verb()->syncWithoutDetaching([
            $this->currentVerb->id => ['mastered' => true]
        ]);
    }

    public function nextVerb()
    {
        if ($this->currentIndex < count($this->verbs) - 1) {
            $this->currentIndex++;
            $this->loadQuestion();
        } else {
            $this->finished = true;
            // Bonus de fin de série
            Auth::user()->increment('xp_balance', 50);
            Auth::user()->increment('xp_total', 50);
            Auth::user()->increment('xp_weekly', 50);
        }
    }

    public function render()
    {
        return view('livewire.category-learn');
    }
}