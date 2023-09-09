<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    function order_list(){
        return view('admin.order.order_list');
    }

    function order_status_update(Request $request){
        Order::where('order_id', $request->order_id)->update([
            'order_status'=> $request->order_status,
            'notification_status'=>1,
        ]);
         return back()->with('order_status_update','Order Status Update Successfully!');
    }

    function order_details($view_order_sl_no){
        if(Order::where('id', $view_order_sl_no)->where('notification_status', 0)){
            Order::find($view_order_sl_no)->update([
                'notification_status'=>1,
            ]);
        }
        
        $view_order_sl_no = $view_order_sl_no;
        return view('admin.order.order_details',[
            'view_order_sl_no'=>$view_order_sl_no,
        ]);
    }


}
