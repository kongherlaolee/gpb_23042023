<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'cus_id', 30,
        'price_id',
        'date_booking',
        'total',
        'status',
        'slip_payment',
    ];
}
