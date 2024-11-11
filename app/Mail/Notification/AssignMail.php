<?php

namespace App\Mail\Notification;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Holds the data required for email or template rendering.
 * 
 * @param string $view The template or view name to be used for rendering.
 * @param string $subject The subject line of the email or message.
 * @param string $from The sender's email address.
 * @param string $fromName The name of the sender.
 */
class AssignMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()

    {

        return $this->view($this->data['view'])->subject($this->data['subject']);
        // return $this->markdown('invoice.mail')->subject('Ragarding to Invoice Payment.')->with(['mail_header' => empty($this->settings['company_name'])) ? $this->settings['company_name'] : env('APP_NAME'),'invoice' => $this->invoice]);
    }
}
