<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ToAdminReservationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $startDay;
    public $name;

    /**
     * Create a new message instance.
     */
    public function __construct($startDay, $name)
    {
        $this->startDay = $startDay;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('【' . config('app.name') . '】' . '予約がありました。')
            ->view('reservationMail.to-mail-admin')
            ->with([
                'name' => $this->name,
                'startDay' => $this->startDay,
            ]);
    }
}
