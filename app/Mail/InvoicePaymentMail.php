<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Storage;

class InvoicePaymentMail extends Mailable
{
    use Queueable, SerializesModels;
    public $newpayment;
    /**
     * Create a new message instance.
     */

    public function __construct($newpayment)
    {
        $this->newpayment = $newpayment;
    }
    
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoice',
        );
    }
    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'billing.invoice',
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

        $filePath = storage_path('app/public/Invoice/'. $this->newpayment->event_id.'/'.$this->newpayment->attachment);
// echo "<pre>";print_r($filePath);die;
        return $this->subject('Invoice')
        ->view('billing.invoice')
        ->attach($filePath, [
            'as' => $this->newpayment->attachment, // File name
            'mime' => Storage::disk('public')->mimeType('Invoice/'.$this->newpayment->event_id.'/'.$this->newpayment->attachment),
        ]);; 
    }
}
