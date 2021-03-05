<?php

namespace App\Model\ControlPanel;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\ControlPanel\ItemCategory
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\ControlPanel\Item[] $items
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ItemCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ItemCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ItemCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ItemCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ItemCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ItemCategory whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ItemCategory whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ItemCategory whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ItemCategory whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ItemCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read int|null $items_count
 */
class ItemCategory extends Model
{
    protected $fillable = [
        'name_en',
        'name_ar',
        'stored_by',
    ];
    protected $guarded = [
        'modified_by',
    ];
    //
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
