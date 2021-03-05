<?php

namespace App\Model\Payroll;

use Illuminate\Database\Eloquent\Model;
use App\Model\Hr\User;
use App\Model\Project\DetailedProposalBudget;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Model\Payroll\PayrollRecord
 *
 * @property-read \App\Model\Project\DetailedProposalBudget $detailed_proposal_budget
 * @property-read \App\Model\Payroll\ProjectVacancy $project_vacancy
 * @property-read \App\Model\Hr\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payroll\PayrollRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payroll\PayrollRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payroll\PayrollRecord query()
 * @mixin \Eloquent
 */
class PayrollRecord extends Model
{
    //
    protected $fillable = ['user_id', 'detailed_proposal_budget_id', 'month', 'basic_salary', 'salary', 'salary_percentage', 'management_allowance_percentage', 'management_allowance',
    'transportation_allowance_percentage', 'transportation_allowance', 'house_allowance_percentage', 'house_allowance', 'cell_phone_allowance_percentage', 'cell_phone_allowance', 'cost_of_living_allowance_percentage',
    'cost_of_living_allowance','fuel_allowance_percentage','fuel_allowance', 'appearance_allowance_percentage', 'appearance_allowance', 'work_nature_allowance_percentage', 'work_nature_allowance', 'project_vacancy_id'];
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function detailed_proposal_budget() : BelongsTo
    {
        return $this->belongsTo(DetailedProposalBudget::class);
    }

    public function project_vacancy() : BelongsTo
    {
        return $this->belongsTo(ProjectVacancy::class);
    }
}
