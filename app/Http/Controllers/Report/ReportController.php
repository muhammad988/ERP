<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Model\Project\Project;
use App\Model\Service\Service;
use App\Model\OrganisationUnit;
use App\Model\Service\ServiceItem;
use App\Model\Report\BudgetReport;
use App\Http\Controllers\Controller;
use App\Model\Service\ServiceInvoice;
use App\Model\ControlPanel\Hr\Sector;
use App\Model\ControlPanel\Hr\Mission;
use App\Model\ControlPanel\Hr\Department;
use App\Model\Project\DetailedProposalBudget;
use App\Model\ControlPanel\Hr\SectorDepartment;
use App\Model\ControlPanel\Hr\DepartmentMission;
use App\Http\Resources\Report\Budget\BudgetCollection;
use App\Http\Resources\Report\Project\ProjectCollection;
use App\Http\Resources\Report\BudgetCategory\BudgetCategoryCollection;

class ReportController extends Controller
{
    public function budget_index ($project_id,$budget_category_id)
    {
        $this->data['project_id'] = $project_id;
        $this->data['budget_category_id'] = $budget_category_id;
        $this->data['nested_url_department_multiple'] = route ('nested_department_mission_multiple');
        $this->data['nested_url_organisation_unit_multiple'] = route ('nested_organisation_unit_mission_multiple');
        $this->data['nested_url_sector_multiple'] = route ('nested_sector_department_multiple');
        $this->data['nested_sector_project_multiple'] = route ('nested_sector_project_multiple');
        $this->data['organisation_unit'] = $this->select_box (new OrganisationUnit(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), '', 'parent_id=51 ');
        $this->data['missions'] = $this->select_box (new Mission(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), '');
        $this->data['departments'] = $this->select_box (new Department(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), '');
        $this->data['projects'] = $this->select_box (new Project(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), '');
        $this->data['sectors'] = $this->select_box (new Sector(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), '');
        return view ('layouts.report.budget.index', $this->data);
    }

    public function project_index ()
    {
        $this->data['nested_url_department_multiple'] = route ('nested_department_mission_multiple');
        $this->data['nested_url_organisation_unit_multiple'] = route ('nested_organisation_unit_mission_multiple');
        $this->data['nested_url_sector_multiple'] = route ('nested_sector_department_multiple');
        $this->data['nested_sector_project_multiple'] = route ('nested_sector_project_multiple');
        $this->data['organisation_unit'] = $this->select_box (new OrganisationUnit(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), '', 'parent_id=51 ');
        $this->data['missions'] = $this->select_box (new Mission(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), '');
        $this->data['departments'] = $this->select_box (new Department(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), '');
        $this->data['projects'] = $this->select_box (new Project(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), '');
        $this->data['sectors'] = $this->select_box (new Sector(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), '');
        return view ('layouts.report.project.index', $this->data);
    }

    public function budget_category_index ($id)
    {
        $this->data['nested_url_department_multiple'] = route ('nested_department_mission_multiple');
        $this->data['nested_url_organisation_unit_multiple'] = route ('nested_organisation_unit_mission_multiple');
        $this->data['nested_url_sector_multiple'] = route ('nested_sector_department_multiple');
        $this->data['nested_sector_project_multiple'] = route ('nested_sector_project_multiple');
        $this->data['organisation_unit'] = $this->select_box (new OrganisationUnit(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), '', 'parent_id=51 ');
        $this->data['missions'] = $this->select_box (new Mission(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), '');
        $this->data['departments'] = $this->select_box (new Department(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), '');
        $this->data['projects'] = $this->select_box (new Project(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), '');
        $this->data['sectors'] = $this->select_box (new Sector(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), '');
        $this->data['id'] = $id;
        return view ('layouts.report.budget_category.index', $this->data);
    }

