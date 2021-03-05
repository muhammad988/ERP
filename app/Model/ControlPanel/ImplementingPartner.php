<?php

namespace App\Model\ControlPanel;

use Eloquent;
use App\Model\Service\Service;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Model\ControlPanel\ImplementingPartner
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $place
 * @property string|null $bank_account
 * @property string|null $email
 * @property string|null $phone_number
 * @property string|null $bank_account_number
 * @property string|null $modified_by
 * @property bool|null $supplier
 * @property string|null $bank
 * @property-read Collection|ImplementingPartnerAccount[] $implementing_partner_accounts
 * @property-read int|null $implementing_partner_accounts_count
 * @property-read Collection|Service[] $services
 * @property-read int|null $services_count
 * @method static Builder|ImplementingPartner newModelQuery()
 * @method static Builder|ImplementingPartner newQuery()
 * @method static Builder|ImplementingPartner query()
 * @method static Builder|ImplementingPartner whereBank($value)
 * @method static Builder|ImplementingPartner whereBankAccount($value)
 * @method static Builder|ImplementingPartner whereBankAccountNumber($value)
 * @method static Builder|ImplementingPartner whereCreatedAt($value)
 * @method static Builder|ImplementingPartner whereEmail($value)
 * @method static Builder|ImplementingPartner whereId($value)
 * @method static Builder|ImplementingPartner whereModifiedBy($value)
 * @method static Builder|ImplementingPartner whereNameAr($value)
 * @method static Builder|ImplementingPartner whereNameEn($value)
 * @method static Builder|ImplementingPartner wherePhoneNumber($value)
 * @method static Builder|ImplementingPartner wherePlace($value)
 * @method static Builder|ImplementingPartner whereStoredBy($value)
 * @method static Builder|ImplementingPartner whereSupplier($value)
 * @method static Builder|ImplementingPartner whereUpdatedAt($value)
 * @mixin Eloquent
 */
class ImplementingPartner extends Model
{
    protected $fillable = [
        'name_en',
        'name_ar',
        'email',
        'phone_number',
        'stored_by',
    ];
    protected $guarded = [
        'modified_by',
    ];

    public static function boot() {
        parent::boot();
        static::deleting(function($implementing_partner) { // before delete() method call this
            ImplementingPartnerAccount::where('implementing_partner_id', $implementing_partner->id)->delete();
        });
    }

    //
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    /**
     * @return HasMany
     */
    public function implementing_partner_accounts(): HasMany
    {
        return $this->hasMany(ImplementingPartnerAccount::class)->without ('t');
    }
}
