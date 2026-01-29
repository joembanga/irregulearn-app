<?php

namespace App\Jobs;

use App\Mail\VerbsExportMail;
use App\Models\User;
use App\Models\Verb;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class ProcessPdfExport
{

    /**
     * Create a new job instance.
     */
    public function __construct(public User $user) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = $this->user;

        $verbs = Verb::with(['users' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }])->orderBy('infinitive')->get();

        $data = [
            'user' => $user,
            'verbs' => $verbs,
            'date' => now()->format('d/m/Y'),
        ];

        $pdf = Pdf::loadView('pdf.my-verbs', $data);

        Mail::to($user)->send(new VerbsExportMail($user, $pdf->output()));
    }
}
