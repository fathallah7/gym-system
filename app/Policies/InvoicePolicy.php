<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;

class InvoicePolicy
{
    /**
     * Determine whether the user can view any invoices.
     */
    public function viewAny(User $user): bool
    {
        return true; // All authenticated users can view invoices
    }

    /**
     * Determine whether the user can view the invoice.
     */
    public function view(User $user, Invoice $invoice): bool
    {
        return true; // All authenticated users can view a specific invoice
    }

    /**
     * Determine whether the user can create invoices.
     */
    public function create(User $user): bool
    {
        return true; // All authenticated users can create invoices
    }

    /**
     * Determine whether the user can update the invoice.
     */
    public function update(User $user, Invoice $invoice): bool
    {
        return true; // All authenticated users can update invoices
    }

    /**
     * Determine whether the user can delete the invoice.
     */
    public function delete(User $user, Invoice $invoice): bool
    {
        return true; // All authenticated users can delete invoices
    }
}
