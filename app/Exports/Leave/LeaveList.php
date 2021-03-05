<?php

namespace App\Exports\Leave;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;


/**
 * Class InvoiceFinancialExport
 * @package App\Exports\Clearance
 */
class LeaveList    implements    WithTitle,FromView, ShouldAutoSize,WithEvents
{
    private  $leaves;
    /**
     * InvoiceFinancialExport constructor.
     * @param object $leaves
     */
    public function __construct(object $leaves)
    {
      $this->leaves=$leaves;
    }

//    /**
//     * @return array
//     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $i=$this->leaves->count()+1;

//                 All headers - set font size to 14
                $cellRange = 'A1:Q1';
                $cellRange_2 = 'A1:Q'.$i;

                $styleArray = [
                    'font' => [
                        'bold' => true
                    ],
                ];
                $styleArray_2 = [

                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],

                    ],
                ];
                $event->sheet->getDelegate()->setAutoFilter ($cellRange) ;
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle($cellRange_2)->getFont()->setName('Arial');
                $event->sheet->getDelegate()->getStyle($cellRange_2)->applyFromArray($styleArray_2);
                $event->sheet->getDelegate() ->getStyle($cellRange_2)->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate() ->getStyle('A1');
            },
            // Handle by a closure.
            BeforeExport::class => function(BeforeExport $event) {
                $event->writer->getDelegate ()->getProperties()->setCreator('ERP');
            },
        ];
    }
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Leave';
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('exports.Leave.index', [
            'leaves' => $this->leaves,
        ]);
    }

}
