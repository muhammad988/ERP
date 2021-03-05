<?php

namespace App\Http\Resources\ControlPanel\Project\ExchangeRate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Donor
 * @package App\Http\Resources\Currency
 */
class ExchangeRate extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            'id' => $this->id,
            'mission_id' => $this->mission_id,
            'mission' => $this->mission->name_en,
            'currency_id' => $this->currency_id,
            'currency' => $this->currency->name_en,
            'exchange_rate' => $this->exchange_rate,
            'due_date' => $this->due_date,
        ] ;
    }
}
