<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePolicy
{
    use HandlesAuthorization;

    public function isMyService(User $user, Service $service)
    {
        return $user->id == $service->creator_user_id;
    }
}
