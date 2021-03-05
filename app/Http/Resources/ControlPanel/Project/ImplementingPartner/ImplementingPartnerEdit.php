<?php

namespace App\Http\Resources\ControlPanel\Project\ImplementingPartner;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Donor
 * @package App\Http\Resources\Donor
 */
class ImplementingPartnerEdit extends JsonResource
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
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'account' => $this->implementing_partner_accounts,
        ] ;
    }
}
