<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Models\SiteInfo;

class Sitecontroller extends Controller
{
    // site controller ==================
    function site_info(){
        $site_count = SiteInfo::count();
        if($site_count == 0){
            return view('admin.site_info.site_info');
        }
        else{
            $site_details = SiteInfo::get()->first();
            return view('admin.site_info.site_info',[
                'site_details'=>$site_details,
            ]);
        }
    }

    // add site info ===========================================================================
    function add_site_info(Request $request){
        $request->validate([
            'site_name'=>'required',
            'site_address'=>'required',
            'site_email' => 'required|email:rfc',
            'contact_number' => 'required|numeric',
            'site_logo' => 'required|mimes:jpg,jpeg,png,gif,webp|max:512',
        ],[
            'site_name.required'=>'Site Name Field is Empty!',
            'site_address.required'=>'Site Address Field is Empty!',
            'site_email.required'=>'Site Email Field is Empty!',
            'contact_number.required'=>'Contact Number Field is Empty!',
            'contact_number.numeric'=>'Numaric Character Only!',
            'site_logo.required'=>'Site logo is not selected!',
            'site_logo.mimes'=>'Logo type must be: jpg, jpeg, png, gif or webp!',
            'site_logo.max'=> 'Logo size will be maximum 512 kb!',
        ]);

        $site_id = SiteInfo::insertGetId([
            'site_name'=>$request->site_name,
            'site_slogan'=>$request->site_slogan,
            'site_address'=>$request->site_address,
            'site_email'=>$request->site_email,
            'contact_number'=>$request->contact_number,
            'created_at' => Carbon::now(),
        ]);

        $site_logo = $request->site_logo;
        $extension = $site_logo->getClientOriginalExtension();
        $file_name = 'site_logo'.'.'.$extension;
        
        Image::make($site_logo)->save(public_path('uploads/site_logo/'.$file_name));

        SiteInfo::find($site_id)->update([
            'site_logo'=>$file_name,
        ]);

        return back()->with('site_info_add_success','Site Info Added Successfully!');
        
    }


    // update site info =====================================================================
    function Update_site_info(Request $request){

        // update site info with logo ======================
        if($request->site_logo!=null){
            $request->validate([
                'site_name'=>'required',
                'site_address'=>'required',
                'site_email' => 'required|email:rfc',
                'contact_number' => 'required|numeric',
                'site_logo' => 'mimes:jpg,jpeg,png,gif,webp|max:512',
            ],[
                'site_name.required'=>'Site Name Field is Empty!',
                'site_address.required'=>'Site Address Field is Empty!',
                'site_email.required'=>'Site Email Field is Empty!',
                'contact_number.required'=>'Contact Number Field is Empty!',
                'contact_number.numeric'=>'Numaric Character Only!',
                'site_logo.mimes'=>'Logo type must be: jpg, jpeg, png, gif or webp!',
                'site_logo.max'=> 'Logo size will be maximum 512 kb!',
            ]);
    
            // site logo delete =============
            $deleted_site_logo_name = SiteInfo::find($request->site_id)->site_logo;
            $deleted_site_logo_path = public_path('uploads/site_logo/'.$deleted_site_logo_name);
            unlink($deleted_site_logo_path);
    
            // site logo update =============
            $site_logo = $request->site_logo;
            $extension = $site_logo->getClientOriginalExtension();
            $file_name = 'site_logo'.'.'.$extension;
            Image::make($site_logo)->save(public_path('uploads/site_logo/'.$file_name));
    
            SiteInfo::find($request->site_id)->update([
                'site_name'=>$request->site_name,
                'site_slogan'=>$request->site_slogan,
                'site_address'=>$request->site_address,
                'site_email'=>$request->site_email,
                'contact_number'=>$request->contact_number,
                'site_logo'=>$file_name,
            ]);
    
            return back()->with('site_info_update_success','Site Info Updated Successfully!'); 
        }

        // update site info without logo ======================
        else{
            $request->validate([
                'site_name'=>'required',
                'site_address'=>'required',
                'site_email' => 'required|email:rfc',
                'contact_number' => 'required|numeric',
            ],[
                'site_name.required'=>'Site Name Field is Empty!',
                'site_address.required'=>'Site Address Field is Empty!',
                'site_email.required'=>'Site Email Field is Empty!',
                'contact_number.required'=>'Contact Number Field is Empty!',
                'contact_number.numeric'=>'Numaric Character Only!',
            ]);
    
            SiteInfo::find($request->site_id)->update([
                'site_name'=>$request->site_name,
                'site_slogan'=>$request->site_slogan,
                'site_address'=>$request->site_address,
                'site_email'=>$request->site_email,
                'contact_number'=>$request->contact_number,
            ]);
    
            return back()->with('site_info_update_success','Site Info Updated Successfully!'); 
        }
    }
}
