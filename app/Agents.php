<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agents extends Model
{
    public function booking()
    {
        return $this->hasMany(Booking::class);
    }
}
