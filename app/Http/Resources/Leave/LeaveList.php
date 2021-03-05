<?php

namespace App\Http\Resources\Leave;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DepartmentList
 * @package App\Http\Resources\Project
 */
class LeaveList extends JsonResource
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
            'user_full_name' => $this->user_full_name,
            'leave_type_name' => $this->leave_type_name,
            'leave_days' => $this->leave_days,
            'status_id' => $this->status_id,
            'status_name' => $this->status_name,
            'position_name' => $this->position_name,
            'created_at' => $this->created_at,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ] ;
    }

}
