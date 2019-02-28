<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Exports\ScheduleExport;
use App\Report;
use App\Schedule;
use App\Waiver;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;


class ReportController extends Controller
{
    public function schedulePreview(Request $request)
    {
        $bookings = $this->fetchBookings($request['date'], $request['type']);
        return view('reports.schedule', compact('bookings'));

    }

    public function fetchBookings($date, $type = null)
    {
        $collection = collect();
        $incoming = Booking::where('booking_data->arrival_date', '=', $date)->get();
        $outgoing = Booking::where('booking_data->return_date', $date)->get();

        if ($type == 'both' || $type == 'in') {
           $collection->put('incoming', $incoming);
        } if ($type == 'both' || $type == 'out') {
            $collection->put('outgoing', $outgoing);
        }

        

        return (new Schedule(Carbon::createFromFormat('d-m-Y', $date)))->build($collection->toArray());
    }

    public function scheduleExport(Request $request)
    {
        return $export = (new ScheduleExport($this->fetchBookings($request['date'], $request['type'])))->download($request['date'] . '.xls');

    }

    public function waivers(Request $request)
    {
        set_time_limit(0);
        $bookings = Booking::where('booking_data->arrival_date', $request['date'])->get();
        $bookings = (new Waiver(Carbon::createFromFormat('d-m-Y', $request['date'])))->build($bookings);
        $html = view('reports.pdf-waiver', compact('bookings'));
        //$pdf = App::make('dompdf.wrapper');
        $pdf = PDF::loadHtml($html);
        //$pdf->setBasePath('/css/app.css');
        return $pdf->stream('waivers.pdf');

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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Report $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Report $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Report $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Report $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }
}
