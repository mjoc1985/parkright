<?php

namespace App\Reports;

use Carbon\Carbon;
use DemeterChain\C;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Waiver extends Report
{
    public $date;
    public $bookings;


    public function __construct(Request $request)
    {
        $this->date = (new Carbon($request['date']));
        $this->bookings = $this->searchBookings($request);
        parent::__construct($request);
    }
    
    public function build($bookingCollection)
    {
         foreach ($bookingCollection as $booking){
            $this->bookings->push($this->setData($booking));
        }
         return $this->bookings;
         //dd($this->bookings);
       
    }

    /**
     * @param $booking
     * @return array
     * @throws \Exception
     */
    public function setData($booking)
    {
        return array(
            'ref'            => $booking->ref,
            'name'           => $this->getName($booking),
            'terminal'       => $booking->booking_data->terminal_out,
            'stay'           => $this->getLengthOfStay($booking),
            'arrival_date'   => (new Carbon($booking->booking_data->arrival_date))->format('d-m-Y'),
            'time'           => Carbon::createFromFormat('H:i', $booking->booking_data->arrival_time)->format('H:i'),
            'return_date'    => (new Carbon($booking->booking_data->return_date))->format('d-m-Y'),
            'return_time'    => $booking->booking_data->return_date .' '. $booking->booking_data->return_time,
            'vehicle_reg'    => $booking->booking_data->vehicle_reg,
            'vehicle'        => $booking->booking_data->vehicle,
            'vehicle_colour' => $booking->booking_data->vehicle_colour,
            'flight'         => $booking->booking_data->flight_in,
            'mobile'         => $booking->booking_data->mobile,
            'passengers'     => $booking->booking_data->passengers,
            'sort'           => $booking->booking_data->arrival_date
        );
        
    }

    public function getName($booking)
    {
        return $booking->booking_data->title . ' ' . $booking->booking_data->first_name . ' ' . $booking->booking_data->last_name;
    }

    /**
     * @param $booking
     * @return int
     * @throws \Exception
     */
    public function getLengthOfStay($booking)
    {
        $arrival = (new Carbon($booking->booking_data->arrival_date));
        $return =(new Carbon($booking->booking_data->return_date));
        return $arrival->diffInDays($return);
    }

    public function createTimeStamp($date)
    {
        $date = Carbon::createFromFormat('d-m-Y H:i', $date)->format('Y-m-d H:i:s');
        return $date;
    }
}
