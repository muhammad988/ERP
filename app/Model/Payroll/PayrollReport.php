<?php

namespace App\Model\Payroll;

use Illuminate\Database\Eloquent\Model;
use App\Model\Hr\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Model\Payroll\PayrollReport
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Payroll\PayrollReportUser[] $payroll_report_users
 * @property-read int|null $payroll_report_users_count
 * @property-read \App\Model\Hr\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payroll\PayrollReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payroll\PayrollReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payroll\PayrollReport query()
 * @mixin \Eloquent
 */
class PayrollReport extends Model
{
    protected $fillable=['name_en','description','month','stored_by'];
    //
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payroll_report_users(): HasMany
    {
        return $this->hasMany(PayrollReportUser::class);
    }
}
