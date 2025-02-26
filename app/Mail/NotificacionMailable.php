<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class NotificacionMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $pdf;
    public string $link;

    /**
     * @param string $pdf Contenido binario del PDF.
     * @param string $link Enlace único para seguimiento.
     */
    public function __construct(string $pdf, string $link)
    {
        $this->pdf = $pdf;
        $this->link = $link;
    }

    public function build()
    {
        return $this->from('buzonpopjl@appsiepcdurango.mx')
            ->subject('Nueva Notificación')
            ->attach(file_get_contents($this->pdf), [
                'as' => 'Notificación.pdf',
                'mime' => 'application/pdf',
            ])
            ->view('emails.notificacion')
            ->with(['link' => $this->link]);
    }
}
