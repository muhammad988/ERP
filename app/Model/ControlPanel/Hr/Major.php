<?php

namespace App\Model\ControlPanel\Hr;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Model\ControlPanel\Hr\Major
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @method static \Illuminate\Database\Eloquent\Builder|Major newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Major newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Major query()
 * @method static \Illuminate\Database\Eloquent\Builder|Major whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Major whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Major whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Major whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Major whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Major whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Major whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Major extends Model
{
    protected $fillable = ['name_en', 'name_ar','stored_by'];

    //
}
