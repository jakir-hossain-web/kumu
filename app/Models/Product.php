<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    function rel_to_catagory(){
        return $this->belongsTo(Catagory::class, 'catagory_id');
    }
    function rel_to_subcatagory(){
        return $this->belongsTo(Subcatagory::class, 'subcatagory_id');
    }
    function rel_to_inventory(){
        return $this->hasMany(Inventory::class, 'product_id');
    }
}
