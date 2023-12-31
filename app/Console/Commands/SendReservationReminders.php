<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\ReservationReminder;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendReservationReminders extends Command
{
    protected $signature = 'send:reservation-reminders';
    protected $description = 'Send reminders for reservations that are one week away.';

    public function handle()
    {
        $oneWeekFromNow = Carbon::today()->addWeek();
        $reservations = Reservation::whereDate('start_day', $oneWeekFromNow)->get();

        foreach ($reservations as $reservation) {
            Mail::to($reservation->email)->send(new ReservationReminder($reservation));
        }

        $this->info('一週間前の予約のリマインドメールを送信しました。');
    }
}
