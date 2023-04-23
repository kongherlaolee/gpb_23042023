<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDrinkDetail extends Model
{
    use HasFactory;
    protected $fillable =[
        'id',
        'order_id',
        'd_id',
        'qty',
        'price',
        'total',
    ];
}
