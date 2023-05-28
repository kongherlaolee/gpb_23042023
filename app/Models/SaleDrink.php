<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDrink extends Model
{
    use HasFactory;
    protected $fillable =[
        'order_id',
        'emp_id',
        'receive_name',
        'recieve_money',
        'change',
        'total',
    ];
    protected $primaryKey = 'order_id';
}
