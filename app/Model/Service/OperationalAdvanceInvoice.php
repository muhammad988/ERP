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
use Prophecy\Prophecy\ObjectProphecy;


/**
 * App\Model\Service\OperationalAdvanceInvoice
 *
 * @property-read Currency $currency
 * @property-read DetailedProposalBudget $detailed_proposal_budget
 * @property-read Item $item
 * @property-read OperationalAdvance $operational_advance
 * @property-read Project $project
 * @property-read Unit $unit
 * @method static Builder|OperationalAdvanceInvoice newModelQuery()
 * @method static Builder|OperationalAdvanceInvoice newQuery()
 * @method static Builder|OperationalAdvanceInvoice query()
 * @mixin Eloquent
 */
class OperationalAdvanceInvoice extends Model
{
    protected $guarded=[];
//    protected $fillable=['name_en'];
    public function project() : BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function operational_advance() : BelongsTo
    {
        return $this->belongsTo(OperationalAdvance::class);
    }

    public function detailed_proposal_budget() : BelongsTo
    {
        return $this->belongsTo(DetailedProposalBudget::class);
    }

    public function unit() : BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function item() : BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function currency() : BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

}
