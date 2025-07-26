<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // Schedule cron:create-new-monthly-contribution-payments
        $schedule->command('cron:create-new-monthly-contribution-payments')->dailyAt('07:00');
    }
}
