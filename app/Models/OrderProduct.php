<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    function rel_to_product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
    function rel_to_color(){
        return $this->belongsTo(Color::class, 'color_id');
    }
    function rel_to_size(){
        return $this->belongsTo(Size::class, 'size_id');
    }
    function rel_to_catagory(){
        return $this->belongsTo(Catagory::class, 'catagory_id');
    }
    function rel_to_customer(){
        return $this->belongsTo(CustomerLogin::class, 'customer_id');
    }
    function rel_to_order(){
        return $this->belongsTo(Order::class, 'order_id');
    }
}
