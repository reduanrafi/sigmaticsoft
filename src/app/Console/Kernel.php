<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Global Software Industry Trend Intelligence scheduled tasks
        $schedule->command('trends:collect')
            ->everySixHours()
            ->withoutOverlapping(30);

        $schedule->command('trends:aggregate')
            ->dailyAt('01:15')
            ->withoutOverlapping(30);

        $schedule->command('trends:forecast --horizon=3')
            ->weeklyOn(1, '02:00')
            ->withoutOverlapping(30);

        $schedule->command('trends:forecast --horizon=6')
            ->weeklyOn(1, '02:15')
            ->withoutOverlapping(30);

        $schedule->command('trends:forecast --horizon=12')
            ->weeklyOn(1, '02:30')
            ->withoutOverlapping(30);

        $schedule->command('trends:evaluate')
            ->dailyAt('03:00')
            ->withoutOverlapping(30);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
