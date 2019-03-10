<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Booking extends Model
{
    use Searchable;
    protected $guarded = [];
    protected $casts = [
        'booking_data' => 'json',
        'booking_data->price_paid' => 'float',
//        'booking_data->arrival_date' => 'date',
//        'booking_data->return_date' => 'date'

    ];

//    protected $dates = ['booking_data->arrival_date', 'booking_data->return_date'];

    public function agent()
    {
        return $this->belongsTo(Agents::class);
    }

    public function agentProduct()
    {
        return $this->hasOne(AgentProduct::class, 'id', 'agents_products_id');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
    

//    public function product()
//    {
//        return $this->hasOneThrough(Product::class, AgentProduct::class, 'product_id', 'id', 'booking_data->product_id');
//    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'ref' => $this->ref,
            'product_id' => $this->booking_data->product_id,
            'first_name' => $this->booking_data->first_name,
            'last_name' => $this->booking_data->last_name,
            'phone' => $this->booking_data->phone,
            'mobile' => $this->booking_data->mobile,
            'arrival_date' => $this->booking_data->arrival_date,
            'arrival_time' => $this->booking_data->arrival_time,
            'return_date' => $this->booking_data->return_date,
            'return_time' => $this->booking_data->return_time,
            'vehicle' => $this->booking_data->vehicle,
            'vehicle_reg' => $this->booking_data->vehicle_reg,
            'vehicle_colour' => $this->booking_data->vehicle_colour,
            'agent' => $this->agent->name,
            'agent_id' => $this->agent_id,
            'status' => $this->status
        ];
    }

    public function getBookingDataAttribute($value)
    {
        $data = json_decode($value);
//        $data->arrival_date = (new Carbon($data->arrival_date . ' '. $data->arrival_time))->format('d-m-Y H:i:s');
//        $data->return_date  = (new Carbon($data->return_date . ' '. $data->return_time))->format('d-m-Y H:i:s');
        $price = explode('£', $data->price_paid);
        $data->price_paid = (float)$price[1];
       
        return $data;

    }
    
   
}
