<?php

namespace App\Mail;

use App\Models\SolicitudSoftware;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CambioEstadoSolicitudMail extends Mailable
{
    use Queueable, SerializesModels;

    public SolicitudSoftware $solicitud;
    public string $nuevoEstado;
    public ?string $comentarioTecnico;

    public function __construct(SolicitudSoftware $solicitud, string $nuevoEstado, ?string $comentarioTecnico = null)
    {
        $this->solicitud = $solicitud;
        $this->nuevoEstado = $nuevoEstado;
        $this->comentarioTecnico = $comentarioTecnico;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu solicitud de software ha sido ' . strtolower($this->nuevoEstado) . ' - Sistema de Bitácoras',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.cambio-estado-solicitud',
        );
    }
}
