<?php

namespace App\Mail;

use App\Models\Cita;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CitaConfirmacion extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Cita $cita,
        public string $tipo = 'creada' // 'creada' | 'actualizada' | 'cancelada'
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $asunto = match ($this->tipo) {
            'actualizada' => 'Cita actualizada - Veterinaria Patitas',
            'cancelada'   => 'Cita cancelada - Veterinaria Patitas',
            default       => 'Confirmacion de cita - Veterinaria Patitas',
        };

        return new Envelope(subject: $asunto);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.cita-confirmacion',
        );
    }
}
