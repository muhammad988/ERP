<?php

namespace App\Model;

use Eloquent;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


/**
 * Class Status
 *
 * @package App\Model
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @method static Builder|\App\Model\Stage newModelQuery()
 * @method static Builder|\App\Model\Stage newQuery()
 * @method static Builder|\App\Model\Stage query()
 * @method static Builder|\App\Model\Stage whereCreatedAt($value)
 * @method static Builder|\App\Model\Stage whereId($value)
 * @method static Builder|\App\Model\Stage whereModifiedBy($value)
 * @method static Builder|\App\Model\Stage whereNameAr($value)
 * @method static Builder|\App\Model\Stage whereNameEn($value)
 * @method static Builder|\App\Model\Stage whereStoredBy($value)
 * @method static Builder|\App\Model\Stage whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Stage extends Model
{

}
