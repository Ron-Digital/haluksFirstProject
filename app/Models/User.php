<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'Users';

    protected $fillable = [
        'email',
        'password',
        'fullname',
        'company',
    ];

    public function meetings(){
        return $this->belongsToMany('App\Models\Meeting', 'user_to_meeting');
    }
}
