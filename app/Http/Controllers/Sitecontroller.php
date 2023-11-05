<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Sitecontroller extends Controller
{
    // site controller =============
    function add_site_info(){
        return view('admin.site_info.add_site_info');
    }
    function edit_site_info(){
        return view('admin.site_info.edit_site_info');
    }

    function change_site_info(Request $request){
        $request->validate([
            'site_name'=>'required|min:3',
            'site_address'=>'required',
            'site_email' => 'required|email:rfc',
            'contact_number' => 'required|numeric',
            'Site_logo' => 'mimes:jpg,jpeg,png,gif,webp|max:512',
        ],[
            'site_name.required'=>'Site Name Field is Empty!',
            'site_name.min'=>'Minimum 3 Character Required!',
            'site_address.required'=>'Site Address Field is Empty!',
            'site_email.required'=>'Site Email Field is Empty!',
            'contact_number.required'=>'Contact Field is Empty!',
            'contact_number.numeric'=>'Numaric Character Only!',
        ]);
        SiteInfo::update([
            'site_name'=>$request->site_name,
            'site_address'=>$request->site_address,
            'site_email'=>$request->site_email,
            'contact_number'=>$request->contact_number,
            'Site_logo'=>$request->Site_logo,
            'added_by' => Auth::id(),
            'created_at' => Carbon::now(),
        ]);
        return back()->with('site_info_change_success','Site Info Changed Successfully!');
    }
}
