<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Inventory;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function GuzzleHttp\Promise\all;

class CartController extends Controller
{
    //

    function cart(Request $request){
        $coupon_message = null;
        $discount = null;
        $active_btn = $request->coupon_btn;
        $coupon_info = Coupon::where('coupon_name', $request->coupon_name)->get()->first();
        

            // ===== coupon apply =====
            if($request->coupon_name !=''){
                // ===== coupon exist =====
                if(Coupon::where('coupon_name', $request->coupon_name)->exists()){
                    // ===== validity exist =====
                    if($coupon_info->validity >= Carbon::now()){
                        // ===== minimum requirement purchased =====
                        if($request->total > $coupon_info->min_purchase){
                            // ===== persentage discount =====
                            if($coupon_info->coupon_type == 1){
                                // ===== between min & max discount ====
                                if($request->total*$coupon_info->coupon_amount/100 > $coupon_info->min_amount && $request->total*$coupon_info->coupon_amount/100 < $coupon_info->max_amount){
                                    $discount = $request->total*$coupon_info->coupon_amount/100;
                                }
                                else{
                                    // ===== minimum discount =====
                                    if($request->total*$coupon_info->coupon_amount/100 < $coupon_info->min_amount){
                                        $discount = $coupon_info->min_amount;
                                    }
                                    // ===== maximum discount =====
                                    else if($request->total*$coupon_info->coupon_amount/100 > $coupon_info->max_amount){
                                        $discount = $coupon_info->max_amount;
                                    }
                                }
                            }
                            // ===== silid amount discount =====
                            else{
                                $discount = $coupon_info->coupon_amount;
                            }
                        }
                        // ===== minimum requirement not purchased =====
                        else{
                            $discount = 0;
                            $coupon_message = 'Minimum purchase required to apply this coupon!';
                        }
                    }
                    // ===== coupon expired =====
                    else{
                        $discount = 0;
                        $coupon_message = 'Coupon validity expired!';
                    }                   
                }
                // ===== coupon not exist =====
                else{
                    $discount = 0;
                    $coupon_message = 'Coupon name does not exist!';
                }
            }
            // ===== no coupon apply =====
            else{
                $discount = 0;
                $coupon_message = 'No Coupon applied!';
            }

        
        $carts = Cart::where('customer_id', Auth::guard('customerlogin')->id())->get();

        return view('frontend.cart',[
            'carts'=> $carts,
            'discount'=> $discount,
            'coupon_message'=> $coupon_message,
            'active_btn'=> $active_btn,
        ]);
        
    }


    // ================== cart store =====================
    function cart_store(Request $request){
        $request->validate([
            'color_id'=>['required'],
            'size'=>['required'],
        ],[
            'color_id.required'=>'Color is not selected!',
            'size.required'=>'Size is not selected!',
        ]);
        if(Auth::guard('customerlogin')->check()){
            if(Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size)->exists()){
                if (Cart::where('customer_id', Auth::guard('customerlogin')->id())->where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size)->exists()) {
                    Cart::where('customer_id', Auth::guard('customerlogin')->id())->where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size)->increment('quantity', $request->quantity);
                    return back()->with('cart_success', 'Cart Added Successfully');
                } 
                else {
                    Cart::insert([
                        'customer_id' => Auth::guard('customerlogin')->id(),
                        'product_id' => $request->product_id,
                        'color_id' => $request->color_id,
                        'size_id' => $request->size,
                        'quantity' => $request->quantity,
                        'created_at' => Carbon::now(),
                    ]);
                    return back()->with('cart_success', 'Cart Added Successfully');
                }
            }
            else{
                return back()->with('just_stock_out', 'Product is sold out just now!');
            }
        }
        else{
            return redirect()->route('customer.login.register')->with('cartlogin','Please Login First for add to cart!'); 
        }
    }

    // ================== cart remove =====================
    function cart_remove($cart_id){
        Cart::where('id', $cart_id)->where('customer_id', Auth::guard('customerlogin')->id())->delete();
        return back()->with('cart_remove', 'Cart Removed Successfully');
    }

    // ================== cart update =====================
    function cart_update(Request $request){
        foreach($request->quantity as $cart_id=>$quantity){
            Cart::find($cart_id)->update([
                'quantity'=> $quantity,
            ]);
        }
        return back()->with('Cart_update', 'Cart Update Successfully!');
    }

    // remove all checked cart ==========
    function cart_remove_all_checked(Request $request){
        foreach($request->cart_id as $check_cart){
            Cart::find($check_cart)->delete();
        }
        return back()->with('checked_cart_delete', 'Selected Products Are Removed From Cart!');
    }
}
