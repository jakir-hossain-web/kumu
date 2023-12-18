<?php

namespace App\Http\Controllers;

use App\Models\Catagory;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\OrderProduct;
use App\Models\CustomerMessage;
use App\Models\Color;
use App\Models\Size;
use App\Models\PassReset;
use App\Models\CustomerLogin;
use App\Notifications\PassResetNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\Thumbnail;
use App\Models\Wish;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Frontendcontroller extends Controller
{

    function error_404(){
        return view('frontend.404');
    }

    function home(){
        $catagories = Catagory::all();
        $products = Product::take(8)->get();
        $top_selling_products = OrderProduct::whereNotNull('product_id')->groupBy('product_id')->selectRaw('sum(quantity) as sum, product_id')->orderBy('sum','DESC')->get();
        $top_rated_products = OrderProduct::whereNotNull('product_id')->groupBy('product_id')->selectRaw('avg(star) as avg, product_id')->orderBy('avg','DESC')->get();
        $recent_products = Product::orderBy('created_at','desc')->get();
        $banner_products = Product::orderBy('created_at','desc')->take(3)->get();
        return view('frontend.index',[
            'catagories'=>$catagories,
            'products'=>$products,
            'top_selling_products'=>$top_selling_products,
            'top_rated_products'=>$top_rated_products,
            'recent_products'=>$recent_products,
            'banner_products'=>$banner_products,
        ]);
    }

    function shop(Request $request){
        $data = $request->all();
        
        $sorting_by = 'created_at';
        $sorting_type = 'DESC';

        // ====== sort by low-high price, high-low price, A-Z & Z-A =======
        if(!empty($data['sort']) && $data['sort'] != '' && $data['sort'] !='undefined'){
            if($data['sort'] == 1){
                $sorting_by = 'after_discount';
                $sorting_type = 'ASC';
            }
            else if($data['sort'] == 2){
                $sorting_by = 'after_discount';
                $sorting_type = 'DESC';
            }
            else if($data['sort'] == 3){
                $sorting_by = 'product_name';
                $sorting_type = 'ASC';
            }
            else if($data['sort'] == 4){
                $sorting_by = 'product_name';
                $sorting_type = 'DESC';
            }
            else{
                $sorting_by = 'created_at';
                $sorting_type = 'DESC';
            }
        }

        $search_product = Product::where(function ($q) use ($data){
            // ====== sort by search button =======
            if(!empty($data['keyword']) && $data['keyword'] != '' && $data['keyword'] !='undefined'){
                $q->where(function ($q) use ($data){
                    $q->where('product_name', 'like', '%' . $data['keyword'] . '%');
                    $q->orWhere('brand', 'like', '%' . $data['keyword'] . '%');
                    $q->orWhere('key_features', 'like', '%' . $data['keyword'] . '%');
                    $q->orWhere('description', 'like', '%' . $data['keyword'] . '%');
                });
            }

            // ====== sort by only minimum price =======
            $min = 0;
            if(!empty($data['min']) && $data['min'] != '' && $data['min'] !='undefined'){
                $min = $data['min'];
            }
            else{
                $min = 1;
            }

            // ====== sort by only maximum price =======
            $max = 0;
            if(!empty($data['max']) && $data['max'] != '' && $data['max'] !='undefined'){
                $max = $data['max'];
            }
            else{
                $max = 999999999999;
            }

            // ====== sort by both minimum & mazimum price =======
            if(!empty($data['min']) && $data['min'] != '' && $data['min'] !='undefined' || !empty($data['max']) && $data['max'] != '' && $data['max'] !='undefined'){
               $q->whereBetween('after_discount', [$min, $max]);
            }

            // ====== sort by catagory =======
            if(!empty($data['catagory']) && $data['catagory'] != '' && $data['catagory'] !='undefined'){
               $q->where('catagory_id', $data['catagory']);
            }

            // ====== sort by both color & size =======
            if(!empty($data['color']) && $data['color'] != '' && $data['color'] !='undefined' || !empty($data['size']) && $data['size'] != '' && $data['size'] !='undefined'){
               $q->whereHas('rel_to_inventory', function ($q) use ($data){
                    if(!empty($data['color']) && $data['color'] != '' && $data['color'] !='undefined'){
                        $q->whereHas('rel_to_color', function ($q) use ($data){
                            $q->where('colors.id', $data['color']);
                        });
                    }
                    if(!empty($data['size']) && $data['size'] != '' && $data['size'] !='undefined'){
                        $q->whereHas('rel_to_size', function ($q) use ($data){
                            $q->where('sizes.id', $data['size']);
                        });
                    }
                });
            }
        })->orderBy($sorting_by, $sorting_type)->get();
        
        $catagories = Catagory::all();
        $colors = Color::all();
        $sizes = Size::all();
        return view('frontend.shop',[
            'products'=>$search_product,
            'catagories'=>$catagories,
            'colors'=>$colors,
            'sizes'=>$sizes,
        ]);
    }

    function about_us(){
        return view('frontend.about_us');
    }

    function contact(){
        return view('frontend.contact');
    }

    function product_details($slug){

        if (Product::where('slug', $slug)->exists()) {
            $product_info = Product::where('slug', $slug)->get();
            $thumbnails = Thumbnail::where('product_id', $product_info->first()->id)->get();
            $related_products = Product::where('catagory_id', $product_info->first()->catagory_id)->where('id', '!=', $product_info->first()->id)->get();

            $available_colors = Inventory::where('product_id', $product_info->first()->id)->groupBy('color_id')
            ->selectRaw('sum(color_id) as sum, color_id')
            ->get('sum', 'color_id');

            $available_sizes = Inventory::where('product_id', $product_info->first()->id)->groupBy('size_id')
            ->selectRaw('sum(size_id) as sum, size_id')
            ->get('sum', 'size_id');

            $wishlists = Wish::where('customer_id', Auth::guard('customerlogin')->id())->where('product_id', $product_info->first()->id)->get();

            // social share start ======
                $shareButtons = \Share::page(
                    url()->current(),
                    // 'Your share text comes here',
                )
                ->facebook()
                ->twitter()
                ->linkedin()
                ->telegram()
                ->whatsapp()        
                ->reddit();
            // social share end ======

            return view('frontend.product_details', [
                'product_info' => $product_info,
                'thumbnails' => $thumbnails,
                'related_products' => $related_products,
                'available_colors' => $available_colors,
                'available_sizes' => $available_sizes,
                'wishlists' => $wishlists,
                'shareButtons' => $shareButtons,
            ]);
        }
        else{
            return redirect()->route('front.home')->with('product_just_deleted','We update our all product just now and your seleted product is not avaiable!'); 
        }
    }

    function getSize(Request $request){
        $str ='';
        $ajax_sizes = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->groupBy('size_id')
        ->selectRaw('sum(size_id) as sum, size_id')
        ->get('sum','size_id');;
        if ($ajax_sizes->count() == 1){
            foreach($ajax_sizes as $ajax_size){
                $str.= '<div class="form-check size-option form-option form-check-inline mb-2">
                    <input class="form-check-input" type="radio" name="size" value="'.$ajax_size->size_id.'" id="'.$ajax_size->size_id.'" checked>
                    <label class="form-option-label" for="'.$ajax_size->size_id.'">'.$ajax_size->rel_to_size->size_name.'</label>
                </div>';
            }
            echo $str;
        }
        else{
            foreach($ajax_sizes as $ajax_size){
                $str.= '<div class="form-check size-option form-option form-check-inline mb-2">
                    <input class="form-check-input" type="radio" name="size" value="'.$ajax_size->size_id.'" id="'.$ajax_size->size_id.'">
                    <label class="form-option-label" for="'.$ajax_size->size_id.'">'.$ajax_size->rel_to_size->size_name.'</label>
                </div>';
            }
            echo $str;
        }
        
    }

    function customer_login_register(){
        return view('frontend.customer_login_register');
    }

    function catagory_product($catagory_id){
        $catagories = $catagory_id;
        $catagories_all = Catagory::all();
        return view('frontend.catagory_product',[
            'catagories'=>$catagories,
            'catagories_all'=>$catagories_all,
        ]);
    }

    function contact_message(Request $request){

        $request->validate([
            'name'=>['required','min:3','regex:/^[a-zA-Z\s]*$/'],
            'email' => 'required|email:rfc',
            'mobile' => 'nullable|regex:/^\+?\d+$/',
            // 'mobile' => 'nullable|regex:/^\d+$/',
            'message' => 'required',
        ],[
            'name.required'=>'Name Field is Empty!',
            'name.min'=>'Minimum 3 Character Required!',
            'name.regex'=>'Alphabetic  Character Only!',
            'email.required'=>'Email Field is Empty!',
            'mobile.regex' => 'Invalid mobile number format!',
            'message.required'=>'Message Field is Empty!',
        ]);

        if($request->mobile != null){
                $request->validate([
                'mobile' =>'numeric',
            ],[
                'mobile.numeric'=>'Digit Only!',
            ]);
        }

        CustomerMessage::insert([
            'name'=>$request->name,
            'email'=>$request->email,
            'mobile'=>$request->mobile,
            'message'=>$request->message,
            'created_at' => Carbon::now(),
        ]);
        return back()->with('customer_message_success','Message Send Successfully!');

    }
    

}
 