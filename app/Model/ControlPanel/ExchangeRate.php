<?php

namespace App\Model\ControlPanel;;

use App\Model\Currency;
use App\Model\ControlPanel\Hr\Mission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Model\ControlPanel\ExchangeRate
 *
 * @property int $id
 * @property int|null $currency_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property float|null $exchange_rate
 * @property string|null $due_date
 * @property int|null $mission_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ExchangeRate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ExchangeRate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ExchangeRate query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ExchangeRate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ExchangeRate whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ExchangeRate whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ExchangeRate whereExchangeRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ExchangeRate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ExchangeRate whereMissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ExchangeRate whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ExchangeRate whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\ExchangeRate whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Model\Currency|null $currency
 * @property-read \App\Model\ControlPanel\Hr\Mission|null $mission
 */
class ExchangeRate extends Model
{
    protected $fillable = [
        'mission_id',
        'due_date',
        'currency_id',
        'exchange_rate',
        'stored_by',
    ];
    protected $guarded = [
        'modified_by',
    ];
    //
    /**
     * @return BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
    /**
     * @return BelongsTo
     */
    public function mission(): BelongsTo
    {
        return $this->belongsTo(Mission::class);
    }
}
