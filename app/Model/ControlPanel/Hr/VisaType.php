<?php

namespace App\Model\ControlPanel\Hr;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Model\ControlPanel\Hr\VisaType
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @method static \Illuminate\Database\Eloquent\Builder|VisaType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VisaType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VisaType query()
 * @method static \Illuminate\Database\Eloquent\Builder|VisaType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VisaType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VisaType whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VisaType whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VisaType whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VisaType whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VisaType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class VisaType extends Model {

    protected $fillable = ['name_en', 'name_ar','stored_by'];


}
