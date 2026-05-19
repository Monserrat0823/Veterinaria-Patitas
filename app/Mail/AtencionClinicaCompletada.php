<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\HistorialClinico;

class AtencionClinicaCompletada extends Mailable
{
    use Queueable, SerializesModels;

    public $historial;
    protected $pdfReceta;
    protected $pdfVacuna;

    /**
     * Create a new message instance.
     */
    public function __construct(HistorialClinico $historial, $pdfReceta, $pdfVacuna = null)
    {
        $this->historial = $historial;
        $this->pdfReceta = $pdfReceta;
        $this->pdfVacuna = $pdfVacuna;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Resumen de Atencion Clinica - ' . $this->historial->mascota->nombre
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.atencion-clinica',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [
            Attachment::fromData(fn () => $this->pdfReceta, 'Receta_Medica_' . $this->historial->mascota->nombre . '.pdf')
                ->withMime('application/pdf'),
        ];

        if ($this->pdfVacuna) {
            $attachments[] = Attachment::fromData(fn () => $this->pdfVacuna, 'Comprobante_Vacunacion_' . $this->historial->mascota->nombre . '.pdf')
                ->withMime('application/pdf');
        }

        return $attachments;
    }
}
