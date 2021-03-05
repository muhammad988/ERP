<?php

namespace App\Model\Hr;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Fingerprint
 *
 * @package App\Model\Hr
 * @property int $id
 * @property int|null $user_id
 * @property string|null $time
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property int|null $financial_code
 * @property string|null $device
 * @property int|null $index
 * @property string|null $state
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Hr\Fingerprint newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Hr\Fingerprint newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Hr\Fingerprint query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Hr\Fingerprint whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Hr\Fingerprint whereDevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Hr\Fingerprint whereFinancialCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Hr\Fingerprint whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Hr\Fingerprint whereIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Hr\Fingerprint whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Hr\Fingerprint whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Hr\Fingerprint whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Hr\Fingerprint whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Hr\Fingerprint whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Hr\Fingerprint whereUserId($value)
 * @mixin \Eloquent
 */
class Fingerprint extends Model
{

    protected $fillable = ['stored_by','financial_code','user_id','time','device','index','state'];
    protected $guarded = ['modified_by'];
//    protected $attributes = [ 'disabled' => 1];


//    /**
//     * @return BelongsTo
//     */
//    public function project (): BelongsTo
//    {
//        return $this->belongsTo(Project::class);
//    }


//    /**
//     * @return BelongsTo
//     */
//    public function nationality (): BelongsTo
//    {
//        return $this->belongsTo(Nationality::class);
//    }
//
//    /**
//     * @return BelongsTo
//     */
//    public function employment_status (): BelongsTo
//    {
//        return $this->belongsTo(TypeOfContract::class);
//    }
//
//    /**
//     * @return BelongsTo
//     */
//    public function organisation_unit (): BelongsTo
//    {
//        return $this->belongsTo(OrganisationUnit::class);
//    }
//
//    /**
//     * @return BelongsTo
//     */
//    public function contract_type (): BelongsTo
//    {
//        return $this->belongsTo(ContractType::class);
//    }
//
//    /**
//     * @return BelongsTo
//     */
//    public function type_of_contract (): BelongsTo
//    {
//        return $this->belongsTo(TypeOfContract::class);
//    }
//
//    /**
//     * @return BelongsTo
//     */
//    public function user_group (): BelongsTo
//    {
//        return $this->belongsTo(UserGroup::class);
//    }
//
//    /**
//     * @return BelongsTo
//     */
//    public function marital_status (): BelongsTo
//    {
//        return $this->belongsTo(MaritalStatus::class);
//    }
//
//    /**
//     * @return BelongsTo
//     */
//    public function visa_type (): BelongsTo
//    {
//        return $this->belongsTo(VisaType::class);
//    }
//    public function payroll_report_users()
//    {
//        return $this->hasMany(PayrollReportUser::class);
//    }
//
//    public function payroll_records()
//    {
//        return $this->hasMany(PayrollRecord::class);
//    }
//    public function on_behalf_user ()
//    {
//        return $this->hasMany(__CLASS__,'on_behalf_user_id');
//    }
//
//    /**
//     * @param $type
//     * @return Collection
//     */
//    public function leave_request ($type): Collection
//    {
//        return $this->hasMany(Leave::class,'user_id','id')->where('leave_type_id',$type)->orderBy('start_date','asc')->get();
//    }
}
