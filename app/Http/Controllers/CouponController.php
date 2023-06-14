<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    //
    function coupon(){
        $coupons = Coupon::all();
        return view('admin.coupon.coupon',[
            'coupons'=> $coupons,
        ]);
    }

    function coupon_trashed(){
        $coupons = Coupon::onlyTrashed()->get();
        return view('admin.coupon.coupon_trashed',[
            'coupons'=> $coupons,
        ]);
    }

    function coupon_add(){
        return view('admin.coupon.coupon_add');
    }

    function coupon_store(Request $request){
        $request->validate([
            'coupon_name'=>['required','unique:coupons'],
            'coupon_type'=>'required',
            'coupon_amount' =>'required|numeric|gt:0',
            'min_purchase' =>'nullable|numeric|gte:0',
            'min_amount' =>'nullable|numeric|gte:0',
            'max_amount' =>'nullable|numeric|gte:0',
            'validity' =>'required|after:yesterday',
        ],[
            'validity.after'=>'Coupon validity never be past dated!',
        ]);
        Coupon::insert([
            'coupon_name'=>$request->coupon_name,
            'coupon_type'=>$request->coupon_type,
            'coupon_amount'=>$request->coupon_amount,
            'min_purchase'=>$request->min_purchase,
            'min_amount'=>$request->min_amount,
            'max_amount'=>$request->max_amount,
            'validity'=>$request->validity,
            'added_by' => Auth::id(),
            'created_at' => Carbon::now(),
        ]);
        return back()->with('coupon_add','Coupon Added Successfully!');
    }

    function coupon_delete($coupon_id){
        Coupon::find($coupon_id)->delete();
        return back()->with('coupon_delete','Coupon Deleted Successfully!');
    }

    function coupon_edit($coupon_id){
        $coupons = Coupon::find($coupon_id);
        return view('admin.coupon.coupon_update',[
            'coupons'=>$coupons,
        ]);
    }
    
    function coupon_restore($coupon_id){
        Coupon::onlyTrashed()->find($coupon_id)->restore();
        return back()->with('coupon_restore','Coupon Restored Successfully!');
    }

    function coupon_force_delete($coupon_id){
        Coupon::onlyTrashed()->find($coupon_id)->forceDelete();
        return back()->with('coupon_force_delete','Coupon Permanently Deleted Successfully!');
    }

    function coupon_update(Request $request){
        $request->validate([
            'coupon_name'=>'required',
            'coupon_amount' =>'required|numeric|gt:0',
            'min_purchase' =>'nullable|numeric|gte:0',
            'min_amount' =>'nullable|numeric|gte:0',
            'max_amount' =>'nullable|numeric|gte:0',
            'validity' =>'required|after:yesterday',
        ],[
            'validity.after'=>'Coupon validity never be past dated!',
        ]);

        If(Coupon::where('id', $request->coupon_id)->where('coupon_name', $request->coupon_name)->exists()){
            Coupon::find($request->coupon_id)->update([
                'coupon_name'=>$request->coupon_name,
                'coupon_type'=>$request->coupon_type,
                'coupon_amount'=>$request->coupon_amount,
                'min_purchase'=>$request->min_purchase,
                'min_amount'=>$request->min_amount,
                'max_amount'=>$request->max_amount,
                'validity'=>$request->validity,
                'added_by' => Auth::id(),
            ]);
            return back()->with('coupon_update','Coupon Updated Successfully!');
        }
        else{
            if(Coupon::where('coupon_name', $request->coupon_name)->exists()){
                return back()->with('coupon_update_duplicate','This Coupon Name is Already Taken!');
            }
            else{
                Coupon::find($request->coupon_id)->update([
                    'coupon_name'=>$request->coupon_name,
                    'coupon_type'=>$request->coupon_type,
                    'coupon_amount'=>$request->coupon_amount,
                    'min_purchase'=>$request->min_purchase,
                    'max_amount'=>$request->max_amount,
                    'validity'=>$request->validity,
                    'added_by' => Auth::id(),
                ]);
                return back()->with('coupon_update','Coupon Updated Successfully!');
            }
        }
    }


    // ========= delete all coupon =================
    function coupon_delete_all(Request $request){
        foreach($request->coupon_id as $coupon_id){
            Coupon::find($coupon_id)->delete();
        }
        return back()->with('coupon_delete','Coupon Deleted Successfully!');
    }


    // ========= restore & permanently delete all trashed coupon =================
    function coupon_restore_delete_all_trashed(Request $request){
        // restore all ==========
        if($request->check_coupon_trashed_val == 1){
            foreach($request->coupon_id as $coupon_id){
                Coupon::onlyTrashed()->find($coupon_id)->restore();
            }
            return back()->with('coupon_restore','Coupon Restored Successfully!');
        }

        // permanent delete all ============
        if($request->check_coupon_trashed_val == 2){             
            foreach($request->coupon_id as $coupon_id){
                Coupon::onlyTrashed()->find($coupon_id)->forceDelete();
            }
            return back()->with('coupon_force_delete','Coupon Permanently Deleted Successfully!');
        }       
    }


}
