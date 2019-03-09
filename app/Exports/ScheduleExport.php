<?php

namespace App\Exports;

use App\Reports\Schedule;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Writer;


class ScheduleExport implements FromView, ShouldAutoSize, WithEvents
{
    use Exportable;
    public $schedule;
    
    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('reports.schedule', ['schedule' => $this->schedule]);
    }


    public function registerEvents(): array
    {
        return [
            BeforeExport::class  => function(BeforeExport $event) {
                $event->writer->setCreator('Park Right');
                
            },
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                
                $event->sheet->styleCells(
                    'A3:K3',
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
                $event->sheet->styleCells(
                    'A1:A1',
                    [
                        'font' => [
                            'bold' => true
                        ],

                    ]
                );
            },
        ];
    }
}
