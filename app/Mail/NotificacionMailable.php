<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class NotificacionMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $pdf;
    public $link;

    /**
     * @param string $pdf Contenido binario del PDF.
     * @param string $link Enlace único para seguimiento.
     */
    public function __construct($pdf, $link)
    {
        $this->pdf = $pdf;
        $this->link = $link;
    }

    public function build()
    {
        return $this->subject('Nueva Notificación')
                    ->view('emails.notificacion')
                    ->attachData($this->pdf, 'notificacion.pdf', [
                        'mime' => 'application/pdf',
                    ])
                    ->with(['link' => $this->link]);
    }
}
