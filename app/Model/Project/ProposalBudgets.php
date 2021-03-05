<?php

namespace App\Model\Project;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * App\Model\Project\ProposalBudgets
 *
 * @property int $project_id
 * @property int $budget_category_id
 * @property float|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property-read \App\Model\Project\Project $project
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\ProposalBudgets newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\ProposalBudgets newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\ProposalBudgets query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\ProposalBudgets whereBudgetCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\ProposalBudgets whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\ProposalBudgets whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\ProposalBudgets whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\ProposalBudgets whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\ProposalBudgets whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\ProposalBudgets whereValue($value)
 * @mixin \Eloquent
 */
class ProposalBudgets extends Model
{
    protected $primary_key = null;
    public $incrementing = false;
    protected $fillable = ['budget_category_id','value','stored_by'];
    protected $guarded = ['modified_by'];
    public function project() : BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
