<?php

namespace App\Http\Resources\ControlPanel\Hr\NotificationReceiver;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DepartmentList
 * @package App\Http\Resources\NotificationReceiver
 */
class NotificationReceiver extends JsonResource
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
        ];
    }
//    public function withResponse($request, $response)
//    {
//        $response->header('X-Value', 'True');
//    }
}
