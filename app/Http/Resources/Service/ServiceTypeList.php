<?php

namespace App\Http\Resources\Service;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DepartmentList
 * @package App\Http\Resources\Project
 */
class ServiceTypeList extends JsonResource
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
//            'service_type' => $this->service_type->name_en?? null,
            'service_type_id' => $this->service_type_id,
//            'payment_method' => $this->payment_method->name_en?? null,
            'payment_method_id' => $this->payment_method_id,
//            'service_method' => $this->service_method->name_en?? null,
//            'project' => $this->project->name_en ?? null,
            'total_usd' => $this->total_usd,
            'requester' => $this->service_requester->full_name,
            'currency_type' => $this->currency->name_en ?? null,
            'currency_id' => $this->currency->id ?? null,
            'completed' => $this->completed,
            'status_id' => $this->status_id ,
//            'status' => $this->status->name_en ,
            'c_total' => $this->c_total ,
            'created_at' => Carbon::parse ($this->created_at)->format ('Y-m-d') ,
        ] ;
    }
    public function withResponse($request, $response)
    {
        $response->header('X-Value', 'True');
    }
}
