<?php

namespace App\Model\ControlPanel\Hr;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Model\ControlPanel\Hr\UserType
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\UserType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\UserType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\UserType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\UserType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\UserType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\UserType whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\UserType whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\UserType whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\UserType whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\UserType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class UserType extends Model
{
    protected $fillable = ['name_en', 'name_ar','stored_by'];

    //
}