    public function budget_data (Request $request)
    {
        $page = $request->input ('pagination.page');
        $search = $request->input ('query.generalSearch', null);
        $perpage = $request->input ('pagination.perpage', 10);
        $sortOrder = $request->input ('sort.sort', 'asc');
        $sortField = $request->input ('sort.field', 'project_name');
        $offset = ($page - 1) * $perpage;
        $query = BudgetReport::where ('project_id',$request->project_id)->where ('budget_category_id',$request->budget_category_id)->selectRaw ('sector_department_id ,sum(expense) as expense ,sum(recerved) as recerved,sum(remaining) as remaining,sum(usable) as usable,sum(total_budget_line) as total_budget_line , budget_line, category_option, project_name, project_id , project_code ')->groupBy ('category_option','budget_line','sector_department_id', 'project_id', 'project_name', 'project_code');
        if (!is_null ($search)) {
            $query->whereRaw ("(name_en  ilike '%$search%' )");
        }
        if (isset($request->mission_ids) && !isset($request->department_ids) && !isset($request->sector_ids)) {
            $data_sector_ids = [];
            $missions = DepartmentMission::whereIn ('mission_id', $request->mission_ids)->with ('sectors')->get ();
            foreach ($missions as $mission) {
                foreach ($mission->sectors as $sector) {
                    $data_sector_ids[] = $sector->pivot->id;
                }
            }
            $query->whereIn ('sector_department_id', $data_sector_ids);

        }
        if (!isset($request->mission_ids) && isset($request->department_ids) && !isset($request->sector_ids)) {
            $data_sector_ids = [];
            $missions = DepartmentMission::whereIn ('department_id', $request->department_ids)->with ('sectors')->get ();
            foreach ($missions as $mission) {
                foreach ($mission->sectors as $sector) {
                    $data_sector_ids[] = $sector->pivot->id;
                }
            }
            $query->whereIn ('sector_department_id', $data_sector_ids);
        }
        if (isset($request->department_ids, $request->sector_ids) && !isset($request->mission_ids)) {
            $query->whereIn ('sector_department_id', $request->sector_ids);
        }
        if (isset($request->project)) {
            $query->whereIn ('project_id', $request->project);
        }
        if (isset($request->department_ids, $request->mission_ids) && !isset($request->sector_ids)) {
            $missions = DepartmentMission::whereIn ('department_id', $request->department_ids)->whereIn ('mission_id', $request->mission_ids)->with ('sectors')->get ();
            foreach ($missions as $mission) {
                foreach ($mission->sectors as $sector) {
                    $data_sector_ids[] = $sector->pivot->id;
                }
            }
            $query->whereIn ('sector_department_id', $data_sector_ids);
        }
        if (isset($request->department_ids, $request->mission_ids, $request->sector_ids)) {

            $query->whereIn ('sector_department_id', $request->sector_ids);
        }
        if (!isset($request->department_ids) && !isset($request->mission_ids) && isset($request->sector_ids)) {
            $sector_ids = SectorDepartment::whereIn ('sector_id', $request->sector_ids)->select ('id')->get ();
            $query->whereIn ('sector_department_id', $sector_ids);
        }
        $totalCount = $query->count ();
        $query->offset ($offset)
            ->limit ($perpage)
            ->orderBy ($sortField, $sortOrder);
        $data = $query->get ();
        $request->offsetSet ('pages', ceil ($totalCount / $perpage));
        $request->offsetSet ('total', $totalCount);
        return $this->resources (new BudgetCollection($data));
    }

    public function project_data (Request $request)
    {
        $page = $request->input ('pagination.page');
        $search = $request->input ('query.generalSearch', null);
        $perpage = $request->input ('pagination.perpage', 10);
        $sortOrder = $request->input ('sort.sort', 'asc');
        $sortField = $request->input ('sort.field', 'project_name');
        $offset = ($page - 1) * $perpage;
        $query = BudgetReport::whereNotNull ('project_id')->selectRaw ('sector_department_id ,sum(expense) as expense ,sum(recerved) as recerved,sum(remaining) as remaining,sum(usable) as usable,sum(total_budget_line) as total_budget_line , project_name, project_id , project_code, project_account ')->groupBy ('project_account','sector_department_id', 'project_id', 'project_name', 'project_code');
        if (!is_null ($search)) {
            $query->whereRaw ("(project_code  ilike '%$search%' )");
        }
        if (isset($request->mission_ids) && !isset($request->department_ids) && !isset($request->sector_ids)) {
            $data_sector_ids = [];
            $missions = DepartmentMission::whereIn ('mission_id', $request->mission_ids)->with ('sectors')->get ();
            foreach ($missions as $mission) {
                foreach ($mission->sectors as $sector) {
                    $data_sector_ids[] = $sector->pivot->id;
                }
            }
            $query->whereIn ('sector_department_id', $data_sector_ids);

        }
        if (!isset($request->mission_ids) && isset($request->department_ids) && !isset($request->sector_ids)) {
            $data_sector_ids = [];
            $missions = DepartmentMission::whereIn ('department_id', $request->department_ids)->with ('sectors')->get ();
            foreach ($missions as $mission) {
                foreach ($mission->sectors as $sector) {
                    $data_sector_ids[] = $sector->pivot->id;
                }
            }
            $query->whereIn ('sector_department_id', $data_sector_ids);
        }
        if (isset($request->department_ids, $request->sector_ids) && !isset($request->mission_ids)) {
            $query->whereIn ('sector_department_id', $request->sector_ids);
        }
        if (isset($request->project)) {
            $query->whereIn ('project_id', $request->project);
        }
        if (isset($request->department_ids, $request->mission_ids) && !isset($request->sector_ids)) {
            $missions = DepartmentMission::whereIn ('department_id', $request->department_ids)->whereIn ('mission_id', $request->mission_ids)->with ('sectors')->get ();
            foreach ($missions as $mission) {
                foreach ($mission->sectors as $sector) {
                    $data_sector_ids[] = $sector->pivot->id;
                }
            }
            $query->whereIn ('sector_department_id', $data_sector_ids);
        }
        if (isset($request->department_ids, $request->mission_ids, $request->sector_ids)) {

            $query->whereIn ('sector_department_id', $request->sector_ids);
        }
        if (!isset($request->department_ids) && !isset($request->mission_ids) && isset($request->sector_ids)) {
            $sector_ids = SectorDepartment::whereIn ('sector_id', $request->sector_ids)->select ('id')->get ();
            $query->whereIn ('sector_department_id', $sector_ids);
        }
        $totalCount = $query->count ();
        $query->offset ($offset)
            ->limit ($perpage)
            ->orderBy ($sortField, $sortOrder);
        $data = $query->get ();
        $request->offsetSet ('pages', ceil ($totalCount / $perpage));
        $request->offsetSet ('total', $totalCount);
        return $this->resources (new ProjectCollection($data));
    }

