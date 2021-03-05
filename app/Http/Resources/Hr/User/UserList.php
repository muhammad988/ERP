<?php

namespace App\Http\Resources\Hr\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DepartmentList
 * @package App\Http\Resources\Project
 */
class UserList extends JsonResource
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
            'position_name' => $this->position_name ,
            'nationality_name' =>$this->nationality_name,
            'mission_name' =>$this->mission_name,
            'basic_salary' =>$this->basic_salary,
            'gross_salary' =>$this->gross_salary,
            'working_hours' =>$this->working_hours,
            'gender' =>$this->gender_en,
            'start_date' => Carbon::parse($this->start_date)->format('Y-m-d'),
            'end_date' => Carbon::parse($this->end_date)->format('Y-m-d') ,
            'disabled' => $this->disabled ,
        ];
    }
//    public function withResponse($request, $response)
//    {
//        $response->header('X-Value', 'True');
//    }
}
