<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationCancellationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reserva;
    public $motiu;
    public $dataResFormatted;

    public function __construct($reserva, $motiu, $dataResFormatted)
    {
        $this->reserva = $reserva;
        $this->motiu = $motiu;
        $this->dataResFormatted = $dataResFormatted;
    }

    public function build()
    {
        return $this->subject('Cancel·lació de Reserva')->view('emails.reservationCancellation');
    }
}
