<?php

namespace App\Imports;

use App\AgentProduct;
use App\Agents;
use App\Booking;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BookingsImport implements ToModel, WithHeadingRow
{
    protected $agent;

    public function __construct(Agents $agent)
    {
        $this->agent = $agent;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     * @throws \Exception
     */
    public function model(array $row)
    {
        $bookingData = [
            'title' => $row['title'],
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'phone' => $row['phone'],
            'mobile' => $row['mobile'],
            'arrival_date' => (new Carbon($row['arrival_date'] . ' ' . $row['arrival_time']))->toDateTimeString(),
            'arrival_time' => $row['arrival_time'],
            'return_date' => (new Carbon($row['return_date'] . ' ' . $row['return_time']))->toDateTimeString(),
            'return_time' => $row['return_time'],
            'terminal_out' => $row['terminal_out'],
            'terminal_in' => $row['terminal_in'],
            'flight_out' => $row['flight_out'],
            'flight_in' => $row['flight_in'],
            'vehicle' => $row['vehicle'],
            'vehicle_reg' => $row['vehicle_reg'],
            'vehicle_colour' => $row['vehicle_colour'],
            'list_price' => $row['list_price'],
            'price_paid' => $row['price_paid'],
            'supplier_cost' => $row['supplier_cost'],
            'product_id' => $row['product_id']
           
        ];
        if (key_exists('passengers', $row)){
            $bookingData['passengers'] = $row['passengers'];
        }
        if ($booking = Booking::where('ref', $row['booking_ref'])->first()) {
            $booking->status = $row['status'];
            $booking->agent_id = $this->agent['id'];
            $booking->agents_products_id = $row['product_id'];
            $booking->product_id = $this->getProduct($this->agent['id'], $row['product_id']);
            $booking->booking_data = $bookingData;

        } else {
            $booking = new Booking([
                'agent_id' => $this->agent['id'],
                'agents_products_id' => $row['product_id'],
                'product_id' => $this->getProduct($this->agent['id'], $row['product_id']),
                'ref' => $row['booking_ref'],
                'status' => $row['status'],
                'created_at' => $row['created_at']
            ]);
            $booking->booking_data = $bookingData;
        }
        $booking->save();
        return $booking;
    }
    
    public function getProduct($agentId, $productId)
    {
        $agentProduct = AgentProduct::where('agent_id', $agentId)->where('agent_code', $productId)->first();
        
        return $agentProduct->product->id;
        
        
    }
}
