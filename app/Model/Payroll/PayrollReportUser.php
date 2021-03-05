<?php

namespace App\Model\Payroll;

use Illuminate\Database\Eloquent\Model;
use App\Model\Hr\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Model\Payroll\PayrollReportUser
 *
 * @property-read \App\Model\Payroll\PayrollReport $payroll_report
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Payroll\PayrollReportRecord[] $payroll_report_records
 * @property-read int|null $payroll_report_records_count
 * @property-read \App\Model\Hr\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payroll\PayrollReportUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payroll\PayrollReportUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payroll\PayrollReportUser query()
 * @mixin \Eloquent
 */
class PayrollReportUser extends Model
{
    //
    protected $fillable = ['payroll_report_id', 'user_id', 'stored_by', 'salary', 'management_allowance', 'transportation_allowance', 'house_allowance', 'cell_phone_allowance', 'cost_of_living_allowance', 'fuel_allowance', 'appearance_allowance', 'work_nature_allowance'];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payroll_report() : BelongsTo
    {
        return $this->belongsTo(PayrollReport::class);
    }

    public function payroll_report_records(): HasMany
    {
        return $this->hasMany(PayrollReportRecord::class);
    }
}
