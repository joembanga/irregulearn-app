<?php

namespace App\Console\Commands;

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
        $users = \App\Models\User::all();

        foreach ($users as $user) {
            $user->generateDailyVerbs();
            // notify() enverra automatiquement le mail ET créera la notif en base
            $user->notify(new DailyVerbsNotification($user->dailyVerbs));
        }
    }
}
