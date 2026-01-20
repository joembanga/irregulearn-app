<?php

namespace App\Livewire;

use App\Events\ExerciseCompleted;
use App\Models\Category;
use App\Models\Verb;
use App\Models\VerbSentence;
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

    public $mistakes = 0;

    public $finished_reward = 0;

    // Some regular verbs
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
        'yell',
    ];

    public function mount($slug = null, $mode = 'category')
    {
        $this->mode = $mode;

        // Handle different modes
        if ($mode === 'revision') {
            // Load all learned verbs for revision
            $this->verbs = Auth::user()->learnedVerbs()->inRandomOrder()->limit($this->questionsNumber)->get();
            if ($this->verbs->isEmpty()) {
                session()->flash('error', __('Vous n\'avez pas encore de verbes à réviser.'));
                return redirect()->route('learn.index');
            }
        } elseif ($mode === 'timed') {
            // Load 20 random verbs for timed challenge
            $this->questionsNumber = 20;
            $this->verbs = Verb::inRandomOrder()->limit($this->questionsNumber)->get();
        } elseif ($mode === 'custom') {
            // Load custom selected verbs
            $verbIds = explode(',', request('verbs', ''));
            if (count($verbIds) < 5) {
                session()->flash('error', __('Veuillez sélectionner au moins 5 verbes.'));
                return redirect()->route('learn.custom');
            }
            $this->verbs = Verb::whereIn('id', $verbIds)->inRandomOrder()->get();
            $this->questionsNumber = $this->verbs->count();
        } elseif (in_array($this->mode, ['daily', 'favorites'])) {
            // Load verbs
            $this->mode === 'daily' ? $this->verbs = Auth::user()->dailyVerbs()->inRandomOrder()->get() :
                $this->verbs = Auth::user()->favorites()->inRandomOrder()->get();
            
            if ($this->verbs->isEmpty()) {
                if ($this->mode === 'daily') {
                    Auth::user()->generateDailyVerbs();
                    return redirect()->route('learn.session', ['mode' => 'daily']);
                } else {
                    session()->flash('error', __('Vous n\'avez pas encore de verbes favoris.'));
                    return redirect()->route('learn.index');
                }
            }

            // Ensure we have exactly questionsNumber verbs by repeating if necessary
            while ($this->verbs->count() < $this->questionsNumber) {
                foreach ($this->verbs->take($this->questionsNumber - $this->verbs->count()) as $verb) {
                    $this->verbs->add($verb);
                    if ($this->verbs->count() === $this->questionsNumber) {
                        break 2;
                    }
                }
            }
        } else {
            // Category mode
            $this->category = Category::where('slug', $slug)->firstOrFail();

            if (! Auth::user()->canAccessCategory($this->category)) {
                return redirect()->route('learn.index');
            }

            $this->verbs = $this->category->verbs()->inRandomOrder()->limit($this->questionsNumber)->get();
            if ($this->verbs->isEmpty()) {
                return redirect()->route('learn.index');
            }
        }

        $this->loadQuestion();
    }

    public function loadQuestion()
    {
        $this->currentVerb = $this->verbs[$this->currentIndex];

        // Check if verb has sentences available
        $hasSentences = VerbSentence::where('verb_id', $this->currentVerb->id)->exists();

        $types = ['input', 'jumble', 'odd_one_out', 'complete'];
        if ($hasSentences) {
            $types[] = 'sentence';
        }

        if ($this->currentVerb->past_simple !== $this->currentVerb->past_participle) {
            foreach (explode('/', $this->currentVerb->past_simple) as $pSimpleForm) {
                if (!in_array($pSimpleForm, explode('/', $this->currentVerb->past_participle))) {
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
        $correctAnswers = explode('/', $this->currentVerb->{$this->currentTargetForm});

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

        $this->currentTargetForm === 'past_simple' ?
            $options = [$this->currentVerb->past_participle] :
            $options = [$this->currentVerb->past_simple];

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
            'past_participle' => $this->currentVerb->past_participle,
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

        if (! $sentence) {
            // Fallback if something went wrong (should be handled by loadQuestion check, but safety first)
            $this->currentType = 'input';
            $this->answer = $this->currentVerb->{$this->currentTargetForm};
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
            $this->userInput = $this->answer;
            $this->isCorrect = false;
            $this->mistakes++;
        }
    }

    public function handleSuccess()
    {
        $this->isCorrect = true;
        if ($this->mode === 'daily') {
            $verb = Auth::user()
                ->learnedVerbs(false)
                ->wherePivot('verb_id', $this->currentVerb->id)
                ->withPivot('is_learned')
                ->first();
            if ($verb) {
                // Keep this synchronous as it's critical for immediate view "learned" status
                $verb->pivot->is_learned = true;
                $verb->pivot->save();
            }
        }

        // Add to batch for background persistence
        $this->sessionXp += 5;
        if (! in_array($this->currentVerb->id, $this->masteredVerbIds)) {
            $this->masteredVerbIds[] = $this->currentVerb->id;
        }
    }

    public function nextVerb()
    {
        if ($this->currentIndex < count($this->verbs) - 1) {
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

    protected function finishSession()
    {
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

    public function render()
    {
        return view('livewire.learn-session');
    }
}
