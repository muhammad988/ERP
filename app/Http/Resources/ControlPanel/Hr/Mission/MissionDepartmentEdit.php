<?php

namespace App\Http\Resources\ControlPanel\Hr\Mission;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DepartmentList
 * @package App\Http\Resources\Project
 */
class MissionDepartmentEdit extends JsonResource
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
            'department_id' => $this->department_id,
            'department_name_en' => $this->department->name_en,
            'department_name_ar' => $this->department->name_ar,
            'parent_id' => $this->parent_id,
            'parent_name_en' => $this->parent->name_en,
            'parent_name_ar' => $this->parent->name_ar,
            'status' => $this->status,
            'start_date' => Carbon::parse($this->start_date)->format('Y-m-d') ,
            'end_date' => Carbon::parse($this->end_date)->format('Y-m-d') ,
        ] ;
    }
//    public function withResponse($request, $response)
//    {
//        $response->header('X-Value', 'True');
//    }
}
