<?php

namespace App\Http\Controllers;

use App\Booking;
use Carbon\Carbon;
use DemeterChain\B;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function revenue()
    {
        return response([
            'total' => $this->totalRevenue(),
            'week' => $this->totalWeek(),
            'month' => $this->totalMonth(),
            'year' => $this->totalYear()
        ]);
    }

    public function commission()
    {
        return response([
            'total' => $this->totalRevenue() / 100 * 75,
            'week' => $this->totalWeek() / 100 * 75,
            'month' => $this->totalMonth() / 100 * 75,
            'year' => $this->totalYear() / 100 * 75
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function overview()
    {
        return response([
            'currentCount' => $this->getCurrentBookingCount(),
            'today' => $this->overviewToday(),
            'week' => $this->overviewWeek(),

        ]);
    }


    /**
     * @return float
     */
    public function totalRevenue()
    {
        $total = collect();
        $bookings = Booking::all();
        $bookings->each(function ($booking) use ($total) {
            $total->push($booking->booking_data->price_paid);
        });
        return (float)$total->sum();
    }

    public function totalWeek()
    {
        $start = Carbon::today()->startOfWeek()->format('d-m-Y');
        $end = Carbon::today()->format('d-m-Y');
        $bookings = Booking::whereBetween('booking_data->arrival_date', [$start, $end])->get();
        $total = collect();
        $bookings->each(function ($booking) use ($total) {
            $total->push($booking->booking_data->price_paid);
        });

        return (float)$total->sum();
    }

    public function totalMonth()
    {
        $start = Carbon::today()->startOfMonth()->format('d-m-Y');
        $end = Carbon::today()->format('d-m-Y');

        $bookings = Booking::whereBetween('booking_data->arrival_date', [$start, $end])->get();

        $total = collect();
        $bookings->each(function ($booking) use ($total) {
            $total->push($booking->booking_data->price_paid);
        });

        return (float)$total->sum();
    }

    public function totalYear()
    {
        $start = Carbon::today()->startOfYear()->format('d-m-Y');
        $end = Carbon::today()->format('d-m-Y');

        $bookings = Booking::whereBetween('booking_data->arrival_date', [$start, $end])->get();

        $total = collect();
        $bookings->each(function ($booking) use ($total) {
            $total->push($booking->booking_data->price_paid);
        });

        return (float)$total->sum();
    }

    public function getCurrentBookingCount()
    {
        $collection = collect();
        $bookings = Booking::all();
        $date = Carbon::today();

        $bookings->each(function ($booking) use ($date, $collection) {
            $arrival = (new Carbon($booking->booking_data->arrival_date));
            $return = (new Carbon($booking->booking_data->return_date));
            if ($arrival < $date && $return > $date) {
                $collection->push($booking);
            }
        });

        return $collection->count();
    }

    /**
     * @return \Illuminate\Support\Collection
     * @throws \Exception
     */
    public function overviewToday()
    {
        return $this->overviewGet(Carbon::today());
    }

    /**
     * @throws \Exception
     */
    public function overviewWeek()
    {
        $start = Carbon::tomorrow();
        $collection = collect();

        for ($date = new Carbon($start); $date->lte((new Carbon($start))->addWeek()); $date->addDay()) {

            $collection->put($date->format('d-m-Y'),$this->overviewGet($date));
        }
        return $collection;
    }


    public function overviewGet(Carbon $date)
    {
        $date = $date->format('d-m-Y');
        $arrivals = Booking::where('booking_data->arrival_date', $date)->get();
        $returns = Booking::where('booking_data->return_date', $date)->get();

        $collection = collect([
            'in' => $arrivals->count(),
            'out' => $returns->count()
        ]);
        return $collection;
    }

}
