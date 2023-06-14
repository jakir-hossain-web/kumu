<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wish;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishController extends Controller
{
    //

    function wish_store(Request $request){
        if(Auth::guard('customerlogin')->check()){
            if (Product::where('id', $request->product_id)->exists()) {
                Wish::insert([
                    'customer_id' => Auth::guard('customerlogin')->id(),
                    'product_id' => $request->product_id,
                    'created_at' => Carbon::now(),
                ]);
                return back()->with('wish_success', 'Wishlist Added Successfully'); 
            } 
            else {
                return redirect()->route('front.home')->with('product_just_deleted', 'We update our all product just now and your seleted product is not avaiable!');
            } 
        }
        else{
            return redirect()->route('customer.login.register')->with('wishlogin','Please Login First for add to wishlist!'); 
         }
    }
    
    function wish_store_again($product_id){
        if(Auth::guard('customerlogin')->check()){
            if(Product::where('id', $product_id)->exists()){
                if (Wish::where('customer_id', Auth::guard('customerlogin')->id())->where('product_id', $product_id)->exists()) {
                    return back()->with('wish_again_success', 'Wishlist Already Added!');
                } 
                else {
                    Wish::insert([
                        'customer_id' => Auth::guard('customerlogin')->id(),
                        'product_id' => $product_id,
                        'created_at' => Carbon::now(),
                    ]);
                    return back()->with('wish_again_success', 'Wishlist Added Successfully');
                }
            }
            else{
                return redirect()->route('front.home')->with('product_just_deleted', 'We update our all product just now and your seleted product is not avaiable!');
            }         
        }
        else{
            return redirect()->route('customer.login.register')->with('wishlogin','Please Login First for add to wishlist!'); 
         }
    }

    function wish_remove($wish_id){

        Wish::where('id', $wish_id)->where('customer_id', Auth::guard('customerlogin')->id())->delete();
        return back()->with('wish_remove', 'Wishlist Removed Successfully');
        
    }

    // remove all checked wishes ==========
    function wish_remove_all_checked(Request $request){

        foreach($request->wish_id as $check_wish){
            Wish::find($check_wish)->delete();
        }
        return back()->with('checked_wish_all_delete', 'Selected Wishes Are Removed!');
    }
    
}
