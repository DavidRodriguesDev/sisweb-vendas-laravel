<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Sale;

class SalePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('manage sales');
    }

    public function view(User $user, Sale $sale): bool
    {
        return $user->hasPermissionTo('manage sales');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('manage sales');
    }

    public function cancel(User $user, Sale $sale): bool
    {
        return $user->hasPermissionTo('manage sales');
    }
}