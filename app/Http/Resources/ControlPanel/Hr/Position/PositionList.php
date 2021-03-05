<?php

namespace App\Http\Resources\ControlPanel\Hr\Position;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DepartmentList
 * @package App\Http\Resources\Project
 */
class PositionList extends JsonResource
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
            'id' => $this->id ,
            'name_en' => $this->name_en ,
            'name_ar' => $this->name_ar,
            'department' =>  $this->department->name_en??null,
            'position_category' =>  $this->position_category->name_en??null,
            'position_group' =>  $this->position_group->name_en??null,
            'department_id' =>  $this->department_id,
            'position_group_id' =>  $this->position_group_id,
            'position_category_id' =>  $this->position_category_id,
        ];
    }
//    public function withResponse($request, $response)
//    {
//        $response->header('X-Value', 'True');
//    }
}
