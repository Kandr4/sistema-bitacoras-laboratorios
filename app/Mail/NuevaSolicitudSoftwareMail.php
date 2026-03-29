<?php

namespace App\Mail;

use App\Models\SolicitudSoftware;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NuevaSolicitudSoftwareMail extends Mailable
{
    use Queueable, SerializesModels;

    public SolicitudSoftware $solicitud;

    public function __construct(SolicitudSoftware $solicitud)
    {
        $this->solicitud = $solicitud;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nueva solicitud de software - Sistema de Bitácoras',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.nueva-solicitud-software',
        );
    }
}
