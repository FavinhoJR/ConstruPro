<?php

namespace App\Policies;

use App\Enums\RoleName;
use App\Models\Expense;
use App\Models\User;

class ExpensePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasRole(
            RoleName::Admin,
            RoleName::Manager,
            RoleName::Supervisor,
            RoleName::Accounting
        );
    }

    public function update(User $user, Expense $expense): bool
    {
        return $expense->status->value === 'pendiente'
            && $user->hasRole(RoleName::Admin, RoleName::Manager, RoleName::Supervisor, RoleName::Accounting);
    }

    public function approve(User $user, Expense $expense): bool
    {
        return $user->canApproveExpenses();
    }
}
