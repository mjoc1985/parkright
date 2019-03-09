<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];
    
    public function booking()
    {
        return $this->belongsToMany(Booking::class, 'id', 'booking_data->product_id');
    }
}
