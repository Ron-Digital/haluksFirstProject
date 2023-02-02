<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $table = 'Meetings';

    protected $fillable = [
        'customer_id',
        'staff_id',
        'service_id',
        'creator_user_id',
        'meeting_at',
        'duration'
    ];

    public function meeting_customer()
    {
        return $this->hasOne('App\Models\Customer', 'customer_id');
    }

    public function meeting_staff()
    {
        return $this->hasMany('App\Models\Staff', 'staff_id');
    }

    public function meeting_service()
    {
        return $this->hasMany('App\Models\Service', 'service_id');
    }
}
