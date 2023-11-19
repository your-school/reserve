<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\ReservationReminderNextDay;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;


class SendReservationReminderNextDay extends Command
{
    protected $signature = 'send:reservation-reminder-next-day';
    protected $description = 'Send reminders for reservations that are next day.';

    public function handle()
    {
        $nextDayFromNow = Carbon::today()->addDay();
        $reservations = Reservation::whereDate('start_day', $nextDayFromNow)->get();

        foreach ($reservations as $reservation) {
            Mail::to($reservation->email)->send(new ReservationReminderNextDay($reservation));
        }

        $this->info('予約前日のお客様にリマインドメールを送信しました。');
    }
}
