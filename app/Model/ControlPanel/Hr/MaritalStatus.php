<?php

namespace App\Model\ControlPanel\Hr;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Model\ControlPanel\Hr\MaritalStatus
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @method static \Illuminate\Database\Eloquent\Builder|MaritalStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MaritalStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MaritalStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|MaritalStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaritalStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaritalStatus whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaritalStatus whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaritalStatus whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaritalStatus whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaritalStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MaritalStatus extends Model {

    protected $fillable = ['name_en', 'name_ar','stored_by'];

}
