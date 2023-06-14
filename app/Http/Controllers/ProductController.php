<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Carbon\Carbon;
use App\Models\Size;
use App\Models\Color;
use App\Models\Product;
use App\Models\catagory;
use App\Models\Inventory;
use App\Models\Thumbnail;
use App\Models\Subcatagory;
use App\Models\Wish;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Symfony\Component\Process\Process;

class ProductController extends Controller
{
    function product(){
        $products= Product::all();
        $thumbnails= Thumbnail::all();
        return view('admin.product.product',[
            'products'=>$products,
            'thumbnails'=>$thumbnails,
        ]);
    }

    function product_trashed(){
        $products= Product::all();
        $trashed = Product::onlyTrashed()->get();
        $thumbnails= Thumbnail::all();
        return view('admin.product.product_trashed',[
            'products'=>$products,
            'trashed'=> $trashed,
            'thumbnails'=>$thumbnails,
        ]);
    }

    function product_add(){
        $products = Product::all();
        $catagories = Catagory::all();
        $subcatagories = Subcatagory::all();
        return view('admin.product.product_add', [
            'products' => $products,
            'catagories' => $catagories,
            'subcatagories' => $subcatagories,
        ]);
    }

    function getSubcatagory(Request $request){
        $str = "<option value=''>--Select Subcategory--</option>";
        $subcatagories = Subcatagory::where('catagory_id', $request->catagory_id)->get();
        foreach ($subcatagories as $subcatagory) {
            $str .= "<option value='$subcatagory->id'>$subcatagory->subcatagory_name</option>";
        }
        echo $str;
    } 

    function product_store(Request $request){

        $request->validate([
            'catagory_id' => 'required',
            'subcatagory_id' => 'required',
            'product_name' => ['required','unique:products'],
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric|gte:0|lte:100',
            'key_features' => 'required',
            'description' => 'required',
            'preview' => 'required|mimes:jpg,jpeg,png,gif,webp|max:512',
            'thumbnail' => 'required',
            'thumbnail.*' => 'mimes:jpg,jpeg,png,gif,webp|max:512',
        ],[
            'catagory_id.required' => 'Catagory name is not selected!',
            'subcatagory_id.required' => 'Subcatagory name is not selected!',
            'product_name.required' => 'Product name field is empty!',
            'product_name.unique' => 'This product name is already taken!',
            'price.required' => 'Product price field is empty!',
            'price.numeric' => 'Numeric character only!',
            'discount.numeric' => 'Numeric character only!',
            'discount.gte' => 'Discount must be 0-100!',
            'discount.lte' => 'Discount must be 0-100!',
            'key_features.required' => 'Product key features is not given!',
            'description.required' => 'Product description is not given!',
            'preview.required' => 'Product image is not selected!',
            'preview.mimes'=> 'Image type must be: jpg, jpeg, png, gif or webp.!',
            'preview.max'=> 'Image size will be maximum 512 kb!',
            'thumbnail.required' => 'Thumbnail image is not selected!',
            'thumbnail.*.mimes' => 'Image type must be: jpg, jpeg, png, gif or webp.!',
            'thumbnail.*.max' => 'Image size will be maximum 512 kb!',
        ]);

            $product_id = Product::insertGetId([
                'catagory_id'=>$request->catagory_id,
                'subcatagory_id'=>$request->subcatagory_id,
                'product_name'=>$request->product_name,
                'slug'=>str_replace(' ','-',Str::lower($request->product_name)).'-'.rand(100000,999999),
                'price'=>$request->price,
                'discount'=> $request->discount,
                'after_discount'=>$request->price-($request->price*$request->discount/100),
                'brand'=>$request->brand,
                'key_features'=>$request->key_features,
                'description'=>$request->description,
                'created_at'=>Carbon::now(),
            ]);

            $preview = $request->preview;
            $extension = $preview->getClientOriginalExtension();
            $file_name = Str::lower(str_replace(' ','-',$request->product_name)).'-'.rand(100000, 999999).'.'.$extension;
            
            Image::make($preview)->resize(470, 580)->save(public_path('uploads/product/preview/'.$file_name));

            Product::find($product_id)->update([
                'preview'=>$file_name,
            ]);

            $thumbnail = $request->thumbnail;
            foreach ($thumbnail as $thumb){
                $extension = $thumb->getClientOriginalExtension();
                $file_name = Str::lower(str_replace(' ','-',$request->product_name)).'-'.rand(100000, 999999).'.'.$extension;
                Image::make($thumb)->resize(470, 580)->save(public_path('uploads/product/thumbnails/'.$file_name));

                Thumbnail::insert([
                    'product_id'=>$product_id,
                    'thumbnail'=>$file_name,
                ]);
            }
            return back()->with('product_add_success','Product Added Successfully!');
    }

