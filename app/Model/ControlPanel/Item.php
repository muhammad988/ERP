<?php

namespace App\Model\ControlPanel;

use App\Model\Service\ServiceItem;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\ControlPanel\Item
 *
 * @property int $id
 * @property int|null $item_category_id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property-read \App\Model\ControlPanel\ItemCategory|null $item_category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Service\ServiceItem[] $service_items
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Item newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Item newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Item query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Item whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Item whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Item whereItemCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Item whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Item whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Item whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Item whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Item whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read int|null $service_items_count
 */
class Item extends Model
{
    protected $fillable = [
        'name_en',
        'name_ar',
        'item_category_id',
        'stored_by',
    ];
    protected $guarded = [
        'modified_by',
    ];
    //
    public function service_items()
    {
        return $this->hasMany(ServiceItem::class);
    }

    public function item_category() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ItemCategory::class);
    }
}
