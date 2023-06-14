<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Charge;
use Carbon\Carbon;

class ChargeController extends Controller
{
    //
    
    function charge(){
        $charges = Charge::all();
        $trashed_charges = Charge::onlyTrashed()->get();
        return view('admin.charge.charge',[
            'charges'=>$charges,
            'trashed_charges'=>$trashed_charges,
        ]);
    }

    function charge_store(Request $request){
         $request->validate([
            'delivery_type'=>['required','unique:charges'],
            'delivery_charge' =>'required|numeric',
        ]);
        Charge::insert([
            'delivery_type'=>$request->delivery_type,
            'delivery_charge'=>$request->delivery_charge,
            'created_at' => Carbon::now(),
        ]);
        return back()->with('charge_add','Delivery Charge Added Successfully!');
    }

    function charge_delete($delivery_charge_id){
        Charge::find($delivery_charge_id)->delete();
        return back()->with('charge_delete','Delivery Charge Deleted Successfully!');
    }

    function charge_restore($delivery_charge_id){
        Charge::onlyTrashed()->find($delivery_charge_id)->restore();
        return back()->with('charge_restore','Delivery Charge Restored Successfully!');
    }

    function charge_force_delete($delivery_charge_id){
        Charge::onlyTrashed()->find($delivery_charge_id)->forceDelete();
        return back()->with('charge_force_delete','Delivery Charge Permanently Deleted!');
    }

    function charge_edit($delivery_charge_id){
        $charges = Charge::find($delivery_charge_id);
        return view('admin.charge.charge_update',[
            'charges'=>$charges,
        ]);
    }

    function charge_update(Request $request){
        $request->validate([
            'delivery_type'=>'required',
            'delivery_charge' =>'required|numeric',
        ]);

        If(Charge::where('id', $request->charge_id)->where('delivery_type', $request->delivery_type)->exists()){
            Charge::find($request->charge_id)->update([
                'delivery_type'=>$request->delivery_type,
                'delivery_charge'=>$request->delivery_charge,
            ]);
            return back()->with('charge_update','Delivery Charge Updated Successfully!');
        }
        else{
            if(Charge::where('delivery_type', $request->delivery_type)->exists()){
                return back()->with('charge_update_duplicate','This Delivery Charge Type is Already Taken!');
            }
            else{
                Charge::find($request->charge_id)->update([
                    'delivery_type'=>$request->delivery_type,
                    'delivery_charge'=>$request->delivery_charge,
                ]);
                return back()->with('charge_update','Delivery Charge Updated Successfully!');
            }
        }
    }
}
