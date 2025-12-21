<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trader extends Model
{
    protected $table = 'traders';

    protected $fillable = [
        'name',
        'profile_pic',
        'profit_percentage',
        'amount_made',
        'copies',
        'aum',
        'leading_trades',
        'direction',
        'verified'
    ];
}
