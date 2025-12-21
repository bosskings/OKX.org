<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Following extends Model
{
    // Assuming the table name is 'followings'
    protected $table = 'followings';

    // Allow mass assignment of these fields
    protected $fillable = [
        'traders_id',
        'user_id',
    ];
}
