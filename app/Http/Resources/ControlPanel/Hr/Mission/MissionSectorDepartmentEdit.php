<?php

namespace App\Http\Resources\ControlPanel\Hr\Mission;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DepartmentList
 * @package App\Http\Resources\Project
 */
class MissionSectorDepartmentEdit extends JsonResource
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
            'department_name_en' => $this->department->department->name_en,
            'department_name_ar' => $this->department->department->name_ar,
            'sector_name_en' => $this->sector->name_en,
            'sector_name_ar' => $this->sector->name_ar,
        ] ;
    }
//    public function withResponse($request, $response)
//    {
//        $response->header('X-Value', 'True');
//    }
}
