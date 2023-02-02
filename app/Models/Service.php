<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'Services';

    protected $fillable = [
        'job',
        'describe',
        'price',
        'duration',
        'creator_user_id'
    ];
}
