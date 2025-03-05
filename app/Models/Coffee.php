<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coffee extends Model
{
    protected $table = 'coffee';

    protected $fillable = [
        'coffee_name',
        'quantity',
        'image',
    ];

    public function order()
    {
        // return $this->belongsTo(Orders::class);
        return $this->hasMany(Orders::class, 'coffee_id');
    }
}
