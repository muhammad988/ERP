<?php

namespace App\Model\Service;

use App\Model\ControlPanel\Item;
use App\Model\ControlPanel\Project\Unit;
use App\Model\Currency;
use App\Model\Project\DetailedProposalBudget;
use App\Model\Project\Project;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Model\Service\ServiceItem
 *
 * @property int $id
 * @property int|null $service_id
 * @property int|null $project_id
 * @property int|null $item_id
 * @property int|null $currency_id
 * @property float|null $exchange_rate
 * @property int|null $detailed_proposal_budget_id
 * @property int|null $unit_id
 * @property float|null $quantity
 * @property float|null $unit_cost
 * @property string|null $note
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property-read DetailedProposalBudget|null $detailed_proposal_budget
 * @property-read Item|null $item
 * @property-read Project|null $project
 * @property-read Service $recipient
 * @property-read Service|null $service
 * @property-read Unit|null $unit
 * @method static Builder|ServiceItem newModelQuery()
 * @method static Builder|ServiceItem newQuery()
 * @method static Builder|ServiceItem query()
 * @method static Builder|ServiceItem whereCreatedAt($value)
 * @method static Builder|ServiceItem whereCurrencyId($value)
 * @method static Builder|ServiceItem whereDetailedProposalBudgetId($value)
 * @method static Builder|ServiceItem whereExchangeRate($value)
 * @method static Builder|ServiceItem whereId($value)
 * @method static Builder|ServiceItem whereItemId($value)
 * @method static Builder|ServiceItem whereModifiedBy($value)
 * @method static Builder|ServiceItem whereNote($value)
 * @method static Builder|ServiceItem whereProjectId($value)
 * @method static Builder|ServiceItem whereQuantity($value)
 * @method static Builder|ServiceItem whereServiceId($value)
 * @method static Builder|ServiceItem whereStoredBy($value)
 * @method static Builder|ServiceItem whereUnitCost($value)
 * @method static Builder|ServiceItem whereUnitId($value)
 * @method static Builder|ServiceItem whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string|null $invoice_number
 * @property string|null $invoice_date
 * @property-read \App\Model\Currency|null $currency
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceItem whereInvoiceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceItem whereInvoiceNumber($value)
 */
class ServiceItem extends Model
{
//    protected $fillable = [];
    protected $guarded=[];
    //
    /**
     * @return BelongsTo
     */
    public function recipient() : BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
    
    /**
     * @return BelongsTo
     */
    public function project() : BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
    
    /**
     * @return BelongsTo
     */
    public function service() : BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
    
    /**
     * @return BelongsTo
     */
    public function detailed_proposal_budget() : BelongsTo
    {
        return $this->belongsTo(DetailedProposalBudget::class);
    }
    
    /**
     * @return BelongsTo
     */
    public function unit() : BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
    
    /**
     * @return BelongsTo
     */
    public function item() : BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
    
    public function currency() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
}
