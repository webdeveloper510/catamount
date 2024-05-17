<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Storage;

class SendEventMail extends Mailable
{
    use Queueable, SerializesModels;
    public $meeting;
    public $subject;
    public $content;
    public $agreementinfo;
    /**
     * Create a new message instance.
     */
    public function __construct($meeting,$subject,$content,$agreementinfo)
    {
       $this->meeting = $meeting;
       $this->subject = $subject;
       $this->content = $content;
       $this->agreementinfo = $agreementinfo; 
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'meeting.agreement.mail',
            with: ['content' => $this->content],
        );
        
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        return $attachments;
    }

    public function build()
    {
                    $filePath = storage_path('app/public/Agreement_attachments/'. $this->meeting->id.'/'.$this->agreementinfo->attachments);
        return $this->subject($this->subject)
            ->view('lead.mail.view') // Blade view for email content
            ->with('content',$this->content)
            ->attach($filePath, [
                'as' => $this->agreementinfo->attachments, // File name
                'mime' => Storage::disk('public')->mimeType('Agreement_attachments/'.$this->meeting->id.'/'.$this->agreementinfo->attachments),
            ]);
        }
    }