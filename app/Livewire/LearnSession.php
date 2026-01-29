<?php

namespace App\Livewire;

use App\Events\ExerciseCompleted;
use App\Models\Category;
use App\Models\Verb;
use App\Models\VerbSentence;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Component;

class LearnSession extends Component
{
    public $questionsNumber = 15;

    public ?Category $category = null;

    public $mode = 'category';

    public array $verbIds = [];

    public array $questionsData = [];

    public ?int $currentVerbId = null;

    public $currentVerbForms = [];

    public $currentIndex = 0;

    public $masteredVerbIds = [];

    public $sessionXp = 0;

    public $userInput = '';

    public $answer = '';

    public $choices = [];

    public $jumbledLetters = [];

    public $selectedLetters = [];

    public $removedForm = '';

    public $currentType = 'input';

    public $currentTargetForm = 'past_simple';

    public $currentSentence = '';

    public $isCorrect = null;

    public $finished = false;

    public $goodAnswers = 0;

    public $finished_reward = 0;

    #[Computed]
    public function currentVerb()
    {
        return Verb::select('id', 'infinitive', 'past_simple', 'past_participle', 'slug')->find($this->currentVerbId);
    }

    // Some regular verbs
    private static $regularVerbs = [
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
        'yell',
    ];

    public function mount($slug = null, $mode = 'category')
    {
        $this->mode = $mode;

        // Handle different modes
        if ($mode === 'revision') {
            // Load all learned verbs for revision
            $this->verbIds = Auth::user()->learnedVerbs()
                ->inRandomOrder()
                ->limit($this->questionsNumber)
                ->pluck('verbs.id')
                ->toArray();
            if (empty($this->verbIds)) {
                session()->flash('error', __('Vous n\'avez pas encore de verbes à réviser.'));
                return redirect()->route('learn.index');
            }
        } elseif ($mode === 'timed') {
            // Load 20 random verbs for timed challenge
            $this->questionsNumber = 20;
            $this->verbIds = Verb::inRandomOrder()
                ->limit($this->questionsNumber)
                ->pluck('id')
                ->toArray();
        } elseif ($mode === 'custom') {
            // Load custom selected verbs
            $verbIds = explode(',', request('verbs', ''));
            if (count($verbIds) < 5) {
                session()->flash('error', __('Veuillez sélectionner au moins 5 verbes.'));
                return redirect()->route('learn.custom');
            }
            $this->verbIds = Verb::whereIn('id', $verbIds)
                ->inRandomOrder()
                ->pluck('id')
                ->toArray();
            $this->questionsNumber = count($this->verbIds);
        } elseif (in_array($this->mode, ['daily', 'favorites'])) {
            // Load verbs
            $query = ($this->mode === 'daily') 
                ? Auth::user()->dailyVerbs() 
                : Auth::user()->favorites();

            $this->verbIds = $query->inRandomOrder()->pluck('verbs.id')->toArray();

            if (empty($this->verbIds)) {
                if ($this->mode === 'daily') {
                    Auth::user()->generateDailyVerbs();
                    return redirect()->route('learn.session', ['mode' => 'daily']);
                } else {
                    session()->flash('error', __('Vous n\'avez pas encore de verbes favoris.'));
                    return redirect()->route('learn.index');
                }
            }

            // Ensure we have exactly questionsNumber verbs by repeating if necessary
            while (count($this->verbIds) < $this->questionsNumber) {
                $count = count($this->verbIds);
                $remaining = $this->questionsNumber - $count;
                $toAdd = array_slice($this->verbIds, 0, $remaining);
                $this->verbIds = array_merge($this->verbIds, $toAdd);
            }
        } else {
            // Category mode
            $this->category = Category::where('slug', $slug)->select('id', 'slug', 'order')->firstOrFail();

            if (! Auth::user()->canAccessCategory($this->category)) {
                return redirect()->route('learn.index');
            }

            $this->verbIds = $this->category->verbs()
                ->inRandomOrder()
                ->limit($this->questionsNumber)
                ->pluck('verbs.id')
                ->toArray();
            if (empty($this->verbIds)) {
                return redirect()->route('learn.index');
            }
        }

        $this->generateAllQuestions();
    }

