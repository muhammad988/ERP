<?php

namespace App\Model\ControlPanel\Project;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Model\ControlPanel\Hr\PositionGroup;
use App\Model\Project\DetailedProposalBudget;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Model\ControlPanel\Project\CategoryOption
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $category_id
 * @property int|null $parent_id
 * @property string|null $modified_by
 * @property int|null $position_group_id
 * @property string|null $stored_by
 * @property-read Collection|DetailedProposalBudget[] $detailed_proposal_budgets
 * @method static Builder|CategoryOption newModelQuery()
 * @method static Builder|CategoryOption newQuery()
 * @method static Builder|CategoryOption query()
 * @method static Builder|CategoryOption whereCategoryId($value)
 * @method static Builder|CategoryOption whereCreatedAt($value)
 * @method static Builder|CategoryOption whereId($value)
 * @method static Builder|CategoryOption whereModifiedBy($value)
 * @method static Builder|CategoryOption whereNameAr($value)
 * @method static Builder|CategoryOption whereNameEn($value)
 * @method static Builder|CategoryOption whereParentId($value)
 * @method static Builder|CategoryOption wherePositionGroupId($value)
 * @method static Builder|CategoryOption whereStoredBy($value)
 * @method static Builder|CategoryOption whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read int|null $detailed_proposal_budgets_count
 * @property-read \App\Model\ControlPanel\Project\Category|null $category
 * @property-read \App\Model\ControlPanel\Hr\PositionGroup|null $position_group
 */
class CategoryOption extends Model
{
    protected $fillable = [
        'name_en',
        'name_ar',
        'position_group_id',
        'category_id',
        'stored_by',
    ];
    protected $guarded = [
        'modified_by',
    ];
    /**
     * @return HasMany
     */
    public function detailed_proposal_budgets(): HasMany
    {
        return $this->hasMany(DetailedProposalBudget::class);
    }
    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsTo
     */
    public function position_group(): BelongsTo
    {
        return $this->belongsTo(PositionGroup::class);
    }
}
