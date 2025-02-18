<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificacionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $notificacion;

    /**
     * Create a new message instance.
     *
     * @param  $notificacion
     * @return void
     */
    public function __construct($notificacion)
    {
        $this->notificacion = $notificacion;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Notificación Nueva')
                    ->view('emails.notificacion');  // Define la vista que se usará para el correo
    }
}
