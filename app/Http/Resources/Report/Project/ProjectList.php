<?php

namespace App\Http\Resources\Report\Project;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DepartmentCollection
 * @package App\Http\Resources\Project
 */
class ProjectList extends JsonResource
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
            'project_id' => $this->project_id,
            'project_code' => $this->project_code,
            'project_name' => $this->project_name,
            'expense' => $this->expense,
            'recerved' => $this->recerved,
            'remaining' => $this->remaining,
            'usable' => $this->usable,
            'total_budget_line' => $this->total_budget_line,
            'account_balance' => $this->project_account,
        ] ;
    }


}
