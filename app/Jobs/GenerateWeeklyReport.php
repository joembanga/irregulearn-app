<?php

namespace App\Jobs;

use App\Mail\WeeklyReportMail;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class GenerateWeeklyReport implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $user)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $user = $this->user;
            
            // Gather statistics for the week
            $startOfWeek = now()->startOfWeek();
            $endOfWeek = now()->endOfWeek();

            $weeklyXp = $user->xp_weekly;
            $verbsLearned = $user->dailyVerbs()
                ->wherePivot('is_learned', true)
                ->wherePivotBetween('daily_verbs.created_at', [$startOfWeek, $endOfWeek])
                ->count();
            
            // This would likely need a dedicated view
            $data = [
                'user' => $user,
                'weekStart' => $startOfWeek->format('d M'),
                'weekEnd' => $endOfWeek->format('d M'),
                'xp' => $weeklyXp,
                'verbsLearned' => $verbsLearned,
            ];

            // Reset weekly XP after generating report (if running on Sunday/Monday)
            // Or just rely on a separate scheduled task for reset. 
            // For now, we just report.

            // Only send if there was some activity
            if ($weeklyXp > 0 || $verbsLearned > 0) {
                 Mail::to($user)->send(new WeeklyReportMail($data));
            }

        } catch (\Throwable $e) {
            Log::error("Failed to generate weekly report for user {$this->user->id}: " . $e->getMessage());
            $this->fail($e);
        }
    }

    /**
     * Handle job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('GenerateWeeklyReport job failed: ' . $exception->getMessage());
    }
}