    function product_variation(){
        $colors = Color::all();
        $sizes = Size::all();
        return view('admin.product.product_variation',[
            'colors'=>$colors,
            'sizes'=>$sizes,
        ]);
    }

    function color_store(Request $request){
        Color::insert([
            'color_name'=>$request->color_name,
            'color_code'=>$request->color_code,
        ]);
        return back();
    }

    function size_store(Request $request){
        Size::insert([
            'size_name'=>$request->size_name,
        ]);
        return back();
    }

    function product_edit($product_id){
        $products = Product::where('id', $product_id)->get();
        $thumbnails = Thumbnail::where('product_id', $product_id)->get();
        $catagories = Catagory::all();
        return view('admin.product.product_edit',[
            'products'=> $products,
            'catagories'=> $catagories,
            'thumbnails'=> $thumbnails,
        ]);
    }

    function product_update(Request $request){

        $request->validate([
            'catagory_id' => 'required',
            'subcatagory_id' => 'required',
            'product_name' => 'required',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric|gte:0|lte:100',
            'key_features' => 'required',
            'description' => 'required',
            'preview' => 'mimes:jpg,jpeg,png,gif,webp|max:512',
            'thumbnail.*' => 'mimes:jpg,jpeg,png,gif,webp|max:512',
        ],[
            'catagory_id.required' => 'Catagory name is not selected!',
            'subcatagory_id.required' => 'Subcatagory name is not selected!',
            'product_name.required' => 'Product name field is empty!',
            'product_name.unique' => 'This product name is already taken!',
            'price.required' => 'Product price field is empty!',
            'price.numeric' => 'Numeric character only!',
            'discount.numeric' => 'Numeric character only!',
            'discount.gte' => 'Discount must be 0-100!',
            'discount.lte' => 'Discount must be 0-100!',
            'key_features.required' => 'Product key features is not given!',
            'description.required' => 'Product description is not given!',
            'preview.mimes'=> 'Image type must be: jpg, jpeg, png, gif or webp.!',
            'preview.max'=> 'Image size will be maximum 512 kb!',
            'thumbnail.*.mimes' => 'Image type must be: jpg, jpeg, png, gif or webp.!',
            'thumbnail.*.max' => 'Image size will be maximum 512 kb!',
        ]);

        
        // when $request->product_id & $request->product_name both exists in product table ===========
        if(Product::where('id', $request->product_id)->where('product_name', $request->product_name)->exists()){

            // when $request->preview is null ===========
            if($request->preview == ''){

                // when $request->preview & $request->thumbnail both are null ===========
                if($request->thumbnail == ''){
                    Product::find($request->product_id)->update([
                        'catagory_id'=>$request->catagory_id,
                        'subcatagory_id'=>$request->subcatagory_id,
                        'product_name'=>$request->product_name,
                        'slug'=>str_replace(' ','-',Str::lower($request->product_name)).'-'.rand(100000,999999),
                        'price'=>$request->price,
                        'discount'=> $request->discount,
                        'after_discount'=>$request->price-($request->price*$request->discount/100),
                        'brand'=>$request->brand,
                        'key_features'=>$request->key_features,
                        'description'=>$request->description,
                    ]);
                     return back()->with('product_update','Product Updated Successfully!');
                }

                // when $request->preview is null but $request->thumbnail is not null ===========
                else{
                    Product::find($request->product_id)->update([
                        'catagory_id'=>$request->catagory_id,
                        'subcatagory_id'=>$request->subcatagory_id,
                        'product_name'=>$request->product_name,
                        'slug'=>str_replace(' ','-',Str::lower($request->product_name)).'-'.rand(100000,999999),
                        'price'=>$request->price,
                        'discount'=> $request->discount,
                        'after_discount'=>$request->price-($request->price*$request->discount/100),
                        'brand'=>$request->brand,
                        'key_features'=>$request->key_features,
                        'description'=>$request->description,
                    ]);

                    // thumbnail image unlink from folder, old image delete & new image insert to database =============
                    $delete_thumbnail_name = Thumbnail::where('product_id', $request->product_id)->get();
                    foreach($delete_thumbnail_name as $del){
                        $delete_thumbnail_from = public_path('uploads/product/thumbnails/'.$del->thumbnail);
                        unlink($delete_thumbnail_from);
                    }
                    Thumbnail::where('product_id', $request->product_id)->delete();

                    $thumbnail = $request->thumbnail;
                    foreach ($thumbnail as $thumb){
                        $extension = $thumb->getClientOriginalExtension();
                        $file_name = Str::lower(str_replace(' ','-',$request->product_name)).'-'.rand(100000, 999999).'.'.$extension;
                        Image::make($thumb)->save(public_path('uploads/product/thumbnails/'.$file_name));

                        Thumbnail::insert([
                            'product_id'=>$request->product_id,
                            'thumbnail'=>$file_name,
                        ]);
                    }
                    return back()->with('product_update','Product Updated Successfully!');
                }
            }

            // when $request->preview is not null ===========
            else{

                // when $request->preview is not null but $request->thumbnail is null ===========
                if($request->thumbnail == ''){
                    // preview image unlink from folder & update to database =============
                    $delete_preview_name = Product::find($request->product_id)->preview;
                    $delete_preview_from = public_path('uploads/product/preview/'.$delete_preview_name);
                    unlink($delete_preview_from);

                    $preview = $request->preview;
                    $extension = $preview->getClientOriginalExtension();
                    $file_name = Str::lower(str_replace(' ','-',$request->product_name)).'-'.rand(100000, 999999).'.'.$extension;
                    Image::make($preview)->save(public_path('uploads/product/preview/'.$file_name));  
                        
                    Product::find($request->product_id)->update([
                        'catagory_id'=>$request->catagory_id,
                        'subcatagory_id'=>$request->subcatagory_id,
                        'product_name'=>$request->product_name,
                        'slug'=>str_replace(' ','-',Str::lower($request->product_name)).'-'.rand(100000,999999),
                        'price'=>$request->price,
                        'discount'=> $request->discount,
                        'after_discount'=>$request->price-($request->price*$request->discount/100),
                        'brand'=>$request->brand,
                        'key_features'=>$request->key_features,
                        'description'=>$request->description,
                        'preview'=>$file_name,               
                    ]);
                    return back()->with('product_update','Product Updated Successfully!');
                }

                // when $request->preview & $request->thumbnail both are not null ===========
                else{

                    // preview image unlink from folder & update to database =============
                    $delete_preview_name = Product::find($request->product_id)->preview;
                    $delete_preview_from = public_path('uploads/product/preview/'.$delete_preview_name);
                    unlink($delete_preview_from);

                    $preview = $request->preview;
                    $extension = $preview->getClientOriginalExtension();
                    $file_name = Str::lower(str_replace(' ','-',$request->product_name)).'-'.rand(100000, 999999).'.'.$extension;
                    Image::make($preview)->save(public_path('uploads/product/preview/'.$file_name));  
                        
                    Product::find($request->product_id)->update([
                        'catagory_id'=>$request->catagory_id,
                        'subcatagory_id'=>$request->subcatagory_id,
                        'product_name'=>$request->product_name,
                        'slug'=>str_replace(' ','-',Str::lower($request->product_name)).'-'.rand(100000,999999),
                        'price'=>$request->price,
                        'discount'=> $request->discount,
                        'after_discount'=>$request->price-($request->price*$request->discount/100),
                        'brand'=>$request->brand,
                        'key_features'=>$request->key_features,
                        'description'=>$request->description,
                        'preview'=>$file_name,               
                    ]);


                    // thumbnail image unlink from folder, old image delete & new image insert to database =============
                    $delete_thumbnail_name = Thumbnail::where('product_id', $request->product_id)->get();
                    foreach($delete_thumbnail_name as $del){
                        $delete_thumbnail_from = public_path('uploads/product/thumbnails/'.$del->thumbnail);
                        unlink($delete_thumbnail_from);
                    }
                    Thumbnail::where('product_id', $request->product_id)->delete();

                    $thumbnail = $request->thumbnail;
                    foreach ($thumbnail as $thumb){
                        $extension = $thumb->getClientOriginalExtension();
                        $file_name = Str::lower(str_replace(' ','-',$request->product_name)).'-'.rand(100000, 999999).'.'.$extension;
                        Image::make($thumb)->save(public_path('uploads/product/thumbnails/'.$file_name));

                        Thumbnail::insert([
                            'product_id'=>$request->product_id,
                            'thumbnail'=>$file_name,
                        ]);
                    }
                    return back()->with('product_update','Product Updated Successfully!');
                }
            }

        }

        // when $request->product_id & $request->product_name both are not exists in product table ===========
        else{

            // when $request->product_name match with other product_name in product table ===========
            if(Product::where('product_name', $request->product_name)->exists()){
                return back()->with('product_update_duplicate','This product name is already taken!');
            }

            // when $request->product_name not match with other product_name in product table ===========
            else{

                // when $request->preview is null ===========
                if($request->preview == ''){

                    // when $request->preview & $request->thumbnail both are null ===========
                    if($request->thumbnail == ''){ 

                        Product::find($request->product_id)->update([
                            'catagory_id'=>$request->catagory_id,
                            'subcatagory_id'=>$request->subcatagory_id,
                            'product_name'=>$request->product_name,
                            'slug'=>str_replace(' ','-',Str::lower($request->product_name)).'-'.rand(100000,999999),
                            'price'=>$request->price,
                            'discount'=> $request->discount,
                            'after_discount'=>$request->price-($request->price*$request->discount/100),
                            'brand'=>$request->brand,
                            'key_features'=>$request->key_features,
                            'description'=>$request->description,
                        ]);

                        return back()->with('product_update','Product Updated Successfully!');
                        
                    }

                    // when $request->preview is null but $request->thumbnail is not null ===========
                    else{
                        Product::find($request->product_id)->update([
                            'catagory_id'=>$request->catagory_id,
                            'subcatagory_id'=>$request->subcatagory_id,
                            'product_name'=>$request->product_name,
                            'slug'=>str_replace(' ','-',Str::lower($request->product_name)).'-'.rand(100000,999999),
                            'price'=>$request->price,
                            'discount'=> $request->discount,
                            'after_discount'=>$request->price-($request->price*$request->discount/100),
                            'brand'=>$request->brand,
                            'key_features'=>$request->key_features,
                            'description'=>$request->description,
                        ]);

                        // thumbnail image unlink from folder, old image delete & new image insert to database =============
                        $delete_thumbnail_name = Thumbnail::where('product_id', $request->product_id)->get();
                        foreach($delete_thumbnail_name as $del){
                            $delete_thumbnail_from = public_path('uploads/product/thumbnails/'.$del->thumbnail);
                            unlink($delete_thumbnail_from);
                        }
                        Thumbnail::where('product_id', $request->product_id)->delete();

                        $thumbnail = $request->thumbnail;
                        foreach ($thumbnail as $thumb){
                            $extension = $thumb->getClientOriginalExtension();
                            $file_name = Str::lower(str_replace(' ','-',$request->product_name)).'-'.rand(100000, 999999).'.'.$extension;
                            Image::make($thumb)->save(public_path('uploads/product/thumbnails/'.$file_name));

                            Thumbnail::insert([
                                'product_id'=>$request->product_id,
                                'thumbnail'=>$file_name,
                            ]);
                        }
                        return back()->with('product_update','Product Updated Successfully!');
                    }
                }

                // when $request->preview is not null ===========
                else{

                    // when $request->preview is not null but $request->thumbnail is null ===========
                    if($request->thumbnail == ''){
                        // preview image unlink from folder & update to database =============
                        $delete_preview_name = Product::find($request->product_id)->preview;
                        $delete_preview_from = public_path('uploads/product/preview/'.$delete_preview_name);
                        unlink($delete_preview_from);

                        $preview = $request->preview;
                        $extension = $preview->getClientOriginalExtension();
                        $file_name = Str::lower(str_replace(' ','-',$request->product_name)).'-'.rand(100000, 999999).'.'.$extension;
                        Image::make($preview)->save(public_path('uploads/product/preview/'.$file_name));  
                            
                        Product::find($request->product_id)->update([
                            'catagory_id'=>$request->catagory_id,
                            'subcatagory_id'=>$request->subcatagory_id,
                            'product_name'=>$request->product_name,
                            'slug'=>str_replace(' ','-',Str::lower($request->product_name)).'-'.rand(100000,999999),
                            'price'=>$request->price,
                            'discount'=> $request->discount,
                            'after_discount'=>$request->price-($request->price*$request->discount/100),
                            'brand'=>$request->brand,
                            'key_features'=>$request->key_features,
                            'description'=>$request->description,
                            'preview'=>$file_name,               
                        ]);
                        return back()->with('product_update','Product Updated Successfully!');
                    }

                    // when $request->preview & $request->thumbnail both are not null ===========
                    else{

                        // preview image unlink from folder & update to database =============
                        $delete_preview_name = Product::find($request->product_id)->preview;
                        $delete_preview_from = public_path('uploads/product/preview/'.$delete_preview_name);
                        unlink($delete_preview_from);

                        $preview = $request->preview;
                        $extension = $preview->getClientOriginalExtension();
                        $file_name = Str::lower(str_replace(' ','-',$request->product_name)).'-'.rand(100000, 999999).'.'.$extension;
                        Image::make($preview)->save(public_path('uploads/product/preview/'.$file_name));  
                            
                        Product::find($request->product_id)->update([
                            'catagory_id'=>$request->catagory_id,
                            'subcatagory_id'=>$request->subcatagory_id,
                            'product_name'=>$request->product_name,
                            'slug'=>str_replace(' ','-',Str::lower($request->product_name)).'-'.rand(100000,999999),
                            'price'=>$request->price,
                            'discount'=> $request->discount,
                            'after_discount'=>$request->price-($request->price*$request->discount/100),
                            'brand'=>$request->brand,
                            'key_features'=>$request->key_features,
                            'description'=>$request->description,
                            'preview'=>$file_name,               
                        ]);


                        // thumbnail image unlink from folder, old image delete & new image insert to database =============
                        $delete_thumbnail_name = Thumbnail::where('product_id', $request->product_id)->get();
                        foreach($delete_thumbnail_name as $del){
                            $delete_thumbnail_from = public_path('uploads/product/thumbnails/'.$del->thumbnail);
                            unlink($delete_thumbnail_from);
                        }
                        Thumbnail::where('product_id', $request->product_id)->delete();

                        $thumbnail = $request->thumbnail;
                        foreach ($thumbnail as $thumb){
                            $extension = $thumb->getClientOriginalExtension();
                            $file_name = Str::lower(str_replace(' ','-',$request->product_name)).'-'.rand(100000, 999999).'.'.$extension;
                            Image::make($thumb)->save(public_path('uploads/product/thumbnails/'.$file_name));

                            Thumbnail::insert([
                                'product_id'=>$request->product_id,
                                'thumbnail'=>$file_name,
                            ]);
                        }
                        return back()->with('product_update','Product Updated Successfully!');
                    }
                }
            }
        }

    }

