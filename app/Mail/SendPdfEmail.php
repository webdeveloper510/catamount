<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class SendPdfEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $lead;
    public $subject;
    public $content;
    public $proposalinfo; 
    /**
     * Create a new message instance.
     */
    public function __construct($lead,$subject,$content,$proposalinfo,$propid)
    {
        $this->lead = $lead;
        $this->subject = $subject;
        $this->content = $content;
        $this->proposalinfo = $proposalinfo; 
        $this->propid = $propid;
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
            view: 'lead.mail.view',
            with: ['content' => $this->content ,'propid' =>$this->propid],
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
        if($this->proposalinfo->attachments != ''){
            $filePath = storage_path('app/public/Proposal_attachments/'. $this->lead->id.'/'.$this->proposalinfo->attachments);
            return $this->subject($this->subject)
                ->view('lead.mail.view') // Blade view for email content
                ->with('content',$this->content)
                ->with('propid', $this->propid)
                ->attach($filePath, [
                    'as' => $this->proposalinfo->attachments, // File name
                    'mime' => Storage::disk('public')->mimeType('Proposal_attachments/'.$this->lead->id.'/'.$this->proposalinfo->attachments),
                ]);
        }else{
        // echo "<pre>";print_r($filePath);die;
        return $this->subject($this->subject)
            ->view('lead.mail.view') // Blade view for email content
            ->with('content',$this->content)
            ->with('propid', $this->propid);
        }
        
        }
}