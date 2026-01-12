<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Verb;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;

class SearchPage extends Component
{
    #[Url(as: 'q')] // Query parameter 'q' in URL
    public $query = ''; // Search query

    public function render(): View
    {
        $verbs = [];
        $users = [];
        $history = Auth::user()->search_history ?? [];

        if (strlen($this->query) >= 1) {
            $verbs = Verb::where('infinitive', 'like', "%{$this->query}%")
                ->orWhere('past_simple', 'like', "%{$this->query}%")
                ->orWhere('past_participle', 'like', "%{$this->query}%")
                ->limit(10)
                ->get();

            // Recherche des Utilisateurs (sauf soi-même)
            $users = User::where('username', 'like', "%{$this->query}%")
                ->where('id', '!=', Auth::id())
                ->limit(5)
                ->get();
        }

        return view('livewire.search-page', [
            'verbs' => $verbs,
            'users' => $users,
            'query' => $this->query,
            'history' => array_reverse($history), // More recent first
        ]);
    }

    public function selectResult($term, $url)
    {
        $user = Auth::user();
        $history = $user->search_history ?? [];

        // Manage history (max 20 items)
        if (count($history) > 20) {
            // Remove oldest
            array_shift($history);
        }

        if (in_array($term, $history)) {
            // Remove existing occurrence
            $history = array_filter($history, fn ($t) => $t !== $term);
        }
        array_push($history, $term); // Add to the end

        User::where('id', $user->id)->update(['search_history' => $history]);

        // Redirect to the selected result
        return redirect($url);
    }

    public function clearHistory()
    {
        $user = Auth::user();
        User::where('id', $user->id)->update(['search_history' => null]);
    }

    // Remplir la barre de recherche quand on clique sur un élément de l'historique
    public function searchFromHistory($term)
    {
        $this->query = $term;
    }
}
