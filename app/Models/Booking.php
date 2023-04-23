<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'username', 30,
        'court_num',
        'date_booking',
        'time_booking', 30,
        'price_court',
        'price_bcel',
        'status',
        'slip_payment',
    ];
}
