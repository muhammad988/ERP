<?php

namespace App\Model\ControlPanel\Hr;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Model\ControlPanel\Hr\UserStatus
 *
 * @property int $id
 * @property int|null $user_id
 * @property bool|null $status
 * @property string|null $action_date
 * @property bool|null $active
 * @property string|null $note
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatus whereActionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatus whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatus whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatus whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatus whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatus whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatus whereUserId($value)
 * @mixin \Eloquent
 */
class UserStatus extends Model
{
    //
}
