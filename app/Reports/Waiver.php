<?php

namespace App\Reports;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Waiver extends Report
{
    protected $date;
    protected $bookings;
    
    public function __construct(Carbon $date)
    {
        $this->date = $date->format('d-m-Y');
        $this->bookings = new Collection();
        parent::__construct();
    }
    
    public function build($bookingCollection)
    {
         foreach ($bookingCollection as $booking){
            $this->bookings->push($this->setData($booking));
        }
         return $this->bookings;
         //dd($this->bookings);
       
    }
    
    public function setData($booking)
    {
        return [
            'ref'            => $booking['ref'],
            'name'           => $this->getName($booking),
            'terminal'       => $booking['booking_data']['terminal_out'],
            'stay'           => $this->getLengthOfStay($booking),
            'arrival_date'   => $booking['booking_data']['arrival_date'],
            'time'           => Carbon::createFromFormat('H:i', $booking['booking_data']['arrival_time'])->format('H:i'),
            'return_date'    => $booking['booking_data']['return_date'],
            'return_time'    => $booking['booking_data']['return_date'] .' '. $booking['booking_data']['return_time'],
            'vehicle_reg'    => $booking['booking_data']['vehicle_reg'],
            'vehicle'        => $booking['booking_data']['vehicle'],
            'vehicle_colour' => $booking['booking_data']['vehicle_colour'],
            'flight'         => $booking['booking_data']['flight_in'],
            'mobile'         => $booking['booking_data']['mobile'],
//            'passengers'   => $booking['booking_data']['passengers'],
            'sort'           => $this->createTimeStamp($booking['booking_data']['arrival_date'] .' '.$booking['booking_data']['arrival_time'])
        ];
        
    }

    public function getName($booking)
    {
        return $booking['booking_data']['title'] . ' ' . $booking['booking_data']['first_name'] . ' ' . $booking['booking_data']['last_name'];
    }

    public function getLengthOfStay($booking)
    {
        $arrival = Carbon::createFromFormat('d-m-Y', $booking['booking_data']['arrival_date']);
        $return = Carbon::createFromFormat('d-m-Y', $booking['booking_data']['return_date']);
        return $arrival->diffInDays($return);
    }

    public function createTimeStamp($date)
    {
        $date = Carbon::createFromFormat('d-m-Y H:i', $date)->format('Y-m-d H:i:s');
        return $date;
    }
}
