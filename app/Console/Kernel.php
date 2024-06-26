<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('update:status')->daily();
        $schedule->command('command:save-zalo-token')->daily();
        $schedule->command('update:customer_status')->daily();
        $schedule->command('notification:schedules_quahan')->daily();
        $schedule->command('delete:task')->dailyAt('07:00');
        $schedule->command('sms:revenue')->dailyAt('07:00');
        $schedule->command('job:action')->dailyAt('08:00');
        $schedule->command('otp:refresh')->dailyAt('01:00');
        $schedule->command('deleted:Call')->dailyAt('01:00');
        $schedule->command('notification:firebase')->dailyAt('01:00');

        $schedule->command('expired:search')->everyMinute();
        $schedule->command('move_customer:search')->everyMinute();
//        $schedule->command('notification:action')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
