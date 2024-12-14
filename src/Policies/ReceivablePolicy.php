<?php

namespace Modules\DebtsAndReceivables\Policies;

use App\Models\Tenants\User;
use Modules\DebtsAndReceivables\Models\Receivable;

class ReceivablePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('read receivable');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Receivable $receivable): bool
    {
        return $user->can('read receivable');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Receivable $receivable): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Receivable $receivable): bool
    {
        return false;
    }
}
