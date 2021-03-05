<?php

namespace App\Http\Resources\Hr\Fingerprint;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * Class FingerprintList
 * @package App\Http\Resources\Hr\Fingerprint
 */
class FingerprintList extends JsonResource
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
            'financial_code' => $this->financial_code ,
            'user_full_name_en' => $this->user_full_name_en,
            'user_full_name_ar' => $this->user_full_name_ar ,
            'time' => Carbon::parse($this->time)->format('Y-m-d h:i a'),
            'device' => $this->device ,
            'state' => trim ($this->state) ,
        ];
    }
//    public function withResponse($request, $response)
//    {
//        $response->header('X-Value', 'True');
//    }
}
