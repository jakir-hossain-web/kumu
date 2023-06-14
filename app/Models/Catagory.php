<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpParser\Node\Stmt\Return_;

class catagory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    function rel_to_user(){
        return $this->belongsTo(User::class, 'added_by');
    }
}
