<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $fillable = [
        'start_date',
        'end_date',
        'remaining_sessions',
        'status',
        'notes',
        'member_id',
        'plan_id',
    ];

    // relationships
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);   
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

}
