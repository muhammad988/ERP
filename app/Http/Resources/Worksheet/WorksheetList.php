<?php

namespace App\Http\Resources\Worksheet;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DepartmentList
 * @package App\Http\Resources\Project
 */
class WorksheetList extends JsonResource
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
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'start_date' => Carbon::parse ($this->start_date)->format ('Y-m-d H:i'),
            'end_date' => Carbon::parse ($this->end_date)->format ('Y-m-d H:i'),
        ] ;
    }
    public function withResponse($request, $response)
    {
        $response->header('X-Value', 'True');
    }
}
