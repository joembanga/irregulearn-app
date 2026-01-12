<?php

namespace App\Livewire\Admin;

use App\Models\Verb;
use Livewire\Component;
use Livewire\WithPagination;

class VerbManager extends Component
{
    use WithPagination;

    public $search = '';

    public $confirmingVerbDeletion = false;

    public $verbIdToDelete = null;

    public $isEditing = false; // To toggle form visibility if we want inline, or we can use a separate route.

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmVerbDeletion($id)
    {
        $this->confirmingVerbDeletion = true;
        $this->verbIdToDelete = $id;
    }

    public function deleteVerb()
    {
        $verb = Verb::find($this->verbIdToDelete);

        if ($verb) {
            $verb->delete();
            session()->flash('message', 'Verb deleted successfully.');
        }

        $this->confirmingVerbDeletion = false;
        $this->verbIdToDelete = null;
    }

    public function render()
    {
        $verbs = Verb::query()
            ->where('infinitive', 'like', '%'.$this->search.'%')
            ->orderBy('infinitive')
            ->paginate(10);

        return view('livewire.admin.verb-manager', [
            'verbs' => $verbs,
        ]);
    }
}
