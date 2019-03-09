<?php

namespace App\Reports;

use App\Exports\BookingExport;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingExporter extends Report
{
    public $dateFrom;
    public $dateTo;

    /**
     * BookingExporter constructor.
     * 
     * @param Request $request
     * @throws \Exception
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->dateFrom = (new Carbon($request['dateFrom']))->startOfDay()->format('d-m-Y H:i:s');
        $this->dateTo = (new Carbon($request['dateTo']))->endOfDay()->format('d-m-Y H:i:s');
    }

    /**
     * Export Bookings to XLS file
     * 
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download()
    {
        return (new BookingExport($this))->download('export.xls', \Maatwebsite\Excel\Excel::XLS);
    }


//    public function fetchBookings()
//    {
//        $incoming = collect();
//        $outgoing = collect();
//        // dd(new Carbon($this->dateFrom));
//        // dd($booking);
//        try {
//            for ($date = new Carbon($this->dateFrom); $date->lte(new Carbon($this->dateTo)); $date->addDay()) {
//                if ($this->type == 'both' || $this->type == 'in') {
//
//                    $this->getArrivals($date)
//                        ->each(function ($booking) use ($incoming) {
//                            $incoming->push($booking);
//                        });
//                }
//                if ($this->type == 'both' || $this->type == 'out') {
//                    $this->getReturns($date)
//                        ->each(function ($booking) use ($outgoing) {
//                            $outgoing->push($booking);
//                        });
//                }
//            }
//        } catch (\Exception $e) {
//            return response([
//                'error' => [
//                    'code' => $e->getCode(),
//                    'message' => $e->getMessage()
//                ]
//            ]);
//        }
//
//
//        $incoming->each(function ($booking, $key) use ($incoming) {
//            $data = $this->setArrivalsData(json_decode($booking));
//            $incoming->forget($key);
//            $incoming->push($data);
//        });
//
//        $outgoing->each(function ($bookingOut, $key) use ($outgoing) {
//            $dataOut = $this->setReturnsData(json_decode($bookingOut));
//            $outgoing->forget($key);
//            $outgoing->push($dataOut);
//        });
//
//        $collection = collect();
//        $incoming->each(function ($booking) use ($collection) {
//            $collection->push($booking);
//        });
//        $outgoing->each(function ($booking) use ($collection) {
//            $collection->push($booking);
//        });
//
//        return $collection;
//    }




}
