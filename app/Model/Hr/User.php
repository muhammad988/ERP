<?php

namespace App\Model\Hr;

use App\Model\Leave\Leave;
use App\Model\Payroll\PayrollRecord;
use App\Model\Payroll\PayrollReportUser;
use App\Model\ControlPanel\Hr\ContractType;
use App\Model\ControlPanel\Hr\Department;
use App\Model\ControlPanel\Hr\DepartmentMission;
use App\Model\ControlPanel\Hr\MaritalStatus;
use App\Model\ControlPanel\Hr\Mission;
use App\Model\ControlPanel\Hr\TypeOfContract;
use App\Model\ControlPanel\Hr\Nationality;
use App\Model\ControlPanel\Hr\Position;
use App\Model\ControlPanel\Hr\UserGroup;
use App\Model\ControlPanel\Hr\VisaType;
use App\Model\OrganisationUnit;
use App\Model\Project\Project;
use App\Model\ProjectNotification;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;


/**
 * App\Model\Hr\User
 *
 * @property int $id
 * @property string|null $user_name
 * @property string|null $password
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $employeeid
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property string|null $email
 * @property string|null $remember_token
 * @property int|null $user_group_id
 * @property string|null $photo
 * @property string|null $disable_date
 * @property int|null $disable
 * @property bool|null $delegation
 * @property int|null $delegation_user_id
 * @property float|null $balance
 * @property int|null $marital_status_id
 * @property int|null $education_id
 * @property int|null $visa_type_id
 * @property int|null $department_id
 * @property int|null $major_id
 * @property int|null $type_of_contract_id
 * @property int|null $contract_type_id
 * @property bool|null $probation
 * @property int|null $project_id
 * @property int|null $on_behalf_user_id
 * @property string|null $first_name_en
 * @property string|null $middle_name_en
 * @property string|null $last_name_en
 * @property string|null $first_name_ar
 * @property string|null $middle_name_ar
 * @property string|null $last_name_ar
 * @property string|null $date_of_birth
 * @property string|null $start_date
 * @property string|null $end_date
 * @property float|null $employee_number
 * @property string|null $gender_en
 * @property string|null $gender_ar
 * @property string|null $phone_number
 * @property int|null $parent_id
 * @property float|null $number_of_dependents
 * @property string|null $passport_number
 * @property string|null $passport_date
 * @property string|null $emergency_contact_name_en
 * @property string|null $emergency_contact_name_ar
 * @property string|null $emergency_contact_relationship
 * @property float|null $starting_salary
 * @property float|null $salary_after_probation
 * @property float|null $basic_salary
 * @property string|null $visa_validity
 * @property string|null $address
 * @property string|null $date_of_graduation
 * @property float|null $number_of_hours
 * @property float|null $financial_code
 * @property string|null $hr
 * @property string|null $personal_info
 * @property string|null $certificate
 * @property int|null $disabled
 * @property string|null $disabled_date
 * @property float|null $advanced_balance
 * @property float|null $current_number_of_hours
 * @property string|null $start_nursing_date
 * @property string|null $turkish_name
 * @property string|null $ptt_number
 * @property string|null $notes
 * @property int|null $organisation_unit_id
 * @property int|null $user_type_id
 * @property int|null $position_id
 * @property int|null $nationality_id
 * @property float|null $management_allowance
 * @property float|null $transportation_allowance
 * @property float|null $house_allowance
 * @property float|null $cell_phone_allowance
 * @property float|null $cost_of_living_allowance
 * @property float|null $fuel_allowance
 * @property float|null $appearance_allowance
 * @property float|null $gross_salary
 * @property float|null $identity_number
 * @property string|null $identity_expiration_date
 * @property string|null $place_of_birth
 * @property float|null $taxes
 * @property float|null $insurance
 * @property string|null $hiring_date
 * @property string|null $start_time
 * @property string|null $end_time
 * @property float|null $working_hours
 * @property Nationality|null $nationality
 * @property VisaType|null $visa_type
 * @property string|null $position_text
 * @property string|null $financial_code_missions
 * @property float|null $work_nature_allowance
 * @property float|null $lunch_break
 * @property string|null $identity_number_text
 * @property int|null $mission_id
 * @property int|null $departmentid
 * @property string|null $emergency_contact_phone
 * @property string|null $note
 * @property bool|null $service_receiver
 * @property bool|null $logistic_service_receiver
 * @property string|null $end_nursing_date
 * @property int|null $accumulated_days
 * @property int|null $extra_days
 * @property-read Collection|User[] $children
 * @property-read int|null $children_count
 * @property-read ContractType|null $contract_type
 * @property-read DepartmentMission|null $department
 * @property-read TypeOfContract $employment_status
 * @property-read MaritalStatus|null $marital_status
 * @property-read Mission|null $mission
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|User[] $on_behalf_user
 * @property-read int|null $on_behalf_user_count
 * @property-read OrganisationUnit|null $organisation_unit
 * @property-read User|null $parent
 * @property-read Collection|PayrollRecord[] $payroll_records
 * @property-read int|null $payroll_records_count
 * @property-read Collection|PayrollReportUser[] $payroll_report_users
 * @property-read int|null $payroll_report_users_count
 * @property-read Position|null $position
 * @property-read Project|null $project
 * @property-read Collection|ProjectNotification[] $project_notification
 * @property-read int|null $project_notification_count
 * @property-read TypeOfContract|null $type_of_contract
 * @property-read UserGroup|null $user_group
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereAccumulatedDays($value)
 * @method static Builder|User whereAddress($value)
 * @method static Builder|User whereAdvancedBalance($value)
 * @method static Builder|User whereAppearanceAllowance($value)
 * @method static Builder|User whereBalance($value)
 * @method static Builder|User whereBasicSalary($value)
 * @method static Builder|User whereCellPhoneAllowance($value)
 * @method static Builder|User whereCertificate($value)
 * @method static Builder|User whereContractTypeId($value)
 * @method static Builder|User whereCostOfLivingAllowance($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereCurrentNumberOfHours($value)
 * @method static Builder|User whereDateOfBirth($value)
 * @method static Builder|User whereDateOfGraduation($value)
 * @method static Builder|User whereDelegation($value)
 * @method static Builder|User whereDelegationUserId($value)
 * @method static Builder|User whereDepartmentId($value)
 * @method static Builder|User whereDisable($value)
 * @method static Builder|User whereDisableDate($value)
 * @method static Builder|User whereDisabled($value)
 * @method static Builder|User whereDisabledDate($value)
 * @method static Builder|User whereEducationId($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmergencyContactNameAr($value)
 * @method static Builder|User whereEmergencyContactNameEn($value)
 * @method static Builder|User whereEmergencyContactPhone($value)
 * @method static Builder|User whereEmergencyContactRelationship($value)
 * @method static Builder|User whereEmployeeNumber($value)
 * @method static Builder|User whereEmployeeid($value)
 * @method static Builder|User whereEndDate($value)
 * @method static Builder|User whereEndNursingDate($value)
 * @method static Builder|User whereEndTime($value)
 * @method static Builder|User whereExtraDays($value)
 * @method static Builder|User whereFinancialCode($value)
 * @method static Builder|User whereFinancialCodeMissions($value)
 * @method static Builder|User whereFirstNameAr($value)
 * @method static Builder|User whereFirstNameEn($value)
 * @method static Builder|User whereFuelAllowance($value)
 * @method static Builder|User whereGenderAr($value)
 * @method static Builder|User whereGenderEn($value)
 * @method static Builder|User whereGrossSalary($value)
 * @method static Builder|User whereHiringDate($value)
 * @method static Builder|User whereHouseAllowance($value)
 * @method static Builder|User whereHr($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereIdentityExpirationDate($value)
 * @method static Builder|User whereIdentityNumber($value)
 * @method static Builder|User whereIdentityNumberText($value)
 * @method static Builder|User whereInsurance($value)
 * @method static Builder|User whereLastNameAr($value)
 * @method static Builder|User whereLastNameEn($value)
 * @method static Builder|User whereLogisticServiceReceiver($value)
 * @method static Builder|User whereLunchBreak($value)
 * @method static Builder|User whereMajorId($value)
 * @method static Builder|User whereManagementAllowance($value)
 * @method static Builder|User whereMaritalStatusId($value)
 * @method static Builder|User whereMiddleNameAr($value)
 * @method static Builder|User whereMiddleNameEn($value)
 * @method static Builder|User whereMissionId($value)
 * @method static Builder|User whereModifiedBy($value)
 * @method static Builder|User whereNationality($value)
 * @method static Builder|User whereNationalityId($value)
 * @method static Builder|User whereNote($value)
 * @method static Builder|User whereNotes($value)
 * @method static Builder|User whereNumberOfDependents($value)
 * @method static Builder|User whereNumberOfHours($value)
 * @method static Builder|User whereOnBehalfUserId($value)
 * @method static Builder|User whereOrganisationUnitId($value)
 * @method static Builder|User whereParentId($value)
 * @method static Builder|User wherePassportDate($value)
 * @method static Builder|User wherePassportNumber($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User wherePersonalInfo($value)
 * @method static Builder|User wherePhoneNumber($value)
 * @method static Builder|User wherePhoto($value)
 * @method static Builder|User wherePlaceOfBirth($value)
 * @method static Builder|User wherePositionId($value)
 * @method static Builder|User wherePositionText($value)
 * @method static Builder|User whereProbation($value)
 * @method static Builder|User whereProjectId($value)
 * @method static Builder|User wherePttNumber($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereSalaryAfterProbation($value)
 * @method static Builder|User whereServiceReceiver($value)
 * @method static Builder|User whereStartDate($value)
 * @method static Builder|User whereStartNursingDate($value)
 * @method static Builder|User whereStartTime($value)
 * @method static Builder|User whereStartingSalary($value)
 * @method static Builder|User whereStoredBy($value)
 * @method static Builder|User whereTaxes($value)
 * @method static Builder|User whereTransportationAllowance($value)
 * @method static Builder|User whereTurkishName($value)
 * @method static Builder|User whereTypeOfContractId($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereUserGroupId($value)
 * @method static Builder|User whereUserName($value)
 * @method static Builder|User whereUserTypeId($value)
 * @method static Builder|User whereVisaType($value)
 * @method static Builder|User whereVisaTypeId($value)
 * @method static Builder|User whereVisaValidity($value)
 * @method static Builder|User whereWorkNatureAllowance($value)
 * @method static Builder|User whereWorkingHours($value)
 * @mixin Eloquent
 * @property int|null $center_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Hr\User whereCenterId($value)
 */
