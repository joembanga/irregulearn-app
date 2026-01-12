<?php

namespace App\Livewire;

use App\Events\ExerciseCompleted;
use App\Models\Category;
use App\Models\Verb;
use App\Models\VerbSentence;
use App\Services\BadgeService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class LearnSession extends Component
{
    public $questionsNumber = 10;
    public ?Category $category = null;
    public $mode = 'category';
    public $verbs = [];
    public $currentVerb;
    public $currentVerbForms = [];
    public $currentIndex = 0;
    public $masteredVerbIds = [];
    public $sessionXp = 0;

    // État du jeu
    public $userInput = ''; // For complete
    public $answer = '';        // Pour Input
    public $choices = [];       // Pour QCM
    public $jumbledLetters = []; // Pour Jumble (lettres disponibles)
    public $selectedLetters = []; // Pour Jumble (lettres choisies)
    public $removedForm = ''; // Pour Complete

    public $currentType = 'input'; // 'input', 'quiz', 'jumble', 'sentence'
    public $currentTargetForm = 'past_simple'; // 'input', 'quiz', 'jumble'
    public $currentSentence = ''; // For sentence completion

    public $isCorrect = null;
    public $finished = false;
    public $mistakes = 0;
    public $finished_reward = 0;

    // Liste de verbes réguliers pour le mode "Intrus"
    protected $regularVerbs = [
        'work',
        'play',
        'visit',
        'finish',
        'start',
        'watch',
        'clean',
        'cook',
        'walk',
        'talk',
        'help',
        'ask',
        'call',
        'need',
        'look',
        'open',
        'close',
        'live',
        'love',
        'hate',
        'share',
        'smile',
        'laugh',
        'wait',
        'jump',
        'kick',
        'push',
        'pull',
        'touch',
        'climb',
        'dance',
        'skate',
        'stop',
        'turn',
        'move',
        'carry',
        'lift',
        'drop',
        'knock',
        'fix',
        'listen',
        'answer',
        'explain',
        'shout',
        'whisper',
        'remember',
        'decide',
        'learn',
        'study',
        'plan',
        'guess',
        'hope',
        'believe',
        'trust',
        'change',
        'check',
        'save',
        'print',
        'type',
        'mail',
        'phone',
        'rain',
        'snow',
        'travel',
        'stay',
        'arrive',
        'pass',
        'park',
        'sail',
        'accept',
        'allow',
        'appear',
        'attack',
        'attend',
        'avoid',
        'borrow',
        'collect',
        'complain',
        'create',
        'deliver',
        'describe',
        'destroy',
        'develop',
        'enjoy',
        'follow',
        'happen',
        'invite',
        'join',
        'manage',
        'offer',
        'order',
        'prefer',
        'promise',
        'receive',
        'refuse',
        'relax',
        'serve',
        'train',
        'waste',
        'watch',
        'wish',
        'worry',
        'yell'
    ];

    public function mount($slug = null, $mode = 'category')
    {
        $this->mode = $mode;

        if (in_array($this->mode, ['daily', 'favorites', 'knowVerbs'])) {
            // Load verbs
            $this->mode === 'daily' ? $this->verbs = Auth::user()->dailyVerbs()->get() : 
                (
                    $this->mode === 'favorites' ? $this->verbs = Auth::user()->favorites()->get() :
                    $this->verbs = Auth::user()->learnedVerbs()->inRandomOrder()->get()
                );
            if ($this->verbs->isEmpty()) {
                // If no verbs (should not happen if logic is correct, but safe fallback)
                Auth::user()->generateDailyVerbs();
                return redirect()->route('learn.session', ['mode' => 'daily']);
            }
            while (true) {
                foreach ($this->verbs as $verb) {
                    $this->verbs->add($verb);
                    if ($this->verbs->count() === $this->questionsNumber) {
                        break(2);
                    }
                }
            }
        } else {
            // Category mode
            $this->category = Category::where('slug', $slug)->firstOrFail();
            $this->verbs = $this->category->verbs()->inRandomOrder()->limit($this->questionsNumber)->get();
            if ($this->verbs->isEmpty()) {
                return redirect()->route('learn');
            }
        }

        $this->loadQuestion();
    }

    public function loadQuestion()
    {
        $this->currentVerb = $this->verbs[$this->currentIndex];

        // Check if verb has sentences available
        $hasSentences = VerbSentence::where('verb_id', $this->currentVerb->id)->exists();

        $types = ['input', 'jumble', 'quiz', 'odd_one_out', 'complete'];
        if ($hasSentences) {
            $types[] = 'sentence';
        }

        $this->currentType = $types[array_rand($types)];
        $targetForm = ['past_simple', 'past_participle'];
        $this->currentTargetForm = $targetForm[array_rand($targetForm)];

        // Reset des variables
        $this->answer = '';
        $this->userInput = '';
        $this->isCorrect = null;
        $this->selectedLetters = [];
        $this->choices = [];
        $this->currentSentence = '';

        // 2. Préparation selon le type
        $correctAnswers = explode("/", $this->currentVerb->{$this->currentTargetForm});

        switch ($this->currentType) {
            case 'quiz':
                $this->prepareQuiz($correctAnswers);
                break;
            case 'jumble':
                $this->answer = $correctAnswers[array_rand($correctAnswers)];
                $letters = str_split($this->answer);
                shuffle($letters);
                $this->jumbledLetters = $letters;
                break;
            case 'complete':
                $this->prepareComplete();
                break;
            case 'odd_one_out':
                $this->prepareOddOneOut();
                break;
            case 'sentence':
                $this->prepareSentence();
                break;
            case 'input':
                $this->answer = $this->currentVerb->{$this->currentTargetForm};
                $this->userInput = '';
                break;
            default:
                session()->flash('error', 'Une erreur est survenue');
                break;
        }
    }

    public function prepareQuiz(array $answers)
    {
        $this->answer = $answers[array_rand($answers)];
        $options = [$this->answer];

        // On cherche 3 autres verbes aléatoires pour faire les leurres
        $distractors = Verb::inRandomOrder()
            ->where('id', '!=', $this->currentVerb->id)
            ->limit(3)
            ->pluck("{$this->currentTargetForm}")
            ->toArray();

        foreach ($distractors as $k => $distractor) {
            $forms = explode("/", $distractor);
            $distractors[$k] = $forms[array_rand($forms)];
        }

        $this->choices = array_merge($options, $distractors);
        shuffle($this->choices);
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

    public function prepareComplete()
    {
        // 1. On récupère les formes brutes
        $rawForms = [
            'infinitive' => $this->currentVerb->infinitive,
            'past_simple' => $this->currentVerb->past_simple,
            'past_participle' => $this->currentVerb->past_participle
        ];
        foreach ($rawForms as $key => $rawForm) {
            $rawForm = explode('/', $rawForm);
            $form = $rawForm[array_rand($rawForm)];
            $this->currentVerbForms[$key] = $form;
        }
        // 2. On choisit la colonne à cacher
        $this->removedForm = array_rand($this->currentVerbForms);
        // 3. On stocke la solution complète (avec les slashes) pour la vérification
        $this->answer = $rawForms[$this->removedForm];
        $this->userInput = '';
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

    public function prepareSentence()
    {
        $sentence = VerbSentence::where('verb_id', $this->currentVerb->id)->inRandomOrder()->first();

        if (!$sentence) {
            // Fallback if something went wrong (should be handled by loadQuestion check, but safety first)
            $this->currentType = 'input';
            $this->answer = $this->currentVerb->{$this->currentTargetForm};
            $this->userInput = '';
            return;
        }

        // Case insensitive replacement for better UX
        $matches = null;
        preg_match_all('/\b(' . preg_quote($sentence->missing_word, '/') . '\w*)[\p{P}]?/miu', $sentence->sentence, $matches);
        $this->answer = $matches[1][0];
        // We use a regex to replace the word case-insensitively while keeping the blank
        $this->currentSentence = preg_replace('/\b' . preg_quote($sentence->missing_word, '/') . '\w*\p{P}?/miu', '_____', $sentence->sentence);
    }

    public function checkAnswer($submittedAnswer = null)
    {
        $attempt = match ($this->currentType) {
            'quiz', 'odd_one_out' => $submittedAnswer,
            'jumble' => implode('', $this->selectedLetters),
            default => $this->userInput,
        };

        $attempt = trim(Str::lower($attempt));
        $possibleAnswers = explode('/', Str::lower($this->answer));

        if (in_array($attempt, $possibleAnswers)) {
            $this->handleSuccess();
        } else {
            $this->isCorrect = false;
            $this->mistakes++;
        }
    }

    public function handleSuccess()
    {
        $this->isCorrect = true;
        if ($this->mode === 'daily') {
            $verb = Auth::user()->learnedVerbs(false)->wherePivot('verb_id', $this->currentVerb->id)->withPivot('is_learned')->first();
            if ($verb) {
                // Keep this synchronous as it's critical for immediate view "learned" status
                $verb->pivot->is_learned = true;
                $verb->pivot->save();
            }
        }

        // Add to batch for background persistence
        $this->sessionXp += 10;
        if (!in_array($this->currentVerb->id, $this->masteredVerbIds)) {
            $this->masteredVerbIds[] = $this->currentVerb->id;
        }
    }

    public function nextVerb()
    {
        if ($this->currentIndex < count($this->verbs) - 1) {
            $this->currentIndex++;
            $this->loadQuestion();
        } else {
            $this->finished = true;
            $this->finished_reward = (count($this->verbs) - $this->mistakes) * count($this->verbs);
            
            // Dispatch event for background processing
            ExerciseCompleted::dispatch(
                Auth::user(),
                $this->sessionXp + $this->finished_reward,
                $this->mistakes,
                $this->category,
                $this->masteredVerbIds
            );

            Auth::user()->updateStreak();
        }
    }

    public function render()
    {
        return view('livewire.learn-session');
    }
}
