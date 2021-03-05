<?php

namespace App\Exports\Clearance;
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
class InvoiceFinancialExport    implements    WithTitle,FromView, WithEvents, ShouldAutoSize
{
    private  $service;
    private  $service_parent;
    private  $name;

    /**
     * InvoiceFinancialExport constructor.
     * @param object $service
     * @param $service_parent
     * @param $name
     */
    public function __construct(object $service, $service_parent, $name)
    {
      $this->service=$service;
      $this->service_parent=$service_parent;
      $this->name=$name;
    }
    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
//                 All headers - set font size to 14
                $cellRange = 'A1:G1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getDelegate() ->getStyle('A1:G1000')->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A1:G1')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('A9D08E');
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
        return 'Item';
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('exports.invoices_financial', [
            'service' => $this->service,
            'service_parent' => $this->service_parent,
            'name' => $this->name
        ]);
    }

}
