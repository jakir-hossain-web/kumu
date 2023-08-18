<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class Usercontroller extends Controller
{
    // ========= view User page =================
    function user(){
        $users = User::all();
        return view('admin.user.user', compact('users'));
    }

    // ========= delete User =================
    function user_delete($user_id){
        User::find($user_id)->delete();
        return back()->with('delete_success',' ');
    }

    // ========= delete selected User =================
    function user_delete_all(Request $request){
        foreach($request->user_id as $user_id){
            User::find($user_id)->delete();
        }
        return back()->with('delete_all_success', 'Selected Users Are Deleted!');
    }

    // ========= view profile page =================
    function profile(){
        return view('admin.user.profile');
    }

    // ========= update profile info =================
    function profile_update(Request $request){
        $request->validate([
            'name'=>['required','min:3','regex:/^[a-zA-Z\s]*$/'],
            'email' => 'required|email:rfc',
        ],[
            'name.required'=>'Name Field is Empty!',
            'name.min'=>'Minimum 3 Character Required!',
            'name.regex'=>'Alphabetic  Character Only!',
            'email.required'=>'Email Field is Empty!',
        ]);
        User::find(Auth::id())->update([
            'name'=>Str::title($request->name),
            'email'=> $request->email,
        ]);
        return back()->with('profile_update_seccess', 'Profile Info Updated Successfully!');
    }

    // ========= change profile password =================
    function password_update(Request $request){
        $request->validate([
            'old_password'=>'required',
            'password'=>['required',Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'password_confirmation'=>'required',
        ],[
            'old_password.required'=> 'Old Password Field is Empty!',
            'password.required'=> 'New Password Field is Empty!',
            'password_confirmation.required'=> 'Confirm Password Field is Empty!',
        ]);
        
        if (Hash::check($request->old_password, Auth::user()->password)) {
            if($request->password_confirmation == $request->password){
                User::find(Auth::id())->update([
                    'password'=>bcrypt($request->password),
                ]);
                return back()->with('password_update_success', 'Password Changed Successfully!');
            }
            else{
                return back()->with('password_not_match', 'Confirm Password Not Macth!');
            }
        }
        else{
            return back()->with('wrong_password', 'Wrong Old Password!');
        }
    }

    // ========= update profile image =================
    function image_update(Request $request){
        $request->validate([
            'image'=>['required','mimes:jpg,jpeg,png,gif,webp','max:512'],
        ]);
        $profile_image = $request->image;
        $profile_image_extension = $profile_image->getClientOriginalExtension();
        $profile_image_name = Auth::id().'.'.$profile_image_extension;
        Image::make($profile_image)->resize(300, 280)->save(public_path('uploads/user/'.$profile_image_name));

        User::find(Auth::id())->update([
            'image'=>$profile_image_name,
        ]);
        return back()->with('image_update_success', 'Profile Image Updated Successfully!');
    }

}
