<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Storage;
class AgreementResponseMail extends Mailable
{
    use Queueable, SerializesModels;
    public $agreements;
    public $meeting;
    /**
     * Create a new message instance.
     */
    public function __construct($agreements,$meeting)
    {
        $this->agreements = $agreements;
        $this->meeting = $meeting;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Agreement',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'meeting.agreement.signed_mail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
    public function build()
    {
        $filePath = storage_path('app/public/Agreement_response/'. $this->meeting->id.'/'.$this->agreements->agreement_response);
        return $this->subject('Agreement')
                    ->view('meeting.agreement.signed_mail') 
                    ->attach($filePath, [
                        'as' => $this->agreements->agreement_response, // File name
                        'mime' => Storage::disk('public')->mimeType('Agreement_response/'.$this->meeting->id.'/'.$this->agreements->agreement_response),
                    ]); ;
        }
}
