<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificacaoGmud extends Mailable
{
    use Queueable, SerializesModels;

    private $gmud;
    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($gmud, $user)
    {
        $this->gmud = $gmud;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('GMUD ' . $this->gmud->ars_number . " - NOTIFICAÇÃO")->markdown('mail.notificacao-gmud', ['gmud' => $this->gmud, 'usuario' => $this->user]);
    }
}
