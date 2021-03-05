<?php

namespace App\Model\Payroll;

use Illuminate\Database\Eloquent\Model;
use App\Model\Project\DetailedProposalBudget;

/**
 * App\Model\Payroll\PayrollReportRecord
 *
 * @property-read \App\Model\Project\DetailedProposalBudget $detailed_proposal_budget
 * @property-read \App\Model\Payroll\PayrollReportUser $payroll_report_user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payroll\PayrollReportRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payroll\PayrollReportRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payroll\PayrollReportRecord query()
 * @mixin \Eloquent
 */
class PayrollReportRecord extends Model
{
    protected $guarded=[];
    //
    public function payroll_report_user() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PayrollReportUser::class);
    }

    public function detailed_proposal_budget() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(DetailedProposalBudget::class);
    }
}
