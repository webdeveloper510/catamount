<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Storage;

class ProposalResponseMail extends Mailable
{
    use Queueable, SerializesModels;
    public $proposals;
    public $lead;
    /**
     * Create a new message instance.
     */
    public function __construct($proposals,$lead)
    {
       $this->proposals = $proposals;
       $this->lead = $lead;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Proposal',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'lead.mail.proposal_response',
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
        $filePath = storage_path('app/public/Proposal_response/'. $this->lead->id.'/'.$this->proposals->proposal_response);
        return $this->subject('Proposal Response')
                    ->view('lead.mail.proposal_response') 
                    ->attach($filePath, [
                        'as' => $this->proposals->proposal_response, // File name
                        'mime' => Storage::disk('public')->mimeType('Proposal_response/'.$this->lead->id.'/'.$this->proposals->proposal_response),
                    ]); ;
        }
}