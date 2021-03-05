<?php

namespace App\Model\Service;

use App\Model\ProjectNotification;
use App\Model\ControlPanel\ImplementingPartner;
use App\Model\ControlPanel\ImplementingPartnerAccount;
use App\Model\ControlPanel\ServiceProviderAccount;
use App\Model\ControlPanel\Supplier;
use App\Model\ControlPanel\SupplierAccount;
use App\Model\Currency;
use App\Model\Hr\User;
use App\Model\Mission\MissionBudget;
use App\Model\Mission\MissionBudgetLine;
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
 * @property int|null $parent_id
 * @property bool|null $completed
 * @property-read Collection|Service[] $children
 * @property-read int|null $children_count
 * @property-read ImplementingPartnerAccount|null $implementing_partner_account
 * @property-read MissionBudget|null $mission_budget
 * @property-read MissionBudgetLine|null $mission_budget_line
 * @property-read Service|null $parent
 * @property-read Collection|ServiceItem[] $service_invoice
 * @property-read int|null $service_invoice_count
 * @property-read Collection|ServiceInvoice[] $service_invoices
 * @property-read int|null $service_invoices_count
 * @property-read ServiceProviderAccount|null $service_provider_account
 * @property-read SupplierAccount|null $supplier_account
 * @method static Builder|Service whereCompleted($value)
 * @method static Builder|Service whereParentId($value)
 * @property-read User|null $service_requester
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\ProjectNotification[] $notification
 * @property-read int|null $notification_count
 */


class Service extends Model
{

    protected $fillable = ['code', 'total_currency',
                           'status_id',
                           'total_usd',
                           'receipt_file',
                           'implementing_partner_account_id',
                           'service_provider_account_id',
                           'supplier_account_id',
                           'user_exchange_rate',
                           'payment_type_id',
                           'accountant_exchange_rate',
                           'supplier_id',
                           'service_provider_id',
                           'implementing_partner_id',
                           'currency_id',
                           'completed',
                           'recipient',
                           'requester',
                           'payment_method_id',
                           'service_model_id',
                           'service_method_id',
                           'mission_budget_id',
                           'service_receiver_id',
                           'service_type_id',
                           'parent_id',
                           'project_id',
                           'mission_budget_line_id',
                           'stored_by'];

    //

    /**
     * @return BelongsTo
     */
    public function service_method () : BelongsTo
    {
        return $this->belongsTo (ServiceMethod::class);
    }

    /**
     * @return BelongsTo
     */
    public function service_type () : BelongsTo
    {
        return $this->belongsTo (ServiceType::class);
    }

    /**
     * @return BelongsTo
     */
    public function service_model () : BelongsTo
    {
        return $this->belongsTo (ServiceModel::class);
    }

    /**
     * @return BelongsTo
     */
    public function payment_method () : BelongsTo
    {
        return $this->belongsTo (PaymentMethod::class);
    }

    /**
     * @return BelongsTo
     */
    public function payment_type () : BelongsTo
    {
        return $this->belongsTo (PaymentType::class);
    }

    /**
     * @return BelongsTo
     */
    public function currency () : BelongsTo
    {
        return $this->belongsTo (Currency::class);
    }

    /**
     * @return BelongsTo
     */
    public function implementing_partner () : BelongsTo
    {
        return $this->belongsTo (ImplementingPartner::class);
    }

    /**
     * @return BelongsTo
     */
    public function mission_budget () : BelongsTo
    {
        return $this->belongsTo (MissionBudget::class);
    }

    /**
     * @return BelongsTo
     */
    public function mission_budget_line () : BelongsTo
    {
        return $this->belongsTo (MissionBudgetLine::class);
    }

    /**
     * @return BelongsTo
     */
    public function supplier () : BelongsTo
    {
        return $this->belongsTo (Supplier::class);
    }

//    /**
//     * @return BelongsTo
//     */
//    public function recipient () : BelongsTo
//    {
//        return $this->belongsTo (User::class);
//    }

    /**
     * @return BelongsTo
     */
    public function service_provider () : BelongsTo
    {
        return $this->belongsTo (ServiceProvider::class);
    }

    /**
     * @return HasMany
     */
    public function service_items () : HasMany
    {
        return $this->hasMany (ServiceItem::class);
    }

    /**
     * @return HasMany
     */
    public function notification () : HasMany
    {
        return $this->hasMany (ProjectNotification::class, 'url_id', 'id')->orderBy ('id');
    }

//    /**
//     * @return HasMany
//     */
//    public function service_invoice () : HasMany
//    {
//        return $this->hasMany (ServiceItem::class);
//    }

    /**
     * @return BelongsTo
     */
    public function project () : BelongsTo
    {
        return $this->belongsTo (Project::class);
    }

    /**
     * @return BelongsTo
     */
    public function service_recipient () : BelongsTo
    {
        return $this->belongsTo (User::class, 'recipient', 'id');
    } /**
     * @return BelongsTo
     */
    public function service_requester () : BelongsTo
    {
        return $this->belongsTo (User::class, 'requester', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function status () : BelongsTo
    {
        return $this->belongsTo (Status::class);
    }

    /**
     * @return BelongsTo
     */
    public function implementing_partner_account () : BelongsTo
    {
        return $this->belongsTo (ImplementingPartnerAccount::class);
    }

    /**
     * @return BelongsTo
     */
    public function supplier_account () : BelongsTo
    {
        return $this->belongsTo (SupplierAccount::class);
    }

    /**
     * @return BelongsTo
     */
    public function service_provider_account () : BelongsTo
    {
        return $this->belongsTo (ServiceProviderAccount::class);
    }

    /**
     * @return HasMany
     */
    public function service_invoices () : HasMany
    {
        return $this->hasMany (ServiceInvoice::class);
    }

    /**
     * @return BelongsTo
     */
    public function parent () : BelongsTo
    {
        return $this->belongsTo (__CLASS__, 'parent_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function children () : HasMany
    {
        return $this->hasMany (__CLASS__,  'parent_id');
    }
}
