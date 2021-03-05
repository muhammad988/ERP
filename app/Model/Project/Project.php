<?php

namespace App\Model\Project;

use App\Model\Payroll\ProjectVacancy;
use Illuminate\Database\Eloquent\Builder;
use App\Model\ControlPanel\Hr\SectorDepartment;
use App\Model\ControlPanel\Project\Donor;
use App\Model\ControlPanel\Project\ProjectDonorPayment;
use App\Model\OrganisationUnit;
use App\Model\ProjectNotification;
use App\Model\Stage;
use App\Model\Status;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;


/**
 * App\Model\Project\Project
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property string $code
 * @property string|null $start_date
 * @property string|null $end_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $stored_by
 * @property int|null $sector_id
 * @property string|null $actual_start_date
 * @property string|null $actual_end_date
 * @property int|null $manager
 * @property string|null $modified_by
 * @property int|null $status_id
 * @property int|null $stage_id
 * @property int|null $language_id
 * @property float|null $project_budget
 * @property float|null $prosses_av
 * @property string|null $file_plan
 * @property string|null $lang
 * @property int|null $hq_projectstatusid
 * @property int|null $hq_proposalstatusid
 * @property string|null $remarks
 * @property int|null $year
 * @property float|null $totalbeneficiaries
 * @property int|null $hq_projectconfirmationid
 * @property int|null $projectreporttypeid
 * @property string|null $hqnamear
 * @property string|null $hqcode
 * @property string|null $projectoutput
 * @property string|null $qffdcode
 * @property string|null $opscode
 * @property int|null $projectagreementid
 * @property string|null $contractdate
 * @property int|null $focal_point_id
 * @property int|null $organisation_unit_id
 * @property-read Collection|ProposalBeneficiary[] $beneficiaries
 * @property-read int|null $beneficiaries_count
 * @property-read DetailedProposal $detailed_proposal
 * @property-read Collection|DetailedProposalBudget[] $detailed_proposal_budget
 * @property-read int|null $detailed_proposal_budget_count
 * @property-read OrganisationUnit|null $organisation_unit
 * @property-read Collection|Outcome[] $outcomes
 * @property-read int|null $outcomes_count
 * @property-read Collection|ProjectDonorPayment[] $prject_payment
 * @property-read int|null $prject_payment_count
 * @property-read Collection|ProjectAccount[] $project_accounts_payments
 * @property-read int|null $project_accounts_payments_count
 * @property-read Collection|ProjectAccount[] $project_accounts_refunds
 * @property-read int|null $project_accounts_refunds_count
 * @property-read Collection|ProjectNotification[] $project_notification
 * @property-read int|null $project_notification_count
 * @property-read Collection|ProjectVacancy[] $project_vacancies
 * @property-read int|null $project_vacancies_count
 * @property-read Proposal $proposal
 * @property-read Collection|ProposalBudgets[] $proposal_budgets
 * @property-read int|null $proposal_budgets_count
 * @property-read SectorDepartment|null $sector
 * @property-read Stage|null $stage
 * @property-read Status|null $status
 * @property-read Collection|ProposalBeneficiary[] $submission_beneficiaries
 * @method static Builder|Project newModelQuery()
 * @method static Builder|Project newQuery()
 * @method static Builder|Project query()
 * @method static Builder|Project whereActualEndDate($value)
 * @method static Builder|Project whereActualStartDate($value)
 * @method static Builder|Project whereCode($value)
 * @method static Builder|Project whereContractdate($value)
 * @method static Builder|Project whereCreatedAt($value)
 * @method static Builder|Project whereEndDate($value)
 * @method static Builder|Project whereFilePlan($value)
 * @method static Builder|Project whereFocalPointId($value)
 * @method static Builder|Project whereHqProjectconfirmationid($value)
 * @method static Builder|Project whereHqProjectstatusid($value)
 * @method static Builder|Project whereHqProposalstatusid($value)
 * @method static Builder|Project whereHqcode($value)
 * @method static Builder|Project whereHqnamear($value)
 * @method static Builder|Project whereId($value)
 * @method static Builder|Project whereLang($value)
 * @method static Builder|Project whereLanguageId($value)
 * @method static Builder|Project whereManager($value)
 * @method static Builder|Project whereModifiedBy($value)
 * @method static Builder|Project whereNameAr($value)
 * @method static Builder|Project whereNameEn($value)
 * @method static Builder|Project whereOpscode($value)
 * @method static Builder|Project whereOrganisationUnitId($value)
 * @method static Builder|Project whereProjectBudget($value)
 * @method static Builder|Project whereProjectagreementid($value)
 * @method static Builder|Project whereProjectoutput($value)
 * @method static Builder|Project whereProjectreporttypeid($value)
 * @method static Builder|Project whereProssesAv($value)
 * @method static Builder|Project whereQffdcode($value)
 * @method static Builder|Project whereRemarks($value)
 * @method static Builder|Project whereSectorId($value)
 * @method static Builder|Project whereStageId($value)
 * @method static Builder|Project whereStartDate($value)
 * @method static Builder|Project whereStatusId($value)
 * @method static Builder|Project whereStoredBy($value)
 * @method static Builder|Project whereTotalbeneficiaries($value)
 * @method static Builder|Project whereUpdatedAt($value)
 * @method static Builder|Project whereYear($value)
 * @mixin Eloquent
 * @property-read int|null $submission_beneficiaries_count
 */
