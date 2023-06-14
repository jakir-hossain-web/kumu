<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     
    //  here "$data" means the variable($order_id) send from CheckoutController for sending mail ======
    public $order_data;
    public function __construct($data)
    {
        $this->order_data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('invoice.invoicemail',[
            'order_id'=>$this->order_data,
        ]);
    }
}
