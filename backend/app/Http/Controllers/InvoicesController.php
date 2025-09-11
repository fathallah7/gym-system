<?php

namespace App\Http\Controllers;

use App\Mail\PaymentInvoiceMail;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::with('membership.member', 'payments')
            ->withSum('payments', 'amount')
            ->paginate(15);
        return response()->json($invoices);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load('payments');
        return response()->json($invoice);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'status' => 'required|in:paid,partial,canceled',
            'payment_method' => 'required|string|in:cash,other',
        ]);

        try {
            DB::transaction(function () use ($request, $invoice) {

                $invoice->update([
                    'status' => $request->status,
                ]);

                Payment::create([
                    'amount' => $request->amount,
                    'payment_method' => $request->payment_method,
                    'invoice_id' => $invoice->id
                ]);

                if ($invoice->membership->member->email) {
                    Mail::to($invoice->membership->member->email)->send(new PaymentInvoiceMail($invoice));
                }
            });
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update invoice'], 500);
        }

        return response()->json('Done');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        try {
            DB::transaction(function () use ($invoice) {
                $invoice->payments()->delete();
                $invoice->delete();
            });
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete invoice'], 500);
        }

        return response()->json('Done');
    }
}
