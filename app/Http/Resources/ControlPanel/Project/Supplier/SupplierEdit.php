<?php

namespace App\Http\Resources\ControlPanel\Project\Supplier;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * Class SupplierEdit
 * @package App\Http\Resources\ControlPanel\Project\Supplier
 */
class SupplierEdit extends JsonResource
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
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'email' => $this->email,
            'place' => $this->place,
            'phone_number' => $this->phone_number,
            'account' => $this->supplier_accounts,
        ] ;
    }
}
