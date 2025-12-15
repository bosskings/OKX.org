<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    protected $table = 'trades';

    protected $fillable = [
        'users_id',
        'amount',
        'type',
        'trader',
    ];

    /**
     * Get the user that owns the trade.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
