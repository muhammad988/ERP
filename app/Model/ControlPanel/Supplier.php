<?php

namespace App\Model\ControlPanel;

use App\Model\Service\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Model\ControlPanel\Supplier
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $place
 * @property string|null $bank
 * @property string|null $email
 * @property string|null $phone_number
 * @property string|null $bank_account_number
 * @property string|null $modified_by
 * @property string|null $bank_account
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Service\Service[] $services
 * @property-read int|null $services_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\ControlPanel\SupplierAccount[] $supplier_accounts
 * @property-read int|null $supplier_accounts_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Supplier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Supplier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Supplier query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Supplier whereBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Supplier whereBankAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Supplier whereBankAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Supplier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Supplier whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Supplier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Supplier whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Supplier whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Supplier whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Supplier wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Supplier wherePlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Supplier whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Supplier whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Supplier extends Model
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


    public static function boot():void
    {
        parent::boot();
        static::deleting(function($supplier) { // before delete() method call this
            SupplierAccount::where('supplier_id', $supplier->id)->delete();
        });
    }
    //

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
    public function supplier_accounts(): HasMany
    {
        return $this->hasMany(SupplierAccount::class);
    }
}
