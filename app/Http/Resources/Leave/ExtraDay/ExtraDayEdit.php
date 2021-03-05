<?php

namespace App\Http\Resources\Leave\ExtraDay;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * Class ExtraDayEdit
 * @package App\Http\Resources\Leave\ExtraDay
 */
class ExtraDayEdit extends JsonResource
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
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'hours' => gmdate('H:i', Carbon::parse ($this->end_time)->diffInSeconds($this->start_time)),
            'number_of_days' => $this->number_of_days,
            'year' => $this->year,
            'date' => $this->date,
            'user_id' => $this->user_id,
        ];
    }
//    public function withResponse($request, $response)
//    {
//        $response->header('X-Value', 'True');
//    }
}
