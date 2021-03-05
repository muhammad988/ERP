<?php

namespace App\Http\Resources\Payroll;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DepartmentList
 * @package App\Http\Resources\Project
 */
class PayrollList extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  $request
     * @return array
     */
    public function toArray($request):array
    {
        return[
            'id' => $this->id,
            'name_en' => $this->name_en,
            'description' => $this->description,
            'month' => $this->month,
            'stored_by' => $this->stored_by,
            'user_count' => $this->payroll_report_users->count(),
        ];
    }

}
