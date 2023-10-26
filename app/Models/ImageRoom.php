<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'room_id'
    ];

    public function images()
    {
        return $this->belongsTo(Room::class);
    }
}
