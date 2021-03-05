<?php

namespace App\Model;

use App\Model\Hr\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * Class Worksheet
 *
 * @package App\Model
 * @property int $id
 * @property int|null $user_id
 * @property int|null $work_status_id
 * @property string|null $start_date
 * @property string|null $end_date
 * @property string|null $note
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property bool|null $add_day
 * @property-read \App\Model\WorkStatus|null $work_status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Worksheet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Worksheet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Worksheet query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Worksheet whereAddDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Worksheet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Worksheet whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Worksheet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Worksheet whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Worksheet whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Worksheet whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Worksheet whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Worksheet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Worksheet whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Worksheet whereWorkStatusId($value)
 * @mixin \Eloquent
 */
class Worksheet extends Model
{
    protected $table = 'employee_worksheets';
    protected $fillable=['user_id','start_date','end_date','stored_by','work_status_id'];
    protected $guarded=['modified_by'];
//    /**
//     * @return BelongsTo
//     */
//    public function work_status (): BelongsTo
//    {
//        return $this->belongsTo(WorkStatus::class,'work_status_id','id');
//    }

    /**
     * @return BelongsTo
     */
    public function user (): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

}
