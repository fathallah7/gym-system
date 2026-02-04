<?php

namespace App\Services;

use App\Mail\PaymentInvoiceMail;
use App\Models\Invoice;
use App\Models\Member;
use App\Models\Membership;
use App\Models\Payment;
use App\Models\Plan;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class MembershipService
{
    /**
     * Get all memberships with optional search and pagination.
     */
    public function getMemberships(?string $search = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = Membership::with(['member', 'plan']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhereHas('member', function ($mq) use ($search) {
                        $mq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        return $query->paginate($perPage);
    }

    /**
     * Get a single membership with relationships.
     */
    public function getMembership(Membership $membership): Membership
    {
        return $membership->load(['member', 'plan']);
    }

    /**
     * Create a new membership with invoice and payment.
     */
    public function createMembership(array $data): Membership
    {
        return DB::transaction(function () use ($data) {
            $plan = Plan::findOrFail($data['plan_id']);

            // Create membership
            $membership = Membership::create([
                'member_id'  => $data['member_id'],
                'plan_id'    => $data['plan_id'],
                'start_date' => now(),
                'end_date'   => now()->addDays($data['duration']),
                'remaining_sessions' => $plan->sessions,
            ]);

            // Create invoice
            $invoice = Invoice::create([
                'membership_id' => $membership->id,
                'number' => 'INV-' . time(),
                'total_amount'  => $data['total_amount'],
                'status'        => $data['status'],
            ]);

            // Create payment
            Payment::create([
                'invoice_id' => $invoice->id,
                'amount'        => $data['amount'],
                'method'        => $data['payment_method'],
                'note'        => $data['note'] ?? null,
            ]);

            // Send email notification
            $member = Member::find($data['member_id']);
            if ($member?->email) {
                Mail::to($member->email)->send(new PaymentInvoiceMail($invoice));
            }

            return $membership->fresh(['member', 'plan']);
        });
    }

    /**
     * Update a membership.
     */
    public function updateMembership(Membership $membership, array $data): Membership
    {
        $membership->update($data);
        return $membership->fresh();
    }

    /**
     * Delete a membership.
     */
    public function deleteMembership(Membership $membership): bool
    {
        return $membership->delete();
    }
}
