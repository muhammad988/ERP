<?php

namespace App\Model\ControlPanel\Hr;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Model\ControlPanel\Hr\PositionCategory
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @method static Builder|PositionCategory newModelQuery()
 * @method static Builder|PositionCategory newQuery()
 * @method static Builder|PositionCategory query()
 * @method static Builder|PositionCategory whereCreatedAt($value)
 * @method static Builder|PositionCategory whereId($value)
 * @method static Builder|PositionCategory whereModifiedBy($value)
 * @method static Builder|PositionCategory whereNameAr($value)
 * @method static Builder|PositionCategory whereNameEn($value)
 * @method static Builder|PositionCategory whereStoredBy($value)
 * @method static Builder|PositionCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read Collection|Position[] $positions
 * @property-read int|null $positions_count
 * @property-read \App\Model\ControlPanel\Hr\PositionCategory $parent
 */
class PositionCategory extends Model {

    protected $fillable = [
        'name_en',
        'name_ar',
        'parent_id',
        'stored_by',
    ];
    protected $guarded = [
        'modified_by',
    ];
    /**
     * @return HasMany
     */
    public function positions(): HasMany
    {
        return $this->hasMany(Position::class);
    }

    /**
     * @return BelongsTo
     */
    public function parent () : BelongsTo
    {
        return $this->belongsTo (__CLASS__, 'parent_id', 'id');
    }


}