class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = ['_token','position_category_id','modified_by'];
    protected $attributes = [ 'disabled' => 1];

    /**
     * @param $role
     * @return mixed
     */
    public function roles($role) {
        return $role;
//        return $this->belongsToMany(Role::class,'users_roles');

    }


    public function permissions() {
//        return $this->belongsToMany(Permission::class,'users_permissions');

    }

    /**
     * @param $roles
     * @return bool
     */
    public function hasAnyRole($roles) : bool
    {

        return false;
    }

    /**
     * @param mixed ...$roles
     * @return bool
     */
    public function hasRole(... $roles) : bool
    {

        return false;
    }

    /**
     * @param mixed ...$permission
     * @return bool
     */
    public function hasPermission(...$permission) : bool
    {

        return false;
    }


    /**
     * @return string
     */
    protected function getFullNameAttribute(): string
    {
        return $this->first_name_en . ' ' . $this->last_name_en;
    }

    /**
     * @return HasMany
     */
    public function children (): HasMany
    {
        return $this->hasMany(__CLASS__,'parent_id');
    }



    /**
     * @return BelongsTo
     */
    public function parent (): BelongsTo
    {
        return $this->belongsTo(__CLASS__,'parent_id');
    }

    /**
     * @return BelongsTo
     */
    public function position (): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * @return BelongsTo
     */
    public function department (): BelongsTo
    {
        return $this->belongsTo(DepartmentMission::class);
    }

    /**
     * @return BelongsTo
     */
    public function mission (): BelongsTo
    {
        return $this->belongsTo(Mission::class);
    }

    /**
     * @return BelongsTo
     */
    public function project (): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * @return HasMany
     */
    public function project_notification (): HasMany
    {
        return $this->hasMany(ProjectNotification::class,'receiver','id')->where ('status_id',174)->with ('user_requester','message')->orderByDesc  ('created_at');
    }

    /**
     * @return BelongsTo
     */
    public function nationality (): BelongsTo
    {
        return $this->belongsTo(Nationality::class);
    }

    /**
     * @return BelongsTo
     */
    public function employment_status (): BelongsTo
    {
        return $this->belongsTo(TypeOfContract::class);
    }

    /**
     * @return BelongsTo
     */
    public function organisation_unit (): BelongsTo
    {
        return $this->belongsTo(OrganisationUnit::class);
    }

    /**
     * @return BelongsTo
     */
    public function contract_type (): BelongsTo
    {
        return $this->belongsTo(ContractType::class);
    }

    /**
     * @return BelongsTo
     */
    public function type_of_contract (): BelongsTo
    {
        return $this->belongsTo(TypeOfContract::class);
    }

    /**
     * @return BelongsTo
     */
    public function user_group (): BelongsTo
    {
        return $this->belongsTo(UserGroup::class);
    }

    /**
     * @return BelongsTo
     */
    public function marital_status (): BelongsTo
    {
        return $this->belongsTo(MaritalStatus::class);
    }

    /**
     * @return BelongsTo
     */
    public function visa_type (): BelongsTo
    {
        return $this->belongsTo(VisaType::class);
    }
    public function payroll_report_users()
    {
        return $this->hasMany(PayrollReportUser::class);
    }

    public function payroll_records()
    {
        return $this->hasMany(PayrollRecord::class);
    }
    public function on_behalf_user ()
    {
        return $this->hasMany(__CLASS__,'on_behalf_user_id');
    }

    /**
     * @param $type
     * @return Collection
     */
    public function leave_request ($type): Collection
    {
        return $this->hasMany(Leave::class,'user_id','id')->where('leave_type_id',$type)->orderBy('start_date','asc')->get();
    }
}
