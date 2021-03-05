<?php

namespace App\Http\Resources\Report\BudgetCategory;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DepartmentCollection
 * @package App\Http\Resources\Project
 */
class BudgetCategoryList extends JsonResource
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
            'budget_category_id' => $this->budget_category_id,
            'budget_category' => $this->budget_category,
            'project_code' => $this->project_code,
            'project_id' => $this->project_id,
            'project_name' => $this->project_name,
            'expense' => $this->expense,
            'received' => $this->recerved,
            'remaining' => $this->remaining,
            'usable' => $this->usable,
            'total_budget' => $this->total_budget_line,
        ] ;
    }


}
