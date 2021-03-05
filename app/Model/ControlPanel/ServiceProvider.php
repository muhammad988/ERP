<?php

namespace App\Model\ControlPanel;

use App\Model\Service\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Model\ControlPanel\ServiceProvider
 *
 * @property int $id
 * @property string $name_en
 * @property int|null $methodid
 * @property string|null $namear
 * @property string|null $storedby
 * @property string|null $modifiedby
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\ControlPanel\ServiceProviderAccount[] $service_provider_accounts
 * @property-read int|null $service_provider_accounts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Service\Service[] $services
 * @property-read int|null $services_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ServiceProvider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ServiceProvider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ServiceProvider query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ServiceProvider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ServiceProvider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ServiceProvider whereMethodid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ServiceProvider whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ServiceProvider whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ServiceProvider whereNamear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ServiceProvider whereStoredby($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ServiceProvider whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ServiceProvider extends Model
{
    protected $fillable = [
        'name_en',
        'name_ar',
        'email',
        'place',
        'phone_number',
        'stored_by',
    ];
    protected $guarded = [
        'modified_by',
    ];
    //
    public static function boot():void
    {
        parent::boot();
        static::deleting(function($supplier) {
            // before delete() method call this
            ServiceProviderAccount::where('service_provider_id', $supplier->id)->delete();
        });
    }
    /**
     * @return HasMany
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    /**
     * @return HasMany
     */
    public function service_provider_accounts(): HasMany
    {
        return $this->hasMany(ServiceProviderAccount::class);
    }
}
