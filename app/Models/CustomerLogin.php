<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class CustomerLogin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guarded = ['id'];

    protected $guard = 'customerlogin';

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function rel_to_country(){
        return $this->belongsTo(Country::class, 'country_id');
    }
    function rel_to_city(){
        return $this->belongsTo(City::class, 'city_id');
    }
}
