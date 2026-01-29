<?php

namespace App\Livewire;

use Livewire\Component;

class WeeklyReportCard extends Component
{
    public $report;
    public $showShareDialog = false;

    public function mount()
    {
        // Get the latest weekly report for the authenticated user
        $this->report = auth()->user()->weeklyReports()->first();
    }

    public function share()
    {
        if (!$this->report) {
            return;
        }

        // Increment share count
        $this->report->incrementSharedCount();

        // Trigger native share dialog
        $this->showShareDialog = true;
        
        $this->dispatch('openShare', [
            'title' => auth()->user()->username . "'s Weekly Verb Conquest",
            'text' => "I mastered {$this->report->verbs_mastered_count} verbs this week on IrreguLearn! 🔥",
            'url' => route('share.image', ['type' => 'weekly-report', 'identifier' => $this->report->id]),
        ]);
    }

    public function render()
    {
        return view('livewire.weekly-report-card');
    }
}
