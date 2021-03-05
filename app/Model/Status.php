<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Status
 *
 * @package App\Model
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property int|null $sort_by
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Status newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Status newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Status query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Status whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Status whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Status whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Status whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Status whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Status whereSortBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Status whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Status whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Status extends Model
{

}
