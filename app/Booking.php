<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Booking extends Model
{
    use Searchable;
    protected $guarded = [];
    protected $casts = ['booking_data' => 'json'];

    public function agent()
    {
        return $this->belongsTo(Agents::class);
    }
    public function agentProduct($code)
    {
       return AgentProduct::where('agent_code', $code)->first();
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'ref' => $this->ref,
            'product_id' => $this->booking_data['product_id'],
            'first_name' => $this->booking_data['first_name'],
            'last_name' => $this->booking_data['last_name'],
            'phone' => $this->booking_data['phone'],
            'mobile' => $this->booking_data['mobile'],
            'arrival_date' => $this->booking_data['arrival_date'],
            'arrival_time' => $this->booking_data['arrival_time'],
            'return_date' => $this->booking_data['return_date'],
            'return_time' => $this->booking_data['return_time'],
            'vehicle' => $this->booking_data['vehicle'],
            'vehicle_reg' => $this->booking_data['vehicle_reg'],
            'vehicle_colour' => $this->booking_data['vehicle_colour'],
            'agent' => $this->agent->name,
            'agent_id' => $this->agent_id,
            'status' => $this->status
        ];
    }
}
