<?php

namespace App\Model\Payroll;

use Eloquent;
use App\Model\Project\Project;
use App\Model\ControlPanel\Hr\Department;
use App\Model\ControlPanel\Hr\Position;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Model\Payroll\ProjectVacancy
 *
 * @property-read Department $department
 * @property-read Collection|PayrollRecord[] $payroll_records
 * @property-read int|null $payroll_records_count
 * @property-read Position $position
 * @property-read Project $project
 * @method static Builder|ProjectVacancy newModelQuery()
 * @method static Builder|ProjectVacancy newQuery()
 * @method static Builder|ProjectVacancy query()
 * @mixin Eloquent
 */
class ProjectVacancy extends Model
{
    protected $guarded = [];

    //
    public function project() : BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function position() : BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function department() : BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function payroll_records(): HasMany
    {
        return $this->hasMany(PayrollRecord::class);
    }
}
