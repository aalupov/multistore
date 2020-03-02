<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StoresMailSend extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The storeMailSend object instance.
     *
     * @var storeMailSend
     */
    public $storeMailSend;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($storeMailSend)
    {
        $this->storeMailSend = $storeMailSend;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->storeMailSend->sender_email, $this->confirmMailSend->sender_name)
            ->subject('Message from ' . $this->storeMailSend->receiver_name . ' store contact form')
            ->view('mail.storeMailSend');
        // ->text('mail.storeMailSend_plain');
    }
}
