<?php

namespace App\Policies;

use App\Models\Plan;
use App\Models\User;

class PlanPolicy
{
    /**
     * Determine whether the user can view any plans.
     */
    public function viewAny(User $user): bool
    {
        return true; // All authenticated users can view plans
    }

    /**
     * Determine whether the user can view the plan.
     */
    public function view(User $user, Plan $plan): bool
    {
        return true; // All authenticated users can view a specific plan
    }

    /**
     * Determine whether the user can create plans.
     */
    public function create(User $user): bool
    {
        return true; // All authenticated users can create plans
    }

    /**
     * Determine whether the user can update the plan.
     */
    public function update(User $user, Plan $plan): bool
    {
        return true; // All authenticated users can update plans
    }

    /**
     * Determine whether the user can delete the plan.
     */
    public function delete(User $user, Plan $plan): bool
    {
        return true; // All authenticated users can delete plans
    }
}
