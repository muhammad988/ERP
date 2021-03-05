<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Model\Message
 *
 * @property int $id
 * @property string|null $message
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Message query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Message whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Message whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Message whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Message whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Message extends Model
{

}
