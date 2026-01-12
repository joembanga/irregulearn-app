<?php

namespace App\Livewire;

use App\Models\Report;
use App\Models\User;
use App\Models\Verb;
use App\Models\VerbExample;
use App\Notifications\ExampleLiked;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class VerbDiscussion extends Component
{
    public Verb $verb;

    public $body = '';

    protected $rules = ['body' => 'required|min:5|max:150'];

    public function submitExample()
    {
        $this->validate(['body' => 'required|min:5|max:200']);
        $user = Auth::user();

        $example = VerbExample::create([
            'verb_id' => $this->verb->id,
            'user_id' => $user->id,
            'body' => $this->body,
        ]);

        // RÉCOMPENSE : +10 XP pour la contribution
        $user->increment('xp_balance', 10);

        $this->reset('body');
        session()->flash('status', 'Exemple publié ! +10 XP ⚡');
    }

    public function like($id)
    {
        /**
         * @var User $user
         */
        $user = Auth::user();
        $example = VerbExample::findOrFail($id);
        $author = User::where('id', $example->user_id)->first();
        $verb = Verb::findOrFail($example->verb_id);

        if ($author->id === $user->id) {
            return;
        }

        if ($user->hasLikedExample($example)) {
            $user->likedExamples()->detach($example->id);
            $example->decrement('likes_count');
        } else {
            $user->likedExamples()->attach($example->id);
            $example->increment('likes_count');

            $author->increment('xp_balance', 5);
            $author->notify(new ExampleLiked($verb));
        }
    }

    public function report($id)
    {
        $user = Auth::user();
        $example = VerbExample::findOrFail($id);

        $alreadyReported = Report::where('user_id', $user->id)
            ->where('verb_example_id', $id)
            ->exists();

        if (! $alreadyReported) {
            // 2. Créer le signalement
            Report::create([
                'user_id' => $user->id,
                'verb_example_id' => $id,
                'reason' => 'Inappropriate content', // Raison par défaut
            ]);

            $reportCount = Report::where('verb_example_id', $id)->count();
            if ($reportCount >= 5) {
                $example->update(['is_hidden' => true]);
            }

            session()->flash('info', 'Signalement enregistré. Merci ! 🛡️');
        } else {
            session()->flash('warning', 'Tu as déjà signalé cet exemple.');
        }
    }

    public function render()
    {
        return view('livewire.verb-discussion', [
            'examples' => $this->verb->communityExamples()
                ->where('is_hidden', false)
                ->get(),
        ]);
    }
}
