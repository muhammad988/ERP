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
 * Class ExtraDay
 *
 * @package App\Model\Leave
 * @property int $id
 * @property string $year
 * @property string|null $date
 * @property string|null $start_time
 * @property string|null $end_time
 * @property float|null $number_of_minutes
 * @property float|null $number_of_days
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property-read \App\Model\Hr\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Leave\ExtraDay newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Leave\ExtraDay newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Leave\ExtraDay query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Leave\ExtraDay whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Leave\ExtraDay whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Leave\ExtraDay whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Leave\ExtraDay whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Leave\ExtraDay whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Leave\ExtraDay whereNumberOfDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Leave\ExtraDay whereNumberOfMinutes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Leave\ExtraDay whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Leave\ExtraDay whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Leave\ExtraDay whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Leave\ExtraDay whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Leave\ExtraDay whereYear($value)
 * @mixin \Eloquent
 */
class ExtraDay extends Model
{
    protected $fillable = [ 'number_of_minutes','number_of_days','user_id','year','start_time','date','end_time','stored_by'];
     protected $guarded=['modified_by'];

    /**
     * @return BelongsTo
     */
    public function user () : BelongsTo
    {
        return $this->belongsTo (User::class);
    }

}
