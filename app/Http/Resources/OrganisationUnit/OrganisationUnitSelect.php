<?php

namespace App\Http\Resources\OrganisationUnit;

use Illuminate\Http\Resources\Json\JsonResource;

class OrganisationUnitSelect extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            'id' => $this->id,
            'text' => $this->name_en,
            'children' => true,
        ];
    }
}
