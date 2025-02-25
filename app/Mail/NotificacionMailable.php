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
    // Usamos una propiedad separada para nuestros adjuntos personalizados
    public $customAttachments;

    /**
     * @param string $pdf Contenido del PDF en base64.
     * @param string $link Enlace único para seguimiento.
     * @param array $attachments Arreglo de archivos adicionales (cada uno con 'path' y 'name')
     */
    public function __construct(string $pdf, string $link, array $attachments = [])
    {
        $this->pdf = $pdf;
        $this->link = $link;
        $this->customAttachments = $attachments;
    }

    public function build()
    {
        // Decodifica el contenido del PDF
        $pdfContent = base64_decode($this->pdf);


        Log::info('Adjuntando PDF', ['pdf_length' => strlen($pdfContent)]);
        Log::info('Adjuntos personalizados', $this->customAttachments);

         //Adjunta el PDF usando attachData (esto agregará un elemento estructurado correctamente en $this->attachments)
         $this->from('buzonpopjl@appsiepcdurango.mx')
             ->subject('Nueva Notificación')
             ->attachData($pdfContent, 'Notificacion.pdf', [
                 'mime' => 'application/pdf',
             ]);


        

        // Recorremos nuestros adjuntos personalizados y los agregamos con attach()
        foreach ($this->customAttachments as $att) {
            if (isset($att['path'], $att['name'])) {
                $filePath = storage_path('app/' . $att['path']);
                if (file_exists($filePath)) {
                    Log::info('Adjuntando archivo', ['file' => $att['name'], 'path' => $filePath]);
                    $this->attach($filePath, [
                        'as'   => $att['name'],
                        'mime' => File::mimeType($filePath),
                    ]);
                }else {
                    Log::warning('Archivo no encontrado', ['file' => $att['name'], 'path' => $filePath]);
            }
        }

        // Finalmente, retornamos la vista (asegúrate de que resources/views/emails/notificacion.blade.php exista)
        return $this->view('emails.notificacion')
                    ->with(['link' => $this->link]);
    }
}
}