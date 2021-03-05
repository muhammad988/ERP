<?php

namespace App\Http\Resources\Project;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DepartmentList
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
            'id' => $this->id,
            'code' => $this->code,
            'mission' => $this->sector->department->mission->name_en,
            'budget' => $this->project_budget,
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'stage_id' =>  $this->stage->id ?? 1,
            'stage' =>  $this->stage->name_en ?? null,
            'donors' => $this->detailed_proposal_budget()->select('donors.name_en')->groupBy('donors.name_en')->get(),
            'status_id' => $this->status->id ?? 174,
            'status' => $this->status->name_en ?? null,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ] ;
    }
    public function withResponse($request, $response)
    {
        $response->header('X-Value', 'True');
    }
}
