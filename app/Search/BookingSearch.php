<?php

namespace App\Search;

use App\Booking;
use Illuminate\Http\Request;

class BookingSearch
{
    public static function filter(Request $filters)
    {
        $arrivals = (new Booking())->newQuery();
        $returns = (new Booking())->newQuery();
        
        // Search for all bookings for a specific date. Used for daily schedule.
        if ($filters->has('date')) {
            $arrivals->where('booking_data->arrival_date', $filters['date']);
            $returns->where('booking_data->return_date', $filters['date']);
        }
        // From date for booking range search.
        if ($filters->has('dateFrom') && !$filters->has('dateTo')) {
            $arrivals->where('booking_data->arrival_date', $filters['dateFrom']);
        }
        // To date for booking range search.
        if ($filters->has('dateTo') && !$filters->has('dateFrom')) {
            $returns->where('booking_data->return_date', $filters['dateTo']);
        }
        // Bookings between dateFrom and dateTo.
        if ($filters->has('dateFrom') && $filters->has('dateTo')) {
            $arrivals->whereBetween('booking_data->arrival_date', [$filters['dateFrom'], $filters['dateTo']]);
            $returns->whereBetween('booking_data->return_date', [$filters['dateFrom'], $filters['dateTo']]);
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
    }
}
