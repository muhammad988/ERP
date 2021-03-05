<?php

namespace App\Model;

use App\Model\Service\Service;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Model\Currency
 *
 * @property int $id
 * @property string|null $name_en
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property string|null $name_ar
 * @property-read Collection|Service[] $services
 * @method static Builder|Currency newModelQuery()
 * @method static Builder|Currency newQuery()
 * @method static Builder|Currency query()
 * @method static Builder|Currency whereCreatedAt($value)
 * @method static Builder|Currency whereId($value)
 * @method static Builder|Currency whereModifiedBy($value)
 * @method static Builder|Currency whereNameAr($value)
 * @method static Builder|Currency whereNameEn($value)
 * @method static Builder|Currency whereStoredBy($value)
 * @method static Builder|Currency whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read int|null $services_count
 */
class Currency extends Model
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

    /**
     * @return HasMany
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}
