<?php

namespace App\Http\Resources\OrganisationUnit;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\OrganisationUnit\OrganisationUnitSelect;

class OrganisationUnitSelectCollection extends ResourceCollection
{

    public $collects = OrganisationUnitSelect::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return  ['data'=>$this->collection];
    }
}
