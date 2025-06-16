<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_email',
        'booking_date',
        'booking_type',
        'booking_slot',
        'from_time',
        'to_time',
    ];

    protected $dates = [
        'booking_date' => 'date',
    ];

    // Stub method for conflict checking
    public static function hasConflict($data)
    {
        // Logic goes here later
        return false;
    }
} 
