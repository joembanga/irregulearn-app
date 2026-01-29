<?php

namespace App\Livewire;

use App\Models\VerbExample;
use Livewire\Component;

class DeleteExample extends Component
{
    public $exampleId;
    public $showConfirmation = false;

    public function mount($exampleId)
    {
        $this->exampleId = $exampleId;
    }

    public function confirmDelete()
    {
        $this->showConfirmation = true;
    }

    public function cancelDelete()
    {
        $this->showConfirmation = false;
    }

    public function delete()
    {
        $example = VerbExample::findOrFail($this->exampleId);

        // Verify ownership
        if ($example->user_id !== auth()->id()) {
            $this->dispatch('error', message: __('You can only delete your own examples.'));
            return;
        }

        // Delete the example
        $example->delete();

        // Emit event to refresh parent components
        $this->dispatch('exampleDeleted');
        
        // Show success message
        $this->dispatch('success', message: __('Example deleted successfully.'));

        // Close confirmation dialog
        $this->showConfirmation = false;
    }

    public function render()
    {
        return view('livewire.delete-example');
    }
}
