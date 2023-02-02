<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class staff_to_service extends Model
{
    use HasFactory;

    protected $table = 'staff_to_service';

    protected $fillable = [
        'staff_id',
        'service_id'
    ];
}
