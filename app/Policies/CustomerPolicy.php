<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;

    public function isMyCustomer(User $user, Customer $customer)
    {
        return $user->id == $customer->creator_user_id;
    }
}
