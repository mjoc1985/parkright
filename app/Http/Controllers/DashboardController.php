<?php

namespace App\Http\Controllers;

use App\Booking;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Return revenue data.
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function revenue()
    {
        return response([
            'total' => number_format($this->totalRevenue(), 2),
            'week' => number_format($this->totalWeek(), 2),
            'month' => number_format($this->totalMonth(), 2),
            'year' => number_format($this->totalYear(), 2)
        ]);
    }

    /**
     * Return commission data.
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function commission()
    {
        return response([
            'total' => number_format($this->totalRevenue() / 100 * 70, 2),
            'week' => number_format($this->totalWeek() / 100 * 70, 2),
            'month' => number_format($this->totalMonth() / 100 * 70, 2),
            'year' => number_format($this->totalYear() / 100 * 70, 2)
        ]);
    }

    /**
     * Return overview data.
     *
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
     * Return total revenue data.
     *
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

    /**
     * Return total weekly data.
     *
     * @return float
     */
    public function totalWeek()
    {
        $start = Carbon::today()->startOfWeek()->toDateTimeString();
        $end = Carbon::today()->endOfDay()->toDateTimeString();
        $bookings = Booking::whereBetween('booking_data->arrival_date', [$start, $end])->get();
        $total = collect();
        $bookings->each(function ($booking) use ($total) {
            $total->push($booking->booking_data->price_paid);
        });

        return (float)$total->sum();
    }

    /**
     * Return total month data.
     *
     * @return float
     */
    public function totalMonth()
    {
        $start = Carbon::today()->startOfMonth()->toDateTimeString();
        $end = Carbon::today()->endOfDay()->toDateTimeString();

        $bookings = Booking::whereBetween('booking_data->arrival_date', [$start, $end])->get();

        $total = collect();
        $bookings->each(function ($booking) use ($total) {
            $total->push($booking->booking_data->price_paid);
        });

        return (float)$total->sum();
    }

    /**
     * Return total annual data.
     *
     * @return float
     */
    public function totalYear()
    {
        $start = Carbon::today()->startOfYear()->toDateTimeString();
        $end = Carbon::today()->endOfDay()->toDateTimeString();

        $bookings = Booking::whereBetween('booking_data->arrival_date', [$start, $end])->get();

        $total = collect();
        $bookings->each(function ($booking) use ($total) {
            $total->push($booking->booking_data->price_paid);
        });

        return (float)$total->sum();
    }

    /**
     * Return current booking count.
     *
     * @return int
     */
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
     * Return today's overview.
     *
     * @return \Illuminate\Support\Collection
     * @throws \Exception
     */
    public function overviewToday()
    {
        return $this->overviewGet(Carbon::today());
    }

    /**
     * Return weekly overview data.
     *
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


    /**
     * Return overview.
     *
     * @param Carbon $date
     * @return \Illuminate\Support\Collection
     */
    public function overviewGet(Carbon $date)
    {
        $arrivals = Booking::whereBetween('booking_data->arrival_date', [
            $date->startOfDay()->toDateTimeString(),
            $date->endOfDay()->toDateTimeString()
        ])->get();
        $returns = Booking::whereBetween('booking_data->return_date', [
            $date->startOfDay()->toDateTimeString(),
            $date->endOfDay()->toDateTimeString()
        ])->get();

        $collection = collect([
            'in' => $arrivals->count(),
            'out' => $returns->count()
        ]);
        return $collection;
    }

}
