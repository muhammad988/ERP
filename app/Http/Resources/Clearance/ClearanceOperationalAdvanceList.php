<?php

namespace App\Http\Resources\Clearance;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DepartmentList
 * @package App\Http\Resources\Project
 */
class ClearanceOperationalAdvanceList extends JsonResource
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
            'code' => $this->code,
            'project' => $this->project->name_en ?? null,
            'total' => $this->total_currency,
            'currency_type' => $this->currency->name_en,
            'status_id' => $this->status_id ,
            'status' => $this->status->name_en ,
            'date' => Carbon::parse ($this->created_at)->format ('Y-m-d') ,
        ] ;
    }
//    public function withResponse($request, $response)
//    {
//        $response->header('X-Value', 'True');
//    }
}
