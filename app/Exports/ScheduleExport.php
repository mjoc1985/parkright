<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Writer;


class ScheduleExport implements FromView, ShouldAutoSize, WithEvents
{
    use Exportable;
    protected $bookings;
    
    public function __construct($bookings)
    {
        $this->bookings = $bookings;
       
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('reports.schedule', ['bookings' => $this->bookings]);
    }


    public function registerEvents(): array
    {
        return [
            BeforeExport::class  => function(BeforeExport $event) {
                $event->writer->setCreator('Patrick');
            },
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

                $event->sheet->styleCells(
                    'A1:K1',
                    [
                        'font' => [
                            'bold' => true
                        ]
//                        'borders' => [
//                            'outline' => [
//                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
//                                'color' => ['argb' => 'FFFF0000'],
//                            ],
//                        ]
                    ]
                );
            },
        ];
    }
}
