<?php

namespace App\Model;

use App\Model\Project\Project;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Model\NotificationReceiver
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $stored_by
 * @property int|null $parent_id
 * @property string|null $modified_by
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationReceiver newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationReceiver newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationReceiver query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationReceiver whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationReceiver whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationReceiver whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationReceiver whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationReceiver whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationReceiver whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationReceiver whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationReceiver whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class NotificationReceiver extends Model
{
    protected $fillable = [
        'name_en',
        'name_ar',
        'stored_by',
    ];
    protected $guarded = [
        'modified_by',
    ];
}
