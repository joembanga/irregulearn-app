<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetWeeklyXP extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-weekly-x-p';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remet à zéro le compteur XP hebdomadaire';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        \App\Models\User::query()->update(['xp_weekly' => 0]);
        $this->info('Le classement hebdomadaire a été réinitialisé !');
    }
}
