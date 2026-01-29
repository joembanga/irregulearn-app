<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\AvatarService;
use Illuminate\Console\Command;

class MigrateAvatars extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-avatars';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download and save avatars locally for existing users';

    /**
     * Execute the console command.
     */
    public function handle(AvatarService $avatarService)
    {
        $this->info('Starting avatar migration...');

        // Find users with avatar_code but no local avatar file
        $users = User::whereNotNull('avatar_code')
            ->where(function ($query) {
                $query->whereNull('avatar_url')
                    ->orWhere('avatar_url', '');
            })
            ->get();

        $count = $users->count();
        $this->info("Found {$count} users to process.");

        $bar = $this->output->createProgressBar($count);
        $bar->start();

        foreach ($users as $user) {
            $result = $avatarService->downloadAndSave($user);
            
            if (!$result) {
                $this->warn("\nFailed to download avatar for user: {$user->username}");
            }
            
            $bar->advance();
            
            // Be nice to the API
            usleep(100000); // 100ms delay
        }

        $bar->finish();
        $this->newLine();
        $this->info('Avatar migration completed!');
    }
}
