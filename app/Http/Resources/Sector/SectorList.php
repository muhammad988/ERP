<?php

namespace App\Http\Resources\Sector;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Sector
 * @package App\Http\Resources\Sector
 */
class SectorList extends JsonResource
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
            'sector_id' => $this->sector_id,
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
        ] ;
    }
}
