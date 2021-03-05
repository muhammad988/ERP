<?php

namespace App\Http\Resources\ControlPanel\Hr\NotificationCycle;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DepartmentList
 * @package App\Http\Resources\NotificationCycle
 */
class NotificationCycle extends JsonResource
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
            'name_ar' => $this->name_ar ,
            'group_number' => $this->group_number,
            'number_of_superiors' => $this->number_of_superiors,
            'notification_receiver_id' => $this->notification_receiver_id,
            'notification_receiver' => $this->notification_receiver->name_en,
            'notification_type_id' => $this->notification_type_id,
            'notification_type' => $this->notification_type->name_en,
            'authorized' => $this->authorized,
        ];
    }
//    public function withResponse($request, $response)
//    {
//        $response->header('X-Value', 'True');
//    }
}