    function product_restore($product_id){
        Product::onlyTrashed()->find($product_id)->restore();
        return back()->with('product_restore_seccess', 'Product Restored Successfully!');
    }

    function product_delete($product_id){
        Product::find($product_id)->delete();
        Cart::where('product_id', $product_id)->delete();
        Wish::where('product_id', $product_id)->delete();
        return back()->with('product_move_to_trash', 'Product Move to Trash List!');
    }

    function product_force_delete($product_id){
        $delete_privew = Product::onlyTrashed()->find($product_id)->preview;
        $delete_privew_from = public_path('uploads/product/preview/'.$delete_privew);
        unlink($delete_privew_from);

        $delete_thumbnail = Thumbnail::where('product_id', $product_id)->get();
        foreach ($delete_thumbnail as $del_thumb){
            $delete_thumbnail_from = public_path('uploads/product/thumbnails/'.$del_thumb->thumbnail);
            unlink($delete_thumbnail_from);
        }
        Thumbnail::where('product_id',$product_id)->delete();
        Inventory::where('product_id', $product_id)->delete();
        Product::onlyTrashed()->find($product_id)->forceDelete();
        return back()->with('product_delete_success', 'Product Deleted Permanently!');
    }

    function product_inventory($product_id){
        $colors = Color::all();
        $sizes = Size::all();
        $product_info = Product::find($product_id);
        $inventories = Inventory::where('product_id', $product_id)->get();
        return view('admin.product.product_inventory',[
            'colors'=>$colors,
            'sizes'=>$sizes,
            'product_info'=>$product_info,
            'inventories'=>$inventories,
        ]);
    }

