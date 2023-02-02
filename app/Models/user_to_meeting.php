<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_to_meeting extends Model
{
    use HasFactory;

    protected $table = 'user_to_meeting';

    protected $fillable = [
        'user_id',
        'meeting_id'
    ];
}
