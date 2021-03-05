<?php

namespace App\Model\Mission;

use App\Model\Service\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Model\Mission\MissionBudget
 *
 * @property int $id
 * @property int|null $mission_id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property string|null $code
 * @property string|null $start_date
 * @property string|null $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudget newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudget newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudget query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudget whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudget whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudget whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudget whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudget whereMissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudget whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudget whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudget whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudget whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudget whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Mission\MissionBudget whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Mission\MissionBudgetLine[] $mission_budget_line
 * @property-read int|null $mission_budget_line_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Service\Service[] $services
 * @property-read int|null $services_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Mission\MissionBudgetLine[] $detailed_proposal_budget
 * @property-read int|null $detailed_proposal_budget_count
 */
class MissionBudget extends Model
{
    protected $fillable=['name_en','name_ar','start_date','end_date','stored_by'];
    protected $guarded=['modified_by'];
    //
    public function mission_budget_line()
    {
        return $this->hasMany(MissionBudgetLine::class);
    }
    public function services()
    {
        return $this->hasMany(Service::class);
    }
    /**
     * @return HasMany
     */
    public function detailed_proposal_budget () : HasMany
    {
        return $this->hasMany (MissionBudgetLine::class)
            ->join ('category_options', 'mission_budget_lines.category_option_id', '=', 'category_options.id')
            ->join ('units', 'mission_budget_lines.unit_id', '=', 'units.id')
            ->select ('mission_budget_lines.*', 'units.name_en as unit_name_en',  'category_options.name_en as category_option_name_en');
    }
}
