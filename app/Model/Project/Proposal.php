<?php

namespace App\Model\Project;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Model\Project\Proposal
 *
 * @property int $id
 * @property int|null $project_id
 * @property string|null $indirect_beneficiaries
 * @property int|null $catchment_area
 * @property string|null $project_summary
 * @property string|null $overall_objective
 * @property string|null $needs_assessment
 * @property float|null $personnel
 * @property float|null $supplies
 * @property float|null $equipment
 * @property float|null $contractual
 * @property float|null $travel
 * @property float|null $transfers
 * @property float|null $general_operating
 * @property float|null $support_costs
 * @property float|null $overhead
 * @property-read \App\Model\Project\Project|null $project
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Proposal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Proposal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Proposal query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Proposal whereCatchmentArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Proposal whereContractual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Proposal whereEquipment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Proposal whereGeneralOperating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Proposal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Proposal whereIndirectBeneficiaries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Proposal whereNeedsAssessment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Proposal whereOverallObjective($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Proposal whereOverhead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Proposal wherePersonnel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Proposal whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Proposal whereProjectSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Proposal whereSupplies($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Proposal whereSupportCosts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Proposal whereTransfers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Proposal whereTravel($value)
 * @mixin \Eloquent
 */
class Proposal extends Model
{
    protected $fillable=['project_id','indirect_beneficiaries','catchment_area','project_summary','overall_objective','needs_assessment'];
    public  $timestamps = false;
    public function project() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
