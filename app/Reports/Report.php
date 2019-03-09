<?php

namespace App\Reports;

use App\Booking;
use App\Search\BookingSearch;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Report
{
    public $type;
    public $bookings;
    public $serviceType;
    
    public function __construct(Request $request)
    {
        $this->type             = $request['type'] ?: 'both';
        $this->serviceType      = $request['service'];
        $this->bookings         = $this->search($request);

    }

    /**
     * Arrival date for use with exports.
     * 
     * @param $booking
     * @return array
     */
    public function setArrivalsData($booking)
    {
        return [
            'ref'          => $booking->ref,
            'name'         => $this->getName($booking),
            'terminal'     => $booking->booking_data->terminal_out,
            'stay'         => $this->getLengthOfStay($booking),
            'arrival'      => $booking->booking_data->arrival_date,
            'time'         => Carbon::createFromFormat('H:i', $booking->booking_data->arrival_time)->format('H:i'),
            'return'       => $booking->booking_data->return_date,
            'return_time'  => $booking->booking_data->return_time,
            'vehicle_reg'  => $booking->booking_data->vehicle_reg,
            'vehicle'      => $booking->booking_data->vehicle,
            'flight'       => $booking->booking_data->flight_out,
            'mobile'       => $booking->booking_data->mobile,
            'passengers'   => $booking->booking_data->passengers,
            'type'         => 'In',
            'sort'         => $this->createTimeStamp($booking->booking_data->arrival_date .' '.$booking->booking_data->arrival_time)
        ];
    }

    /**
     * Return date for use with exports.
     * 
     * @param $booking
     * @return array
     */
    public function setReturnsData($booking)
    {
        
        return [
            'ref'          => $booking->ref,
            'name'         => $this->getName($booking),
            'terminal'     => $booking->booking_data->terminal_in,
            'stay'         => $this->getLengthOfStay($booking),
            'arrival'      => $booking->booking_data->arrival_date,
            'time'         => Carbon::createFromFormat('H:i', $booking->booking_data->return_time)->format('H:i'),
            'vehicle_reg'  => $booking->booking_data->vehicle_reg,
            'vehicle'      => $booking->booking_data->vehicle,
            'flight'       => $booking->booking_data->flight_in,
            'mobile'       => $booking->booking_data->mobile,
            'return'       => $booking->booking_data->return_date,
            'return_time'  => $booking->booking_data->return_time,
            'passengers'   => $booking->booking_data->passengers,
            'type'         => 'Out',
            'sort'         => $this->createTimeStamp($booking->booking_data->return_date.' '. $booking->booking_data->return_time)
        ];
    }

    /**
     * Returns customer name and title string.
     * 
     * @param $booking
     * @return string
     */
    public function getName($booking)
    {
        return $booking->booking_data->title . ' ' . $booking->booking_data->first_name . ' ' . $booking->booking_data->last_name;
    }

    /** 
     * Search and process bookings ready for exporting.
     * 
     * @param $request
     * @return \Illuminate\Support\Collection
     */
    public function search($request)
    {
        return $this->processForExport($this->searchBookings($request));
    }

    /**
     * Search Bookings and returns incoming and outgoing collections.
     * 
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function searchBookings(Request $request)
    {
        return BookingSearch::filter($request);
    }

    /**
     * Calculate the length of stay.
     * 
     * @param $booking
     * @return int
     */
    public function getLengthOfStay($booking)
    {
        $arrival = Carbon::parse($booking->booking_data->arrival_date);
        $return = Carbon::parse($booking->booking_data->return_date);
        return $arrival->diffInDays($return);
    }

    /**
     * @param $date
     * @return string
     */
    public function createTimeStamp($date)
    {   
        $date = Carbon::createFromFormat('d-m-Y H:i', $date)->format('Y-m-d H:i:s');
        return $date;
    }

    /**
     * Get all arrivals for specified date.
     * 
     * @param $date
     * @return mixed
     */
    public function getArrivals($date)
    {
        return Booking::where('booking_data->arrival_date', $date->format('d-m-Y'))->get();
    }

    /**
     * Get all returns for specified date.
     * 
     * @param $date
     * @return mixed
     */
    public function getReturns($date)
    {
        return Booking::where('booking_data->return_date', $date->format('d-m-Y'))->get();
    }

    /**
     * Process and combines all bookings for export. All date is then sorted by the date/time.
     * 
     * @param $bookings
     * @return \Illuminate\Support\Collection
     */
    public function processForExport($bookings)
    {
        $type = $this->type;
        
        $collection = Collect();
        
        if ($type == 'both' || $type == 'in'){
        $bookings['incoming']->each(function ($booking) use ($collection){
            $collection->push($this->setArrivalsData($booking));
        });
        }
        
        if ($type == 'both' || $type == 'out') {
            $bookings['outgoing']->each(function ($booking) use ($collection) {
                $collection->push($this->setReturnsData($booking));
            });
        }

        return $collection->sortBy('sort');
    }
    
    
}