    protected function generateAllQuestions()
    {
        $verbs = Verb::whereIn('id', $this->verbIds)
            ->select('id', 'infinitive', 'past_simple', 'past_participle', 'slug')
            ->get()
            ->keyBy('id');

        $sentences = VerbSentence::whereIn('verb_id', $this->verbIds)
            ->select('id', 'verb_id', 'sentence', 'missing_word')
            ->get()
            ->groupBy('verb_id');

        foreach ($this->verbIds as $index => $id) {
            $verb = $verbs[$id];
            $hasSentences = isset($sentences[$id]) && $sentences[$id]->isNotEmpty();
            
            $types = ['input', 'jumble', 'odd_one_out', 'complete'];
            if ($hasSentences) $types[] = 'sentence';

            if ($verb->past_simple !== $verb->past_participle) {
                foreach (explode('/', $verb->past_simple) as $pSimpleForm) {
                    if (!in_array($pSimpleForm, explode('/', $verb->past_participle))) {
                        $types[] = 'quiz';
                        break;
                    }
                }
            }

            $type = $types[array_rand($types)];
            $targetForms = ['past_simple', 'past_participle'];
            $targetForm = $targetForms[array_rand($targetForms)];
            $answer = $verb->{$targetForm};
            $data = [
                'id' => $id,
                'infinitive' => $verb->infinitive,
                'type' => $type,
                'targetForm' => $targetForm,
                'answer' => $answer,
            ];

            // Specific preparations
            switch ($type) {
                case 'quiz':
                    $correctAnswers = explode('/', $answer);
                    $actualAnswer = $correctAnswers[array_rand($correctAnswers)];
                    $otherForm = ($targetForm === 'past_simple') ? $verb->past_participle : $verb->past_simple;
                    $options = explode('/', $otherForm);
                    $choices = [$actualAnswer, $options[0]];
                    shuffle($choices);
                    $data['choices'] = $choices;
                    $data['answer'] = $actualAnswer;
                    break;
                case 'jumble':
                    $correctAnswers = explode('/', $answer);
                    $actualAnswer = $correctAnswers[array_rand($correctAnswers)];
                    $letters = str_split($actualAnswer);
                    shuffle($letters);
                    $data['jumbledLetters'] = $letters;
                    $data['answer'] = $actualAnswer;
                    break;
                case 'complete':
                    $forms = [
                        'infinitive' => $verb->infinitive,
                        'past_simple' => explode('/', $verb->past_simple)[0],
                        'past_participle' => explode('/', $verb->past_participle)[0],
                    ];
                    $removedForm = array_rand($forms);
                    $data['forms'] = $forms;
                    $data['removedForm'] = $removedForm;
                    $data['answer'] = ($removedForm === 'past_simple') ? $verb->past_simple : (($removedForm === 'past_participle') ? $verb->past_participle : $verb->infinitive);
                    break;
                case 'odd_one_out':
                    $actualAnswer = collect(self::$regularVerbs)->random();
                    $otherIrregulars = Verb::where('id', '!=', $id)->inRandomOrder()->limit(2)->pluck('infinitive')->toArray();
                    $choices = collect([$verb->infinitive, ...$otherIrregulars, $actualAnswer])->shuffle()->toArray();
                    $data['choices'] = $choices;
                    $data['answer'] = $actualAnswer;
                    break;
                case 'sentence':
                    $sentence = $sentences[$id]->random();
                    $matches = null;
                    preg_match_all('/\b('.preg_quote($sentence->missing_word, '/').'\w*)[\p{P}]?/miu', $sentence->sentence, $matches);
                    $data['sentence'] = preg_replace('/\b'.preg_quote($sentence->missing_word, '/').'\w*\p{P}?/miu', '_____', $sentence->sentence);
                    $data['answer'] = $matches[1][0] ?? $sentence->missing_word;
                    break;
            }

            $this->questionsData[] = $data;
        }

        // Initialize first question for compatibility
        $this->loadQuestion();
    }

    public function loadQuestion()
    {
        $this->currentVerbId = $this->verbIds[$this->currentIndex];
        $currentVerb = $this->currentVerb();

        // Check if verb has sentences available
        $hasSentences = VerbSentence::where('verb_id', $this->currentVerbId)->exists();

        $types = ['input', 'jumble', 'odd_one_out', 'complete'];
        if ($hasSentences) {
            $types[] = 'sentence';
        }

        if ($currentVerb->past_simple !== $currentVerb->past_participle) {
            foreach (explode('/', $currentVerb->past_simple) as $pSimpleForm) {
                if (!in_array($pSimpleForm, explode('/', $currentVerb->past_participle))) {
                    $types[] = 'quiz';
                }
            }
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
        $correctAnswers = explode('/', $currentVerb->{$this->currentTargetForm});

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
                $this->answer = $currentVerb->{$this->currentTargetForm};
                $this->userInput = '';
                break;
            default:
                session()->flash('error', 'Une erreur est survenue');
                break;
        }

        $this->dispatch('jumble-reset');
    }

