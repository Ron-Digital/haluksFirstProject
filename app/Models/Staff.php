<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'Staffs';

    protected $fillable = [
        'fullname',
        'age',
        'email',
        'password',
        'creator_user_id'
    ];

    public function services(){
        return $this->belongsToMany('App\Models\Service', 'staff_to_service' );
    }
}
