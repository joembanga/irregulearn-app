<?php

namespace App\Livewire\Admin;

use App\Models\Report;
use App\Models\VerbExample;
use Livewire\Component;
use Livewire\WithPagination;

class ReportManager extends Component
{
    use WithPagination;

    public function dismissReport($reportId)
    {
        $report = Report::find($reportId);
        if ($report) {
            $report->delete();
            session()->flash('message', 'Report dismissed.');
        }
    }

    public function deleteContent($reportId)
    {
        $report = Report::with('example')->find($reportId);

        if ($report && $report->example) {
            // Delete the example content
            $report->example->delete();
            // The report will be deleted via cascade (database level) or we do it manually if logic requires
            // Assuming cascade on foreign key or we delete it explicitly
            $report->delete();

            session()->flash('message', 'Content deleted and report resolved.');
        } else {
            // If example is already gone, just delete report
            if ($report) $report->delete();
        }
    }

    public function render()
    {
        $reports = Report::with(['example.verb', 'example.user']) // Adjust relations based on User/VerbExample models
            ->latest()
            ->paginate(10);

        return view('livewire.admin.report-manager', [
            'reports' => $reports
        ]);
    }
}
