<?php

namespace App\Model\Authority;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Model\Authority\Role
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property string|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Authority\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Authority\Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Authority\Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Authority\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Authority\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Authority\Role whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Authority\Role whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Authority\Role whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Authority\Role whereParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Authority\Role whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Authority\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Role extends Model
{
}
