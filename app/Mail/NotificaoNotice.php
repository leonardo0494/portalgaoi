<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificaoNotice extends Mailable
{
    use Queueable, SerializesModels;

    private $notice;
    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($notice, $user)
    {
        $this->notice = $notice;
        $this->user   = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->notice->title)->markdown('mail.notificacao-notice', ['notice' => $this->notice, "user" => $this->user ]);
    }
}
