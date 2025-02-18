<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ArchivoAdjuntoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $archivoPath;  // Ruta del archivo adjunto

    public function __construct($archivoPath)
    {
        $this->archivoPath = $archivoPath;
    }

    public function build()
    {
        return $this->markdown('emails.archivo-adjunto')
                    ->subject('Archivo adjunto enviado')
                    ->attach($this->archivoPath);
    }
}
