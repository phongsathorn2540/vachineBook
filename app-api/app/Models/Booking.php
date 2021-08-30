<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'booking';
    protected $fillable = [
        'user_id', 'booking_date',
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}