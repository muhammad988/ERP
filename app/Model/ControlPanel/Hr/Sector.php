<?php

namespace App\Model\ControlPanel\Hr;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;


/**
 * App\Model\ControlPanel\Hr\Sector
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property-read Collection|DepartmentMission[] $departments
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\Sector newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\Sector newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\Sector query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\Sector whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\Sector whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\Sector whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\Sector whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\Sector whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\Sector whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\Sector whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read int|null $departments_count
 */
class Sector extends Model {
    protected $fillable = ['name_en', 'name_ar','stored_by'];
    protected $guarded = ['modified_by'];
    
    /**
     * @return BelongsToMany
     */
    public function departments() : BelongsToMany
    {
        return $this->belongsToMany(DepartmentMission::class, 'sectors_departments','sector_id','department_id')->withTimestamps();
    }
}
