<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\PassReset;
use App\Models\CustomerLogin;
use App\Notifications\CustomerPasswordResetNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules\Password;
use Laravel\Socialite\Facades\Socialite;

class CustomerLoginController extends Controller
{
    //
    function customer_login(Request $request){
        if(Auth::guard('customerlogin')->attempt(['email'=> $request->email, 'password'=> $request->password,])){
            if(Auth::guard('customerlogin')->user()->email_verify_at != null){
                return redirect('/'); 
            }
            else{
                Auth::guard('customerlogin')->logout();
                return redirect()->route('customer.login.register')->with('email_not_verified', 'Please verify your email address first to login (Check your email).');
            }
        }
        else{
            return back()->with('customer_error_login', 'Wrong Email Address Or Password');
        }
    }

    function customer_logout(){
        Auth::guard('customerlogin')->logout();
        return redirect()->route('customer.login.register');
    }

    function customer_password_reset(){
        return view('frontend.customer_password_reset');
    }


    // ============== return back to the same page with error message if email not found/match =============
    function customer_password_reset_request(Request $request){
        try {
            $customer_info = CustomerLogin::where('email', $request->email)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return back()->with('mail_not_found', 'Customer not found with email: ' . $request->email);
        }
        
        PassReset::where('customer_id', $customer_info->id)->delete();

        $pass_reset_info = PassReset::create([
            'customer_id'=>$customer_info->id,
            'token'=>uniqid(),
            'created_at'=>Carbon::now(),
        ]);
        Notification::send($customer_info, new CustomerPasswordResetNotification($pass_reset_info));

        return back()->with('pass_reset_req','Request send successfully. Please check your email to reset your password!');
    }

    

    function customer_password_reset_form($token){
        return view('frontend.customer_pass_reset_form',[
            'token' => $token,
        ]);
    }


    // ===== return back to the same page with error message if token is invalid or expired or not found/match =====
    function customer_password_reset_confirm(Request $request){
        try {
            $customer_info = PassReset::where('token', $request->token)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return back()->with('password_reset_link_not_found', 'Password reset link is invalid or expired. Please try again to');
        }

        $request->validate([
            'password'=>['required',Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'password_confirmation'=>'required',
        ],[
            'password.required'=>'Password Field is Empty!',
            'password_confirmation.required'=>'Confirm Password Field is Empty!',
        ]);

        if($request->password_confirmation == $request->password){
            CustomerLogin::find($customer_info->customer_id)->update([
                'password'=>bcrypt($request->password),
            ]);

            PassReset::where('customer_id', $customer_info->customer_id)->delete();
            return redirect()->route('customer.login.register')->with('pass_reset_success','Password Reset Successfully. Please Login!');
        }
        else{
            return back()->with('confirm_password_not_match', 'Confirm Password Not Matched!');
        }
        
    }


    // =================== github login =======================
    function redirectToGithub(){
        return Socialite::driver('github')->redirect();
    }

    function handleGithubCallback(){
        $user = Socialite::driver('github')->user();
        $finduser = CustomerLogin::where('email', $user->email)->first();

        $user_name = $user->name;
        $random_string = substr($user_name,0,2);
        $random_integer = random_int(10000, 99999);
        $generate_password = $random_string.$random_integer.'@';

        if($finduser){
            Auth::guard('customerlogin')->login($finduser);
            if(Auth::guard('customerlogin')->user()->email_verify_at != null){                
                return redirect('/');
            }
            else{
                CustomerLogin::where('email', $user->email)->update([
                    'email_verify_at'=> Carbon::now(),
                ]);
                return redirect('/');
            }
        }
        else{
            $newUser = CustomerLogin::updateOrCreate([
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => bcrypt($generate_password),
                    'email_verify_at'=> Carbon::now(),
                ]);

            Auth::guard('customerlogin')->login($newUser);
            return redirect('/')->with('github_login_register_success', 'Registration Successful!');
        }
    }
    

    // =================== google login =======================
    function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    function handleGoogleCallback(){
        $user = Socialite::driver('google')->user();
        $finduser = CustomerLogin::where('email', $user->email)->first();

        $user_name = $user->name;
        $random_string = substr($user_name,0,2);
        $random_integer = random_int(10000, 99999);
        $generate_password = $random_string.$random_integer.'@';

        if($finduser){
            Auth::guard('customerlogin')->login($finduser);
            if(Auth::guard('customerlogin')->user()->email_verify_at != null){                
                return redirect('/');
            }
            else{
                CustomerLogin::where('email', $user->email)->update([
                    'email_verify_at'=> Carbon::now(),
                ]);
                return redirect('/');
            }
        }
        else{
            $newUser = CustomerLogin::updateOrCreate([
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => bcrypt($generate_password),
                    'email_verify_at'=> Carbon::now(),
                ]);

            Auth::guard('customerlogin')->login($newUser);
            return redirect('/')->with('gmail_login_register_success', 'Registration Successful!');
        }
    }

}
