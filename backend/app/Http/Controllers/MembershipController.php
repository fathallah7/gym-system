<?php

namespace App\Http\Controllers;

use App\Mail\PaymentInvoiceMail;
use App\Models\Invoice;
use App\Models\Member;
use App\Models\Membership;
use App\Models\Payment;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class MembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $memberships = Membership::with(['member', 'plan'])->get();
        return response()->json($memberships);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            // membership
            'member_id' => 'required|exists:members,id',
            'plan_id'   => 'required|exists:plans,id',
            'duration'  => 'required|integer|min:1',

            // payment
            'amount'    => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:cash,other',
            'note' => 'nullable|string|max:255',

            // invoice
            'total_amount'   => 'required|numeric|min:0',
            'status'        => 'required|string|in:paid,unpaid,partial,canceled',
        ]);

        try {
            DB::transaction(function () use ($request) {

                $plan = Plan::findOrFail($request->plan_id);

                $membership = Membership::create([
                    'member_id'  => $request->member_id,
                    'plan_id'    => $request->plan_id,
                    'start_date' => now(),
                    'end_date'   => now()->addDays($request->duration),
                    'remaining_sessions' => $plan->sessions,
                ]);

                $invoice = Invoice::create([
                    'membership_id' => $membership->id,
                    'number' => 'INV-' . time(),
                    'total_amount'  => $request->total_amount,
                    'status'        => $request->status,
                ]);

                $payment = Payment::create([
                    'invoice_id' => $invoice->id,
                    'amount'        => $request->amount,
                    'method'        => $request->payment_method,
                    'note'        => $request->note,
                ]);

                $member = Member::find($request->member_id);
                if ($member?->email) {
                    Mail::to($member->email)->send(new PaymentInvoiceMail($invoice));
                }
            });
            return response()->json(['message' => 'Membership, Payment, and Invoice created successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create membership, payment, or invoice', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Membership $membership)
    {
        $request->validate([
            'status'    => 'required|string|in:active,canceled,expired,frozen',
        ]);
        $membership->update($request->all());

        return response()->json(['message' => 'Membership updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Membership $membership)
    {
        $membership->delete();
        return response()->json(['message' => 'Membership deleted successfully']);
    }
}
