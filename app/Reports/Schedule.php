<?php

namespace App\Reports;

use App\Exports\ScheduleExport;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Schedule extends Report
{
    public $date;

    /**
     * Schedule constructor.
     * @param Request $request
     * @throws \Exception
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->date = (new Carbon($request['date']));
    }

    public function download()
    {
        return (new ScheduleExport($this))->download('export.xls', \Maatwebsite\Excel\Excel::XLS);
    }
}
