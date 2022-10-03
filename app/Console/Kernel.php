<?php

namespace App\Console;

use WpStarter\Console\Scheduling\Schedule;
use WpStarter\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \WpStarter\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('user:reset_icount')->at('00:05');
        $schedule->command('user:recover_icount')->hourly();
        $schedule->command('ti:rotate')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}
