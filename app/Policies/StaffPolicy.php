<?php

namespace App\Policies;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StaffPolicy
{
    use HandlesAuthorization;

    public function isMyStaff(User $user, Staff $staff)
    {
        return $user->id == $staff->creator_user_id;
    }
}
