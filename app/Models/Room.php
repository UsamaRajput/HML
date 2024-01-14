<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'capacity',
        'price',
        'current',
        'is_active',
    ];

    public function ImagesRoom()
    {
        return $this->hasMany(ImageRoom::class);
    }

    public function requestedUser(){
        return $this->belongsToMany(User::class,'requested_rooms');
    }

    public function users(){
        return $this->belongsToMany(User::class, 'room_user');
    }
}
