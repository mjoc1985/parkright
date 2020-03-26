<?php

namespace App\Http\Controllers;

use App\Agents;
use App\Booking;
use App\Imports\BookingsImport;
use App\Imports\LCSBookingImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BookingController extends Controller
{
    public function import()
    {
        $agent = Agents::find(request('agent'));

        $file = \request()->file('file');

        if ($agent->slug == 'LCS') {
            Excel::import(new LCSBookingImport($agent), $file);
        } else {
            Excel::import(new BookingsImport($agent), $file);
        }

        return response([
            'status' => 'success',
            'msg' => 'Upload successful',
            'bookings' => Booking::all()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->has('query')) {
            $bookings = Booking::search(request('query'))->paginate(10);

        } else {
            $bookings = Booking::paginate(10);
        }

        $bookings->getCollection()->transform(function ($booking) {
            $booking->agent = $booking->agent;
            $booking->product = $booking->product;

            return $booking;
        });
        return response([
            'status' => 'success',
            'bookings' => $bookings
        ]);
    }

    public function edit($id)
    {
        return Booking::find($id)->load('agent', 'product');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $booking = Booking::find($id);
        try {
            $booking->update($request->except(['agent', 'product']));
        } catch (\Exception $e) {
            return response([
                'status' => 'error',
                'error' => [
                    'msg' => $e->getMessage(),
                    'code' => $e->getCode()
                ]
            ], 422);

        }
        return response([
            'status' => 'success',
            'msg' => 'Booking updated.'
        ], 200);
    }
}
