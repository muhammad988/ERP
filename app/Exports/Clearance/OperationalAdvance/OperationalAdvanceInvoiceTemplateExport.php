<?php

namespace App\Exports\Clearance\OperationalAdvance;

use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class OperationalAdvanceInvoiceTemplateExport    implements  WithHeadings,WithTitle, WithEvents
{
    
    private  $items;
    private  $units;
    private  $currencies;
    private  $service_items;
    
    public function __construct($currencies,$items,$units)
    {
        
        
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
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(50);
                
                
                $objValidation_items =  $event->sheet->getDataValidation('D2:D1000');
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
                
           
                $objValidation_units =  $event->sheet->getDataValidation('E2:E1000');
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
    
                $objValidation_currencies =  $event->sheet->getDataValidation('H2:H1000');
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
