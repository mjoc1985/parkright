<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentProduct extends Model
{
    protected $guarded = [];
    protected $table = 'agents_products';
    
    public function agent()
    {
        return $this->belongsTo(Agents::class);
    }
    
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
