<?php

namespace App\Model\Leave;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class LeaveType
 *
 * @package App\Model\Leave
 * @property int $id
 * @property string|null $name_en
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property bool|null $hourly
 * @method static Builder|LeaveType newModelQuery()
 * @method static Builder|LeaveType newQuery()
 * @method static Builder|LeaveType query()
 * @method static Builder|LeaveType whereCreatedAt($value)
 * @method static Builder|LeaveType whereHourly($value)
 * @method static Builder|LeaveType whereId($value)
 * @method static Builder|LeaveType whereModifiedBy($value)
 * @method static Builder|LeaveType whereNameEn($value)
 * @method static Builder|LeaveType whereStoredBy($value)
 * @method static Builder|LeaveType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LeaveType extends Model
{
    //
}
