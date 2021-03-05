<?php

namespace App\Model\ControlPanel;

use Eloquent;
use App\Model\Service\Service;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Model\ControlPanel\SupplierAccount
 *
 * @property int $id
 * @property int $supplier_id
 * @property string|null $bank_name
 * @property string|null $account_name
 * @property string|null $iban
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $storedby
 * @property string|null $modifiedby
 * @property-read Collection|Service[] $services
 * @property-read int|null $services_count
 * @property-read Supplier $supplier
 * @method static Builder|SupplierAccount newModelQuery()
 * @method static Builder|SupplierAccount newQuery()
 * @method static Builder|SupplierAccount query()
 * @method static Builder|SupplierAccount whereAccountName($value)
 * @method static Builder|SupplierAccount whereBankName($value)
 * @method static Builder|SupplierAccount whereCreatedAt($value)
 * @method static Builder|SupplierAccount whereIban($value)
 * @method static Builder|SupplierAccount whereId($value)
 * @method static Builder|SupplierAccount whereModifiedby($value)
 * @method static Builder|SupplierAccount whereStoredby($value)
 * @method static Builder|SupplierAccount whereSupplierId($value)
 * @method static Builder|SupplierAccount whereUpdatedAt($value)
 * @mixin Eloquent
 */
class SupplierAccount extends Model
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

    public function supplier() : BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
}
