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
 * App\Model\Leave\AccumulatedDay
 *
 * @property int $id
 * @property string $year
 * @property float|null $number_of_days
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property-read \App\Model\Leave\LeaveType $leave_type
 * @property-read \App\Model\Status $status
 * @property-read \App\Model\Hr\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Leave\AccumulatedDay newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Leave\AccumulatedDay newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Leave\AccumulatedDay query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Leave\AccumulatedDay whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Leave\AccumulatedDay whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Leave\AccumulatedDay whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Leave\AccumulatedDay whereNumberOfDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Leave\AccumulatedDay whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Leave\AccumulatedDay whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Leave\AccumulatedDay whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Leave\AccumulatedDay whereYear($value)
 * @mixin \Eloquent
 */
class AccumulatedDay extends Model
{
    protected $fillable = [ 'year','user_id','stored_by','number_of_days'];
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
