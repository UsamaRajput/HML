<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visitor extends Model
{
    use HasFactory;

    protected $guarded =[];
    public $timestamps =false;


    public function room()  {
        return $this->belongsTo(Room::class);
    }

    public function user()  {
        return $this->belongsTo(User::class);
    }
}
