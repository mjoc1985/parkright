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
       // return request()->all();
        $agent = Agents::find(request('agent'));
        //return $agent;
        $file = \request()->file('file');
        if ($agent->slug == 'LCS') {
            Excel::import(new LCSBookingImport($agent), $file);
        } else {
            Excel::import(new BookingsImport($agent), $file);
        }
        
        return response([
            'status' => 'success',
            'msg'    => 'Upload successful'
        ]);
    }
    
    public function get()
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        //
    }

    
    public function edit($id)
    {
        return Booking::find($id)->load('agent');   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $booking = Booking::find($id);
        $booking->update($request->except(['agent']));
        return $booking;
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        //
    }
}