    public function prepareQuiz(array $answers)
    {
        $this->answer = $answers[array_rand($answers)];
        $currentVerb = $this->currentVerb();

        $this->currentTargetForm === 'past_simple' ?
            $options = [$currentVerb->past_participle] :
            $options = [$currentVerb->past_simple];

        foreach ($options as $k => $option) {
            $forms = explode('/', $option);
            foreach ($forms as $form) {
                if (!in_array($form, $options)) {
                    $options[$k] = $form;
                    break;
                }
            }
        }

        $options[] = $this->answer;

        $this->choices = $options;
        shuffle($this->choices);
    }

    protected function prepareOddOneOut()
    {
        $this->answer = collect(self::$regularVerbs)->random();
        $currentVerb = $this->currentVerb();

        $irregular1 = $currentVerb->infinitive;

        $otherIrregulars = Verb::where('id', '!=', $this->currentVerbId)
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
        $currentVerb = $this->currentVerb();
        // 1. On récupère les formes brutes
        $rawForms = [
            'infinitive' => $currentVerb->infinitive,
            'past_simple' => $currentVerb->past_simple,
            'past_participle' => $currentVerb->past_participle,
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
        $sentence = VerbSentence::where('verb_id', $this->currentVerbId)
            ->select('id', 'sentence', 'missing_word')
            ->inRandomOrder()
            ->first();

        if (! $sentence) {
            // Fallback if something went wrong (should be handled by loadQuestion check, but safety first)
            $this->currentType = 'input';
            $this->answer = $this->currentVerb()->{$this->currentTargetForm};
            $this->userInput = '';

            return;
        }

        // Case insensitive replacement for better UX
        $matches = null;
        preg_match_all('/\b('.preg_quote($sentence->missing_word, '/').'\w*)[\p{P}]?/miu', $sentence->sentence, $matches);
        $this->answer = $matches[1][0];
        // We use a regex to replace the word case-insensitively while keeping the blank
        $this->currentSentence = preg_replace(
            '/\b'.preg_quote($sentence->missing_word, '/').'\w*\p{P}?/miu',
            '_____',
            $sentence->sentence
        );
    }

    public function checkAnswer($submittedAnswer = null)
    {
        // This is now a fallback if Alpine sync is slow or for initial load
        $attempt = match ($this->currentType) {
            'quiz', 'odd_one_out', 'jumble' => $submittedAnswer ?? $this->userInput,
            default => $this->userInput,
        };

        $attempt = trim(Str::lower($attempt));
        $possibleAnswers = explode('/', Str::lower($this->answer));

        if (in_array($attempt, $possibleAnswers)) {
            $this->recordResult(true);
        } else {
            $this->recordResult(false);
        }
    }

    public function recordResult($correct, $verbId = null)
    {
        // Ensure we are syncing for the correct verb
        if ($verbId) {
            $this->currentVerbId = $verbId;
        }

        if ($correct) {
            $this->isCorrect = true;
            $this->handleSuccess();
        } else {
            $this->isCorrect = false;
        }
    }

    public function handleSuccess()
    {
        $this->isCorrect = true;
        $this->goodAnswers += 1;
        if ($this->mode === 'daily') {
            $verb = Auth::user()
                ->learnedVerbs(false)
                ->wherePivot('verb_id', $this->currentVerbId)
                ->withPivot('is_learned')
                ->select('verbs.id')
                ->first();
            if ($verb) {
                // Keep this synchronous as it's critical for immediate view "learned" status
                $verb->pivot->is_learned = true;
                $verb->pivot->save();
            }
        }

        // Add to batch for background persistence
        $this->sessionXp += 5;
        if (! in_array($this->currentVerbId, $this->masteredVerbIds)) {
            $this->masteredVerbIds[] = $this->currentVerbId;
        }
    }

    public function nextVerb()
    {
        if ($this->currentIndex < count($this->verbIds) - 1) {
            $this->currentIndex++;
            $this->loadQuestion();
        } else {
            $this->finishSession();
        }
    }

    public function finishTimedSession()
    {
        // Force finish the session when timer expires
        $this->finishSession();
    }

    public function finishSession()
    {
        $this->finished = true;
        $this->sessionXp = 0;
        $this->finished_reward = $this->goodAnswers * 10;
        if ($this->mode === 'timed') {
            $this->finished_reward = $this->goodAnswers * 5;
        }

        // Dispatch event for background processing
        ExerciseCompleted::dispatch(
            Auth::user(),
            $this->finished_reward,
            $this->goodAnswers,
            $this->category,
            $this->masteredVerbIds
        );

        Auth::user()->updateStreak();
    }

    public function render()
    {
        return view('livewire.learn-session');
    }
}
