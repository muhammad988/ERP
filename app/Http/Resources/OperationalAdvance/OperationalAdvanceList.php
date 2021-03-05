<?php

namespace App\Http\Resources\OperationalAdvance;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Sector
 * @package App\Http\Resources\Sector
 */
class OperationalAdvanceList extends JsonResource
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
            'recipient' => $this->user_recipient->full_name,
            'currency_type' => $this->currency->name_en?? null,
            'completed' => $this->completed,
            'status_id' => $this->status_id ,
            'status' => $this->status->name_en ,
            'date' => Carbon::parse ($this->created_at)->format ('Y-m-d') ,
        ] ;
    }
}
