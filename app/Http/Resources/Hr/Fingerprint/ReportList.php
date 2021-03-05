<?php

namespace App\Http\Resources\Hr\Fingerprint;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * Class ReportList
 * @package App\Http\Resources\Hr\Fingerprint
 */
class ReportList extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */

    public function toArray($request):array
    {
       $data= work_hours($this->start_date,$this->end_date,$this->user_id,['d' => $this->assumed_work_status]);
        return[
            'id' => $this->id ,
            'financial_code' => $this->financial_code ,
            'user_full_name_ar' => $this->user_full_name_ar,
            'user_id' => $this->user_id,
            'assumed_work_status' => $this->assumed_work_status,
            'center' => $this->center_name_ar,
            'position_name_ar' => $this->position_name_ar,
            'work_hours' =>  $this->start_date != $this->end_date ?  gmdate("H:i:s",$data['time']) : '' ,
            'start_date' => Carbon::parse($this->start_date)->format('Y-m-d'),
            'assumed_entry' => $this->start_date != $this->end_date ?  Carbon::parse($this->start_date)->format('Y-m-d h:i a') : "",
            'assumed_exit' =>  $this->start_date != $this->end_date ?  Carbon::parse($this->end_date)->format('Y-m-d h:i a') : "",
            'entry' =>$data['entry'],
            'exit' =>$data['exit'],
            'work_status' => $this->start_date != $this->end_date ?  $data['type'] : ['d' => $this->assumed_work_status],
        ];
    }
//    public function withResponse($request, $response)
//    {
//        $response->header('X-Value', 'True');
//    }
}
