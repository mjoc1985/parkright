<?php

namespace App\Search;

use App\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingSearch
{
    /**
     * @param Request $filters
     * @return \Illuminate\Support\Collection
     * @throws \Exception
     */
    public static function filter(Request $filters)
    {
        $arrivals = (new Booking)->newQuery();
        $returns = (new Booking)->newQuery();
        //dd($arrivals);
        //dd(new Carbon($filters->input('dateTo')));
        
        // Search for all bookings for a specific date. Used for daily schedule.
        if ($filters->has('date')) {
            $arrivals->whereBetween('booking_data->arrival_date', [
                (new Carbon($filters->input('date')))->startOfDay()->toDateTimeString(),
                (new Carbon($filters->input('date')))->endOfDay()->toDateTimeString()
            ]);
            $returns->whereBetween('booking_data->return_date', [
                (new Carbon($filters->input('date')))->startOfDay()->toDateTimeString(),
                (new Carbon($filters->input('date')))->endOfDay()->toDateTimeString()
            ]);        }
//        // From date for booking range search.
        if ($filters->has('dateFrom') && !$filters->has('dateTo')) {
            $arrivals->whereBetween('booking_data->arrival_date', [
                (new Carbon($filters->input('dateFrom')))->startOfDay()->toDateTimeString(),
                (new Carbon($filters->input('dateFrom')))->endOfDay()->toDateTimeString()
            ]);        }
//        // To date for booking range search.
        if ($filters->has('dateTo') && !$filters->has('dateFrom')) {
            $returns->whereBetween('booking_data->return_date', [
                (new Carbon($filters->input('dateTo')))->startOfDay()->toDateTimeString(),
                (new Carbon($filters->input('dateTo')))->endOfDay()->toDateTimeString()
            ]);        }
        // Bookings between dateFrom and dateTo.
        if ($filters->has('dateFrom') && $filters->has('dateTo')) {
            $arrivals->whereBetween('booking_data->arrival_date', [
                (new Carbon($filters->input('dateFrom')))->startOfDay()->toDateTimeString(),
                (new Carbon($filters->input('dateTo')))->endOfDay()->toDateTimeString()
            ]);
            $returns->whereBetween('booking_data->return_date', [
                (new Carbon($filters->input('dateFrom')))->startOfDay()->toDateTimeString(),
                (new Carbon($filters->input('dateTo')))->endOfDay()->toDateTimeString()
            ]);        
        }
        // Service type filter
        if ($filters->has('service')) {
            $arrivals->whereHas('product', function ($query) use ($filters){
               $query->where('products.type', $filters['service']); 
            });
            $returns->whereHas('product', function ($query) use ($filters){
                $query->where('products.type', $filters['service']);
            });
        }
        // Agent filter
        if ($filters->has('agent')) {
            $arrivals->whereHas('agent', function ($query)  use ($filters) {
               $query->where('agents.slug', $filters['agent']); 
            });
            $returns->whereHas('agent', function ($query)  use ($filters) {
                $query->where('agents.slug', $filters['agent']);
            });
        }
        // Product filter
        if ($filters->has('product')) {
            $arrivals->whereHas('product', function ($query)  use ($filters) {
                $query->where('products.id', $filters['product']);
            });
            $returns->whereHas('product', function ($query)  use ($filters) {
                $query->where('products.id', $filters['product']);
            });
        }
      
        return $booking = collect([
            'incoming' => $arrivals->get(),
            'outgoing' => $returns->get()
        ]);
        //dd($booking);
    }
}
