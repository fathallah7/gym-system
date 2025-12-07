<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Member;
use App\Models\Membership;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $cards = [
            'total_members' => Member::count(),
            'total_memberships' => Membership::count(),
            'total_active_memberships' => Membership::where('status', 'active')->count(),
            'total_expired_memberships' => Membership::where('status', 'expired')->count(),
            'total_canceled_memberships' => Membership::where('status', 'canceled')->count(),
            'total_frozen_memberships' => Membership::where('status', 'frozen')->count(),
            'total_payments_amount' => Payment::sum('amount'),
            'total_paid_invoices' => Invoice::where('status', 'paid')->count(),
            'total_unpaid_invoices' => Invoice::where('status', 'unpaid')->count(),
            'total_partial_invoices' => Invoice::where('status', 'partial')->count(),
            'total_expiring_memberships' => Membership::where('end_date', '<=', now()->addDays(7))->where('status', 'active')->count(),
        ];

        $tables = [
            'recent_members' => Member::latest()->take(5)->get(),
            'recent_memberships' => Membership::with('member:id,name', 'plan:id,name')->latest()->take(5)->get(),
            'recent_payments' => Payment::latest()->take(5)->get(),
            'recent_invoices' => Invoice::with('membership')->latest()->take(5)->get(),
        ];

        $charts = [
            'monthly_revenue' => Payment::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(amount) as total')
            )->groupBy('month')->orderBy('month')->get(),

            'new_memberships_per_month' => Membership::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )->groupBy('month')->orderBy('month')->get(),

            'subscriptions_by_plan' => Membership::select(
                'plan_id',
                DB::raw('COUNT(*) as count')
            )->groupBy('plan_id')->with('plan:id,name')->get(),

            'subscriptions_status' => Membership::select(
                'status',
                DB::raw('COUNT(*) as count')
            )->groupBy('status')->get(),
        ];

        return response()->json([
            'cards' => $cards,
            'tables' => $tables,
            'charts' => $charts,
        ]);
    }
}
