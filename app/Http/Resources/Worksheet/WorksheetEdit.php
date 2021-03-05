<?php

namespace App\Http\Resources\Worksheet;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DepartmentList
 * @package App\Http\Resources\Project
 */
class WorksheetEdit extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request):array
    {
        return[
            'id' => $this->id,
            'user_id' => $this->user_id,
            'day' => Carbon::parse ($this->start_date)->format ('Y-m-d'),
            'day_1' => $this->start_date,
            'work_status_id' => $this->work_status_id,
            'end_time' => Carbon::parse ($this->end_date)->format ('H:i'),
            'start_time' => Carbon::parse ($this->start_date)->format ('H:i'),
            'name_day' => Carbon::parse ($this->start_date)->isoFormat ('dddd'),
            'add_day' => $this->add_day,
        ] ;
    }

}
