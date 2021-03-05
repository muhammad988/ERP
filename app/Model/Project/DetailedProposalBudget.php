<?php

namespace App\Model\Project;

use Eloquent;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use App\Model\ControlPanel\Project\Donor;
use App\Model\Payroll\PayrollReportRecord;
use Illuminate\Database\Eloquent\Collection;
use App\Model\ControlPanel\Project\CategoryOption;
use App\Model\Service\ServiceItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * Class DetailedProposalBudget
 *
 * @package App\Model\Project
 * @property int $id
 * @property int|null $project_id
 * @property int|null $budget_category_id
 * @property int|null $donor_id
 * @property int|null $location
 * @property int|null $category_option_id
 * @property string|null $budget_line
 * @property float|null $quantity
 * @property float|null $unit_cost
 * @property float|null $duration
 * @property float|null $chf
 * @property bool|null $support
 * @property bool|null $in_kind
 * @property bool|null $out_of_administrative_cost
 * @property string|null $justification
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property int|null $unit_id
 * @method static Builder|DetailedProposalBudget newModelQuery()
 * @method static Builder|DetailedProposalBudget newQuery()
 * @method static Builder|DetailedProposalBudget query()
 * @method static Builder|DetailedProposalBudget whereBudgetCategoryId($value)
 * @method static Builder|DetailedProposalBudget whereBudgetLine($value)
 * @method static Builder|DetailedProposalBudget whereCategoryOptionId($value)
 * @method static Builder|DetailedProposalBudget whereChf($value)
 * @method static Builder|DetailedProposalBudget whereCreatedAt($value)
 * @method static Builder|DetailedProposalBudget whereDonorId($value)
 * @method static Builder|DetailedProposalBudget whereDuration($value)
 * @method static Builder|DetailedProposalBudget whereId($value)
 * @method static Builder|DetailedProposalBudget whereInKind($value)
 * @method static Builder|DetailedProposalBudget whereJustification($value)
 * @method static Builder|DetailedProposalBudget whereLocation($value)
 * @method static Builder|DetailedProposalBudget whereModifiedBy($value)
 * @method static Builder|DetailedProposalBudget whereOutOfAdministrativeCost($value)
 * @method static Builder|DetailedProposalBudget whereProjectId($value)
 * @method static Builder|DetailedProposalBudget whereQuantity($value)
 * @method static Builder|DetailedProposalBudget whereStoredBy($value)
 * @method static Builder|DetailedProposalBudget whereSupport($value)
 * @method static Builder|DetailedProposalBudget whereUnitCost($value)
 * @method static Builder|DetailedProposalBudget whereUnitId($value)
 * @method static Builder|DetailedProposalBudget whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read CategoryOption|null $category_option
 * @property-read Collection|ServiceItem[] $service_items
 * @property-read int|null $service_items_count
 * @property string|null $description
 * @property-read Donor|null $donor
 * @property-read Collection|PayrollReportRecord[] $payroll_report_records
 * @property-read int|null $payroll_report_records_count
 * @property-read Project|null $project
 * @method static Builder|DetailedProposalBudget whereDescription($value)
 */
class DetailedProposalBudget extends Model
{
    protected $fillable = ['project_id','budget_category_id','category_option_id','donor_id','budget_line','unit_cost','duration','quantity','chf','support','in_kind','out_of_administrative_cost','unit_id','description','stored_by'];
    protected $guarded = ['modified_by'];

    public function category_option() : BelongsTo
    {
        return $this->belongsTo(CategoryOption::class);
    }

    public function service_items()
    {
        return $this->hasMany(ServiceItem::class);
    }
    public function project() : BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
    public function donor() : BelongsTo
    {
        return $this->belongsTo(Donor::class);
    }

    public function payroll_report_records()
    {
        return $this->hasMany(PayrollReportRecord::class);
    }
}
