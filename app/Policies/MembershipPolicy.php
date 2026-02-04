<?php

namespace App\Policies;

use App\Models\Membership;
use App\Models\User;

class MembershipPolicy
{
    /**
     * Determine whether the user can view any memberships.
     */
    public function viewAny(User $user): bool
    {
        return true; // All authenticated users can view memberships
    }

    /**
     * Determine whether the user can view the membership.
     */
    public function view(User $user, Membership $membership): bool
    {
        return true; // All authenticated users can view a specific membership
    }

    /**
     * Determine whether the user can create memberships.
     */
    public function create(User $user): bool
    {
        return true; // All authenticated users can create memberships
    }

    /**
     * Determine whether the user can update the membership.
     */
    public function update(User $user, Membership $membership): bool
    {
        return true; // All authenticated users can update memberships
    }

    /**
     * Determine whether the user can delete the membership.
     */
    public function delete(User $user, Membership $membership): bool
    {
        return true; // All authenticated users can delete memberships
    }
}
