<?php

namespace App\Http\Resources\Service;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DepartmentList
 * @package App\Http\Resources\Project
 */
class ServiceOfficeList extends JsonResource
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
            'service_type' => $this->service_type->name_en?? null,
            'service_type_id' => $this->service_type_id,
            'payment_method' => $this->payment_method->name_en?? null,
            'payment_method_id' => $this->payment_method_id,
            'service_method' => $this->service_method->name_en?? null,
            'office' => $this->mission_budget->name_en ?? null,
            'total' => $this->total_usd,
            'currency_type' => $this->currency->name_en?? null,
            'status_id' => $this->status_id ,
            'status' => $this->status->name_en?? null ,
            'date' => Carbon::parse ($this->created_at)->format ('Y-m-d') ,
        ] ;
    }
    public function withResponse($request, $response)
    {
        $response->header('X-Value', 'True');
    }
}
