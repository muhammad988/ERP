<?php

namespace App\Exports\Clearance;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

/**
 * Class InvoiceTemplateExport
 * @package App\Exports\Clearance
 */
class InvoiceTemplateExport    implements    WithHeadings,WithTitle, WithEvents
{

    private  $items;
    private  $units;
    private  $currencies;
    private  $service_items;

    public function __construct(object $service_items,$currencies,$items,$units)
    {
        foreach($service_items as $key=>$service){
            $this->service_items .= $service->id .' - '.$service->detailed_proposal_budget->budget_line .' - '. $service->detailed_proposal_budget->category_option->name_en .' - '. $service->item->name_en  .' - '. $service->quantity*$service->unit_cost.',';
        }

        foreach($currencies as $key=>$currency){
            $this->currencies  .= $currency->id .' - '. $currency->name_en.',';
        }
        foreach($items as $key=>$item){
            $this->items .= $item->id .' - '. $item->name_en.',';
        }
        foreach($units as $key=>$unit){
            $this->units  .= $unit->id .' - '. $unit->name_en.',';
        }
    }

//    public function drawings()
//    {
//        $drawing = new Drawing();
//        $drawing->setName('Logo');
//        $drawing->setDescription('QRCS');
//        $drawing->setPath(public_path('/images/logo/qrcs_heading.jpg'));
//        $drawing->setHeight(60);
//        $drawing->setCoordinates('A1');
//
//        return $drawing;
//    }
    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {

//                 All headers - set font size to 14
//                $cellRange = 'A4:L4';
//                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(6);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(50);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('L')->setWidth(50);

                $objValidation =  $event->sheet->getDataValidation('B2:B1100');
                $objValidation->setType(DataValidation::TYPE_LIST );
                $objValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Value is not in list.');
                $objValidation->setPromptTitle('Pick from list');
                $objValidation->setPrompt('Please pick a value from the drop-down list.');
                $objValidation->setFormula1('"'. $this->service_items.'"');

                $objValidation_items =  $event->sheet->getDataValidation('E2:E1000');
                $objValidation_items->setType(DataValidation::TYPE_LIST );
                $objValidation_items->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $objValidation_items->setAllowBlank(false);
                $objValidation_items->setShowInputMessage(true);
                $objValidation_items->setShowErrorMessage(true);
                $objValidation_items->setShowDropDown(true);
                $objValidation_items->setErrorTitle('Input error');
                $objValidation_items->setError('Value is not in list.');
                $objValidation_items->setPromptTitle('Pick from list');
                $objValidation_items->setPrompt('Please pick a value from the drop-down list.');
                $objValidation_items->setFormula1('"'. $this->items.'"');

                $objValidation_units =  $event->sheet->getDataValidation('F2:F1000');
                $objValidation_units->setType(DataValidation::TYPE_LIST );
                $objValidation_units->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $objValidation_units->setAllowBlank(false);
                $objValidation_units->setShowInputMessage(true);
                $objValidation_units->setShowErrorMessage(true);
                $objValidation_units->setShowDropDown(true);
                $objValidation_units->setErrorTitle('Input error');
                $objValidation_units->setError('Value is not in list.');
                $objValidation_units->setPromptTitle('Pick from list');
                $objValidation_units->setPrompt('Please pick a value from the drop-down list.');
                $objValidation_units->setFormula1('"'. $this->units.'"');

                $objValidation_currencies =  $event->sheet->getDataValidation('I2:I1000');
                $objValidation_currencies->setType(DataValidation::TYPE_LIST );
                $objValidation_currencies->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $objValidation_currencies->setAllowBlank(false);
                $objValidation_currencies->setShowInputMessage(true);
                $objValidation_currencies->setShowErrorMessage(true);
                $objValidation_currencies->setShowDropDown(true);
                $objValidation_currencies->setErrorTitle('Input error');
                $objValidation_currencies->setError('Value is not in list.');
                $objValidation_currencies->setPromptTitle('Pick from list');
                $objValidation_currencies->setPrompt('Please pick a value from the drop-down list.');
                $objValidation_currencies->setFormula1('"'. $this->currencies.'"');
            },
            // Handle by a closure.
            BeforeExport::class => function(BeforeExport $event) {
                $event->writer->getProperties()->setCreator('ERP');
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
    public function headings(): array
    {
        return [
          '#',
            'Service Item',
            'Invoice Number',
            'Invoice Date',
            'Item',
            'Unit',
            'Quantity',
            'Unit Cost',
            'Currency',
            'Exchange Rate',
            'Total Cost',
            'Note'

        ];
    }

}
