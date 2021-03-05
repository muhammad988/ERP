<?php

namespace App\Imports\Clearance;

use App\Model\Service\ServiceInvoice;
use Maatwebsite\Excel\Concerns\ToModel;

class ClearanceImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ServiceInvoice([
            'invoice_number'     => $row[0],
        ]);
    }
}
