<?php

namespace App\Model\ControlPanel;

use App\Model\Service\Service;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\ControlPanel\ServiceProviderAccount
 *
 * @property int $id
 * @property int $service_provider_id
 * @property string|null $bank_name
 * @property string|null $account_name
 * @property string|null $iban
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $storedby
 * @property string|null $modifiedby
 * @property-read \App\Model\ControlPanel\ServiceProvider $service_provider
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Service\Service[] $services
 * @property-read int|null $services_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ServiceProviderAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ServiceProviderAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ServiceProviderAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ServiceProviderAccount whereAccountName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ServiceProviderAccount whereBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ServiceProviderAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ServiceProviderAccount whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ServiceProviderAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ServiceProviderAccount whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ServiceProviderAccount whereServiceProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ServiceProviderAccount whereStoredby($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ServiceProviderAccount whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ServiceProviderAccount extends Model
{
    protected $fillable = [
        'bank_name',
        'account_name',
        'iban',
        'stored_by',
    ];
    protected $guarded = [
        'modified_by',
    ];
    //
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function service_provider() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ServiceProvider::class);
    }
}
