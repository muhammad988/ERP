<?php

namespace App\Http\Resources\ControlPanel\Hr\NotificationType;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DepartmentList
 * @package App\Http\Resources\NotificationType
 */
class NotificationType extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */

    public function toArray ($request): array
    {
        return [
            'id'          => $this->id,
            'name_en'     => $this->name_en,
            'name_ar'     => $this->name_ar,
            'module_name' => $this->module_name,
        ];
    }
//    public function withResponse($request, $response)
//    {
//        $response->header('X-Value', 'True');
//    }
}
