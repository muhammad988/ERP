<?php

namespace App\Model\ControlPanel;

use App\Model\Service\ServiceItem;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Center
 *
 * @package App\Model\ControlPanel
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Center newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Center newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Center query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Center whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Center whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Center whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Center whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Center whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Center whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Center whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Center extends Model
{

}
