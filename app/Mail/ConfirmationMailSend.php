<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmationMailSend extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The confirmMailSend object instance.
     *
     * @var confirmMailSend
     */
    public $confirmMailSend;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($confirmMailSend)
    {
        $this->confirmMailSend = $confirmMailSend;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->confirmMailSend->sender_email, $this->confirmMailSend->sender_name)
            ->subject('Confirmation email to the order #' . $this->confirmMailSend->order_number . ' from ' . $this->confirmMailSend->sender_name)
            ->view('mail.confirmMailSend');
    }
}
