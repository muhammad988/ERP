<?php

namespace App\Model\ControlPanel;

use App\Model\Service\Service;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Model\ControlPanel\ImplementingPartnerAccount
 *
 * @property int $id
 * @property int $implementing_partner_id
 * @property string|null $bank_name
 * @property string|null $account_name
 * @property string|null $iban
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property-read ImplementingPartner $implementing_partner
 * @property-read Collection|Service[] $services
 * @property-read int|null $services_count
 * @method static Builder|ImplementingPartnerAccount newModelQuery()
 * @method static Builder|ImplementingPartnerAccount newQuery()
 * @method static Builder|ImplementingPartnerAccount query()
 * @method static Builder|ImplementingPartnerAccount whereAccountName($value)
 * @method static Builder|ImplementingPartnerAccount whereBankName($value)
 * @method static Builder|ImplementingPartnerAccount whereCreatedAt($value)
 * @method static Builder|ImplementingPartnerAccount whereIban($value)
 * @method static Builder|ImplementingPartnerAccount whereId($value)
 * @method static Builder|ImplementingPartnerAccount whereImplementingPartnerId($value)
 * @method static Builder|ImplementingPartnerAccount whereModified_by($value)
 * @method static Builder|ImplementingPartnerAccount whereStored_by($value)
 * @method static Builder|ImplementingPartnerAccount whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $storedby
 * @property string|null $modifiedby
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ImplementingPartnerAccount whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ImplementingPartnerAccount whereStoredby($value)
 */
class ImplementingPartnerAccount extends Model
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

    /**
     * @return HasMany
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    /**
     * @return BelongsTo
     */
    public function implementing_partner() : BelongsTo
    {
        return $this->belongsTo(ImplementingPartner::class);
    }
}
