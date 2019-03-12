<?php

namespace App\Http\Controllers;

use App\Agents;
use App\Booking;
use App\Exports\BookingExport;
use App\Exports\ScheduleExport;
use App\Product;
use App\Reports\BookingExporter;
use App\Reports\Schedule;
use App\Reports\Waiver;
use App\Search\BookingSearch;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;


class ReportController extends Controller
{
    /**
     * Preview Schedule
     * 
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function schedulePreview(Request $request)
    {
        $schedule = (new Schedule($request));
        
        return view('reports.schedule', compact('schedule'));
    }

    /**
     * Export Schedule to Excel file
     *
     * @param Request $request
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Exception
     */
    public function scheduleExport(Request $request)
    {
        return (new Schedule($request))->download();

    }

    /**
     * Generate Waivers to PDF file for download.
     *
     * @param Request $request
     * @return mixed
     */
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
     * Booking Export
     *
     * @param Request $request
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Exception
     */
    public function bookingsExport(Request $request)
    {
        return $export = (new BookingExporter($request))->download();
    }

    /**
     * Booking Preview
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function bookingsPreview(Request $request)
    {
        $export = (new BookingExporter($request));
        return view('reports.booking-export', ['bookings' => $export->bookings]);
    }
    
    public function filterData()
    {
        return [
            'agents' => Agents::all()->toArray(),
            'products' => Product::all()->toArray(),
            'serviceType' => [
                'Park and Ride', 'Undercover MG', 'Return MG', 'Meet and Greet'
            ]
        ];
    }
}


   
