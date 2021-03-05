<?php

namespace App\Model\ControlPanel\Hr;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasOne;

/**
 * App\Model\ControlPanel\Hr\SectorDepartment
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property int|null $department_id
 * @property int|null $manager
 * @property string|null $modified_by
 * @property int|null $sector_id
 * @property-read \App\Model\ControlPanel\Hr\DepartmentMission $department
 * @property-read \App\Model\ControlPanel\Hr\Sector $sector
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\SectorDepartment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\SectorDepartment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\SectorDepartment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\SectorDepartment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\SectorDepartment whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\SectorDepartment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\SectorDepartment whereManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\SectorDepartment whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\SectorDepartment whereSectorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\SectorDepartment whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\SectorDepartment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SectorDepartment extends Model
{
    protected  $table='sectors_departments';
    protected $fillable = ['department_id','sector_id'];
    protected $guarded = ['modified_by'];
    
    /**
     * @return hasOne
     */
    public function department(): HasOne
    {
        return $this->hasOne(DepartmentMission::class,'id','department_id');
    }
    
    /**
     * @return hasOne
     */
    public function sector(): HasOne
    {
        return $this->hasOne(Sector::class,'id','sector_id');
    }
//    public function parent(): \Illuminate\Database\Eloquent\Relations\hasOne
//    {
//        return $this->hasOne(Department::class,'id','parent_id');
//    }

}
