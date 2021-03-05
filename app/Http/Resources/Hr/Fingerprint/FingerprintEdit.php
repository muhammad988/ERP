<?php

namespace App\Http\Resources\Hr\Fingerprint;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * Class FingerprintEdit
 * @package App\Http\Resources\Hr\Fingerprint
 */
class FingerprintEdit extends JsonResource
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
            'time' => Carbon::parse($this->time)->format('H:i'),
            'day' => Carbon::parse($this->time)->format('Y-m-d'),
            'state' => trim ($this->state) ,
        ];
    }
//    public function withResponse($request, $response)
//    {
//        $response->header('X-Value', 'True');
//    }
}
