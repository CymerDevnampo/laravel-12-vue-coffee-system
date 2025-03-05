<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'coffee_id',
        'quantity',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function coffee()
    {
        // return $this->hasMany(Coffee::class, 'coffee_id', 'id');
        return $this->belongsTo(Coffee::class, 'coffee_id', 'id');
    }
}
