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
        $this->dateFrom = (new Carbon($request['dateFrom']))->format('d-m-Y');
        $this->dateTo = (new Carbon($request['dateTo']))->format('d-m-Y');
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
}
