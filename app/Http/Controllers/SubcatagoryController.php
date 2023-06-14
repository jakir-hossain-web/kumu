<?php

namespace App\Http\Controllers;

use App\Models\Catagory;
use App\Models\Subcatagory;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SubcatagoryController extends Controller
{
    function subcatagory(){
        $catagories = Catagory::all();
        $subcatagories = Subcatagory::all();
        $trashed = Subcatagory::onlyTrashed()->get();
        return view('admin.subcatagory.subcatagory',[
            'catagories'=>$catagories,
            'subcatagories'=>$subcatagories,
            'trashed'=>$trashed,
        ]);
    }
    
    function subcatagory_store(Request $request){
        $request->validate([
            'catagory_id' => ['required'],
            'subcatagory_name' => ['required'],
        ], [
            'catagory_id.required' => 'Catagory is not selected',
            'subcatagory_name.required' => 'Subcatagory Name Field is Empty!',
        ]);

        if(Subcatagory::where('catagory_id', $request->catagory_id)->where('subcatagory_name', $request->subcatagory_name)->exists()){
            return back()->with('subcatagory_duplicate','This Subcatagory Name is Already Taken!');
        }
        else{
            Subcatagory::insert([
                'catagory_id'=> $request->catagory_id,
                'subcatagory_name'=> $request->subcatagory_name,
                'created_at'=> Carbon::now(),
            ]);
            return back()->with('subcatagory_add_seccess','Subcatagory Added Successfully!');
        }

    }

    function subcatagory_delete($subcatagory_id){
        Subcatagory::find($subcatagory_id)->delete();
        return back()->with('subcatagory_move_to_trash','Subcatagory Move to Trash List!');
    }

    function subcatagory_restore($subcatagory_id){
        Subcatagory::onlyTrashed()->find($subcatagory_id)->restore();
        return back()->with('subcatagory_restore_seccess','Subcatagory Restore Successfully!');
    }

    function subcatagory_force_delete($subcatagory_id){
        Subcatagory::onlyTrashed()->find($subcatagory_id)->forceDelete();
        return back()->with('subcatagory_force_deleted_seccess','Subcatagory Deleted Permanently!');
    }

    // ========= delete all subcatagory =================
    function subcatagory_delete_all(Request $request){
        foreach($request->subcatagory_id as $subcatagory_id){
            Subcatagory::find($subcatagory_id)->delete();
        }
        return back()->with('subcatagory_move_to_trash','Subcatagory Move to Trash List!');
    }

    // ========= restore & permanently delete all trashed subcatagory =================
    function subcatagory_restore_delete_all_trashed(Request $request){
        // restore all ==========
        if($request->check_subcatagory_trashed_val == 1){
            foreach($request->subcatagory_id as $subcatagory_id){
                Subcatagory::onlyTrashed()->find($subcatagory_id)->restore();
            }
            return back()->with('subcatagory_restore_seccess','Subcatagory Restore Successfully!');
        }

        // permanent delete all ============
        if($request->check_subcatagory_trashed_val == 2){             
            foreach($request->subcatagory_id as $subcatagory_id){
                Subcatagory::onlyTrashed()->find($subcatagory_id)->forceDelete();
            }
            return back()->with('subcatagory_force_deleted_seccess','Subcatagory Deleted Permanently!');
        }       
    }

    function subcatagory_edit($subcatagory_id){
        $catagories = Catagory::all();
        $subcatagory_info = Subcatagory::find($subcatagory_id);
        return view('admin.subcatagory.edit',[
            'catagories'=> $catagories,
            'subcatagory_info'=> $subcatagory_info,
        ]);
    }

    function subcatagory_update(Request $request){
        $request->validate([
            'catagory_id' => ['required'],
            'subcatagory_name' => ['required'],
        ], [
            'catagory_id.required' => 'Catagory is not selected',
            'subcatagory_name.required' => 'Subcatagory Name Field is Empty!',
        ]);

        if(Subcatagory::where('catagory_id', $request->catagory_id)->where('id', $request->subcatagory_id)->where('subcatagory_name', $request->subcatagory_name)->exists()){
            Subcatagory::find($request->subcatagory_id)->update([
                'catagory_id'=>$request->catagory_id,
                'subcatagory_name'=>$request->subcatagory_name,
            ]);
            return back()->with('subcatagory_update_seccess','Subcatagory Updated Successfully!');
        }
        else{
            if(Subcatagory::where('catagory_id', $request->catagory_id)->where('subcatagory_name', $request->subcatagory_name)->exists()){
                return back()->with('subcatagory_duplicate','This Subcatagory Name is Already Taken!');
            }
            else{
                Subcatagory::find($request->subcatagory_id)->update([
                    'catagory_id'=>$request->catagory_id,
                    'subcatagory_name'=>$request->subcatagory_name,
                ]);
                return back()->with('subcatagory_update_seccess','Subcatagory Updated Successfully!');
            }
        }
    }
    
}