    function inventory_store(Request $request){
        Inventory::insert([
            'product_id'=>$request->product_id,
            'color_id'=>$request->color_id,
            'size_id'=>$request->size_id,
            'quantity'=>$request->quantity,
            'created_at'=>Carbon::now(),
        ]);
        return back();
    }

    function inventory_update(Request $request){
        Inventory::find($request->inv_id)->update([
            'quantity'=>$request->inv_quantity,           
        ]);
        return back()->with('inventory_update', 'Inventory Update Successfully!');
    }

    function inventory_all_update(Request $request){
        foreach($request->inv_id as $sl=>$inv_id){
            Inventory::find($inv_id)->update([
                    'quantity'=>$request->inv_quantity[$sl],           
                ]);         
        }
        return back()->with('inventory_update', 'Inventory Update Successfully!');
    }

    function inventory_delete($inventory_id){
        $inv_all = Inventory::find($inventory_id);
        Cart::where('product_id', $inv_all->product_id)->where('color_id', $inv_all->color_id)->where('size_id', $inv_all->size_id)->where('customer_id', Auth::guard('customerlogin')->id())->delete();
        Inventory::find($inventory_id)->delete();
        return back()->with('inventory_delete', 'Inventory Deleted Successfully!');
    }

    // soft delete all ==========
    function check_delete_pro(Request $request){
        foreach($request->product_id as $check_pro){
            Product::find($check_pro)->delete();
            Cart::where('product_id', $check_pro)->delete();
            Wish::where('product_id', $check_pro)->delete();
        }
        return back()->with('product_move_to_trash', 'Product Move to Trash List!');
    }


    function check_restore_delete(Request $request){
        // restore all ==========
        if($request->check_btn_val == 1){
            foreach($request->product_id as $check_pro){
                Product::onlyTrashed()->find($check_pro)->restore();
            }
            return back()->with('product_restore_seccess', 'Product Restored Successfully!');
        }

        // permanent delete all ============
        if($request->check_btn_val == 2){
            foreach($request->product_id as $check_pro){
                $delete_privew = Product::onlyTrashed()->find($check_pro)->preview;

                $delete_privew_from = public_path('uploads/product/preview/'.$delete_privew);
                unlink($delete_privew_from);
    
                $delete_thumbnail = Thumbnail::where('product_id', $check_pro)->get();
                foreach ($delete_thumbnail as $del_thumb){
                    $delete_thumbnail_from = public_path('uploads/product/thumbnails/'.$del_thumb->thumbnail);
                    unlink($delete_thumbnail_from);
                }
                Thumbnail::where('product_id',$check_pro)->delete();
                Inventory::where('product_id', $check_pro)->delete();
                Product::onlyTrashed()->find($check_pro)->forceDelete();
            }
            return back()->with('product_delete_success', 'Product Deleted Permanently!');
        }       
    }

    
 
}
