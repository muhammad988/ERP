<?php

namespace App\Model\Service;

use App\Model\Currency;
use App\Model\Hr\User;
use App\Model\Project\Project;
use App\Model\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * App\Model\Service\OperationalAdvance
 *
 * @property-read \App\Model\Currency $currency
 * @property-read \App\Model\Service\OperationalAdvance $parent
 * @property-read \App\Model\Project\Project $project
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Service\ServiceItem[] $service_invoice
 * @property-read int|null $service_invoice_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Service\OperationalAdvanceInvoice[] $service_invoices
 * @property-read int|null $service_invoices_count
 * @property-read \App\Model\Status $status
 * @property-read \App\Model\Hr\User $user_recipient
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\OperationalAdvance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\OperationalAdvance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\OperationalAdvance query()
 * @mixin \Eloquent
 */
class OperationalAdvance extends Model
{
protected $guarded=[];
    
    
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
    public function project () : BelongsTo
    {
        return $this->belongsTo (Project::class);
    }
    /**
     * @return HasMany
     */
    public function service_invoice () : HasMany
    {
        return $this->hasMany (ServiceItem::class);
    }
    /**
     * @return BelongsTo
     */
    public function user_recipient () : BelongsTo
    {
        return $this->belongsTo (User::class, 'recipient', 'id');
    }
    public function service_invoices () : HasMany
    {
        return $this->hasMany (OperationalAdvanceInvoice::class);
    }
    /**
     * @return BelongsTo
     */
    public function status () : BelongsTo
    {
        return $this->belongsTo (Status::class);
    }
    public function parent () : BelongsTo
    {
        return $this->belongsTo (__CLASS__, 'parent_id', 'id');
    }
}
