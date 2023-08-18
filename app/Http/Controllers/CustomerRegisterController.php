<?php

namespace App\Http\Controllers;

use App\Models\CustomerLogin;
use App\Models\EmailVerify;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Notifications\CustomerEmailVerificationNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules\Password;


class CustomerRegisterController extends Controller
{
    //
    function customer_register(Request $request){

        $request->validate([
            'name'=>['required','min:3','regex:/^[a-zA-Z\s]*$/'],
            'email' => 'required|email:rfc',
            'password'=>['required',Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'password_confirmation'=>'required',
        ],[
            'name.required'=>'Name Field is Empty!',
            'name.min'=>'Minimum 3 Character Required!',
            'name.regex'=>'Alphabetic  Character Only!',
            'email.required'=>'Email Field is Empty!',
            'password.required'=>'Password Field is Empty!',
            'password_confirmation.required'=>'Confirm Password Field is Empty!',
        ]);

        if($request->password_confirmation == $request->password){
            If(CustomerLogin::where('email', $request->email)->exists()){
                return back()->with('customer_register_duplicate', 'This Email Address is Already Registered!');
            }
            else{
                $customer_info = CustomerLogin::create([
                    'name'=> $request->name,
                    'email'=> $request->email,
                    'password'=> bcrypt($request->password),
                    'created_at'=> Carbon::now(),
                ]);

                $email_verify_info = EmailVerify::create([
                    'customer_id'=>$customer_info->id,
                    'token'=>uniqid(),
                    'created_at'=>Carbon::now(),
                ]);

                Notification::send($customer_info, new CustomerEmailVerificationNotification($email_verify_info));

                // if(Auth::guard('customerlogin')->attempt(['email'=> $request->email, 'password'=> $request->password,])){
                //     return redirect('/'); 
                // }

                return back()->with('customer_register_success', 'Your registration is successfull. Please check your email and complete the verification process!');
            }
        }
        else{
            return back()->with('confirm_password_not_match', 'Confirm Password Not Matched!');
        }

        
  
    }

    // function customer_email_verify($token){
    //     $customer_info = EmailVerify::where('token', $token)->firstOrFail();
    //     CustomerLogin::find($customer_info->customer_id)->update([
    //         'email_verify_at'=>Carbon::now(),
    //     ]);
    //     EmailVerify::where('token', $token)->delete();

    //     return back()->with('customer_email_verify_success', 'Your email verification process is successfully completed! Please Login');
    // }

    function customer_email_verify($token){
        try {
            $customer_info = EmailVerify::where('token', $token)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return back()->with('email_verify_link_not_found', 'Email verify link is invalid or expired. Please try again to Register!');
        }

        CustomerLogin::find($customer_info->customer_id)->update([
            'email_verify_at'=>Carbon::now(),
        ]);
        EmailVerify::where('token', $token)->delete();

        return back()->with('customer_email_verify_success', 'Your email verification process is successfully completed! Please Login');
    }

}
