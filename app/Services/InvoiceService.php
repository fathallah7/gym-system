<?php

namespace App\Services;

use App\Mail\PaymentInvoiceMail;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class InvoiceService
{
    /**
     * Get all invoices with optional search and pagination.
     */
    public function getInvoices(?string $search = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = Invoice::with('membership.member', 'payments')
            ->withSum('payments', 'amount');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('number', 'like', "%{$search}%")
                    ->orWhereHas('membership.member', function ($im) use ($search) {
                        $im->where('name', 'like', "%{$search}%");
                    });
            });
        }

        return $query->paginate($perPage);
    }

    /**
     * Get a single invoice with relationships.
     */
    public function getInvoice(Invoice $invoice): Invoice
    {
        return $invoice->load('payments', 'membership.member');
    }

    /**
     * Process a payment for an invoice.
     */
    public function processPayment(Invoice $invoice, array $data): Invoice
    {
        return DB::transaction(function () use ($invoice, $data) {
            // Update invoice status
            $invoice->update([
                'status' => $data['status'],
            ]);

            // Create payment record
            Payment::create([
                'amount' => $data['amount'],
                'method' => $data['payment_method'],
                'invoice_id' => $invoice->id
            ]);

            // Send email notification
            if ($invoice->membership->member->email) {
                Mail::to($invoice->membership->member->email)
                    ->send(new PaymentInvoiceMail($invoice));
            }

            return $invoice->fresh(['payments', 'membership.member']);
        });
    }

    /**
     * Delete an invoice and its payments.
     */
    public function deleteInvoice(Invoice $invoice): bool
    {
        return DB::transaction(function () use ($invoice) {
            $invoice->payments()->delete();
            return $invoice->delete();
        });
    }
}
