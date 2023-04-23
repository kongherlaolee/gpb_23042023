<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;
    protected $fillable =[
        'id',
        'time_id',
        'price_court1',
        'price_court2',
        'court1',
        'court2',
    ];
}
