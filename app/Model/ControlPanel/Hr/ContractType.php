<?php

namespace App\Model\ControlPanel\Hr;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Model\ControlPanel\Hr\ContractType
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property int|null $holiday_id
 * @property int|null $weekend_id
 * @property bool|null $holidays_included
 * @property string|null $modified_by
 * @property bool|null $weekends_included
 * @property string|null $start_time
 * @property string|null $end_time
 * @property bool|null $date_of_join
 * @property float|null $less_than_year
 * @property float|null $more_than_year
 * @property float|null $nursing_period
 * @property string|null $first_day
 * @property string|null $last_day
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereDateOfJoin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereFirstDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereHolidayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereHolidaysIncluded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereLastDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereLessThanYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereMoreThanYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereNursingPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereWeekendId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereWeekendsIncluded($value)
 * @mixin \Eloquent
 * @property int|null $leaveperiodid
 * @property int|null $probationperiodid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\ContractType whereLeaveperiodid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\ContractType whereProbationperiodid($value)
 * @property float|null $probation_period
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\ContractType whereProbationPeriod($value)
 * @property int|null $leave_period_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\ContractType whereLeavePeriodId($value)
 */
class ContractType extends Model {





}
