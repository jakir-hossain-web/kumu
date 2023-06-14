<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Mail\InvoiceMail;
use App\Models\Cart;
use App\Models\Charge;
use App\Models\Country;
use App\Models\City;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\BillingDetails;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Str;

class CheckoutController extends Controller
{
    //
    function checkout(){
        $carts = Cart::where('customer_id', Auth::guard('customerlogin')->id())->get();
        $charges = Charge::all();
        $countries = Country::all();
        return view('frontend.checkout',[
            'carts'=>$carts,
            'charges'=>$charges,
            'countries'=>$countries,
        ]);
    }

    function getCity(Request $request){
        $str = '<option value="">-- Select City --</option>';
        $cities = City::where('country_id', $request->country_id)->get();
        foreach($cities as $city){
            $str.='<option value="'.$city->id.'">'.$city->name.'</option>';
        }
        echo $str;
    }



    // order ======
    function order_store(Request $request){
       
        $customer_name = Auth::guard('customerlogin')->user()->name;
        $random_string = substr($customer_name,0,3);
        $random_integer = random_int(10000000, 99999999);
        $order_id = '#'.Str::upper($random_string).'-'.$random_integer;

        $request->validate([
            'name' =>['required','min:3','regex:/^[a-zA-Z\s]*$/'],
            'email' =>'required',
            'company' =>'nullable',
            'mobile' =>'required|numeric',
            'address' =>'required',
            'country_id' =>'required',
            'city_id' =>'required',
            'zip' =>'nullable',
            'notes' =>'nullable',
            'sales_discount' =>'nullable',
            'coupon_discount' =>'nullable',
            'delivery_charge' =>'nullable',
            'discount' =>'nullable',
        ]);


        if($request->payment_method == 1){
            Order::insert([
                'order_id'=>$order_id,
                'customer_id'=>Auth::guard('customerlogin')->id(),
                'sub_total'=>$request->sub_total,
                'sales_discount'=>$request->sales_discount,
                'coupon_discount'=>$request->coupon_discount,
                'delivery_charge'=>$request->charge,
                'total'=>($request->sub_total+$request->charge)-($request->sales_discount+$request->coupon_discount),
                'payment_method'=>$request->payment_method,
                'created_at'=>Carbon::now(),
            ]);

            BillingDetails::insert([
                'order_id'=>$order_id,
                'customer_id'=>Auth::guard('customerlogin')->id(),
                'name'=>$request->name,
                'email'=>$request->email,
                'company'=>$request->company,
                'mobile'=>$request->mobile,
                'address'=>$request->address,
                'country_id'=>$request->country_id,
                'city_id'=>$request->city_id,
                'zip'=>$request->zip,
                'notes'=>$request->notes,
                'created_at'=>Carbon::now(),
            ]);

            $carts = Cart::where('customer_id', Auth::guard('customerlogin')->id())->get();

            foreach($carts as $cart){
                OrderProduct::insert([
                    'order_id'=>$order_id,
                    'customer_id'=>Auth::guard('customerlogin')->id(),
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
            $order_seccess_mail = Auth::guard('customerlogin')->user()->email;
            Mail::to($order_seccess_mail)->send(new InvoiceMail($order_id));


            // order success bulk sms integration ===============
            // $total = ($request->sub_total+$request->charge)-($request->sales_discount+$request->coupon_discount);
            // $url = "http://bulksmsbd.net/api/smsapi";
            // $api_key = "mq8L5jcTC1NRRSgvXJuz";
            // $senderid = "jhossain";
            // $number = $request->mobile;
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

            return redirect('/customer/order_complete')->with('order_success','Order Placed Successfully!');
        }

        else if($request->payment_method == 2){
            $checkout_info = $request->all();
            return redirect('/pay')->with('checkout_info', $checkout_info);
        }
        else{
            $checkout_info = $request->all();
            return redirect('/stripe')->with('checkout_info', $checkout_info);
        }
        
    }

    // review update ===========
    function review_update(Request $request, $product_id){

        if($request->star == 0){
            return back()->withInput(['tab' => 'reviews'])->with('review_update_error','Please rating the product to submit your review!');
        }
        else{
            if($request->review == null){
                return back()->withInput(['tab' => 'reviews'])->with('review_update_error','Review field is empty!');
            }
            else{
                if(Str::length($request->review) >= 10 && Str::length($request->review) <= 500){
                    OrderProduct::where('customer_id', Auth::guard('customerlogin')->id())->where('product_id', $product_id)->first()->update([
                        'review'=>$request->review,
                        'star'=>$request->star,
                    ]);
                    return back()->withInput(['tab' => 'reviews'])->with('review_update','Review Submitted Successfully!');
                }
                else{
                    return back()->withInput(['tab' => 'reviews'])->with('review_update_error','Review must be between 10-500 words!');
                }
            }
        }
 
  
    }

    
}
