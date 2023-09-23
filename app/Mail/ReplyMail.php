<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $customer_mail_data;
    public function __construct($data)
    {
        $this->customer_mail_data = $data;
    }
   

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('reply_mail.reply_mail',[
            'message_id'=>$this->customer_mail_data,
        ]);
    }

}
