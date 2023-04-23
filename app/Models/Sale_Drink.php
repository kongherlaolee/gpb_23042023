<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale_Drink extends Model
{
    use HasFactory;
    protected $fillable =[
        'order_id',
        'emp_id',
        'receive_name',
        'pay_amount',
        'order_status',
    ];
    protected $primaryKey = 'order_id';
}
