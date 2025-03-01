<?php

namespace App\Jobs;

use App\Mail\NotificacionMailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EnviarNotificacionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $destinatario;
    protected $pdf;
    protected $link;
    protected $attachments; // nuevo campo

    /**
     * @param $destinatario Modelo del destinatario.
     * @param string $pdf Contenido binario del PDF.
     * @param string $link Enlace único para seguimiento.
     *
     */
    public function __construct($destinatario, $pdf, $link, $attachments = [])
    {
        $this->destinatario = $destinatario;
        $this->pdf = $pdf;
        $this->link = $link;
        $this->attachments = $attachments;
    }

    public function handle()
    {
        Mail::to($this->destinatario)->send(new NotificacionMailable($this->pdf, $this->link));

    }
}
