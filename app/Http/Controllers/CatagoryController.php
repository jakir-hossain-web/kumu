<?php

namespace App\Http\Controllers;

use App\Models\catagory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Console\View\Components\Alert;

class CatagoryController extends Controller
{
    function catagory(){
        $catagories = Catagory::all();
        $trashed = Catagory::onlyTrashed()->get();
        return view('admin.catagory.catagory', [
            'catagories'=>$catagories,
            'trashed'=>$trashed,
        ]);
    }
    function catagory_store(Request $request){
        $request->validate([
            'catagory_name'=>['required','unique:catagories'],
            'catagory_image'=>['required','mimes:jpg,jpeg,png,gif,webp','max:512'],
        ],[
            'catagory_name.required'=>'Catagory Name Field is Empty!',
            'catagory_image.required'=>'Catagory Image Field is Empty!',
            'catagory_image.mimes'=>'Image file type must be a: jpg, jpeg, png, gif or webp.!',
            'catagory_image.max'=>'Image size will be maximum 512 kb!'
        ]);

        $catagory_id = Catagory::insertGetId([
            'catagory_name'=>$request->catagory_name,
            'added_by'=>Auth::id(),
        ]);

        $uploaded_file = $request->catagory_image;
        $extension = $uploaded_file->getClientOriginalExtension();
        $file_name = Str::lower(str_replace(' ','-',$request->catagory_name)).'-'.rand(100000, 999999).'.'.$extension;
        
        Image::make($uploaded_file)->resize(300, 200)->save(public_path('uploads/catagory/'.$file_name));
        

        Catagory::find($catagory_id)->update([
            'catagory_image'=>$file_name,
        ]);
        return back()->with('catagory_add_seccess','Catagory Added Successfully!');
    }

    function catagory_delete($catagory_id){
        Catagory::find($catagory_id)->delete();
        return back()->with('catagory_move_to_trash','Catagory Move to Trash List!');
    }

    // ========= delete all catagory =================
    function catagory_delete_all(Request $request){
        foreach($request->catagory_id as $catagory_id){
            Catagory::find($catagory_id)->delete();
        }
        return back()->with('catagory_move_to_trash','Catagory Move to Trash List!');
    }

    // ========= restore & permanently delete all trashed catagory =================
    function catagory_restore_delete_all_trashed(Request $request){
        // restore all ==========
        if($request->check_catagory_trashed_val == 1){
            foreach($request->catagory_id as $catagory_id){
                Catagory::onlyTrashed()->find($catagory_id)->restore();
            }
            return back()->with('catagory_restore_seccess','Catagory Restored Successfully!');
        }

        // permanent delete all ============
        if($request->check_catagory_trashed_val == 2){             
            foreach($request->catagory_id as $catagory_id){
                $delete_image_name = Catagory::onlyTrashed()->find($catagory_id)->catagory_image;
                $delete_image_from = public_path('uploads/catagory/'.$delete_image_name);
                unlink($delete_image_from);
                Catagory::onlyTrashed()->find($catagory_id)->forceDelete();
            }
            return back()->with('catagory_force_deleted_seccess','Catagory Deleted Permanently!');
        }       
    }


    function catagory_restore($catagory_id){
        Catagory::onlyTrashed()->find($catagory_id)->restore();
        return back()->with('catagory_restore_seccess','Catagory Restored Successfully!');
    }

    function catagory_force_delete($catagory_id){
        $delete_image_name = Catagory::onlyTrashed()->find($catagory_id)->catagory_image;
        $delete_image_from = public_path('uploads/catagory/'.$delete_image_name);
        unlink($delete_image_from);
        Catagory::onlyTrashed()->find($catagory_id)->forceDelete();
        return back()->with('catagory_force_deleted_seccess','Catagory Deleted Permanently!');
    }

    function catagory_edit($catagory_id){
        $catagory = Catagory::find($catagory_id);
        return view('admin.catagory.edit', [

            'catagory' => $catagory,
        ]);
    }

    function catagory_update(Request $request){
        $request->validate([
            'catagory_name'=>['required'],
            'catagory_image'=>['mimes:jpg,jpeg,png,gif,webp','max:512'],
        ],[
            'catagory_name.required'=>'Catagory Name Field is Empty!',
            'catagory_image.mimes'=>'Image file type must be a: jpg, jpeg, png, gif or webp.!',
            'catagory_image.max'=>'Image size will be maximum 512 kb!'
        ]);

        if(Catagory::where('id', $request->catagory_id)->where('catagory_name', $request->catagory_name)->exists()){
            if($request->catagory_image == ''){
                Catagory::find($request->catagory_id)->update([
                    'catagory_name'=>$request->catagory_name,
                    'added_by'=>Auth::id(),
                ]);
                return back()->with('catagory_update_seccess','Catagory Updated Successfully!');
            }
            else{
                $delete_image_name = Catagory::find($request->catagory_id)->catagory_image;
                $delete_image_from = public_path('uploads/catagory/'.$delete_image_name);
                unlink($delete_image_from);

                $uploaded_file = $request->catagory_image;
                $extension = $uploaded_file->getClientOriginalExtension();
                $file_name = Str::lower(str_replace(' ','-',$request->catagory_name)).'-'.rand(100000, 999999).'.'.$extension;

                Image::make($uploaded_file)->resize(300, 200)->save(public_path('uploads/catagory/'.$file_name));

                Catagory::find($request->catagory_id)->update([
                    'catagory_name'=>$request->catagory_name,
                    'catagory_image'=>$file_name,
                    'added_by'=>Auth::id(),
                ]);
                return back()->with('catagory_update_seccess','Catagory Updated Successfully!');
            }
        }

        else{
            if(Catagory::where('catagory_name', $request->catagory_name)->exists()){
                return back()->with('catagory_update_duplicate','This Catagory Name is Already Taken!');
            }
            else{
                if($request->catagory_image == ''){
                    Catagory::find($request->catagory_id)->update([
                        'catagory_name'=>$request->catagory_name,
                        'added_by'=>Auth::id(),
                    ]);
                    return back()->with('catagory_update_seccess','Catagory Updated Successfully!');
                }
                else{
                    $delete_image_name = Catagory::find($request->catagory_id)->catagory_image;
                    $delete_image_from = public_path('uploads/catagory/'.$delete_image_name);
                    unlink($delete_image_from);
        
                    $uploaded_file = $request->catagory_image;
                    $extension = $uploaded_file->getClientOriginalExtension();
                    $file_name = Str::lower(str_replace(' ','-',$request->catagory_name)).'-'.rand(100000, 999999).'.'.$extension;
                    
                    Image::make($uploaded_file)->resize(300, 200)->save(public_path('uploads/catagory/'.$file_name));
        
                    Catagory::find($request->catagory_id)->update([
                        'catagory_name'=>$request->catagory_name,
                        'catagory_image'=>$file_name,
                        'added_by'=>Auth::id(),
                    ]);
                    return back()->with('catagory_update_seccess','Catagory Updated Successfully!');
                }
            }
        }
    }
     
}
