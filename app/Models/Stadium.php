<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stadium extends Model
{
    use HasFactory;
    protected $table = 'stadiums';
    protected $fillable =[
        'id',
        'number',
        'detail',
        'image',
        'date_not_empty'
    ];
}
