<?php

namespace App\Http\Resources\Report\Budget;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DepartmentCollection
 * @package App\Http\Resources\Project
 */
class BudgetList extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request):array
    {
        return[
            'id' => $this->id,
            'project_code' => $this->project_code,
            'budget_line' => $this->budget_line,
            'category_option' => $this->category_option,
            'expense' => $this->expense,
            'received' => $this->recerved,
            'remaining' => $this->remaining,
            'usable' => $this->usable,
            'total_budget_line' => $this->total_budget_line,
        ] ;
    }


}
