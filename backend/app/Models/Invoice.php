<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
        protected $fillable = [
        'number',
        'total_amount',
        'status',
        'membership_id',
    ];

    // relations
    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

}
