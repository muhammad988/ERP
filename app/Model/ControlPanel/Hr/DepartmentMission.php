<?php

namespace App\Model\ControlPanel\Hr;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;


/**
 * App\Model\ControlPanel\Hr\DepartmentMission
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $start_date
 * @property string|null $end_date
 * @property string|null $description
 * @property string|null $objective
 * @property bool|null $activation
 * @property int|null $reporting
 * @property int|null $manager
 * @property int|null $status
 * @property string|null $modified_by
 * @property int|null $mission_id
 * @property int|null $department_id
 * @property-read Department $department
 * @property-read Department $parent
 * @method static Builder|DepartmentMission newModelQuery()
 * @method static Builder|DepartmentMission newQuery()
 * @method static Builder|DepartmentMission query()
 * @method static Builder|DepartmentMission whereActivation($value)
 * @method static Builder|DepartmentMission whereCreatedAt($value)
 * @method static Builder|DepartmentMission whereDepartmentId($value)
 * @method static Builder|DepartmentMission whereDescription($value)
 * @method static Builder|DepartmentMission whereEndDate($value)
 * @method static Builder|DepartmentMission whereId($value)
 * @method static Builder|DepartmentMission whereManager($value)
 * @method static Builder|DepartmentMission whereMissionId($value)
 * @method static Builder|DepartmentMission whereModifiedBy($value)
 * @method static Builder|DepartmentMission whereNameAr($value)
 * @method static Builder|DepartmentMission whereNameEn($value)
 * @method static Builder|DepartmentMission whereObjective($value)
 * @method static Builder|DepartmentMission whereParentId($value)
 * @method static Builder|DepartmentMission whereReporting($value)
 * @method static Builder|DepartmentMission whereStartDate($value)
 * @method static Builder|DepartmentMission whereStatus($value)
 * @method static Builder|DepartmentMission whereStoredBy($value)
 * @method static Builder|DepartmentMission whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read Mission $mission
 * @property-read Collection|Sector[] $sectors
 * @property string|null $descriptioin
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\DepartmentMission whereDescriptioin($value)
 * @property-read int|null $sectors_count
 */
class DepartmentMission extends Model
{
    protected  $table='departments_missions';
    protected $fillable = ['department_id','start_date','end_date','parent_id','status','stored_by'];
    protected $guarded = ['modified_by'];
    
    /**
     * @return HasOne
     */
    public function department(): HasOne
    {
        return $this->hasOne(Department::class,'id','department_id');
    }
    
    /**
     * @return HasOne
     */
//    public function department_by_mission(): HasOne
//    {
//        return $this->hasMany(Department::class,'id','department_id');
//    }
//
    /**
     * @return HasOne
     */
    public function mission(): HasOne
    {
        return $this->hasOne(Mission::class,'id','mission_id');
    }
    
    /**
     * @return HasOne
     */
    public function parent(): HasOne
    {
        return $this->hasOne(Department::class,'id','parent_id');
    }
    
    /**
     * @return BelongsToMany
     */
    public function sectors() : BelongsToMany
    {
        return $this->belongsToMany(Sector::class, 'sectors_departments','department_id','sector_id')->withPivot('id');
    }
}
