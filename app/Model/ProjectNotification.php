<?php

namespace App\Model;

use App\Model\Hr\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ProjectNotification
 *
 * @package App\Model
 * @property int $id
 * @property int|null $notification_type_id
 * @property int|null $requester
 * @property int|null $sender
 * @property int|null $receiver
 * @property string|null $url
 * @property int|null $url_id
 * @property int|null $status_id
 * @property string|null $note
 * @property int|null $step
 * @property int|null $message_id
 * @property int|null $delegated_user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property int|null $group_number
 * @property-read Message|null $message
 * @property-read Status|null $status
 * @property-read User|null $user_requester
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectNotification whereDelegatedUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectNotification whereGroupNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectNotification whereMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectNotification whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectNotification whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectNotification whereNotificationTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectNotification whereReceiver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectNotification whereRequester($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectNotification whereSender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectNotification whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectNotification whereStep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectNotification whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectNotification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectNotification whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectNotification whereUrlId($value)
 * @mixin \Eloquent
 * @property bool|null $authorized
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectNotification whereAuthorized($value)
 * @property int|null $rejected_by
 * @property-read User|null $delegated_user
 * @property-read User|null $user_receiver
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectNotification whereRejectedBy($value)
 */
class ProjectNotification extends Model
{
    protected $guarded = ['modified_by'];

    /**
     * @return BelongsTo
     */
    public function user_requester (): BelongsTo
    {
        return $this->belongsTo(User::class,'requester','id');
    }
    /**
     * @return BelongsTo
     */
    public function user_receiver (): BelongsTo
    {
        return $this->belongsTo(User::class,'receiver','id');
    }    /**
     * @return BelongsTo
     */
    public function delegated_user (): BelongsTo
    {
        return $this->belongsTo(User::class,'delegated_user_id','id');
    }

    /**
     * @return BelongsTo
     */
    public function message (): BelongsTo
    {
        return $this->belongsTo(Message::class,'message_id','id');
    }

    /**
     * @return BelongsTo
     */
    public function status (): BelongsTo
    {
        return $this->belongsTo(Status::class,'status_id','id');
    }

}
