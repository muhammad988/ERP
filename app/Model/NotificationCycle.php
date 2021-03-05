<?php

namespace App\Model;

use App\Model\Project\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Model\NotificationCycle
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property int|null $number_of_superiors
 * @property int|null $notification_receiver_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property int|null $parent_id
 * @property string|null $modified_by
 * @property int|null $notification_type_id
 * @property int|null $orderby
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationCycle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationCycle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationCycle query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationCycle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationCycle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationCycle whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationCycle whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationCycle whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationCycle whereNotificationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationCycle whereNotificationReceiverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationCycle whereNumberOfSuperiors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationCycle whereOrderby($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationCycle whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationCycle whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationCycle whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $group_number
 * @property bool|null $authorized
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationCycle whereAuthorized($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationCycle whereGroupNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationCycle whereNotificationTypeId($value)
 * @property-read \App\Model\NotificationReceiver|null $notification_receiver
 * @property-read \App\Model\NotificationType|null $notification_type
 */
class NotificationCycle extends Model
{
    protected $fillable = [
        'name_en',
        'name_ar',
        'notification_receiver_id',
        'notification_type_id',
        'number_of_superiors',
        'group_number',
        'authorized',
        'stored_by',
    ];
    protected $guarded = [
        'modified_by',
    ];
    /**
     * @return BelongsTo
     */
    public function notification_type (): BelongsTo
    {
        return $this->belongsTo(NotificationType::class,'notification_type_id','id');
    }    /**
 * @return BelongsTo
 */
    public function notification_receiver (): BelongsTo
    {
        return $this->belongsTo(NotificationReceiver::class,'notification_receiver_id','id');
    }
}
