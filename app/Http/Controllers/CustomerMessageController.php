<?php

namespace App\Http\Controllers;

use App\Models\CustomerMessage;
use Illuminate\Http\Request;

class CustomerMessageController extends Controller
{
    //
    function customer_message(){
        $messages = CustomerMessage::all();
        return view('admin.customer_message.customer_message',[
            'messages'=> $messages,
        ]);
    }

    function reply_customer_message(Request $request){
        return $request->all();
    }
}
