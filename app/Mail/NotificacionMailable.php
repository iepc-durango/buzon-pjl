<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class NotificacionMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $pdf;
    public $link;
    public $attachmentsData;
    // Usamos una propiedad separada para nuestros adjuntos personalizados
  

    /**
     * @param string $pdf Contenido del PDF en base64.
     * @param string $link Enlace único para seguimiento.
     * @param array $attachments Arreglo de archivos adicionales (cada uno con 'path' y 'name')
     */
    public function __construct(string $pdf, string $link, $attachmentsData)
    {
        $this->pdf = $pdf;
        $this->link = $link;
        $this->attachmentsData = $attachmentsData;
   
    }

    public function build()
    {
        // Decodifica el contenido del PDF
        $pdfContent = base64_decode($this->pdf);



         //Adjunta el PDF usando attachData (esto agregará un elemento estructurado correctamente en $this->attachments)
         $this->from('buzonpopjl@appsiepcdurango.mx')
             ->subject('Nueva Notificación')
             ->attachData($pdfContent, 'Notificacion.pdf', [
                 'mime' => 'application/pdf',
             ]);
  // Finalmente, retornamos la vista (asegúrate de que resources/views/emails/notificacion.blade.php exista)
        return $this->view('emails.notificacion')
                    ->with(['link' => $this->link]);
    }
}
