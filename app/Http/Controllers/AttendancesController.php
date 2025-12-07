<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Http\Request;

class AttendancesController extends Controller
{
    public function update(Membership $membership)
    {
        $membership->update([
            'remaining_sessions' => max(0, $membership->remaining_sessions - 1),
        ]);

        return response()->json(
            [
                'message' => 'Attendance recorded successfully',
                'remaining_sessions' => $membership->remaining_sessions
            ],
            200
        );
    }
}
