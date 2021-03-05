<?php

namespace App\Http\Resources\Leave\AccumulatedDay;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * Class AccumulatedDayEdit
 * @package App\Http\Resources\Leave\AccumulatedDay
 */
class AccumulatedDayEdit extends JsonResource
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
            'id' => $this->id,
            'number_of_days' => $this->number_of_days,
            'year' => $this->year,
            'user_id' => $this->user_id,
        ];
    }
//    public function withResponse($request, $response)
//    {
//        $response->header('X-Value', 'True');
//    }
}
