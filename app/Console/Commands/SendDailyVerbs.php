<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\DailyVerbsNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendDailyVerbs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-daily-verbs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            $user->generateDailyVerbs();
            $user->notify(new DailyVerbsNotification($user->dailyVerbs));
        }
    }
}
