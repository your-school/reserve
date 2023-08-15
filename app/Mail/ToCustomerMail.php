<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ToCustomerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $content;
    public $name;

    /**
     * Create a new message instance.
     */
    public function __construct($content, $name)
    {
        $this->content = $content;
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
            ->subject('【' . config('app.name') . '】' . 'お問合せ確認メールの送信')
            ->view('inquiriesMail.mail-content')
            ->with([
                'name' => $this->name,
                'content' => $this->content,
            ]);
    }
}
