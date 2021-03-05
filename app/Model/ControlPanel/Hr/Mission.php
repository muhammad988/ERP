<?php

namespace App\Model\ControlPanel\Hr;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * App\Model\ControlPanel\Hr\Mission
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property int|null $organisation_unit_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property int|null $number_of_employees
 * @property int|null $parent_id
 * @property int|null $head_of_mission
 * @property int|null $head_of_finance
 * @property int|null $head_of_logistic
 * @property int|null $head_of_procurement
 * @property int|null $head_of_hr
 * @property int|null $head_of_health
 * @property int|null $head_of_program
 * @property string|null $start_date
 * @property string|null $end_date
 * @method static \Illuminate\Database\Eloquent\Builder|Mission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Mission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mission whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mission whereHeadOfFinance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mission whereHeadOfHealth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mission whereHeadOfHr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mission whereHeadOfLogistic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mission whereHeadOfMission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mission whereHeadOfProcurement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mission whereHeadOfProgram($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mission whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mission whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mission whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mission whereNumberOfEmployees($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mission whereOrganisationUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mission whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mission whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mission whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mission whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\ControlPanel\Hr\Department[] $department
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\ControlPanel\Hr\Mission[] $children
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\ControlPanel\Hr\Department[] $departments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\ControlPanel\Hr\Department[] $departments_with_parent
 * @property-read \App\Model\ControlPanel\Hr\Mission|null $parent
 * @property int|null $finance_responsibility
 * @property int|null $logistic_responsibility
 * @property int|null $procurement_responsibility
 * @property int|null $hr_responsibility
 * @property int|null $accountant_responsibility
 * @property int|null $m_e_responsibility
 * @property int|null $finance_authority
 * @property int|null $accountant_authority
 * @property int|null $logistic_authority
 * @property int|null $procurement_authority
 * @property int|null $hr_authority
 * @property int|null $it_responsibility
 * @property int|null $im_responsibility
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\Mission whereAccountantAuthority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\Mission whereAccountantResponsibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\Mission whereFinanceAuthority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\Mission whereFinanceResponsibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\Mission whereHrAuthority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\Mission whereHrResponsibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\Mission whereImResponsibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\Mission whereItResponsibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\Mission whereLogisticAuthority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\Mission whereLogisticResponsibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\Mission whereMEResponsibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\Mission whereProcurementAuthority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\Mission whereProcurementResponsibility($value)
 * @property int|null $treasurer_responsibility
 * @property int|null $hq_coordinator
 * @property int|null $continent_director
 * @property int|null $rehabilatation_development_manager
 * @property int|null $ceo
 * @property int|null $mission_budget_holder
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\Mission whereCeo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\Mission whereContinentDirector($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\Mission whereHqCoordinator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\Mission whereMissionBudgetHolder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\Mission whereRehabilatationDevelopmentManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\Mission whereTreasurerResponsibility($value)
 * @property-read int|null $children_count
 * @property-read int|null $departments_count
 * @property-read int|null $departments_with_parent_count
 */
class Mission extends Model
{

    protected $fillable = [
        'name_en',
        'name_ar',
        'start_date',
        'end_date',
        'parent_id',
        'stored_by',
        'organisation_unit_id',

    ];

    protected $guarded = [
        'modified_by',
        'head_of_mission',
        'finance_authority',
        'accountant_authority',
        'logistic_authority',
        'procurement_authority',
        'hr_authority',
        'finance_responsibility',
        'logistic_responsibility',
        'procurement_responsibility',
        'hr_responsibility',
        'accountant_responsibility',
        'it_responsibility',
        'im_responsibility',
        'm_e_responsibility'
    ];
    
    
    /**
     * @return BelongsToMany
     */
    public function departments_with_parent (): BelongsToMany
    {
        return $this->belongsToMany(Department::class,'departments_missions')
                    ->withPivot('start_date','id','department_id','status')
                    ->leftJoin('departments as par','par.id','=','departments_missions.parent_id')
                    ->select('par.name_en as parent','departments.name_en')
                    ->orderBy('pivot_department_id','ASC')
                    ->withTimestamps();
    }
    
    /**
     * @return BelongsToMany
     */
    public function departments (): BelongsToMany
    {
        return $this->belongsToMany(Department::class,'departments_missions')->withPivot('id','mission_id','department_id','status')->withTimestamps();
    }
    /**
     * @return HasMany
     */
    public function children (): HasMany
    {
        return $this->hasMany(__CLASS__,'parent_id');
    }
    
    /**
     * @return BelongsTo
     */
    public function parent (): BelongsTo
    {
        return $this->belongsTo(__CLASS__,'parent_id');
    }
}
