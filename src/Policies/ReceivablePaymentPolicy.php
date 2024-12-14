<?php

namespace Modules\DebtsAndReceivables\Policies;

use App\Models\Tenants\User;
use Modules\DebtsAndReceivables\Models\ReceivablePayment;

class ReceivablePaymentPolicy
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
    public function view(User $user, ReceivablePayment $receivablePayment): bool
    {
        return $user->can('read receivable payment');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create receivable payment');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ReceivablePayment $receivablePayment): bool
    {
        return $user->can('update receivable payment');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ReceivablePayment $receivablePayment): bool
    {
        return $user->can('delete receivable payment');
    }
}
