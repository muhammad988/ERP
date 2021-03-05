<?php

namespace App\Model\ControlPanel\Hr;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Model\ControlPanel\Hr\Department
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $start_date
 * @property string|null $end_date
 * @property string|null $descriptioin
 * @property string|null $objective
 * @property bool|null $activation
 * @property int|null $reporting
 * @property int|null $status
 * @property string|null $modified_by
 * @property-read Position $position
 * @method static \Illuminate\Database\Eloquent\Builder|Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Department newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Department query()
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereActivation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereDescriptioin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereObjective($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereReporting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\ControlPanel\Hr\Mission[] $mission
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\ControlPanel\Hr\Position[] $positions
 * @property-read int|null $mission_count
 * @property-read int|null $positions_count
 */
class Department extends Model {

    protected $fillable = ['name_en', 'name_ar','stored_by'];

    public function positions(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(Position::class);
    }

    public function mission(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Mission::class,'departments_missions');
    }
}
