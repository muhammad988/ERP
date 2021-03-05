<?php

namespace App\Model\Mission;

use App\Model\ControlPanel\Project\CategoryOption;
use App\Model\Service\Service;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Mission\MissionBudgetLine
 *
 * @property int $id
 * @property int|null $mission_budget_id
 * @property int|null $budget_category_id
 * @property int|null $location
 * @property int|null $category_option_id
 * @property string|null $budget_line
 * @property float|null $quantity
 * @property float|null $unit_cost
 * @property float|null $duration
 * @property float|null $chf
 * @property int|null $unit_id
 * @property bool|null $support
 * @property bool|null $in_kind
 * @property bool|null $out_of_administrative_cost
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudgetLine newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudgetLine newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudgetLine query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudgetLine whereBudgetCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudgetLine whereBudgetLine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudgetLine whereCategoryOptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudgetLine whereChf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudgetLine whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudgetLine whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudgetLine whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudgetLine whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudgetLine whereInKind($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudgetLine whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudgetLine whereMissionBudgetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudgetLine whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudgetLine whereOutOfAdministrativeCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudgetLine whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudgetLine whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudgetLine whereSupport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudgetLine whereUnitCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudgetLine whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudgetLine whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Model\ControlPanel\Project\CategoryOption|null $category_option
 * @property-read \App\Model\Mission\MissionBudget|null $mission_budget
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Service\Service[] $services
 * @property-read int|null $services_count
 */
class MissionBudgetLine extends Model
{
    protected $fillable=['budget_line',
                         'category_option_id',
                         'unit_id',
                         'duration',
                         'quantity',
                         'unit_cost',
                         'chf',
                         'in_kind',
                         'support',
                         'out_of_administrative_cost',
                         'description',
                         'description',
                         'stored_by',
                         'description',
                         'budget_category_id',
                         'mission_budget_id',
                         'modified_by'];
    
    //
    public function mission_budget() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MissionBudget::class);
    }
    public function services()
    {
        return $this->hasMany(Service::class);
    }
    public function category_option() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CategoryOption::class);
    }
}
