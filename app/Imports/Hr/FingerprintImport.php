<?php

namespace App\Imports\Hr;

use Auth;
use App\Model\Hr\User;
use App\Model\Hr\Fingerprint;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

/**
 * Class FingerprintImport
 * @package App\Imports\Hr
 */
class FingerprintImport implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    private $rows_count = 0;
    private $error_rows_count = 0;
    private $error_rows= [];
    private $success_rows_count = 0;

    /**
     * @param array $row
     *
     * @return Model|Model[]|null
     */
    public function model (array $row)
    {
        ++$this->rows_count;
        $user = User::where ('financial_code', $row['pin'])->select ('id')->first ();
        $index = Fingerprint::where ('index', $row['index'])->select ('id')->first ();
        if (!is_null ($user) && is_null ($index) ) {
            ++$this->success_rows_count;
            return new Fingerprint([
                'stored_by'      => Auth::user ()->full_name,
                'financial_code' => $row['pin'],
                'user_id'        => $user->id,
                'time'           => $row['time'],
                'device'         => $row['device'],
                'index'          => $row['index'],
                'state'          => trim ($row['state']),
            ]);
        }else{
            ++$this->error_rows_count;
            $this->error_rows[]=$row['index'];
        }
    }

    public function batchSize (): int
    {
        return 1000;
    }

    public function chunkSize (): int
    {
        return 1000;
    }

    public function headingRow (): int
    {
        return 1;
    }

    public function get_row_count (): int
    {
        return $this->rows_count;
    }
    public function get_success_row_count (): int
    {
        return $this->success_rows_count;
    }
    public function get_error_row_count (): int
    {
        return $this->error_rows_count;
    }
    public function get_error_row (): array
    {
        return $this->error_rows;
    }

}
