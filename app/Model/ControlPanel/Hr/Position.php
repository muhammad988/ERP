<?php

namespace App\Model\ControlPanel\Hr;

use App\Model\Hr\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * App\Model\ControlPanel\Hr\Position
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $stored_by
 * @property int|null $department_id
 * @property int|null $position_category_id
 * @property int|null $parent_id
 * @property string|null $modified_by
 * @property int|null $position_group_id
 * @property-read Department|null $department
 * @property-read PositionCategory|null $position_category
 * @property-read Collection|User[] $users
 * @method static Builder|Position newModelQuery()
 * @method static Builder|Position newQuery()
 * @method static Builder|Position query()
 * @method static Builder|Position whereCreatedAt($value)
 * @method static Builder|Position whereDepartmentId($value)
 * @method static Builder|Position whereId($value)
 * @method static Builder|Position whereModifiedBy($value)
 * @method static Builder|Position whereNameAr($value)
 * @method static Builder|Position whereNameEn($value)
 * @method static Builder|Position whereParentId($value)
 * @method static Builder|Position wherePositionCategoryId($value)
 * @method static Builder|Position wherePositionGroupId($value)
 * @method static Builder|Position whereStoredBy($value)
 * @method static Builder|Position whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read int|null $users_count
 */
class Position extends Model
{
    protected $fillable = ['name_en', 'name_ar','department_id','position_category_id','stored_by'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
    public function position_category(): BelongsTo
    {
        return $this->belongsTo(PositionCategory::class);
    }
}
