<?php

namespace App\Http\Resources\Sector;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class SectorCollection
 * @package App\Http\Resources\Sector
 */
class SectorCollection extends ResourceCollection
{
    public $collects = 'App\Http\Resources\Sector\SectorList';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request):array
    {
        return  ['items'=>$this->collection];
    }
}
