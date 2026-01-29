<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\WeeklyReport;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateWeeklyReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-weekly-reports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate weekly mastery reports for all users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting weekly report generation...');

        // Get the previous week (Monday to Sunday)
        $weekEnd = Carbon::now()->previous(Carbon::SUNDAY);
        $weekStart = $weekEnd->copy()->previous(Carbon::MONDAY);

        $this->info("Generating reports for week: {$weekStart->format('Y-m-d')} to {$weekEnd->format('Y-m-d')}");

        $users = User::all();
        $generatedCount = 0;

        foreach ($users as $user) {
            try {
                // Check if report already exists for this week
                $existingReport = WeeklyReport::where('user_id', $user->id)
                    ->where('week_start_date', $weekStart->format('Y-m-d'))
                    ->first();

                if ($existingReport) {
                    $this->warn("Report already exists for user {$user->username}");
                    continue;
                }

                // Calculate verbs mastered during the week
                $verbsMastered = DB::table('user_verb')
                    ->where('user_id', $user->id)
                    ->where('mastered', true)
                    ->whereBetween('updated_at', [$weekStart, $weekEnd->endOfDay()])
                    ->count();

                // Get XP earned during the week (we'll use xp_weekly as it tracks weekly XP)
                // Note: This assumes xp_weekly is the XP earned in the current/last week
                $xpEarned = $user->xp_weekly ?? 0;

                // Get streak at start and end of week
                // For simplicity, we'll use current streak as end, and calculate start
                $streakAtEnd = $user->current_streak;
                $streakAtStart = max(0, $streakAtEnd - 7); // Approximate

                // Get leaderboard ranks
                $rankAtStart = $this->getUserRank($user->id, $weekStart);
                $rankAtEnd = $this->getUserRank($user->id, $weekEnd);

                // Create the weekly report
                $report = WeeklyReport::create([
                    'user_id' => $user->id,
                    'week_start_date' => $weekStart->format('Y-m-d'),
                    'week_end_date' => $weekEnd->format('Y-m-d'),
                    'verbs_mastered_count' => $verbsMastered,
                    'xp_earned' => $xpEarned,
                    'streak_at_start' => $streakAtStart,
                    'streak_at_end' => $streakAtEnd,
                    'leaderboard_rank_start' => $rankAtStart,
                    'leaderboard_rank_end' => $rankAtEnd,
                    'image_generated' => false,
                    'shared_count' => 0,
                ]);

                $generatedCount++;
                $this->info("Generated report for user: {$user->username}");
            } catch (\Exception $e) {
                $this->error("Failed to generate report for user {$user->username}: {$e->getMessage()}");
            }
        }

        $this->info("Successfully generated {$generatedCount} weekly reports!");

        return Command::SUCCESS;
    }

    /**
     * Get user's leaderboard rank at a specific date.
     */
    private function getUserRank(int $userId, Carbon $date): ?int
    {
        // Get all users ordered by xp_weekly at that time
        // Note: This is an approximation since we don't have historical xp_weekly data
        // In a production system, you'd want to track this separately
        $rank = User::where('xp_weekly', '>', function ($query) use ($userId) {
            $query->select('xp_weekly')
                ->from('users')
                ->where('id', $userId);
        })->count() + 1;

        return $rank > 0 ? $rank : null;
    }
}
