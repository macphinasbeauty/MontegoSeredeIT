<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DuffelAccessDetails extends Mailable
{
    use Queueable, SerializesModels;

    public $bookingData;
    public $accessDetails;

    /**
     * Create a new message instance.
     */
    public function __construct($bookingData, $accessDetails)
    {
        $this->bookingData = $bookingData;
        $this->accessDetails = $accessDetails;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Hotel Access Details - Booking #' . ($this->bookingData['reference_code'] ?? 'N/A'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.duffel-access-details',
            with: [
                'bookingData' => $this->bookingData,
                'accessDetails' => $this->accessDetails,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
