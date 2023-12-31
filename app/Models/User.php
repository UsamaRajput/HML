<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function requestedRoom(){
        return $this->belongsToMany(Room::class,'requested_rooms');
    }

    public function userInfo(){
        return $this->hasOne(UserInfo::class);
    }

    public function rooms(){
        return $this->belongsToMany(Room::class, 'room_user');
    }

    public function current_room(){
        return $this->belongsToMany(Room::class, 'room_user')
            ->wherePivot('leaving_date', '=', null)
            ->orderByPivot('allocation_date', 'DESC');
    }

    public function generalServices(){
        return $this->belongsToMany(GeneralServices::class,'user_service','user_id','general_service_id');
    }

}
