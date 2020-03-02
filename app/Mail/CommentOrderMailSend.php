<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentOrderMailSend extends Mailable
{
    use Queueable, SerializesModels;
    
    /**
     * The commentOrderMailSend object instance.
     *
     * @var commentOrderMailSend
     */
    public $commentOrderMailSend;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($commentOrderMailSend)
    {
        $this->commentOrderMailSend = $commentOrderMailSend;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->commentOrderMailSend->sender_email, $this->commentOrderMailSend->sender_name)
        ->subject('New comment to the order #' . $this->commentOrderMailSend->order_number . ' from ' . $this->commentOrderMailSend->sender_name)
        ->view('mail.commentOrderMailSend');
    }
}
