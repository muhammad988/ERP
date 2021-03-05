<?php

namespace App\Http\Resources\Hr\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DepartmentList
 * @package App\Http\Resources\Project
 */
class UserEdit extends JsonResource
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
            'photo' => $this->photo ,
            'first_name_en' => $this->first_name_en." " .$this->last_name_en ,
            'first_name_ar' => $this->first_name_ar." " .$this->last_name_ar ,
            'email' => $this->email ,
            'position' => $this->position->name_en,
            'nationality' =>$this->nationality_id !== null ?   $this->nationality->name_en : "",
            'employment_status' =>$this->employment_status_id !== null ?   $this->employment_status->name_en : "",
            'date' => Carbon::parse($this->start_date)->format('Y-m-d') ,
        ];
    }
//    public function withResponse($request, $response)
//    {
//        $response->header('X-Value', 'True');
//    }
}
