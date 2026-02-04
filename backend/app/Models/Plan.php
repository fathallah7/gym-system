<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{

    protected $fillable = [
        'name',
        'type',
        'sessions',
        'duration',
        'price',
    ];

    // relationships
    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }
}