class Project extends Model
{
    protected $fillable = ['name_en', 'name_ar', 'sector_id', 'start_date', 'end_date', 'project_budget', 'stage_id', 'status_id', 'organisation_unit_id', 'stored_by'];
    protected $guarded = ['modified_by'];

    /**
     * @return HasMany
     */
    public function beneficiaries () : HasMany
    {
        return $this->hasMany (ProposalBeneficiary::class)
            ->join ('project_beneficiary_types', 'project_beneficiaries.project_beneficiary_type_id', '=', 'project_beneficiary_types.id')
            ->whereRaw ('(project_beneficiaries.project_beneficiary_type_id=374764 or project_beneficiaries.project_beneficiary_type_id = 374765)')
            ->select ('project_beneficiaries.*', 'project_beneficiary_types.name_en as type_name_en', 'project_beneficiary_types.name_ar as type_name_ar', 'project_beneficiary_types.id as type_id');
    }

    /**
     * @return HasMany
     */
    public function submission_beneficiaries () : HasMany
    {
        return $this->hasMany (ProposalBeneficiary::class)
            ->join ('project_beneficiary_types', 'project_beneficiaries.project_beneficiary_type_id', '=', 'project_beneficiary_types.id')
            ->join ('organisation_units', 'project_beneficiaries.organisation_unit_id', '=', 'organisation_units.id')
            ->where ('project_beneficiary_type_id', 375445)
            ->select ('project_beneficiaries.*', 'organisation_units.name_en as organisation_unit_name_en', 'organisation_units.name_ar as organisation_unit_name_ar'
                , 'project_beneficiary_types.id as type_id');
    }

    /**
     * @return HasMany
     */
    public function proposal_budgets () : HasMany
    {
        return $this->hasMany (ProposalBudgets::class)->join ('budget_categories', 'proposal_budgets.budget_category_id', '=', 'budget_categories.id')
            ->select ('proposal_budgets.*', 'budget_categories.name_en as budget_name_en', 'budget_categories.name_ar as budget_name_ar', 'budget_categories.id as budget_category_id');
    }

    /**
     * @return HasMany
     */
    public function project_notification () : HasMany
    {
        return $this->hasMany (ProjectNotification::class, 'url_id', 'id');
    }


    /**
     * @return HasMany
     */
    public function detailed_proposal_budget () : HasMany
    {
        return $this->hasMany (DetailedProposalBudget::class)
            ->join ('donors', 'detailed_proposal_budgets.donor_id', '=', 'donors.id')
            ->join ('category_options', 'detailed_proposal_budgets.category_option_id', '=', 'category_options.id')
            ->join ('budget_categories', 'detailed_proposal_budgets.budget_category_id', '=', 'budget_categories.id')
            ->join ('units', 'detailed_proposal_budgets.unit_id', '=', 'units.id')
            ->select ('detailed_proposal_budgets.*', 'units.name_en as unit_name_en', 'units.id as unit_id', 'donors.name_en as donor_name_en',
                'category_options.name_en as category_option_name_en',  'budget_categories.name_en as budget_category_name_en');
    }

    /**
     * @return HasMany
     */
    public function outcomes () : HasMany
    {
        return $this->hasMany (Outcome::class);
    }

    /**
     * @return BelongsTo
     */
    public function organisation_unit () : BelongsTo
    {
        return $this->belongsTo (OrganisationUnit::class);
    }

    /**
     * @return HasOne
     */
    public function proposal () : HasOne
    {
        return $this->hasOne (Proposal::class);
    }

    /**
     * @return HasOne
     */
    public function detailed_proposal () : HasOne
    {
        return $this->hasOne (DetailedProposal::class);
    }

    /**
     * @return BelongsTo
     */
    public function sector () : BelongsTo
    {
        return $this->belongsTo (SectorDepartment::class);
    }

    /**
     * @return BelongsTo
     */
    public function status () : BelongsTo
    {
        return $this->belongsTo (Status::class);
    }

    /**
     * @return BelongsTo
     */
    public function stage () : BelongsTo
    {
        return $this->belongsTo (Stage::class);
    }

    public function donors ()
    {
        return $this->belongsToMany (Donor::class, 'projects_donors')->withPivot ('project_name_en',
            'project_code',
            'monetary',
            'in_kind',
            'proposal_file',
            'delegation_file',
            'agreement_file',
            'budget_file',
            'raca_file');
    }

    public function donor_report ($donor_id)
    {
        return $this->belongsToMany (Donor::class, 'project_reports')->where ('donor_id', $donor_id)->withPivot ('report_type_id',
            'name_en',
            'id',
            'due_date')->get ();
    }

    public function donor_payment ($donor_id)
    {
        return $this->belongsToMany (Donor::class, 'project_donor_payments')->where ('donor_id', $donor_id)->withPivot (
            'payment_number_id',
            'due_date',
            'id',
            'agreed_amount')->get ();
    }

    public function prject_payment ()
    {
        return $this->hasMany  (ProjectDonorPayment::class)->orderBy ('id');
    }
    public function project_vacancies()
    {
        return $this->hasMany(ProjectVacancy::class);
    }

    public function project_accounts_payments()
    {
        return $this->hasMany(ProjectAccount::class)->where ('department_id', 372096)->whereNotNull ('amount');
    }
    public function project_accounts_refunds()
    {
        return $this->hasMany(ProjectAccount::class)->where ('department_id', 372096)->whereNotNull ('refund');
    }
}
