<?php

namespace App\Http\Resources\ControlPanel\Project\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Donor
 * @package App\Http\Resources\Donor
 */
class Category extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray ($request)
    {
        return [
            'id'                 => $this->id,
            'name_en'            => $this->name_en,
            'name_ar'            => $this->name_ar,
            'budget_category_id' => $this->budget_category_id,
        ];
    }
}
