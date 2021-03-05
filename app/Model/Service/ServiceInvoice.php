<?php

namespace App\Model\Service;

use App\Model\ControlPanel\ImplementingPartner;
use App\Model\ControlPanel\Item;
use App\Model\ControlPanel\Project\Unit;
use App\Model\ControlPanel\Supplier;
use App\Model\Currency;
use App\Model\Hr\User;
use App\Model\Project\DetailedProposalBudget;
use App\Model\Project\Project;
use App\Model\Status;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Model\Service\Service
 *
 * @property int $id
 * @property int|null $service_type_id
 * @property int|null $service_method_id
 * @property int|null $service_model_id
 * @property int|null $mission_budget_id
 * @property int|null $mission_budget_line_id
 * @property int|null $payment_method_id
 * @property int|null $payment_type_id
 * @property int|null $currency_id
 * @property float|null $user_exchange_rate
 * @property float|null $accountant_exchange_rate
 * @property float|null $treasurer_exchange_rate
 * @property float|null $total_dollar
 * @property float|null $total_currency
 * @property int|null $requester
 * @property User $recipient
 * @property int|null $supplier_id
 * @property int|null $implementing_partner_id
 * @property int|null $status_id
 * @property bool|null $disabled
 * @property string|null $disabled_at
 * @property bool|null $canceled
 * @property bool|null $deleted
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property int|null $project_id
 * @property-read Currency|null $currency
 * @property-read ImplementingPartner|null $implementing_partner
 * @property-read PaymentMethod|null $payment_method
 * @property-read PaymentType|null $payment_type
 * @property-read Project|null $project
 * @property-read Collection|ServiceItem[] $service_items
 * @property-read ServiceMethod|null $service_method
 * @property-read ServiceModel|null $service_model
 * @property-read ServiceType|null $service_type
 * @property-read Supplier|null $supplier
 * @method static Builder|Service newModelQuery()
 * @method static Builder|Service newQuery()
 * @method static Builder|Service query()
 * @method static Builder|Service whereAccountantExchangeRate($value)
 * @method static Builder|Service whereCanceled($value)
 * @method static Builder|Service whereCreatedAt($value)
 * @method static Builder|Service whereCurrencyId($value)
 * @method static Builder|Service whereDeleted($value)
 * @method static Builder|Service whereDisabled($value)
 * @method static Builder|Service whereDisabledAt($value)
 * @method static Builder|Service whereId($value)
 * @method static Builder|Service whereImplementingPartnerId($value)
 * @method static Builder|Service whereMissionBudgetId($value)
 * @method static Builder|Service whereMissionBudgetLineId($value)
 * @method static Builder|Service whereModifiedBy($value)
 * @method static Builder|Service wherePaymentMethodId($value)
 * @method static Builder|Service wherePaymentTypeId($value)
 * @method static Builder|Service whereProjectId($value)
 * @method static Builder|Service whereRecipient($value)
 * @method static Builder|Service whereRequester($value)
 * @method static Builder|Service whereServiceMethodId($value)
 * @method static Builder|Service whereServiceModelId($value)
 * @method static Builder|Service whereServiceTypeId($value)
 * @method static Builder|Service whereStatusId($value)
 * @method static Builder|Service whereStoredBy($value)
 * @method static Builder|Service whereSupplierId($value)
 * @method static Builder|Service whereTotalCurrency($value)
 * @method static Builder|Service whereTotalDollar($value)
 * @method static Builder|Service whereTreasurerExchangeRate($value)
 * @method static Builder|Service whereUpdatedAt($value)
 * @method static Builder|Service whereUserExchangeRate($value)
 * @mixin Eloquent
 * @property float|null $total_usd
 * @method static Builder|Service whereTotalUsd($value)
 * @property int|null $service_provider_id
 * @property-read int|null $service_items_count
 * @property-read User|null $service_recipient
 * @method static Builder|Service whereServiceProviderId($value)
 * @property string|null $code
 * @property int|null $implementing_partner_account_id
 * @property int|null $service_provider_account_id
 * @property int|null $supplier_account_id
 * @property string|null $receipt_file
 * @property-read ServiceProvider|null $service_provider
 * @property-read Status|null $status
 * @method static Builder|Service whereCode($value)
 * @method static Builder|Service whereImplementingPartnerAccountId($value)
 * @method static Builder|Service whereReceiptFile($value)
 * @method static Builder|Service whereServiceProviderAccountId($value)
 * @method static Builder|Service whereSupplierAccountId($value)
 * @property int|null $service_id
 * @property int|null $service_item_id
 * @property string|null $invoice_number
 * @property string|null $invoice_date
 * @property int|null $item_id
 * @property float|null $exchange_rate
 * @property int|null $detailed_proposal_budget_id
 * @property int|null $unit_id
 * @property float|null $quantity
 * @property float|null $unit_cost
 * @property string|null $note
 * @property-read \App\Model\Project\DetailedProposalBudget|null $detailed_proposal_budget
 * @property-read \App\Model\ControlPanel\Item|null $item
 * @property-read \App\Model\Service\Service|null $service
 * @property-read \App\Model\ControlPanel\Project\Unit|null $unit
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceInvoice whereDetailedProposalBudgetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceInvoice whereExchangeRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceInvoice whereInvoiceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceInvoice whereInvoiceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceInvoice whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceInvoice whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceInvoice whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceInvoice whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceInvoice whereServiceItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceInvoice whereUnitCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceInvoice whereUnitId($value)
 */
class ServiceInvoice extends Model
{
    protected $guarded=[];
    
    public function project() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
    
    public function service() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
    
    public function detailed_proposal_budget() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(DetailedProposalBudget::class);
    }
    
    public function unit() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
    
    public function item() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
    
    public function currency() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
    
}
