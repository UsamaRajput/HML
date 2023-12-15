<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'banner',
        'title',
        'superintendent_name',
        'superintendent_desc',
        'content',
    ];
}
