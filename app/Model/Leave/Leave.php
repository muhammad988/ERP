<?php

namespace App\Model\Leave;

use Eloquent;
use App\Model\Status;
use App\Model\Hr\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Leave
 *
 * @package App\Model\Leave
 * @property int $id
 * @property string|null $name_en
 * @property int|null $leave_type_id
 * @property int|null $user_id
 * @property float|null $leave_days
 * @property int|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property int|null $on_behalf_user_id
 * @property string|null $start_date
 * @property string|null $end_date
 * @property string|null $reason
 * @property string|null $note
 * @property string|null $start_time
 * @property string|null $end_time
 * @property string|null $file
 * @method static Builder|Leave newModelQuery()
 * @method static Builder|Leave newQuery()
 * @method static Builder|Leave query()
 * @method static Builder|Leave whereCreatedAt($value)
 * @method static Builder|Leave whereEndDate($value)
 * @method static Builder|Leave whereEndTime($value)
 * @method static Builder|Leave whereFile($value)
 * @method static Builder|Leave whereId($value)
 * @method static Builder|Leave whereLeaveDays($value)
 * @method static Builder|Leave whereLeaveTypeId($value)
 * @method static Builder|Leave whereModifiedBy($value)
 * @method static Builder|Leave whereNameEn($value)
 * @method static Builder|Leave whereNote($value)
 * @method static Builder|Leave whereOnBehalfUserId($value)
 * @method static Builder|Leave whereReason($value)
 * @method static Builder|Leave whereStartDate($value)
 * @method static Builder|Leave whereStartTime($value)
 * @method static Builder|Leave whereStatus($value)
 * @method static Builder|Leave whereStoredBy($value)
 * @method static Builder|Leave whereUpdatedAt($value)
 * @method static Builder|Leave whereUserId($value)
 * @mixin Eloquent
 * @property int|null $status_id
 * @property-read \App\Model\Leave\LeaveType|null $leave_type
 * @property-read \App\Model\Hr\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Leave\Leave whereStatusId($value)
 */
class Leave extends Model
{
    protected $fillable = [ 'leave_type_id','start_date','end_date','start_time','end_time','user_id','on_behalf_user_id','reason','stored_by','leave_days','file','status_id'];
     protected $guarded=['modified_by'];

    /**
     * @return BelongsTo
     */
    public function leave_type () : BelongsTo
    {
        return $this->belongsTo (LeaveType::class);
    }
    /**
     * @return BelongsTo
     */
    public function user () : BelongsTo
    {
        return $this->belongsTo (User::class);
    }
    /**
     * @return BelongsTo
     */
    public function status () : BelongsTo
    {
        return $this->belongsTo (Status::class);
    }
}
