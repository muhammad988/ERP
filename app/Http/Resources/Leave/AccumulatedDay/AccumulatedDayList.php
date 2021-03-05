<?php

namespace App\Http\Resources\Leave\AccumulatedDay;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class AccumulatedDayList
 * @package App\Http\Resources\Leave\AccumulatedDay
 */
class AccumulatedDayList extends JsonResource
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
            'number_of_days' => $this->number_of_days,
            'year' => $this->year,
            'user_full_name' => $this->user_full_name,
        ] ;
    }

}
