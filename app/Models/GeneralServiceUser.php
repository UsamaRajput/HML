<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralServiceUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'room_id',
        'requested_time',
        'leaving_time',
    ];
}
