<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subcatagory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    function rel_to_cat(){
        return $this->belongsTo(Catagory::class, 'catagory_id');
    }
}
