<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CommonMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $subject;
    public $view;
    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct($subject, $view, $data)
    {
        $this->subject = $subject;
        $this->view = $view;
        $this->data = $data;
    }

   /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view($this->view)
                    ->subject($this->subject)
                    ->with($this->data);
    }
}
