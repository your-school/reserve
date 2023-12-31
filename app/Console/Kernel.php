<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('create:room-slot-data')->weeklyOn(1, '00:00');
        // 一週間前の予約リマインドメールを送信
        $schedule->command('send:reservation-reminders')->daily();
        // 翌日の予約リマインドメールを送信
        $schedule->command('send:reservation-reminder-next-day')->daily('10:00');
        // $schedule->command('delete:exceed-room-slots')->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
