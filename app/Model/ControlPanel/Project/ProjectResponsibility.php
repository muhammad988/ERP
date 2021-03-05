<?php

namespace App\Model\ControlPanel\Project;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class ProjectResponsibility
 *
 * @package App\Model\ControlPanel\Project
 * @property int $id
 * @property int $project_id
 * @property int|null $project_manager
 * @property int|null $program_manager
 * @property int|null $head_of_department
 * @property int|null $project_accountant
 * @property mixed|null $project_officer
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @method static Builder|ProjectResponsibility newModelQuery()
 * @method static Builder|ProjectResponsibility newQuery()
 * @method static Builder|ProjectResponsibility query()
 * @method static Builder|ProjectResponsibility whereCreatedAt($value)
 * @method static Builder|ProjectResponsibility whereHeadOfDepartment($value)
 * @method static Builder|ProjectResponsibility whereId($value)
 * @method static Builder|ProjectResponsibility whereModified_by($value)
 * @method static Builder|ProjectResponsibility whereProgramManager($value)
 * @method static Builder|ProjectResponsibility whereProjectAccountant($value)
 * @method static Builder|ProjectResponsibility whereProjectId($value)
 * @method static Builder|ProjectResponsibility whereProjectManager($value)
 * @method static Builder|ProjectResponsibility whereProjectOfficer($value)
 * @method static Builder|ProjectResponsibility whereStored_by($value)
 * @method static Builder|ProjectResponsibility whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string|null $storedby
 * @property string|null $modifiedby
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectResponsibility whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectResponsibility whereStoredby($value)
 */
class ProjectResponsibility extends Model
{
    protected $guarded = ['modified_by'];
    
}
