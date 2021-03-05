<?php

namespace App\Model\ControlPanel\Project;

use App\Model\Service\ServiceItem;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Donor
 *
 * @package App\Model\ControlPanel\Project
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Service\ServiceItem[] $service_items
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\Unit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\Unit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\Unit query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\Unit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\Unit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\Unit whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\Unit whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\Unit whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\Unit whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\Unit whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read int|null $service_items_count
 */
class Unit extends Model
{
    protected $fillable = [
        'name_en',
        'name_ar',
        'stored_by',
    ];
    protected $guarded = [
        'modified_by',
    ];
    public function service_items()
    {
        return $this->hasMany(ServiceItem::class);
    }
}
