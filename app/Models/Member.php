<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'address',
        'gender',
        'date_of_birth',
        'notes',
        'photo',
        'status',
    ];

    // relationships
    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }


}
