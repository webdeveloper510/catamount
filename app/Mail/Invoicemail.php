<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Invoicemail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()

    {
       return $this->view('invoice.mail')->subject('Invoice Payment.');
        // return $this->markdown('invoice.mail')->subject('Ragarding to Invoice Payment.')->with(
        //     [
        //         'mail_header' => (!empty($this->settings['company_name'])) ? $this->settings['company_name'] : env('APP_NAME'),
        //         'invoice' => $this->invoice
        //     ]
        // );
    }
}
