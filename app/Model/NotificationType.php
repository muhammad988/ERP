<?php

namespace App\Model;

use App\Model\Project\Project;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\NotificationType
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $stored_by
 * @property int|null $parent_id
 * @property string|null $modified_by
 * @property string|null $module_name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationType whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationType whereModuleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationType whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationType whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationType whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationType whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\NotificationType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class NotificationType extends Model
{
    protected $fillable = [
        'name_en',
        'name_ar',
        'module_name',
        'stored_by',
    ];
    protected $guarded = [
        'modified_by',
    ];
}
