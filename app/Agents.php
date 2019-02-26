<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agents extends Model
{
    protected $guarded = [];
    
    public function booking()
    {
        return $this->hasMany(Booking::class);
    }
    
    public function agentProducts()
    {
        return $this->hasMany(AgentProduct::class);
    }
}
