<?php

namespace App\Http\Resources\DetailedProposalBudget;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DepartmentList
 * @package App\Http\Resources\Project
 */
class DetailedProposalBudgetList extends JsonResource
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
            'budget_line' => $this->budget_line,
            'duration' => $this->duration,
            'donor' => $this->donor_name_en,
            'remaining' => availability($this->id),
            'total' =>  ($this->duration*$this->unit_cost*$this->chf*$this->quantity)/100,
            'category_option_name' =>  $this->category_option_name_en,
//            'remaining' =>  ($this->duration*$this->unit_cost*$this->chf*$this->quantity)/100,

        ] ;
    }
//    public function withResponse($request, $response)
//    {
//        $response->header('X-Value', 'True');
//    }
}
