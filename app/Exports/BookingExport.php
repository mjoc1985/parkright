<?php

namespace App\Exports;

use App\Booking;
use App\Reports\BookingExporter;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;

class BookingExport implements FromView, ShouldAutoSize, WithEvents
{
    use Exportable;
    protected $bookings;
    
    public function __construct(BookingExporter $bookings)
    {
        $this->bookings = $bookings;
    }

    /**
     * @return View
     */
    public function view(): View
    {

        return view('reports.booking-export')->with(['bookings' => $this->bookings->bookings->sortBy('sort'), 'date' => $this->bookings->dateFrom]);
    }

    public function registerEvents(): array
    {
        return [
            BeforeExport::class => function (BeforeExport $event) {
                $event->writer->setCreator('Park Right');

            },
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

                $event->sheet->styleCells(
                    'A1:N1',
                    [
                        'font' => [
                            'bold' => true
                        ],
                        'borders' => [
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                //'color' => ['argb' => 'FFFF0000'],
                            ],
                        ]
                    ]
                );
            },
        ];
    }
    public function setArrivalsData($booking)
    {
        return [
            'ref'          => $booking['ref'],
            'name'         => $this->getName($booking),
            'terminal'     => $booking['booking_data']['terminal_out'],
            'stay'         => $this->getLengthOfStay($booking),
            'time'         => Carbon::createFromFormat('H:i', $booking['booking_data']['arrival_time'])->format('H:i'),
            'return'       => $booking['booking_data']['return_date'] .' '. $booking['booking_data']['return_time'],
            'vehicle_reg'  => $booking['booking_data']['vehicle_reg'],
            'vehicle'      => $booking['booking_data']['vehicle'],
            'flight'       => $booking['booking_data']['flight_out'],
            'mobile'       => $booking['booking_data']['mobile'],
            'passengers'   => $booking['booking_data']['passengers'],
            'sort'         => $this->createTimeStamp($booking['booking_data']['arrival_date'] .' '.$booking['booking_data']['arrival_time'])
        ];
    }

    public function setReturnsData($booking)
    {
        return [
            'ref'          => $booking['ref'],
            'name'         => $this->getName($booking),
            'terminal'     => $booking['booking_data']['terminal_in'],
            'stay'         => $this->getLengthOfStay($booking),
            'time'         => Carbon::createFromFormat('H:i', $booking['booking_data']['return_time'])->format('H:i'),
            'vehicle_reg'  => $booking['booking_data']['vehicle_reg'],
            'vehicle'      => $booking['booking_data']['vehicle'],
            'flight'       => $booking['booking_data']['flight_in'],
            'mobile'       => $booking['booking_data']['mobile'],
            'return'       => null,
            'passengers'   => $booking['booking_data']['passengers'],
            'sort'         => $this->createTimeStamp($booking['booking_data']['return_date'].' '. $booking['booking_data']['return_time'])
        ];
    }
    
}
