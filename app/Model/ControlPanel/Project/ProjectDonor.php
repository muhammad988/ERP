<?php

namespace App\Model\ControlPanel\Project;


use Eloquent;
use App\Model\Project\Project;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;


/**
 * App\Model\ControlPanel\Project\ProjectDonor
 *
 * @property int $project_id
 * @property int $donor_id
 * @property string|null $project_name_en
 * @property string|null $project_name_ar
 * @property string|null $project_code
 * @property float|null $monetary
 * @property float|null $in_kind
 * @property string|null $proposal_file
 * @property string|null $budget_file
 * @property string|null $agreement_file
 * @property string|null $delegation_file
 * @property string|null $financial_documents_file
 * @property string|null $raca_file
 * @property string|null $amendment_file
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $storedby
 * @property string|null $modifiedby
 * @property-read Collection|Project[] $projects
 * @property-read int|null $projects_count
 * @method static Builder|ProjectDonor newModelQuery()
 * @method static Builder|ProjectDonor newQuery()
 * @method static Builder|ProjectDonor query()
 * @method static Builder|ProjectDonor whereAgreementFile($value)
 * @method static Builder|ProjectDonor whereAmendmentFile($value)
 * @method static Builder|ProjectDonor whereBudgetFile($value)
 * @method static Builder|ProjectDonor whereCreatedAt($value)
 * @method static Builder|ProjectDonor whereDelegationFile($value)
 * @method static Builder|ProjectDonor whereDonorId($value)
 * @method static Builder|ProjectDonor whereFinancialDocumentsFile($value)
 * @method static Builder|ProjectDonor whereInKind($value)
 * @method static Builder|ProjectDonor whereModifiedby($value)
 * @method static Builder|ProjectDonor whereMonetary($value)
 * @method static Builder|ProjectDonor whereProjectCode($value)
 * @method static Builder|ProjectDonor whereProjectId($value)
 * @method static Builder|ProjectDonor whereProjectNameAr($value)
 * @method static Builder|ProjectDonor whereProjectNameEn($value)
 * @method static Builder|ProjectDonor whereProposalFile($value)
 * @method static Builder|ProjectDonor whereRacaFile($value)
 * @method static Builder|ProjectDonor whereStoredby($value)
 * @method static Builder|ProjectDonor whereUpdatedAt($value)
 * @mixin Eloquent
 */
class ProjectDonor extends Model
{
    protected $table='projects_donors';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $guarded = [];
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'projects_donors');
    }
}