    public function budget_category_data (Request $request)
    {
        $page = $request->input ('pagination.page');
        $search = $request->input ('query.generalSearch', null);
        $perpage = $request->input ('pagination.perpage', 10);
        $sortOrder = $request->input ('sort.sort', 'asc');
        $sortField = $request->input ('sort.field', 'project_name');
        $offset = ($page - 1) * $perpage;
        $query = BudgetReport::where ('project_id', $request->project_id)->selectRaw ('sum(expense) as expense ,sum(recerved) as recerved,sum(remaining) as remaining,sum(usable) as usable,sum(total_budget_line) as total_budget_line , project_name, project_id, budget_category_id, budget_category, sector_department_id')->groupBy ('project_id', 'sector_department_id', 'project_name', 'budget_category_id', 'budget_category');
        if (!is_null ($search)) {
            $query->whereRaw ("(name_en  ilike '%$search%' )");
        }
        if (isset($request->mission_ids) && !isset($request->department_ids) && !isset($request->sector_ids)) {
            $data_sector_ids = [];
            $missions = DepartmentMission::whereIn ('mission_id', $request->mission_ids)->with ('sectors')->get ();
            foreach ($missions as $mission) {
                foreach ($mission->sectors as $sector) {
                    $data_sector_ids[] = $sector->pivot->id;
                }
            }
            $query->whereIn ('sector_department_id', $data_sector_ids);

        }
        if (!isset($request->mission_ids) && isset($request->department_ids) && !isset($request->sector_ids)) {
            $data_sector_ids = [];
            $missions = DepartmentMission::whereIn ('department_id', $request->department_ids)->with ('sectors')->get ();
            foreach ($missions as $mission) {
                foreach ($mission->sectors as $sector) {
                    $data_sector_ids[] = $sector->pivot->id;
                }
            }
            $query->whereIn ('sector_department_id', $data_sector_ids);
        }
        if (isset($request->department_ids, $request->sector_ids) && !isset($request->mission_ids)) {
            $query->whereIn ('sector_department_id', $request->sector_ids);
        }
        if (isset($request->project)) {
            $query->whereIn ('project_id', $request->project);
        }
        if (isset($request->department_ids, $request->mission_ids) && !isset($request->sector_ids)) {
            $missions = DepartmentMission::whereIn ('department_id', $request->department_ids)->whereIn ('mission_id', $request->mission_ids)->with ('sectors')->get ();
            foreach ($missions as $mission) {
                foreach ($mission->sectors as $sector) {
                    $data_sector_ids[] = $sector->pivot->id;
                }
            }
            $query->whereIn ('sector_department_id', $data_sector_ids);
        }
        if (isset($request->department_ids, $request->mission_ids, $request->sector_ids)) {

            $query->whereIn ('sector_department_id', $request->sector_ids);
        }
        if (!isset($request->department_ids) && !isset($request->mission_ids) && isset($request->sector_ids)) {
            $sector_ids = SectorDepartment::whereIn ('sector_id', $request->sector_ids)->select ('id')->get ();
            $query->whereIn ('sector_department_id', $sector_ids);
        }
        $totalCount = $query->count ();
        $query->offset ($offset)
            ->limit ($perpage)
            ->orderBy ($sortField, $sortOrder);
        $data = $query->get ();
        $request->offsetSet ('pages', ceil ($totalCount / $perpage));
        $request->offsetSet ('total', $totalCount);
        return $this->resources (new BudgetCategoryCollection($data));
    }

    public function create_report_budget ()
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
