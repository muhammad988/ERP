<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Worksheet
 *
 * @package App\Model
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property bool|null $is_counted
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\WorkStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\WorkStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\WorkStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\WorkStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\WorkStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\WorkStatus whereIsCounted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\WorkStatus whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\WorkStatus whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\WorkStatus whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\WorkStatus whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\WorkStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class WorkStatus extends Model
{

}
