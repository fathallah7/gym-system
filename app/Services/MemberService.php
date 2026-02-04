<?php

namespace App\Services;

use App\Models\Member;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class MemberService
{
    /**
     * Get all members with optional search and pagination.
     */
    public function getMembers(?string $search = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = Member::with('memberships');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            });
        }

        return $query->paginate($perPage);
    }

    /**
     * Get a single member with relationships.
     */
    public function getMember(Member $member): Member
    {
        return $member->load('memberships.plan');
    }

    /**
     * Create a new member.
     */
    public function createMember(array $data): Member
    {
        return Member::create($data);
    }

    /**
     * Update an existing member.
     */
    public function updateMember(Member $member, array $data): Member
    {
        $member->update($data);
        return $member->fresh();
    }

    /**
     * Delete a member.
     */
    public function deleteMember(Member $member): bool
    {
        return $member->delete();
    }
}
