<?php

namespace App\Policies;

use App\Models\Member;
use App\Models\User;

class MemberPolicy
{
    /**
     * Determine whether the user can view any members.
     */
    public function viewAny(User $user): bool
    {
        return true; // All authenticated users can view members
    }

    /**
     * Determine whether the user can view the member.
     */
    public function view(User $user, Member $member): bool
    {
        return true; // All authenticated users can view a specific member
    }

    /**
     * Determine whether the user can create members.
     */
    public function create(User $user): bool
    {
        return true; // All authenticated users can create members
    }

    /**
     * Determine whether the user can update the member.
     */
    public function update(User $user, Member $member): bool
    {
        return true; // All authenticated users can update members
    }

    /**
     * Determine whether the user can delete the member.
     */
    public function delete(User $user, Member $member): bool
    {
        return true; // All authenticated users can delete members
    }
}
