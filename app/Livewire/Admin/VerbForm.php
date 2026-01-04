<?php

namespace App\Livewire\Admin;

use App\Models\Verb;
use App\Models\Category;
use Livewire\Component;

class VerbForm extends Component
{
    public Verb $verb;
    public $categories = [];
    public $selectedCategories = [];

    protected $rules = [
        'verb.infinitive' => 'required|string|max:255',
        'verb.past_simple' => 'required|string|max:255',
        'verb.past_participle' => 'required|string|max:255',
        'verb.translation' => 'required|string|max:255',
        'verb.level' => 'required|in:beginner,intermediate,advanced',
        'verb.description' => 'nullable|string',
        'selectedCategories' => 'array'
    ];

    public function mount(Verb $verb = null)
    {
        $this->verb = $verb ?? new Verb(['level' => 'beginner']);
        $this->categories = Category::orderBy('order')->get();

        if ($this->verb->exists) {
            $this->selectedCategories = $this->verb->categories->pluck('id')->map(fn($id) => (string) $id)->toArray();
        }
    }

    public function save()
    {
        $this->validate();

        // If creating new
        if (!$this->verb->exists) {
            // Slug generation logic (simple version)
            $this->verb->slug = \Illuminate\Support\Str::slug($this->verb->infinitive);
        }

        $this->verb->save();
        $this->verb->categories()->sync($this->selectedCategories);

        session()->flash('message', 'Verb saved successfully.');

        return redirect()->route('admin.verbs.index');
    }

    public function render()
    {
        return view('livewire.admin.verb-form');
    }
}
