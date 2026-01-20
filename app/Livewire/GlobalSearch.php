<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Verb;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GlobalSearch extends Component
{
    public $query = '';
    public $results = [];

    public function updatedQuery()
    {
        if (strlen($this->query) < 2) {
            $this->results = [];
            return;
        }

        $verbs = Verb::where('infinitive', 'like', "%{$this->query}%")
            ->orWhere('past_simple', 'like', "%{$this->query}%")
            ->orWhere('past_participle', 'like', "%{$this->query}%")
            ->limit(5)
            ->get()
            ->map(function ($verb) {
                if ($verb) {
                    return [
                        'type' => 'verb',
                        'title' => $verb->infinitive,
                        'subtitle' => $verb->past_simple . ' / ' . $verb->past_participle,
                        'url' => route('verbs.show', ['verb' => $verb->slug]),
                        'icon' => '📖'
                    ];
                }
            });

        $users = User::where('username', 'like', "%{$this->query}%")
            ->where('id', '!=', Auth::id())
            ->limit(3)
            ->get()
            ->map(function ($user) {
                if ($user) {
                    return [
                        'type' => 'user',
                        'title' => $user->username,
                        'subtitle' => __('Profil public'),
                        'url' => route('profile.public', ['user' => $user->username]),
                        'icon' => '👤'
                    ];
                }
            });

        $this->results = $verbs->concat($users)->toArray();
    }

    public function render()
    {
        return view('livewire.global-search');
    }
}

