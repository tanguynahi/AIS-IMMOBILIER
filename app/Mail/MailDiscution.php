<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailDiscution extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $obj;
    public $sujet;
    public $attachmenPath;
    public function __construct($sujet, $obj, $attachmenPath)
    {
        $this->obj = $obj;
        $this->sujet = $sujet;
        $this->attachmenPath = $attachmenPath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
        return $this->view('emails.mail-discution', ['sujet'=>$this->sujet, 'data'=>$this->obj]);
    }
    
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->sujet,
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return $this->attachmenPath;
    }
}
