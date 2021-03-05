<?php

namespace App\Model\Report;

use Eloquent;
use App\Model\Project\Project;
use App\Model\Service\Service;
use App\Model\Service\ServiceItem;
use App\Model\Service\ServiceInvoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Model\Project\DetailedProposalBudget;


/**
 * App\Model\Report\BudgetReport
 *
 * @method static Builder|BudgetReport newModelQuery()
 * @method static Builder|BudgetReport newQuery()
 * @method static Builder|BudgetReport query()
 * @mixin Eloquent
 */
class BudgetReport extends Model
{
    public function create_report_budget (): void
    {
        $project = Project::with ('detailed_proposal_budget')->where ('status_id', 170)->get ();
        foreach ($project as $item) {
            foreach ($item->detailed_proposal_budget as $value) {
                $info = $this->info ($value->id);
                $report = BudgetReport::where ('detailed_proposal_budget_id', $value->id)->first ();
                if (is_null ($report)) {
                    $report = new BudgetReport ();
                }
                $report->detailed_proposal_budget_id = $value->id;
                $report->budget_line = $value->budget_line;
                $report->total_budget_line = $info['total'];
                $report->expense = $info['expense'];
                $report->recerved = $info['reserve'];
                $report->remaining = $info['remaining'];
                $report->usable = $info['usable'];
                $report->donor = $value->donor_name_en;
                $report->organisation_unit_id = $item->organisation_unit->id;
                $report->organisation_unit = $item->organisation_unit->name_en;
                $report->mission_id = $item->sector->department->mission->id;
                $report->mission = $item->sector->department->mission->name_en;
                $report->sector = $item->sector->sector->name_en;
                $report->sector_department_id = $item->sector->id;
                $report->department_mission_id = $item->sector->department->id;
                $report->department = $item->sector->department->department->name_en;
                $report->project_id = $item->id;
                $report->project_name = $item->name_en;
                $report->project_code = $item->code;
                $report->budget_category_id = $value->budget_category_id;
                $report->budget_category = $value->budget_category_name_en;
                $report->category_option_id = $value->category_option_id;
                $report->category_option = $value->category_option_name_en;
                $report->project_account = $item->project_accounts_payments->sum('amount')- $item->project_accounts_refunds->sum ('refund');
                $report->save ();
            }
        }
    }
    public function info ($id): array
    {
        $budget = DetailedProposalBudget::find ($id);
        $total = ($budget->duration * $budget->unit_cost * $budget->chf * $budget->quantity) / 100;
        $services = ServiceItem::where ('detailed_proposal_budget_id', $budget->id)->select ('service_id')->groupBy ('service_id')->get ();
        $currency = ['87035' => 1, '87036' => 2, '87034' => 3];
        $reserve = 0;
        $reserve_2 = 0;
        $expense = 0;
        foreach ($services as $service) {
            if ($service->service->status_id == 174) {
                $service_item = ServiceItem::where ('detailed_proposal_budget_id', $budget->id)->where ('service_id', $service->service_id)->get ();
                foreach ($service_item as $key => $item) {
                    if ($item->exchange_rate) {
                        $reserve += ($item->quantity * $item->unit_cost) / $item->exchange_rate;
                    } else {
                        $reserve += ($item->quantity * $item->unit_cost);
                    }
                }
            }
            if ($service->service->status_id == 170) {
                foreach (Service::where ('parent_id', $service->service_id)->get () as $key => $children) {
                    if (!$service->service->completed && $children->status_id == 170) {
                        $service_invoices = ServiceInvoice::where ('detailed_proposal_budget_id', $budget->id)->where ('service_id', $children->id)->get ();
                        foreach ($service_invoices as $service_invoice) {
                            if ($children->user_exchange_rate) {
                                if ($currency[$children['currency_id']] <= $currency[$service->service['currency_id']]) {
                                    $expense += (($service_invoice->quantity * $service_invoice->unit_cost) / $service_invoice->exchange_rate) / $children->user_exchange_rate;
                                } else {
                                    $expense += (($service_invoice->quantity * $service_invoice->unit_cost) * $service_invoice->exchange_rate) / $children->user_exchange_rate;
                                }
                            } else {
                                if ($currency[$children['currency_id']] <= $currency[$service->service['currency_id']]) {
                                    $expense += ($service_invoice->quantity * $service_invoice->unit_cost) / $service_invoice->exchange_rate;
                                } else {
                                    $expense += ($service_invoice->quantity * $service_invoice->unit_cost) * $service_invoice->exchange_rate;
                                }
                            }
                        }
                        $service_item = ServiceItem::where ('detailed_proposal_budget_id', $budget->id)->where ('service_id', $service->service_id)->get ();
                        foreach ($service_item as $item) {
                            if ($item->exchange_rate) {
                                $reserve_2 += ($item->quantity * $item->unit_cost) / $item->exchange_rate;
                            } else {
                                $reserve_2 += ($item->quantity * $item->unit_cost);
                            }
                        }
                        $reserve += $reserve_2 - $expense;
                    } elseif ($service->service->completed && $children->status_id == 170) {
                        $service_invoices = ServiceInvoice::where ('detailed_proposal_budget_id', $budget->id)->where ('service_id', $children->id)->get ();
                        foreach ($service_invoices as $service_invoice) {
                            if ($children->user_exchange_rate) {
                                if ($currency[$children['currency_id']] <= $currency[$service->service['currency_id']]) {
                                    $expense += (($service_invoice->quantity * $service_invoice->unit_cost) / $service_invoice->exchange_rate) / $children->user_exchange_rate;
                                } else {
                                    $expense += (($service_invoice->quantity * $service_invoice->unit_cost) * $service_invoice->exchange_rate) / $children->user_exchange_rate;
                                }
                            } else {
                                if ($currency[$children['currency_id']] <= $currency[$service->service['currency_id']]) {
                                    $expense += ($service_invoice->quantity * $service_invoice->unit_cost) / $service_invoice->exchange_rate;
                                } else {
                                    $expense += ($service_invoice->quantity * $service_invoice->unit_cost) * $service_invoice->exchange_rate;
                                }
                            }
                        }
                    }

                }
            }

        }
        return ['total' => $total, 'expense' => $expense, 'reserve' => ($reserve), 'usable' => ($total - ($reserve + $expense)), 'remaining' => $total - $expense];
    }
}
