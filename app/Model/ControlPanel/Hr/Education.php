<?php

namespace App\Model\ControlPanel\Hr;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\ControlPanel\Hr\Education
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @method static \Illuminate\Database\Eloquent\Builder|Education newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Education newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Education query()
 * @method static \Illuminate\Database\Eloquent\Builder|Education whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Education whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Education whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Education whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Education whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Education whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Education whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Education extends Model {

    protected $fillable = ['name_en', 'name_ar','stored_by'];



}
