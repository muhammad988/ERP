<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


/**
 * Class ProjectNotificationStructure
 *
 * @package App\Model
 * @property int $id
 * @property int $mission_id
 * @property int $project_id
 * @property int|null $project_manager
 * @property int|null $program_manager
 * @property int|null $head_of_department
 * @property int|null $project_accountant
 * @property int|null $head_of_mission
 * @property int|null $finance_responsibility
 * @property int|null $accountant_responsibility
 * @property int|null $logistic_responsibility
 * @property int|null $procurement_responsibility
 * @property int|null $hr_responsibility
 * @property int|null $it_responsibility
 * @property int|null $im_responsibility
 * @property int|null $m_e_responsibility
 * @property int|null $finance_authority
 * @property int|null $accountant_authority
 * @property int|null $logistic_authority
 * @property int|null $procurement_authority
 * @property int|null $hr_authority
 * @property int|null $treasurer_responsibility
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property int|null $hq_coordinator
 * @property int|null $continent_director
 * @property int|null $rehabilatation_development_manager
 * @property int|null $ceo
 * @property int|null $mission_budget_holder
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure whereAccountantAuthority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure whereAccountantResponsibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure whereCeo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure whereContinentDirector($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure whereFinanceAuthority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure whereFinanceResponsibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure whereHeadOfDepartment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure whereHeadOfMission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure whereHqCoordinator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure whereHrAuthority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure whereHrResponsibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure whereImResponsibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure whereItResponsibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure whereLogisticAuthority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure whereLogisticResponsibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure whereMEResponsibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure whereMissionBudgetHolder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure whereMissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure whereProcurementAuthority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure whereProcurementResponsibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure whereProgramManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure whereProjectAccountant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure whereProjectManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure whereRehabilatationDevelopmentManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure whereTreasurerResponsibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProjectNotificationStructure whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProjectNotificationStructure extends Model
{

protected $guarded=[];
}
