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
    public $currentTargetForm = 'past_simple'; // 'input', 'quiz', 'jumble'
    public $targetForm = ['past_simple', 'past_participle']; // ou 'past_participle' (pour varier plus tard)
    
    public $isCorrect = null;
    public $finished = false;
    public $mistakes = 0;
    public $finished_reward = 0;

    // Liste de verbes réguliers pour le mode "Intrus"
    protected $regularVerbs = [
        'work', 'play', 'visit', 'finish', 'start', 'watch', 'clean', 'cook', 'walk', 'talk', 'help', 'ask', 'call', 'need', 'look', 'open', 
        'close', 'live', 'love', 'hate', 'share', 'smile', 'laugh', 'wait', 'jump', 'kick', 'push', 'pull', 'touch', 'climb', 'dance', 'skate',
        'stop', 'turn', 'move', 'carry', 'lift', 'drop', 'knock', 'fix', 'listen', 'answer', 'explain', 'shout', 'whisper', 'remember', 'decide', 
        'learn', 'study', 'plan', 'guess', 'hope', 'believe', 'trust', 'change', 'check', 'save', 'print', 'type', 'mail', 'phone', 'rain',
        'snow', 'travel', 'stay', 'arrive', 'pass', 'park', 'sail', 'accept', 'allow', 'appear', 'attack', 'attend', 'avoid', 'borrow',
        'collect', 'complain', 'create', 'deliver', 'describe', 'destroy', 'develop', 'enjoy', 'follow', 'happen', 'invite', 'join', 'manage',
        'offer', 'order', 'prefer', 'promise', 'receive', 'refuse', 'relax', 'serve', 'train', 'waste', 'watch', 'wish', 'worry', 'yell'
    ];

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
        $types = ['input', 'quiz', 'jumble', 'odd_one_out'];
        $this->currentType = $types[array_rand($types)];
        $this->currentTargetForm = $this->targetForm[array_rand($this->targetForm)];

        // Reset des variables
        $this->answer = '';
        $this->isCorrect = null;
        $this->selectedLetters = [];
        $this->choices = [];

        // 2. Préparation selon le type
        $correctAnswers = explode("/", $this->currentVerb->{$this->currentTargetForm});

        if ($this->currentType === 'quiz') {

            $options = [$correctAnswers[array_rand($correctAnswers)]];

            // On cherche 3 autres verbes aléatoires pour faire les leurres
            $distractors = Verb::inRandomOrder()
                ->where('id', '!=', $this->currentVerb->id)
                ->limit(3)
                ->pluck('past_simple', 'past_participle')
                ->toArray();

            foreach ($distractors as $distractor) {
                $forms = explode("/", $distractor);
                $distractors[] = $forms[array_rand($forms)];
            }

            $this->choices = array_merge($options, $distractors);
            shuffle($this->choices);
        } elseif ($this->currentType === 'jumble') {
            $letters = str_split($correctAnswers[array_rand($correctAnswers)]);
            shuffle($letters);
            $this->jumbledLetters = $letters;
        } elseif ($this->currentType === 'odd_one_out') {
            $this->prepareOddOneOut();
        }
    }

    protected function prepareOddOneOut()
    {
        $this->answer = collect($this->regularVerbs)->random();

        $irregular1 = $this->currentVerb->infinitive;

        $otherIrregulars = Verb::where('id', '!=', $this->currentVerb->id)
            ->inRandomOrder()
            ->limit(2)
            ->pluck('infinitive')
            ->toArray();

        $this->choices = collect([$irregular1, ...$otherIrregulars, $this->answer])
            ->shuffle()
            ->toArray();
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
        if ($this->currentType === 'odd_one_out') {
            if (trim(Str::lower($submittedAnswer)) === $this->answer) {
                $this->handleSuccess();
            } else {
                $this->isCorrect = false;
                $this->mistakes++;
            }
            return;
        }

        if ($this->currentType === 'jumble') {
            $attempt = implode('', $this->selectedLetters);
        } else {
            $attempt = $submittedAnswer ?? $this->answer;
        }

        $corrects = explode('/', Str::lower($this->currentVerb->{$this->currentTargetForm}));

        if (in_array(trim(Str::lower($attempt)), $corrects)) {
            $this->handleSuccess();
        } else {
            $this->isCorrect = false;
            $this->mistakes++;
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
            $this->finished_reward = (count($this->verbs) - $this->mistakes) * count($this->verbs);
            // Bonus de fin de série
            Auth::user()->increment('xp_balance', $this->finished_reward);
            Auth::user()->increment('xp_total', $this->finished_reward);
            Auth::user()->increment('xp_weekly', $this->finished_reward);
        }
    }

    public function render()
    {
        return view('livewire.category-learn');
    }
}
