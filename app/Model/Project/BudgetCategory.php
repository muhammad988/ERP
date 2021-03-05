<?php

namespace App\Model\Project;

use Eloquent;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Model\Project\BudgetCategory
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property bool|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @method static Builder|BudgetCategory newModelQuery()
 * @method static Builder|BudgetCategory newQuery()
 * @method static Builder|BudgetCategory query()
 * @method static Builder|BudgetCategory whereCreatedAt($value)
 * @method static Builder|BudgetCategory whereId($value)
 * @method static Builder|BudgetCategory whereModifiedBy($value)
 * @method static Builder|BudgetCategory whereNameAr($value)
 * @method static Builder|BudgetCategory whereNameEn($value)
 * @method static Builder|BudgetCategory whereStatus($value)
 * @method static Builder|BudgetCategory whereStoredBy($value)
 * @method static Builder|BudgetCategory whereUpdatedAt($value)
 * @mixin Eloquent
 */
class BudgetCategory extends Model
{
    //
}
