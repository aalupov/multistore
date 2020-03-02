<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AddBuisnessMailSend extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The AddBuisnessMailSend object instance.
     *
     * @var addBuisnessMailSend
     */
    public $addBuisnessMailSend;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($addBuisnessMailSend)
    {
        $this->addBuisnessMailSend = $addBuisnessMailSend;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->addBuisnessMailSend->sender_email, $this->addBuisnessMailSend->sender_name)
            ->subject('Request to add the new store')
            ->view('mail.addBuisnessMailSend');
    }
}
