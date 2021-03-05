<?php

namespace App\Http\Resources\ControlPanel\Project\CategoryOption;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Donor
 * @package App\Http\Resources\Donor
 */
class CategoryOption extends JsonResource
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
            'position_group_id' => $this->position_group->id ?? null,
            'position_group' => $this->position_group->name_en ?? null,
            'category' => $this->category->name_en ?? null,
            'category_id' => $this->category->id ?? null,
        ] ;
    }
}
