<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dob',
        'blood_group',
        'cnic',
        'image',
        'phone',
        'emergency_phone',
        'address',
        'city',
        'security_pay'
    ];
}
