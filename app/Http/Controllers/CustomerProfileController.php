<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerLogin;
use App\Models\Wish;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use App\Models\Country;
use App\Models\City;
use Illuminate\Validation\Rules\Password;
use PDF;

class CustomerProfileController extends Controller
{
    function customer_profile(){
        $customer_info = CustomerLogin::find(Auth::guard('customerlogin')->id());
        $countries = Country::all();
        return view('frontend.customer_profile',[
            'customer_info'=>$customer_info,
            'countries'=>$countries,
        ]);
    }

    function customer_profile_udpate(Request $request){
        $request->validate([
            'name' => ['required','min:3','regex:/^[a-zA-Z\s]*$/'],
            'email' => 'required|email:rfc',
            'mobile' => 'required|numeric',
            'address' =>['required','max:100'],
            'country_id' =>'required',
            'city_id' =>'required',
            'profile_image' => 'mimes:jpg,jpeg,png,gif,webp|max:512',
        ]);
        $customer_info = CustomerLogin::find(Auth::guard('customerlogin')->id());

        if(CustomerLogin::where('id', Auth::guard('customerlogin')->id())->where('email', $request->email)->exists()){
            
            if($request->old_password != '' || $request->password != '' || $request->password_confirmation != ''){
                $request->validate([
                    'old_password' => 'required',
                    'password'=>['required',Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
                    'password_confirmation' => 'required',
                ]);

                if(Hash::check($request->old_password, $customer_info->password)){

                    if($request->password_confirmation == $request->password){

                        if($request->profile_image != ''){
                            $profile_image = $request->profile_image;
                            $profile_image_extension = $profile_image->getClientOriginalExtension();
                            $profile_image_name = 'customer-'.Auth::guard('customerlogin')->id().'.'.$profile_image_extension;
                            Image::make($profile_image)->resize(300, 280)->save(public_path('uploads/customer/'.$profile_image_name));

                            CustomerLogin::find(Auth::guard('customerlogin')->id())->update([
                                'name'=>Str::title($request->name),
                                'email'=>$request->email,
                                'mobile'=>$request->mobile,
                                'password'=>bcrypt($request->password),
                                'country_id'=>$request->country_id,
                                'city_id'=>$request->city_id,
                                'address'=>$request->address,
                                'profile_image'=>$profile_image_name,
                            ]);
                            return back()->with('customer_profile_update','Customer Profile Updated Successfully!');
                        }
                        else{
                            CustomerLogin::find(Auth::guard('customerlogin')->id())->update([
                                'name'=>Str::title($request->name),
                                'email'=>$request->email,
                                'mobile'=>$request->mobile,
                                'password'=>bcrypt($request->password),
                                'country_id'=>$request->country_id,
                                'city_id'=>$request->city_id,
                                'address'=>$request->address,
                            ]);
                            return back()->with('customer_profile_update','Customer Profile Updated Successfully!');
                        }
                    }
                    else{
                         return back()->with('password_not_match','Confirm Password not Match!');
                    }
                }
                else{
                    return back()->with('wrong_old_password','Wrong Email Address Or Old Password!');
                }
            }
            else{
                if($request->profile_image != ''){
                    $profile_image = $request->profile_image;
                    $profile_image_extension = $profile_image->getClientOriginalExtension();
                    $profile_image_name = 'customer-'.Auth::guard('customerlogin')->id().'.'.$profile_image_extension;
                    Image::make($profile_image)->resize(300, 280)->save(public_path('uploads/customer/'.$profile_image_name));

                    CustomerLogin::find(Auth::guard('customerlogin')->id())->update([
                        'name'=>Str::title($request->name),
                        'email'=>$request->email,
                        'mobile'=>$request->mobile,
                        'country_id'=>$request->country_id,
                        'city_id'=>$request->city_id,
                        'address'=>$request->address,
                        'profile_image'=>$profile_image_name,
                    ]);
                    return back()->with('customer_profile_update','Customer Profile Updated Successfully!');
                }
                else{
                    CustomerLogin::find(Auth::guard('customerlogin')->id())->update([
                        'name'=>Str::title($request->name),
                        'email'=>$request->email,
                        'mobile'=>$request->mobile,
                        'country_id'=>$request->country_id,
                        'city_id'=>$request->city_id,
                        'address'=>$request->address,
                    ]);
                    return back()->with('customer_profile_update','Customer Profile Updated Successfully!');
                }               
            }
        }
        else{
            if(CustomerLogin::where('email', $request->email)->exists()){
                return back()->with('duplicate_email','This Email Address is Already Registered!');
            }
            else{

                if($request->old_password != '' || $request->password != '' || $request->password_confirmation != ''){
                    $request->validate([
                        'old_password' => 'required',
                        'password'=>['required',Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
                        'password_confirmation' => 'required',
                    ]);

                    if(Hash::check($request->old_password, $customer_info->password)){

                        if($request->password_confirmation == $request->password){

                            if($request->profile_image != ''){
                                $profile_image = $request->profile_image;
                                $profile_image_extension = $profile_image->getClientOriginalExtension();
                                $profile_image_name = 'customer-'.Auth::guard('customerlogin')->id().'.'.$profile_image_extension;
                                Image::make($profile_image)->resize(300, 280)->save(public_path('uploads/customer/'.$profile_image_name));

                                CustomerLogin::find(Auth::guard('customerlogin')->id())->update([
                                    'name'=>Str::title($request->name),
                                    'email'=>$request->email,
                                    'mobile'=>$request->mobile,
                                    'password'=>bcrypt($request->password),
                                    'country_id'=>$request->country_id,
                                    'city_id'=>$request->city_id,
                                    'address'=>$request->address,
                                    'profile_image'=>$profile_image_name,
                                ]);
                                return back()->with('customer_profile_update','Customer Profile Updated Successfully!');
                            }
                            else{
                                CustomerLogin::find(Auth::guard('customerlogin')->id())->update([
                                    'name'=>Str::title($request->name),
                                    'email'=>$request->email,
                                    'mobile'=>$request->mobile,
                                    'password'=>bcrypt($request->password),
                                    'country_id'=>$request->country_id,
                                    'city_id'=>$request->city_id,
                                    'address'=>$request->address,
                                ]);
                                return back()->with('customer_profile_update','Customer Profile Updated Successfully!');
                            }
                            
                        }
                        else{
                            return back()->with('password_not_match','Confirm Password not Match!');
                        }
                    }
                    else{
                        return back()->with('wrong_old_password','Wrong Email Address Or Old Password!');
                    }
                }
                else{
                    if($request->profile_image != ''){
                        $profile_image = $request->profile_image;
                        $profile_image_extension = $profile_image->getClientOriginalExtension();
                        $profile_image_name = 'customer-'.Auth::guard('customerlogin')->id().'.'.$profile_image_extension;
                        Image::make($profile_image)->resize(300, 280)->save(public_path('uploads/customer/'.$profile_image_name));

                        CustomerLogin::find(Auth::guard('customerlogin')->id())->update([
                            'name'=>Str::title($request->name),
                            'email'=>$request->email,
                            'mobile'=>$request->mobile,
                            'country_id'=>$request->country_id,
                            'city_id'=>$request->city_id,
                            'address'=>$request->address,
                            'profile_image'=>$profile_image_name,
                        ]);
                        return back()->with('customer_profile_update','Customer Profile Updated Successfully!');
                    }
                    else{
                        CustomerLogin::find(Auth::guard('customerlogin')->id())->update([
                            'name'=>Str::title($request->name),
                            'email'=>$request->email,
                            'mobile'=>$request->mobile,
                            'country_id'=>$request->country_id,
                            'city_id'=>$request->city_id,
                            'address'=>$request->address,
                        ]);
                        return back()->with('customer_profile_update','Customer Profile Updated Successfully!');
                    }
                } 
            }
        }
    }

    function customer_order_complete(){
        return view('frontend.order_complete');
    }


    function customer_order_failed(){
        return view('frontend.order_failed');
    }


    function customer_order(){
        $customer_info = CustomerLogin::find(Auth::guard('customerlogin')->id());
        return view('frontend.customer_order',[
            'customer_info'=>$customer_info,
        ]);
    }


    function customer_wish(){
        $customer_info = CustomerLogin::find(Auth::guard('customerlogin')->id());
        $wishes = Wish::where('customer_id', Auth::guard('customerlogin')->id())->get();
        return view('frontend.customer_wish',[
            'customer_info'=>$customer_info,
            'wishes'=>$wishes,
        ]);
    }

    function Download_invoice($order_id){
        $order_id = '#'.$order_id;
        $customer_id= Order::where('order_id', $order_id)->first()->customer_id;

        $pdf = PDF::loadView('invoice.invoice_download', [
            'order_id'=>$order_id,
            'customer_id'=>$customer_id,
        ]);
        return $pdf->download('invoice.pdf');
        
        // for preview only (not download) the invoice -----------
        // return $pdf->stream('invoice.pdf');
    }

}
