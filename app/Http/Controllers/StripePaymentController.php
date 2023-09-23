<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\BillingDetails;
use App\Models\OrderProduct;
use App\Models\Stripeorder;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;
use Session;
use Stripe;
use Str;

class StripePaymentController extends Controller{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe(){

        // $checkout_info = session('checkout_info');
        // $total = ($checkout_info ['sub_total']+$checkout_info ['charge'])-($checkout_info ['sales_discount']+$checkout_info ['coupon_discount']);
        // $customer_name = Auth::guard('customerlogin')->user()->name;
        // $random_string = substr($customer_name,0,3);
        // $random_integer = random_int(10000000, 99999999);
        // $order_id = '#'.Str::upper($random_string).'-'.$random_integer;
        // $customer_id = Auth::guard('customerlogin')->id();


        // Stripeorder::insert([
        //     'order_id' => $order_id,
        //     'customer_id'=>$customer_id,
        //     'status' => 'Pending',
        //     'name' => $checkout_info ['name'],
        //     'email' => $checkout_info ['email'],
        //     'mobile' => $checkout_info ['mobile'],
        //     'address' => $checkout_info ['address'],
        //     // 'transaction_id' => $post_data['tran_id'],
        //     'sub_total'=>$checkout_info ['sub_total'],
        //     'sales_discount'=>$checkout_info ['sales_discount'],
        //     'coupon_discount'=>$checkout_info ['coupon_discount'],
        //     'delivery_charge'=>$checkout_info ['charge'],
        //     'total' => $total,
        //     'currency' => 'BDT',
        //     'company'=>$checkout_info ['company'],
        //     'country_id'=>$checkout_info ['country_id'],
        //     'city_id'=>$checkout_info ['city_id'],
        //     'zip'=>$checkout_info ['zip'],
        //     'notes'=>$checkout_info ['notes'],
        //     'created_at'=>Carbon::now(),
        // ]);

        return view('stripe');
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */

    public function stripePost(Request $request){

        $order_info = session('order_info');
        $customer_name = Auth::guard('customerlogin')->user()->name;
        $random_string = substr($customer_name,0,3);
        $random_integer = random_int(10000000, 99999999);
        $order_id = '#'.Str::upper($random_string).'-'.$random_integer;
        $customer_id = Auth::guard('customerlogin')->id();

        

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        Stripe\Charge::create ([
            "amount" => 100 * $request->total,
            "currency" => "BDT",
            "source" => $request->stripeToken,
            "description" => "Test payment" 
        ]);


        // $tran_id = $request->input('tran_id');
        // $order_info = Sslorder::where('transaction_id', $tran_id)->get()->first();

        // Sslorder::find($order_info->id)->update([
        //     'status' => 'completed',
        // ]);

        Order::insert([
            'order_id'=>$order_id,
            'customer_id'=>$customer_id,
            'sub_total'=>$order_info['sub_total'],
            'sales_discount'=>$order_info['sales_discount'],
            'coupon_discount'=>$order_info['coupon_discount'],
            'delivery_charge'=>$order_info['charge'],
            'total'=>$request->total,
            'payment_method'=>3,
            'created_at'=>Carbon::now(),
        ]);

        BillingDetails::insert([
            'order_id'=>$order_id,
            'customer_id'=>$customer_id,
            'name'=>$order_info['name'],
            'email'=>$order_info['email'],
            'company'=>$order_info['company'],
            'mobile'=>$order_info['mobile'],
            'address'=>$order_info['address'],
            'country_id'=>$order_info['country_id'],
            'city_id'=>$order_info['city_id'],
            'zip'=>$order_info['zip'],
            'notes'=>$order_info['notes'],
            'created_at'=>Carbon::now(),
        ]);

        $carts = Cart::where('customer_id', Auth::guard('customerlogin')->id())->get();

        foreach($carts as $cart){
            OrderProduct::insert([
                'order_id'=>$order_id,
                'customer_id'=>$customer_id,
                'product_id'=>$cart->product_id,
                'original_price'=>$cart->rel_to_product->price,
                'discount'=>$cart->rel_to_product->discount,
                'after_discount'=>($cart->rel_to_product->after_discount)*($cart->quantity),
                'color_id'=>$cart->color_id,
                'size_id'=>$cart->size_id,
                'quantity'=>$cart->quantity,
                'created_at'=>Carbon::now(),
            ]);

            // Inventory::where('product_id', $cart->product_id)->where('color_id', $cart->color_id)->where('size_id', $cart->size_id)->decrement('quantity', $cart->quantity);
        }

        // Cart::where('customer_id', Auth::guard('customerlogin')->id())->delete();

        // order success mail integration ===========
        // Mail::to($order_info->email)->send(new InvoiceMail($order_info->order_id));

        // order success bulk sms integration ===============
        // $total = $order_info->amount;
        // $url = "http://bulksmsbd.net/api/smsapi";
        // $api_key = "mq8L5jcTC1NRRSgvXJuz";
        // $senderid = "jhossain";
        // $number = $order_info->mobile;
        // $message = "Congratulations! Your order has been placed successfully. Your total bill is Tk.".$total;
    
        // $data = [
        //     "api_key" => $api_key,
        //     "senderid" => $senderid,
        //     "number" => $number,
        //     "message" => $message
        // ];
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // $response = curl_exec($ch);
        // curl_close($ch);

        Session::flash('success', 'Payment successful!');

        return redirect('/customer/order_complete')->with('order_success','Order Placed Successfully!');
    }
}
