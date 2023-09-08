<?php

namespace App\Http\Controllers;

use App\Models\CustomerMessage;
use App\Mail\ReplyMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CustomerMessageController extends Controller
{
    //
    function customer_message(){
        $messages = CustomerMessage::all();
        return view('admin.customer_message.customer_message',[
            'messages'=> $messages,
        ]);
    }

    function customer_message_details($message_id){
        $message_info = CustomerMessage::find($message_id);
        return view('admin.customer_message.customer_message_details',[
            'message_info'=>$message_info,
        ]);
    }

    function reply_customer_message(Request $request){

        $message_id =  $request->message_id;
        $customer_email_address =  $request->customer_email_address;
        $customer_message =  $request->customer_message;
        $reply_message =  $request->reply_message;

        CustomerMessage::where('id', $message_id)->update([
            'your_reply'=>$reply_message,
        ]);

        Mail::to($customer_email_address)->send(new ReplyMail($message_id));

        return back()->with('customer_message_reply_success','Reply Message Send Successfully!');
    }

}
