<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Member;
use App\Models\Plan;
use App\Models\Membership;
use App\Models\Invoice;
use App\Models\Payment;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ====== Users ======
        User::create([
            'name' => 'Owner',
            'email' => 'abdodisoff@gmail.com',
            'role' => 'owner',
            'password' => Hash::make('aaaaaaaa'),
        ]);

        User::create([
            'name' => 'Staff Member',
            'email' => 'staff@gmail.com',
            'role' => 'staff',
            'password' => Hash::make('ssssssss'),
        ]);

        // ====== Plans ======
        $plan1 = Plan::create([
            'name' => 'Monthly Open',
            'type' => 'open',
            'duration' => 30,
            'price' => 500.00
        ]);

        $plan2 = Plan::create([
            'name' => '10 Sessions',
            'type' => 'sessions',
            'sessions' => 10,
            'price' => 300.00
        ]);

        $plan3 = Plan::create([
            'name' => 'Quarterly Open',
            'type' => 'open',
            'duration' => 90,
            'price' => 1200.00
        ]);

        // ====== Members + Memberships + Invoices + Payments ======
        $membersData = [
            ['Ahmed Ali', 'ahmed@example.com', 'male', 'Cairo, Egypt', '1995-06-15', $plan1, 25, null, 'active', 'paid', 500],
            ['Sara Mohamed', 'sara@example.com', 'female', 'Alexandria, Egypt', '1998-02-20', $plan2, 60, 10, 'active', 'unpaid', 300],
            ['Mohamed Hassan', 'mohamed@example.com', 'male', 'Giza, Egypt', '1990-11-02', $plan3, 80, null, 'active', 'partial', 1200],
            ['Laila Adel', 'laila@example.com', 'female', 'Cairo, Egypt', '1997-03-10', $plan1, 10, null, 'expired', 'paid', 500],
            ['Omar Samir', 'omar@example.com', 'male', 'Alexandria, Egypt', '1996-08-25', $plan2, 30, 5, 'active', 'paid', 300],
            ['Huda Nabil', 'huda@example.com', 'female', 'Cairo, Egypt', '1999-01-14', $plan3, 85, null, 'active', 'unpaid', 1200],
            ['Khaled Mostafa', 'khaled@example.com', 'male', 'Giza, Egypt', '1994-09-09', $plan1, 29, null, 'frozen', 'partial', 500],
            ['Nour El-Din', 'nour@example.com', 'male', 'Cairo, Egypt', '1993-12-30', $plan2, 55, 8, 'active', 'paid', 300],
        ];

        foreach ($membersData as $index => $data) {
            [$name, $email, $gender, $address, $dob, $plan, $daysLeft, $sessions, $membershipStatus, $invoiceStatus, $amount] = $data;

            $member = Member::create([
                'name' => $name,
                'email' => $email,
                'phone_number' => '010' . rand(10000000, 99999999),
                'gender' => $gender,
                'address' => $address,
                'date_of_birth' => $dob,
                'status' => 'allowed'
            ]);

            $membership = Membership::create([
                'member_id' => $member->id,
                'plan_id' => $plan->id,
                'start_date' => now()->subDays(30 - $daysLeft),
                'end_date' => now()->addDays($daysLeft),
                'remaining_sessions' => $sessions,
                'status' => $membershipStatus
            ]);

            $invoice = Invoice::create([
                'number' => 'INV-10' . str_pad($index + 1, 2, '0', STR_PAD_LEFT),
                'total_amount' => $amount,
                'status' => $invoiceStatus,
                'membership_id' => $membership->id
            ]);

            // لو الفاتورة مدفوعة أو جزئية، أضف دفعة
            if (in_array($invoiceStatus, ['paid', 'partial'])) {
                Payment::create([
                    'invoice_id' => $invoice->id,
                    'amount' => $invoiceStatus === 'paid' ? $amount : $amount / 2,
                    'method' => 'cash',
                    'payment_date' => now()
                ]);
            }
        }
    }
}
