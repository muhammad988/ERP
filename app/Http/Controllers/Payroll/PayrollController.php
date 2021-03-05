<?php

namespace App\Http\Controllers\Payroll;

use DB;
use PDF;
use Auth;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use App\Model\Hr\User;
use Illuminate\Http\Request;
use App\Model\Project\Project;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Model\Payroll\PayrollRecord;
use App\Model\Payroll\PayrollReport;
use App\Model\Payroll\ProjectVacancy;
use App\Model\ControlPanel\Hr\Mission;
use App\Model\ControlPanel\Hr\Position;
use App\Model\Payroll\PayrollReportUser;
use App\Model\Payroll\PayrollReportRecord;
use App\Model\Project\DetailedProposalBudget;
use App\Http\Resources\Payroll\PayrollCollection;

class PayrollController extends Controller
{
    // User salary
    public function index ()
    {
        return view ('layouts.payroll.index', $this->data);

    }

    // User salary
    public function get_all (Request $request): JsonResponse
    {
        $page = $request->input ('pagination.page');
        $search = $request->input ('query.generalSearch', null);
        $perpage = $request->input ('pagination.perpage', 10);
        $sortOrder = $request->input ('sort.sort', 'asc');
        $sortField = $request->input ('sort.field', 'name_en');
        $offset = ($page - 1) * $perpage;
        $query = PayrollReport::whereNotNull ('name_en');
        if (!is_null ($search)) {
            $query->whereRaw ("(name_en  ilike '%$search%' or  description  ilike '%$search%' )");
        }
        $totalCount = $query->count ();
        $query->offset ($offset)
            ->limit ($perpage)
            ->orderBy ($sortField, $sortOrder);
        $data = $query->get ();
        $request->offsetSet ('pages', ceil ($totalCount / $perpage));
        $request->offsetSet ('total', $totalCount);
        return $this->resources (new PayrollCollection($data));

    }

    public function user_salary ($id)
    {
        $budget_line = DetailedProposalBudget::find ($id);
        $type = ['Salary', 'basic_salary', 'salary_percentage', 'salary'];
        $users = User::with (['payroll_records' => function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('salary_percentage', '>=', '0');
        }])
            ->select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en')
            ->join ('positions', 'positions.id', '=', 'users.position_id')
            ->join ('category_options', 'category_options.position_group_id', '=', 'positions.position_group_id')
            ->join ('detailed_proposal_budgets', 'detailed_proposal_budgets.category_option_id', '=', 'category_options.id')
            ->where ('detailed_proposal_budgets.id', $id)
            ->where ('users.basic_salary', '>', '0')
            ->distinct ()
            ->get ();
        $missions = Mission::orderBy ('name_en')->get ();
        // Get all vacancies for the current project and fits this budget line
        $project_vacancies = ProjectVacancy::with (['payroll_records' => function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('salary_percentage', '>=', '0');
        }])
            ->select ('positions.name_en as position', 'project_vacancies.id', 'project_vacancies.name_en',
                'project_vacancies.basic_salary as salary', 'project_vacancies.quantity', 'project_vacancies.note')
            ->orderBy ('positions.name_en', 'ASC')->orderBy ('project_vacancies.name_en', 'ASC')
            ->join ('positions', 'positions.id', '=', 'project_vacancies.position_id')
            ->where ('project_vacancies.basic_salary', '>', '0')
            ->get ();

        return view ('layouts.payroll.project_budget', compact ('budget_line', 'type', 'users', 'missions', 'project_vacancies'));
    }

    public function check_salary (Request $request): ?JsonResponse
    {
        try {
//            $proposal = PayrollRecord::where ('user_id', $request->id)->whereDate ('month', $request->month)->where ('detailed_proposal_budget_id', $request->budget_line_id)->sum ($request->type);
            $salary = PayrollRecord::where ('user_id', $request->id)->whereDate ('month', $request->month)->where ('detailed_proposal_budget_id', $request->budget_line_id)->sum ('salary');
            $availability = availability ($request->budget_line_id);
            if (($request->value * $request->salary / 100) > ($availability + $salary)) {
                return $this->setStatusCode (422)->respond (['error' => 'Allocated Amount can not exceed the available in this budget line.']);
            }
            if ($request->type_name != 'salary') {
                $request->type_name .= '_allowance';
            }
            PayrollRecord::updateOrCreate (
                ['user_id'                     => $request->id,
                 'month'                       => $request->month,
                 'detailed_proposal_budget_id' => $request->budget_line_id],
                ['user_id'                     => $request->id,
                 'month'                       => $request->month,
                 "$request->type"              => $request->value,
                 'basic_salary'                => $request->salary,
                 $request->type_name           => ($request->value * $request->salary / 100),
                 'detailed_proposal_budget_id' => $request->budget_line_id]);
            PayrollRecord::where ('user_id', $request->id)->whereNull ('month')->where ('detailed_proposal_budget_id', $request->budget_line_id)->delete ();
            return $this->setStatusCode (200)->respond (['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => 'Something is error']);
        }

    }

    public function check_report_salary (Request $request): ?JsonResponse
    {
        try {
            $availability = availability ($request->budget_line_id);
            $salary = PayrollRecord::where ('user_id', $request->id)->whereDate ('month', $request->month)->where ('detailed_proposal_budget_id', $request->budget_line_id)->where ('status',true)->get ();
            $total_salary = 0;
            foreach ($salary as $key => $value) {
                $total_salary += $value->salary + $value->management_allowance + $value->transportation_allowance + $value->house_allowance + $value->cell_phone_allowance + $value->cost_of_living_allowance + $value->fuel_allowance + $value->appearance_allowance + $value->work_nature_allowance;
            }
            $salary_report = PayrollReportRecord::where ('payroll_report_user_id', $request->payroll_report_user_id)->whereDate ('month', $request->month)->where ('detailed_proposal_budget_id', $request->budget_line_id)->get ();
            $total_report_salary = 0;
            foreach ($salary_report as $key => $value) {
                $total_report_salary += $value->salary + $value->management_allowance + $value->transportation_allowance + $value->house_allowance + $value->cell_phone_allowance + $value->cost_of_living_allowance + $value->fuel_allowance + $value->appearance_allowance + $value->work_nature_allowance;
            }
            if (($request->value * $request->salary / 100) > ($availability  + $total_report_salary+$total_salary)) {
                return $this->setStatusCode (422)->respond (['error' => 'Allocated Amount can not exceed the available in this budget line.']);
            }
            $value = (($request->value * $request->salary / 100) != 0) ? ($request->value * $request->salary / 100) : null;

               PayrollReportRecord::whereNotNull ($request->type)->updateOrCreate (
                   ['payroll_report_user_id'      => $request->payroll_report_user_id,
                    'month'                       => $request->month,
                    'detailed_proposal_budget_id' => $request->budget_line_id],
                   ['payroll_report_user_id'       => $request->payroll_report_user_id,
                    'month'                        => $request->month,
                    "$request->type"               => $value,
                    $request->type . '_percentage' => $request->value,
                    'detailed_proposal_budget_id'  => $request->budget_line_id]);
               if ( $request->type=='salary'){
                   if (($request->value=='' || $request->value==0)){
                       PayrollRecord::where ('user_id', $request->id)->whereDate ('month',  $request->month)->where ('detailed_proposal_budget_id',  $request->budget_line_id)->update (['status'=>true]);
                   }else{
                       PayrollRecord::where ('user_id', $request->id)->whereDate ('month',  $request->month)->where ('detailed_proposal_budget_id',  $request->budget_line_id)->update (['status'=>false]);
                   }
               }
            return $this->setStatusCode (200)->respond (['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => 'Something is error']);
        }

    }

    public function check_salary_allocation (Request $request): ?JsonResponse
    {
        try {
            $proposal = PayrollRecord::where ('user_id', $request->id)->whereDate ('month', '!=', $request->month)->where ('detailed_proposal_budget_id', $request->budget_line_id)->sum ($request->type);
            $salary = PayrollRecord::where ('user_id', $request->id)->whereDate ('month', $request->month)->where ('detailed_proposal_budget_id', $request->budget_line_id)->sum ('salary');
            $availability = availability ($request->budget_line_id);
            if (($request->value * $request->salary / 100) > ($availability + $salary)) {
                return $this->setStatusCode (422)->respond (['error' => 'Allocated Amount can not exceed the available in this budget line.']);
            }
            if ($proposal + $request->value > 100) {
                return $this->setStatusCode (422)->respond (['error' => 'Allocated Salary can not exceed 100 percent']);
            }
            if ($request->type_name != 'salary') {
                $request->type_name .= '_allowance';
            }
            PayrollRecord::updateOrCreate (
                ['user_id'                     => $request->id,
                 'month'                       => $request->month,
                 'detailed_proposal_budget_id' => $request->budget_line_id],
                ['user_id'                     => $request->id,
                 'month'                       => $request->month,
                 "$request->type"              => $request->value,
                 'basic_salary'                => $request->salary,
                 $request->type_name           => ($request->value * $request->salary / 100),
                 'stored_by'                   => Auth::user ()->full_name,
                 'detailed_proposal_budget_id' => $request->budget_line_id]);
            PayrollRecord::where ('user_id', $request->id)->whereNull ('month')->where ('detailed_proposal_budget_id', $request->budget_line_id)->delete ();
            return $this->setStatusCode (200)->respond (['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => 'Something is error']);
        }

    }

    public function check_vacancy (Request $request): ?JsonResponse
    {
        try {
//            $proposal = PayrollRecord::where ('project_vacancy_id', $request->id)->whereDate ('month', '!=', $request->month)->where ('detailed_proposal_budget_id', $request->budget_line_id)->sum ($request->type);
            $salary = PayrollRecord::where ('project_vacancy_id', $request->id)->whereDate ('month', $request->month)->where ('detailed_proposal_budget_id', $request->budget_line_id)->sum ('salary');
            $availability = availability ($request->budget_line_id);
            if (($request->value * $request->salary / 100) > ($availability + $salary)) {
                return $this->setStatusCode (422)->respond (['error' => 'Allocated Amount can not exceed the available in this budget line.']);
            }
//            if ($proposal + $request->value > 100) {
//                return $this->setStatusCode (422)->respond (['error' => 'error 100 %']);
//            }
            if ($request->type_name != 'salary') {
                $request->type_name .= '_allowance';
            }
            PayrollRecord::updateOrCreate (
                ['project_vacancy_id'          => $request->id,
                 'month'                       => $request->month,
                 'detailed_proposal_budget_id' => $request->budget_line_id],
                ['project_vacancy_id'          => $request->id,
                 'month'                       => $request->month,
                 "$request->type"              => $request->value,
                 'basic_salary'                => $request->salary,
                 $request->type_name           => ($request->value * $request->salary / 100),
                 'detailed_proposal_budget_id' => $request->budget_line_id]);
            PayrollRecord::where ('project_vacancy_id', $request->id)->whereNull ('month')->where ('detailed_proposal_budget_id', $request->budget_line_id)->delete ();
            return $this->setStatusCode (200)->respond (['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => 'Something is error']);
        }

    }

    // User salary
    public function save_user_salary (Request $request)
    {

        if (isset($request->users)){
            $deleted_users = DB::table ('payroll_records')
                ->where ('detailed_proposal_budget_id', $request->detailed_proposal_budget_id)
                ->where ("$request->type_percentage" ,'>=', 0)
                ->whereNotIn ("$request->type_percentage", $request->users)
                ->whereNotNull ('user_id')
                ->delete ();
            foreach ($request->users as $user_id) {
                $find = PayrollRecord::where ('user_id', $user_id)->where ('detailed_proposal_budget_id', $request->detailed_proposal_budget_id)->where ('salary_percentage', '>=', 0)->first ();
                if (is_null ($find)) {
                    PayrollRecord::create (['user_id'                     => $user_id,
                                            'detailed_proposal_budget_id' => $request->detailed_proposal_budget_id,
                                            "$request->type_percentage"   => 0
                    ]);
                }
            }
        }else{
            $deleted_users = DB::table ('payroll_records')
                ->where ('detailed_proposal_budget_id', $request->detailed_proposal_budget_id)
                ->where ("$request->type_percentage", '>=', 0)
                ->whereNotNull ('user_id')
                ->delete ();
        }


        if (isset($request->vacancies)) {
            $deleted_users = DB::table ('payroll_records')
                ->where ('detailed_proposal_budget_id', $request->detailed_proposal_budget_id)
                ->where ("$request->type_percentage", '>=', 0)
                ->whereNotIn ('project_vacancy_id', $request->vacancies)
                ->whereNotNull ('project_vacancy_id')
                ->delete ();
            foreach ($request->vacancies as $vacancy) {

                $find = \App\Model\Payroll\PayrollRecord::where ('project_vacancy_id', $vacancy)
                    ->where ('detailed_proposal_budget_id', $request->detailed_proposal_budget_id)
                    ->where ("$request->type_percentage", '>=', 0)
                    ->first ();

                if (is_null ($find)) {
                    \App\Model\Payroll\PayrollRecord::create (['project_vacancy_id'          => $vacancy,
                                                               'detailed_proposal_budget_id' => $request->detailed_proposal_budget_id,
                                                               "$request->type_percentage"   => 0
                    ]);
                }
            }
        }else{
            $deleted_users = DB::table ('payroll_records')
                ->where ('detailed_proposal_budget_id', $request->detailed_proposal_budget_id)
                ->where ("$request->type_percentage", '>=', 0)
                ->whereNotNull ('project_vacancy_id')
                ->delete ();
        }
        return redirect ()->route ("payroll.$request->name" . '_allocation', ['id' => $request->detailed_proposal_budget_id]);
    }

    // User salary allocation
    public function salary_allocation ($id)
    {
        $budget_line = DetailedProposalBudget::find ($id);
        $type = ['Salary', 'basic_salary', 'salary_percentage', 'salary'];
        $users = User::with ('payroll_records')->whereHas ('payroll_records', function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('salary_percentage', '>=', '0');
        })
            ->join ('positions', 'positions.id', '=', 'users.position_id')
            ->select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en as position',
                'users.basic_salary as salary')
            ->distinct ()
            ->orderBy ('users.first_name_en', 'ASC')->orderBy ('users.last_name_en', 'ASC')
            ->get ();
        // project for this budget_line
        $project = Project::where ('id', $budget_line->project_id)->select ('start_date', 'end_date')->first ();
        // project start date and end date
        $from = Carbon::createFromFormat ('Y-m-d', $project->start_date);
        $to = Carbon::createFromFormat ('Y-m-d', $project->end_date);

        $interval = DateInterval::createFromDateString ('1 month');

        // project duration by months
        $months = new DatePeriod($from, $interval, $to);

        // first year in the project
        $first_year = $from->year;

        // number of project's years
        $number_of_years = $to->year - $from->year;

        // Get all vacancies for this budget line
        $project_vacancies = ProjectVacancy::with ('payroll_records')->whereHas ('payroll_records', function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('salary_percentage', '>=', '0');
        })
            ->join ('positions', 'positions.id', '=', 'project_vacancies.position_id')
            ->select ('positions.name_en as position', 'project_vacancies.id', 'project_vacancies.name_en',
                'project_vacancies.basic_salary as salary', 'project_vacancies.quantity')
            ->distinct ()
            ->orderBy ('positions.name_en', 'ASC')->orderBy ('project_vacancies.name_en', 'ASC')
            ->get ();
        return view ('layouts.payroll.budget_allocation', compact ('budget_line', 'type', 'months', 'number_of_years', 'first_year', 'users', 'project_vacancies'));
    }

    // save user salary allocation
    public function store_salary_allocation (Request $request)
    {
        return redirect ()->route ('project.index_budget_line', $request->project_id);
    }

    // User management allowance
    public function management_allowance ($id)
    {
        //$users = User::orderBy('first_name_en', 'ASC')->orderBy('last_name_en', 'ASC')->with('Position')->get();
        $budget_line = DetailedProposalBudget::find ($id);
        $type = ['Management Allowance', 'management_allowance', 'management_allowance_percentage', 'management'];
        $users = User::with (['payroll_records' => function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('management_allowance_percentage', '>=', '0');
        }])
            ->select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en')
            ->orderBy ('users.first_name_en', 'ASC')->orderBy ('users.last_name_en', 'ASC')
            ->join ('positions', 'positions.id', '=', 'users.position_id')
            ->where ('users.management_allowance', '>', '0')
            ->distinct ()
            ->get ();

        $missions = Mission::orderBy ('name_en')->get ();
        // Get all vacancies for the current project and fits this budget line

        $project_vacancies = ProjectVacancy::with (['payroll_records' => function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('management_allowance_percentage', '>=', '0');
        }])
            ->select ('positions.name_en as position', 'project_vacancies.id', 'project_vacancies.name_en',
                'project_vacancies.management_allowance as salary', 'project_vacancies.quantity', 'project_vacancies.note')
            ->orderBy ('positions.name_en', 'ASC')->orderBy ('project_vacancies.name_en', 'ASC')
            ->join ('positions', 'positions.id', '=', 'project_vacancies.position_id')
            ->where ('project_vacancies.management_allowance', '>', '0')
            ->get ();

        return view ('layouts.payroll.project_budget', compact ('budget_line', 'type', 'users', 'missions', 'project_vacancies'));
    }

    //management allowance allocation
    public function management_allocation ($id)
    {
        $budget_line = DetailedProposalBudget::find ($id);
        $type = ['Management Allowance', 'management_allowance', 'management_allowance_percentage', 'management'];

        $users = User::with ('payroll_records')->whereHas ('payroll_records', function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('management_allowance_percentage', '>=', '0');
        })
            ->join ('positions', 'positions.id', '=', 'users.position_id')
            ->select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en as position',
                'users.management_allowance as salary')
            ->where ('users.management_allowance', '>', '0')
            ->distinct ()
            ->orderBy ('first_name_en', 'ASC')->orderBy ('last_name_en', 'ASC')
            ->get ();

        // project for this budget_line
        $project = Project::where ('id', $budget_line->project_id)->select ('start_date', 'end_date')->first ();
        // project start date and end date
        $from = Carbon::createFromFormat ('Y-m-d', $project->start_date);
        $to = Carbon::createFromFormat ('Y-m-d', $project->end_date);

        $interval = DateInterval::createFromDateString ('1 month');
        // project duration by months
        $months = new DatePeriod($from, $interval, $to);
        // first year in the project
        $first_year = $from->year;
        // number of project's years
        $number_of_years = $to->year - $from->year;
        // Get all vacancies for this budget line
        $project_vacancies = ProjectVacancy::with ('payroll_records')->whereHas ('payroll_records', function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('management_allowance_percentage', '>=', '0');
        })
            ->join ('positions', 'positions.id', '=', 'project_vacancies.position_id')
            ->select ('positions.name_en as position', 'project_vacancies.id', 'project_vacancies.name_en',
                'project_vacancies.management_allowance as salary', 'project_vacancies.quantity')
            ->where ('project_vacancies.management_allowance', '>', '0')
            ->distinct ()
            ->get ();
        return view ('layouts.payroll.budget_allocation', compact ('budget_line', 'type', 'months', 'number_of_years', 'first_year', 'users', 'project_vacancies'));
    }

    // User transportation allowance
    public function transportation_allowance ($id)
    {
        //$users = User::orderBy('first_name_en', 'ASC')->orderBy('last_name_en', 'ASC')->with('Position')->get();
        $budget_line = DetailedProposalBudget::find ($id);
        $type = ['Transportation Allowance', 'transportation_allowance', 'transportation_allowance_percentage', 'transportation'];

        $users = User::with (['payroll_records' => function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('transportation_allowance_percentage', '>=', '0');
        }])
            ->select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en')
            ->orderBy ('users.first_name_en', 'ASC')->orderBy ('users.last_name_en', 'ASC')
            ->join ('positions', 'positions.id', '=', 'users.position_id')
            ->where ('users.transportation_allowance', '>', '0')
            ->distinct ()
            ->get ();

        $missions = Mission::orderBy ('name_en')->get ();
        // Get all vacancies for the current project and fits this budget line
        $project_vacancies = ProjectVacancy::with (['payroll_records' => function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('transportation_allowance_percentage', '>=', '0');
        }])
            ->select ('positions.name_en as position', 'project_vacancies.id', 'project_vacancies.name_en',
                'project_vacancies.transportation_allowance as salary', 'project_vacancies.quantity', 'project_vacancies.note')
            ->orderBy ('positions.name_en', 'ASC')->orderBy ('project_vacancies.name_en', 'ASC')
            ->join ('positions', 'positions.id', '=', 'project_vacancies.position_id')
            ->where ('project_vacancies.transportation_allowance', '>', '0')
            ->get ();

        return view ('layouts.payroll.project_budget', compact ('budget_line', 'type', 'users', 'missions', 'project_vacancies'));
    }

    //transportation allowance allocation
    public function transportation_allocation ($id)
    {
        $budget_line = DetailedProposalBudget::find ($id);
        $type = ['Transportation Allowance', 'transportation_allowance', 'transportation_allowance_percentage', 'transportation'];
        $users = User::with ('payroll_records')->whereHas ('payroll_records', function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('transportation_allowance_percentage', '>=', '0');
        })
            ->join ('positions', 'positions.id', '=', 'users.position_id')
            ->select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en as position',
                'users.transportation_allowance as salary')
            ->where ('users.transportation_allowance', '>', '0')
            ->distinct ()
            ->orderBy ('first_name_en', 'ASC')->orderBy ('last_name_en', 'ASC')
            ->get ();
        // project for this budget_line
        $project = Project::where ('id', $budget_line->project_id)->select ('start_date', 'end_date')->first ();
        // project start date and end date
        $from = Carbon::createFromFormat ('Y-m-d', $project->start_date);
        $to = Carbon::createFromFormat ('Y-m-d', $project->end_date);

        $interval = DateInterval::createFromDateString ('1 month');
        // project duration by months
        $months = new DatePeriod($from, $interval, $to);
        // first year in the project
        $first_year = $from->year;
        // number of project's years
        $number_of_years = $to->year - $from->year;
        // Get all vacancies for this budget line
        $project_vacancies = ProjectVacancy::with ('payroll_records')->whereHas ('payroll_records', function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('transportation_allowance_percentage', '>=', '0');
        })
            ->join ('positions', 'positions.id', '=', 'project_vacancies.position_id')
            ->select ('positions.name_en as position', 'project_vacancies.id', 'project_vacancies.name_en',
                'project_vacancies.transportation_allowance as salary', 'project_vacancies.quantity')
            ->where ('project_vacancies.transportation_allowance', '>', '0')
            ->distinct ()
            ->get ();
        return view ('layouts.payroll.budget_allocation', compact ('budget_line', 'type', 'months', 'number_of_years', 'first_year', 'users', 'project_vacancies'));
    }

    // User house allowance
    public function house_allowance ($id)
    {
        //$users = User::orderBy('first_name_en', 'ASC')->orderBy('last_name_en', 'ASC')->with('Position')->get();
        $budget_line = DetailedProposalBudget::find ($id);
        $type = ['House Allowance', 'house_allowance', 'house_allowance_percentage', 'house'];

        $users = User::with (['payroll_records' => function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('house_allowance_percentage', '>=', '0');
        }])
            ->select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en')
            ->orderBy ('users.first_name_en', 'ASC')->orderBy ('users.last_name_en', 'ASC')
            ->join ('positions', 'positions.id', '=', 'users.position_id')
            ->where ('users.house_allowance', '>', '0')
            ->distinct ()
            ->get ();

        $missions = Mission::orderBy ('name_en')->get ();
        // Get all vacancies for the current project and fits this budget line
        $project_vacancies = ProjectVacancy::with (['payroll_records' => function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('house_allowance_percentage', '>=', '0');
        }])
            ->select ('positions.name_en as position', 'project_vacancies.id', 'project_vacancies.name_en',
                'project_vacancies.house_allowance as salary', 'project_vacancies.quantity', 'project_vacancies.note')
            ->orderBy ('positions.name_en', 'ASC')->orderBy ('project_vacancies.name_en', 'ASC')
            ->join ('positions', 'positions.id', '=', 'project_vacancies.position_id')
            ->where ('project_vacancies.house_allowance', '>', '0')
            ->get ();

        return view ('layouts.payroll.project_budget', compact ('budget_line', 'type', 'users', 'missions', 'project_vacancies'));
    }

    //house allowance allocation
    public function house_allocation ($id)
    {
        $budget_line = DetailedProposalBudget::find ($id);
        $type = ['House Allowance', 'house_allowance', 'house_allowance_percentage', 'house'];
        $users = User::with ('payroll_records')->whereHas ('payroll_records', function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('house_allowance_percentage', '>=', '0');
        })
            ->join ('positions', 'positions.id', '=', 'users.position_id')
            ->select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en as position',
                'users.house_allowance as salary')
            ->where ('users.house_allowance', '>', '0')
            ->distinct ()
            ->orderBy ('first_name_en', 'ASC')->orderBy ('last_name_en', 'ASC')
            ->get ();
        // project for this budget_line
        $project = Project::where ('id', $budget_line->project_id)->select ('start_date', 'end_date')->first ();
        // project start date and end date
        $from = Carbon::createFromFormat ('Y-m-d', $project->start_date);
        $to = Carbon::createFromFormat ('Y-m-d', $project->end_date);

        $interval = DateInterval::createFromDateString ('1 month');
        // project duration by months
        $months = new DatePeriod($from, $interval, $to);
        // first year in the project
        $first_year = $from->year;
        // number of project's years
        $number_of_years = $to->year - $from->year;
        // Get all vacancies for this budget line
        $project_vacancies = ProjectVacancy::with ('payroll_records')->whereHas ('payroll_records', function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('house_allowance_percentage', '>=', '0');
        })
            ->join ('positions', 'positions.id', '=', 'project_vacancies.position_id')
            ->select ('positions.name_en as position', 'project_vacancies.id', 'project_vacancies.name_en',
                'project_vacancies.house_allowance as salary', 'project_vacancies.quantity')
            ->where ('project_vacancies.house_allowance', '>', '0')
            ->distinct ()
            ->get ();
        return view ('layouts.payroll.budget_allocation', compact ('budget_line', 'type', 'months', 'number_of_years', 'first_year', 'users', 'project_vacancies'));
    }

    // User cell_phone allowance
    public function cell_phone_allowance ($id)
    {
        //$users = User::orderBy('first_name_en', 'ASC')->orderBy('last_name_en', 'ASC')->with('Position')->get();
        $budget_line = DetailedProposalBudget::find ($id);
        $type = ['Cell Phone Allowance', 'cell_phone_allowance', 'cell_phone_allowance_percentage', 'cell_phone'];

        $users = User::with (['payroll_records' => function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('cell_phone_allowance_percentage', '>=', '0');
        }])
            ->select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en')
            ->orderBy ('users.first_name_en', 'ASC')->orderBy ('users.last_name_en', 'ASC')
            ->join ('positions', 'positions.id', '=', 'users.position_id')
            ->where ('users.cell_phone_allowance', '>', '0')
            ->distinct ()
            ->get ();

        $missions = Mission::orderBy ('name_en')->get ();
        // Get all vacancies for the current project and fits this budget line
        $project_vacancies = ProjectVacancy::with (['payroll_records' => function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('cell_phone_allowance_percentage', '>=', '0');
        }])
            ->select ('positions.name_en as position', 'project_vacancies.id', 'project_vacancies.name_en',
                'project_vacancies.cell_phone_allowance as salary', 'project_vacancies.quantity', 'project_vacancies.note')
            ->orderBy ('positions.name_en', 'ASC')->orderBy ('project_vacancies.name_en', 'ASC')
            ->join ('positions', 'positions.id', '=', 'project_vacancies.position_id')
            ->where ('project_vacancies.cell_phone_allowance', '>', '0')
            ->get ();

        return view ('layouts.payroll.project_budget', compact ('budget_line', 'type', 'users', 'missions', 'project_vacancies'));
    }

    //Cell phone allowance allocation
    public function cell_phone_allocation ($id)
    {
        $budget_line = DetailedProposalBudget::find ($id);
        $type = ['Cell Phone Allowance', 'cell_phone_allowance', 'cell_phone_allowance_percenage', 'cell_phone'];

        $users = User::with ('payroll_records')->whereHas ('payroll_records', function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('cell_phone_allowance_percentage', '>=', '0');
        })
            ->join ('positions', 'positions.id', '=', 'users.position_id')
            ->select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en as position',
                'users.cell_phone_allowance as salary')
            ->where ('users.cell_phone_allowance', '>', '0')
            ->distinct ()
            ->orderBy ('first_name_en', 'ASC')->orderBy ('last_name_en', 'ASC')
            ->get ();
        // project for this budget_line
        $project = Project::where ('id', $budget_line->project_id)->select ('start_date', 'end_date')->first ();
        // project start date and end date
        $from = Carbon::createFromFormat ('Y-m-d', $project->start_date);
        $to = Carbon::createFromFormat ('Y-m-d', $project->end_date);

        $interval = DateInterval::createFromDateString ('1 month');
        // project duration by months
        $months = new DatePeriod($from, $interval, $to);
        // first year in the project
        $first_year = $from->year;
        // number of project's years
        $number_of_years = $to->year - $from->year;
        // Get all vacancies for this budget line
        $project_vacancies = ProjectVacancy::with ('payroll_records')->whereHas ('payroll_records', function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('cell_phone_allowance_percentage', '>=', '0');
        })
            ->join ('positions', 'positions.id', '=', 'project_vacancies.position_id')
            ->select ('positions.name_en as position', 'project_vacancies.id', 'project_vacancies.name_en',
                'project_vacancies.cell_phone_allowance as salary', 'project_vacancies.quantity')
            ->where ('project_vacancies.cell_phone_allowance', '>', '0')
            ->distinct ()
            ->get ();
        return view ('layouts.payroll.budget_allocation', compact ('budget_line', 'type', 'months', 'number_of_years', 'first_year', 'users', 'project_vacancies'));
    }

    // User cost_of_living allowance
    public function cost_of_living_allowance ($id)
    {
        //$users = User::orderBy('first_name_en', 'ASC')->orderBy('last_name_en', 'ASC')->with('Position')->get();
        $budget_line = DetailedProposalBudget::find ($id);
        $type = ['Cost of Living Allowance', 'cost_of_living_allowance', 'cost_of_living_allowance_percentage', 'cost_of_living'];

        $users = User::with (['payroll_records' => function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('cost_of_living_allowance_percentage', '>=', '0');
        }])
            ->select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en')
            ->orderBy ('users.first_name_en', 'ASC')->orderBy ('users.last_name_en', 'ASC')
            ->join ('positions', 'positions.id', '=', 'users.position_id')
            ->where ('users.cost_of_living_allowance', '>', '0')
            ->distinct ()
            ->get ();

        $missions = Mission::orderBy ('name_en')->get ();
        // Get all vacancies for the current project and fits this budget line
        $project_vacancies = ProjectVacancy::with (['payroll_records' => function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('cost_of_living_allowance_percentage', '>=', '0');
        }])
            ->select ('positions.name_en as position', 'project_vacancies.id', 'project_vacancies.name_en',
                'project_vacancies.cost_of_living_allowance as salary', 'project_vacancies.quantity', 'project_vacancies.note')
            ->orderBy ('positions.name_en', 'ASC')->orderBy ('project_vacancies.name_en', 'ASC')
            ->join ('positions', 'positions.id', '=', 'project_vacancies.position_id')
            ->where ('project_vacancies.cost_of_living_allowance', '>', '0')
            ->get ();

        return view ('layouts.payroll.project_budget', compact ('budget_line', 'type', 'users', 'missions', 'project_vacancies'));
    }

    //Cost of Living Allowance allowance allocation
    public function cost_of_living_allocation ($id)
    {
        $budget_line = DetailedProposalBudget::find ($id);
        $type = ['Cost of Living Allowance', 'cost_of_living_allowance', 'cost_of_living_allowance_percentage', 'cost_of_living'];
        $users = User::with ('payroll_records')->whereHas ('payroll_records', function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('cost_of_living_allowance_percentage', '>=', '0');
        })
            ->join ('positions', 'positions.id', '=', 'users.position_id')
            ->select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en as position',
                'users.cost_of_living_allowance as salary')
            ->where ('users.cost_of_living_allowance', '>', '0')
            ->distinct ()
            ->orderBy ('first_name_en', 'ASC')->orderBy ('last_name_en', 'ASC')
            ->get ();
        // project for this budget_line
        $project = Project::where ('id', $budget_line->project_id)->select ('start_date', 'end_date')->first ();
        // project start date and end date
        $from = Carbon::createFromFormat ('Y-m-d', $project->start_date);
        $to = Carbon::createFromFormat ('Y-m-d', $project->end_date);

        $interval = DateInterval::createFromDateString ('1 month');
        // project duration by months
        $months = new DatePeriod($from, $interval, $to);
        // first year in the project
        $first_year = $from->year;
        // number of project's years
        $number_of_years = $to->year - $from->year;
        // Get all vacancies for this budget line
        $project_vacancies = ProjectVacancy::with ('payroll_records')->whereHas ('payroll_records', function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('cost_of_living_allowance_percentage', '>=', '0');
        })
            ->join ('positions', 'positions.id', '=', 'project_vacancies.position_id')
            ->select ('positions.name_en as position', 'project_vacancies.id', 'project_vacancies.name_en',
                'project_vacancies.cost_of_living_allowance as salary', 'project_vacancies.quantity')
            ->where ('project_vacancies.cost_of_living_allowance', '>', '0')
            ->distinct ()
            ->get ();
        return view ('layouts.payroll.budget_allocation', compact ('budget_line', 'type', 'months', 'number_of_years', 'first_year', 'users', 'project_vacancies'));
    }

    // User Fuel allowance
    public function fuel_allowance ($id)
    {
        //$users = User::orderBy('first_name_en', 'ASC')->orderBy('last_name_en', 'ASC')->with('Position')->get();
        $budget_line = DetailedProposalBudget::find ($id);
        $type = ['Fuel Allowance', 'fuel_allowance', 'fuel_allowance_percentage', 'fuel'];

        $users = User::with (['payroll_records' => function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('fuel_allowance_percentage', '>=', '0');
        }])
            ->select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en')
            ->orderBy ('users.first_name_en', 'ASC')->orderBy ('users.last_name_en', 'ASC')
            ->join ('positions', 'positions.id', '=', 'users.position_id')
            ->where ('users.fuel_allowance', '>', '0')
            ->distinct ()
            ->get ();

        $missions = Mission::orderBy ('name_en')->get ();
        // Get all vacancies for the current project and fits this budget line
        $project_vacancies = ProjectVacancy::with (['payroll_records' => function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('fuel_allowance_percentage', '>=', '0');
        }])
            ->select ('positions.name_en as position', 'project_vacancies.id', 'project_vacancies.name_en',
                'project_vacancies.fuel_allowance as salary', 'project_vacancies.quantity', 'project_vacancies.note')
            ->orderBy ('positions.name_en', 'ASC')->orderBy ('project_vacancies.name_en', 'ASC')
            ->join ('positions', 'positions.id', '=', 'project_vacancies.position_id')
            ->where ('project_vacancies.fuel_allowance', '>', '0')
            ->get ();

        return view ('layouts.payroll.project_budget', compact ('budget_line', 'type', 'users', 'missions', 'project_vacancies'));
    }

    //Fuel of Living Allowance allowance allocation
    public function fuel_allocation ($id)
    {
        $budget_line = DetailedProposalBudget::find ($id);
        $type = ['Fuel Allowance', 'fuel_allowance', 'fuel_allowance_percentage', 'fuel'];
        $users = User::with ('payroll_records')->whereHas ('payroll_records', function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('fuel_allowance_percentage', '>=', '0');
        })
            ->join ('positions', 'positions.id', '=', 'users.position_id')
            ->select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en as position',
                'users.fuel_allowance as salary')
            ->where ('users.fuel_allowance', '>', '0')
            ->distinct ()
            ->orderBy ('first_name_en', 'ASC')->orderBy ('last_name_en', 'ASC')
            ->get ();
        // project for this budget_line
        $project = Project::where ('id', $budget_line->project_id)->select ('start_date', 'end_date')->first ();
        // project start date and end date
        $from = Carbon::createFromFormat ('Y-m-d', $project->start_date);
        $to = Carbon::createFromFormat ('Y-m-d', $project->end_date);

        $interval = DateInterval::createFromDateString ('1 month');
        // project duration by months
        $months = new DatePeriod($from, $interval, $to);
        // first year in the project
        $first_year = $from->year;
        // number of project's years
        $number_of_years = $to->year - $from->year;
        // Get all vacancies for this budget line
        $project_vacancies = ProjectVacancy::with ('payroll_records')->whereHas ('payroll_records', function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('fuel_allowance_percentage', '>=', '0');
        })
            ->join ('positions', 'positions.id', '=', 'project_vacancies.position_id')
            ->select ('positions.name_en as position', 'project_vacancies.id', 'project_vacancies.name_en',
                'project_vacancies.fuel_allowance as salary', 'project_vacancies.quantity')
            ->where ('project_vacancies.fuel_allowance', '>', '0')
            ->distinct ()
            ->get ();
        return view ('layouts.payroll.budget_allocation', compact ('budget_line', 'type', 'months', 'number_of_years', 'first_year', 'users', 'project_vacancies'));
    }

    // User Appearance allowance
    public function appearance_allowance ($id)
    {
        //$users = User::orderBy('first_name_en', 'ASC')->orderBy('last_name_en', 'ASC')->with('Position')->get();
        $budget_line = DetailedProposalBudget::find ($id);
        $type = ['Appearance Allowance', 'appearance_allowance', 'appearance_allowance_percentage', 'appearance'];

        $users = User::with (['payroll_records' => function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('appearance_allowance_percentage', '>=', '0');
        }])
            ->select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en')
            ->orderBy ('users.first_name_en', 'ASC')->orderBy ('users.last_name_en', 'ASC')
            ->join ('positions', 'positions.id', '=', 'users.position_id')
            ->where ('users.appearance_allowance', '>', '0')
            ->distinct ()
            ->get ();

        $missions = Mission::orderBy ('name_en')->get ();
        // Get all vacancies for the current project and fits this budget line
        $project_vacancies = ProjectVacancy::with (['payroll_records' => function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('appearance_allowance_percentage', '>=', '0');
        }])
            ->select ('positions.name_en as position', 'project_vacancies.id', 'project_vacancies.name_en',
                'project_vacancies.appearance_allowance as salary', 'project_vacancies.quantity', 'project_vacancies.note')
            ->orderBy ('positions.name_en', 'ASC')->orderBy ('project_vacancies.name_en', 'ASC')
            ->join ('positions', 'positions.id', '=', 'project_vacancies.position_id')
            ->where ('project_vacancies.appearance_allowance', '>', '0')
            ->get ();

        return view ('layouts.payroll.project_budget', compact ('budget_line', 'type', 'users', 'missions', 'project_vacancies'));
    }

    //Appearance Allowance allowance allocation
    public function appearance_allocation ($id)
    {
        $budget_line = DetailedProposalBudget::find ($id);
        $type = ['Appearance Allowance', 'appearance_allowance', 'appearance_allowance_percentage', 'appearance'];

        $users = User::with ('payroll_records')->whereHas ('payroll_records', function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('appearance_allowance_percentage', '>=', '0');
        })
            ->join ('positions', 'positions.id', '=', 'users.position_id')
            ->select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en as position',
                'users.appearance_allowance as salary')
            ->where ('users.appearance_allowance', '>', '0')
            ->distinct ()
            ->orderBy ('first_name_en', 'ASC')->orderBy ('last_name_en', 'ASC')
            ->get ();
        // project for this budget_line
        $project = Project::where ('id', $budget_line->project_id)->select ('start_date', 'end_date')->first ();
        // project start date and end date
        $from = Carbon::createFromFormat ('Y-m-d', $project->start_date);
        $to = Carbon::createFromFormat ('Y-m-d', $project->end_date);

        $interval = DateInterval::createFromDateString ('1 month');
        // project duration by months
        $months = new DatePeriod($from, $interval, $to);
        // first year in the project
        $first_year = $from->year;
        // number of project's years
        $number_of_years = $to->year - $from->year;
        // Get all vacancies for this budget line
        $project_vacancies = ProjectVacancy::with ('payroll_records')->whereHas ('payroll_records', function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('appearance_allowance_percentage', '>=', '0');
        })
            ->join ('positions', 'positions.id', '=', 'project_vacancies.position_id')
            ->select ('positions.name_en as position', 'project_vacancies.id', 'project_vacancies.name_en',
                'project_vacancies.appearance_allowance as salary', 'project_vacancies.quantity')
            ->where ('project_vacancies.appearance_allowance', '>', '0')
            ->distinct ()
            ->get ();
        return view ('layouts.payroll.budget_allocation', compact ('budget_line', 'type', 'months', 'number_of_years', 'first_year', 'users', 'project_vacancies'));
    }

    // User Work Nature allowance
    public function work_nature_allowance ($id)
    {
        //$users = User::orderBy('first_name_en', 'ASC')->orderBy('last_name_en', 'ASC')->with('Position')->get();
        $budget_line = DetailedProposalBudget::find ($id);
        $type = ['Work Nature Allowance', 'work_nature_allowance', 'work_nature_allowance_percentage', 'work_nature'];

        $users = User::with (['payroll_records' => function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('work_nature_allowance_percentage', '>=', '0');
        }])
            ->select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en')
            ->orderBy ('users.first_name_en', 'ASC')->orderBy ('users.last_name_en', 'ASC')
            ->join ('positions', 'positions.id', '=', 'users.position_id')
            ->where ('users.work_nature_allowance', '>', '0')
            ->distinct ()
            ->get ();

        $missions = Mission::orderBy ('name_en')->get ();
        // Get all vacancies for the current project and fits this budget line
        $project_vacancies = ProjectVacancy::with (['payroll_records' => function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('work_nature_allowance_percentage', '>=', '0');
        }])
            ->select ('positions.name_en as position', 'project_vacancies.id', 'project_vacancies.name_en',
                'project_vacancies.work_nature_allowance as salary', 'project_vacancies.quantity', 'project_vacancies.note')
            ->orderBy ('positions.name_en', 'ASC')->orderBy ('project_vacancies.name_en', 'ASC')
            ->join ('positions', 'positions.id', '=', 'project_vacancies.position_id')
            ->where ('project_vacancies.work_nature_allowance', '>', '0')
            ->get ();

        return view ('layouts.payroll.project_budget', compact ('budget_line', 'type', 'users', 'missions', 'project_vacancies'));
    }

    //work Nature allowance allocation
    public function work_nature_allocation ($id)
    {
        $budget_line = DetailedProposalBudget::find ($id);
        $type = ['Work Nature Allowance', 'work_nature_allowance', 'work_nature_allowance_percentage', 'work_nature'];
        $users = User::with ('payroll_records')->whereHas ('payroll_records', function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('work_nature_allowance_percentage', '>=', '0');
        })
            ->join ('positions', 'positions.id', '=', 'users.position_id')
            ->select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en as position',
                'users.work_nature_allowance as salary')
            ->where ('users.work_nature_allowance', '>', '0')
            ->distinct ()
            ->orderBy ('first_name_en', 'ASC')->orderBy ('last_name_en', 'ASC')
            ->get ();
        // project for this budget_line
        $project = Project::where ('id', $budget_line->project_id)->select ('start_date', 'end_date')->first ();
        // project start date and end date
        $from = Carbon::createFromFormat ('Y-m-d', $project->start_date);
        $to = Carbon::createFromFormat ('Y-m-d', $project->end_date);

        $interval = DateInterval::createFromDateString ('1 month');
        // project duration by months
        $months = new DatePeriod($from, $interval, $to);
        // first year in the project
        $first_year = $from->year;
        // number of project's years
        $number_of_years = $to->year - $from->year;
        // Get all vacancies for this budget line
        $project_vacancies = ProjectVacancy::with ('payroll_records')->whereHas ('payroll_records', function($query) use ($id) {
            $query->where ('detailed_proposal_budget_id', $id)
                ->where ('work_nature_allowance_percentage', '>=', '0');
        })
            ->join ('positions', 'positions.id', '=', 'project_vacancies.position_id')
            ->select ('positions.name_en as position', 'project_vacancies.id', 'project_vacancies.name_en',
                'project_vacancies.work_nature_allowance as salary', 'project_vacancies.quantity')
            ->where ('project_vacancies.work_nature_allowance', '>', '0')
            ->distinct ()
            ->get ();
        return view ('layouts.payroll.budget_allocation', compact ('budget_line', 'type', 'months', 'number_of_years', 'first_year', 'users', 'project_vacancies'));
    }

    public function payroll_report ()
    {
        $missions = Mission::orderBy ('name_en')->get ();

        return view ('layouts.payroll.payroll_report', compact ('missions'));
    }

    public function store_payroll_report (Request $request): ?JsonResponse
    {
        try {
            $deleted_users = DB::table ('payroll_report_users')
                ->whereNull ('payroll_report_users.payroll_report_id')
                ->whereNotIn ('user_id', $request->users)
                ->delete ();
            $month = Carbon::create ($request->year, $request->month, 1);
            $report = PayrollReport::create (['stored_by' => Auth::user ()->full_name, 'name_en' => $request->name_en, 'description' => $request->description, 'month' => $month->format ('Y-m-d')]);
            foreach ($request->users as $user) {
               $info_user= User::find ($user);
                PayrollReportUser::create (['stored_by' => Auth::user ()->full_name,
                                            'payroll_report_id' => $report->id,
                                            'user_id' => $user,
                                            'salary' => $info_user->basic_salary,
                                            'management_allowance' => $info_user->management_allowance,
                                            'transportation_allowance' => $info_user->transportation_allowance,
                                            'house_allowance' => $info_user->house_allowance,
                                            'cell_phone_allowance' => $info_user->cell_phone_allowance,
                                            'cost_of_living_allowance' => $info_user->cost_of_living_allowance,
                                            'fuel_allowance' => $info_user->fuel_allowance,
                                            'appearance_allowance' => $info_user->appearance_allowance,
                                            'work_nature_allowance' => $info_user->work_nature_allowance
                ]);
            }
            return $this->setStatusCode (200)->respond (['status' => true, 'id' => $report->id]);
        } catch (\Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => 'Something is error']);
        }
    }

    public function store_report_user (Request $request)
    {
        if (isset($request->user_salary)){
            foreach ($request->user_salary as $key => $value) {
                PayrollReportRecord::whereNotNull ('salary')->updateOrCreate (
                    ['payroll_report_user_id'      => $request->input ('payroll_report_user_id.' . $key),
                     'month'                       => $request->input ('month.' . $key),
                     'detailed_proposal_budget_id' => $request->input ('detailed_proposal_budget_id.' . $key)],
                    ['payroll_report_user_id'       => $request->input ('payroll_report_user_id.' . $key),
                     'month'                        => $request->input ('month.' . $key),
                     'salary'               => $value,
                     'salary_percentage' => $request->input ('salary_percentage.' . $key),
                     'detailed_proposal_budget_id'  => $request->input ('detailed_proposal_budget_id.' . $key)]);
                if ($value=='' || $value==0){
                    PayrollRecord::where ('user_id', $request->input ('user_id.' . $key))->whereDate ('month',  $request->input ('month.' . $key))->where ('detailed_proposal_budget_id', $request->input ('detailed_proposal_budget_id.' . $key))->update (['status'=>true]);
                }else{
                    PayrollRecord::where ('user_id', $request->input ('user_id.' . $key))->whereDate ('month',  $request->input ('month.' . $key))->where ('detailed_proposal_budget_id', $request->input ('detailed_proposal_budget_id.' . $key))->update (['status'=>false]);

                }
            }
        }
        if (isset($request->management_allowance)) {
            foreach ($request->management_allowance as $key => $value) {
                PayrollReportRecord::whereNotNull ('management_allowance')->updateOrCreate (
                    ['payroll_report_user_id'      => $request->input ('management_payroll_report_user_id.' . $key),
                     'month'                       => $request->input ('management_month.' . $key),
                     'detailed_proposal_budget_id' => $request->input ('management_detailed_proposal_budget_id.' . $key)],
                    ['payroll_report_user_id'          => $request->input ('management_payroll_report_user_id.' . $key),
                     'month'                           => $request->input ('management_month.' . $key),
                     'management_allowance'            => $value,
                     'management_allowance_percentage' => $request->input ('management_allowance_percentage.' . $key),
                     'detailed_proposal_budget_id'     => $request->input ('management_detailed_proposal_budget_id.' . $key)]);
            }
        }
        if (isset($request->transportation_allowance)) {
            foreach ($request->transportation_allowance as $key => $value) {
                PayrollReportRecord::whereNotNull ('transportation_allowance')->updateOrCreate (
                    ['payroll_report_user_id'      => $request->input ('transportation_payroll_report_user_id.' . $key),
                     'month'                       => $request->input ('transportation_month.' . $key),
                     'detailed_proposal_budget_id' => $request->input ('transportation_detailed_proposal_budget_id.' . $key)],
                    ['payroll_report_user_id'          => $request->input ('transportation_payroll_report_user_id.' . $key),
                     'month'                           => $request->input ('transportation_month.' . $key),
                     'transportation_allowance'            => $value,
                     'transportation_allowance_percentage' => $request->input ('transportation_allowance_percentage.' . $key),
                     'detailed_proposal_budget_id'     => $request->input ('transportation_detailed_proposal_budget_id.' . $key)]);
            }
        }
        if (isset($request->house_allowance)) {
            foreach ($request->house_allowance as $key => $value) {
                PayrollReportRecord::whereNotNull ('house_allowance')->updateOrCreate (
                    ['payroll_report_user_id'      => $request->input ('house_payroll_report_user_id.' . $key),
                     'month'                       => $request->input ('house_month.' . $key),
                     'detailed_proposal_budget_id' => $request->input ('house_detailed_proposal_budget_id.' . $key)],
                    ['payroll_report_user_id'          => $request->input ('house_payroll_report_user_id.' . $key),
                     'month'                           => $request->input ('house_month.' . $key),
                     'house_allowance'            => $value,
                     'house_allowance_percentage' => $request->input ('house_allowance_percentage.' . $key),
                     'detailed_proposal_budget_id'     => $request->input ('house_detailed_proposal_budget_id.' . $key)]);
            }
        }
        if (isset($request->cell_phone_allowance)) {
            foreach ($request->cell_phone_allowance as $key => $value) {
                PayrollReportRecord::whereNotNull ('cell_phone_allowance')->updateOrCreate (
                    ['payroll_report_user_id'      => $request->input ('cell_phone_payroll_report_user_id.' . $key),
                     'month'                       => $request->input ('cell_phone_month.' . $key),
                     'detailed_proposal_budget_id' => $request->input ('cell_phone_detailed_proposal_budget_id.' . $key)],
                    ['payroll_report_user_id'          => $request->input ('cell_phone_payroll_report_user_id.' . $key),
                     'month'                           => $request->input ('cell_phone_month.' . $key),
                     'cell_phone_allowance'            => $value,
                     'cell_phone_allowance_percentage' => $request->input ('cell_phone_allowance_percentage.' . $key),
                     'detailed_proposal_budget_id'     => $request->input ('cell_phone_detailed_proposal_budget_id.' . $key)]);
            }
        }
        if (isset($request->cost_of_living_allowance)) {
            foreach ($request->cost_of_living_allowance as $key => $value) {
                PayrollReportRecord::whereNotNull ('cost_of_living_allowance')->updateOrCreate (
                    ['payroll_report_user_id'      => $request->input ('cost_of_living_payroll_report_user_id.' . $key),
                     'month'                       => $request->input ('cost_of_living_month.' . $key),
                     'detailed_proposal_budget_id' => $request->input ('cost_of_living_detailed_proposal_budget_id.' . $key)],
                    ['payroll_report_user_id'          => $request->input ('cost_of_living_payroll_report_user_id.' . $key),
                     'month'                           => $request->input ('cost_of_living_month.' . $key),
                     'cost_of_living_allowance'            => $value,
                     'cost_of_living_allowance_percentage' => $request->input ('cost_of_living_allowance_percentage.' . $key),
                     'detailed_proposal_budget_id'     => $request->input ('cost_of_living_detailed_proposal_budget_id.' . $key)]);
            }
        }
        if (isset($request->fuel_allowance)) {
            foreach ($request->fuel_allowance as $key => $value) {
                PayrollReportRecord::whereNotNull ('fuel_allowance')->updateOrCreate (
                    ['payroll_report_user_id'      => $request->input ('fuel_payroll_report_user_id.' . $key),
                     'month'                       => $request->input ('fuel_month.' . $key),
                     'detailed_proposal_budget_id' => $request->input ('fuel_detailed_proposal_budget_id.' . $key)],
                    ['payroll_report_user_id'          => $request->input ('fuel_payroll_report_user_id.' . $key),
                     'month'                           => $request->input ('fuel_month.' . $key),
                     'fuel_allowance'            => $value,
                     'fuel_allowance_percentage' => $request->input ('fuel_allowance_percentage.' . $key),
                     'detailed_proposal_budget_id'     => $request->input ('fuel_detailed_proposal_budget_id.' . $key)]);
            }
        }
        if (isset($request->appearance_allowance)) {
            foreach ($request->appearance_allowance as $key => $value) {
                PayrollReportRecord::whereNotNull ('appearance_allowance')->updateOrCreate (
                    ['payroll_report_user_id'      => $request->input ('appearance_payroll_report_user_id.' . $key),
                     'month'                       => $request->input ('appearance_month.' . $key),
                     'detailed_proposal_budget_id' => $request->input ('appearance_detailed_proposal_budget_id.' . $key)],
                    ['payroll_report_user_id'          => $request->input ('appearance_payroll_report_user_id.' . $key),
                     'month'                           => $request->input ('appearance_month.' . $key),
                     'appearance_allowance'            => $value,
                     'appearance_allowance_percentage' => $request->input ('appearance_allowance_percentage.' . $key),
                     'detailed_proposal_budget_id'     => $request->input ('appearance_detailed_proposal_budget_id.' . $key)]);
            }
        }
        if (isset($request->work_nature_allowance)) {
            foreach ($request->work_nature_allowance as $key => $value) {
                PayrollReportRecord::whereNotNull ('work_nature_allowance')->updateOrCreate (
                    ['payroll_report_user_id'      => $request->input ('work_nature_payroll_report_user_id.' . $key),
                     'month'                       => $request->input ('work_nature_month.' . $key),
                     'detailed_proposal_budget_id' => $request->input ('work_nature_detailed_proposal_budget_id.' . $key)],
                    ['payroll_report_user_id'          => $request->input ('work_nature_payroll_report_user_id.' . $key),
                     'month'                           => $request->input ('work_nature_month.' . $key),
                     'work_nature_allowance'            => $value,
                     'work_nature_allowance_percentage' => $request->input ('work_nature_allowance_percentage.' . $key),
                     'detailed_proposal_budget_id'     => $request->input ('work_nature_detailed_proposal_budget_id.' . $key)]);
            }
        }
        foreach ($request->unpaid_leave_deduction as $key => $value) {
            $salary = $request->input ('salary.' . $key);
            PayrollReportRecord::where ('payroll_report_user_id', $key)->update (
                ['unpaid_leave_deduction'            => $value,
                 'unpaid_leave_days'                 => $request->input ('unpaid_leave_days.' . $key),
                 'deduction'                         => $request->input ('deduction.' . $key),
                 'deduction_percentage'              => $request->input ('deduction_percentage.' . $key),
                 'unpaid_leave_deduction_percentage' => (($request->input ('unpaid_leave_deduction.' . $key) * 100) / $salary),
                ]);
        }
    }

    public function payroll_report_user ($id)
    {
        $payroll_report = PayrollReport::find ($id);
        $payroll_report_users = User::join ('payroll_report_users', 'payroll_report_users.user_id', '=', 'users.id')
            ->join ('positions', 'positions.id', '=', 'users.position_id')
            ->join ('category_options', 'category_options.position_group_id', '=', 'positions.position_group_id')
            ->join ('detailed_proposal_budgets', 'detailed_proposal_budgets.category_option_id', '=', 'category_options.id')
            ->join ('projects', 'projects.id', '=', 'detailed_proposal_budgets.project_id')
            ->where ('payroll_report_users.payroll_report_id', $id)
            ->orderBy ('users.first_name_en')
            ->orderBy ('users.first_name_en')
            ->orderBy ('projects.name_en')
            ->select ('users.id as user_id', 'users.first_name_en', 'users.last_name_en', 'positions.name_en as position', 'detailed_proposal_budgets.budget_line',
                'category_options.name_en as category_option', 'users.basic_salary', 'projects.name_en as project', 'detailed_proposal_budgets.id', 'payroll_report_users.id as payroll_report_user_id')
            ->get ();
        $payroll_records = PayrollRecord::whereNotNull ('salary_percentage')
            ->where ('month', $payroll_report->month)
            ->whereIn ('user_id', $payroll_report_users->pluck ('user_id')->toArray ())->get ();

        // Management Allowance
        $management_budget_lines = DB::table ('detailed_proposal_budgets')
            ->join ('projects', 'projects.id', '=', 'detailed_proposal_budgets.project_id')
            ->join ('category_options', 'category_options.id', '=', 'detailed_proposal_budgets.category_option_id')
            ->select ('detailed_proposal_budgets.id', 'detailed_proposal_budgets.budget_line', 'projects.name_en as project', 'category_options.name_en as category_option')
            ->whereIn ('category_options.id', array(16036))
            ->orderBy ('projects.name_en')
            ->get ();
        $management_payroll_report_users = DB::table ('users')->join ('positions', 'positions.id', '=', 'users.position_id')
            ->join ('payroll_report_users', 'payroll_report_users.user_id', '=', 'users.id')
            ->where ('payroll_report_users.payroll_report_id', $id)
            ->where ('users.management_allowance', '>', '0')
            ->select ('users.id as user_id', 'users.first_name_en', 'users.last_name_en', 'positions.name_en as position', 'users.management_allowance', 'payroll_report_users.id as payroll_report_user_id')
            ->orderBy ('users.management_allowance', 'DESC')->orderBy ('users.first_name_en')->orderBy ('users.last_name_en')
            ->get ();
        $management_payroll_records = PayrollRecord::whereNotNull ('management_allowance_percentage')
            ->where ('month', $payroll_report->month)
            ->whereIn ('user_id', $management_payroll_report_users->pluck ('user_id')->toArray ())->get ();

        // Transportation Allowance
        $transportation_budget_lines = DB::table ('detailed_proposal_budgets')
            ->join ('projects', 'projects.id', '=', 'detailed_proposal_budgets.project_id')
            ->join ('category_options', 'category_options.id', '=', 'detailed_proposal_budgets.category_option_id')
            ->select ('detailed_proposal_budgets.id', 'detailed_proposal_budgets.budget_line', 'projects.name_en as project', 'category_options.name_en as category_option')
            ->whereIn ('category_options.id', array(20714))
            ->orderBy ('projects.name_en')
            ->get ();
        $transportation_payroll_report_users = DB::table ('users')->join ('positions', 'positions.id', '=', 'users.position_id')
            ->join ('payroll_report_users', 'payroll_report_users.user_id', '=', 'users.id')
            ->where ('payroll_report_users.payroll_report_id', $id)
            ->where ('users.transportation_allowance', '>', '0')
            ->select ('users.id as user_id', 'users.first_name_en', 'users.last_name_en', 'positions.name_en as position', 'users.transportation_allowance', 'payroll_report_users.id as payroll_report_user_id')
            ->orderBy ('users.transportation_allowance', 'DESC')->orderBy ('users.first_name_en')->orderBy ('users.last_name_en')
            ->get ();
        $transportation_payroll_records = PayrollRecord::whereNotNull ('transportation_allowance_percentage')
            ->where ('month', $payroll_report->month)
            ->whereIn ('user_id', $transportation_payroll_report_users->pluck ('user_id')->toArray ())->get ();

        // House Allowance
        $house_budget_lines = DB::table ('detailed_proposal_budgets')
            ->join ('projects', 'projects.id', '=', 'detailed_proposal_budgets.project_id')
            ->join ('category_options', 'category_options.id', '=', 'detailed_proposal_budgets.category_option_id')
            ->select ('detailed_proposal_budgets.id', 'detailed_proposal_budgets.budget_line', 'projects.name_en as project', 'category_options.name_en as category_option')
            ->whereIn ('category_options.id', array(16036))
            ->orderBy ('projects.name_en')
            ->get ();
        $house_payroll_report_users = DB::table ('users')->join ('positions', 'positions.id', '=', 'users.position_id')
            ->join ('payroll_report_users', 'payroll_report_users.user_id', '=', 'users.id')
            ->where ('payroll_report_users.payroll_report_id', $id)
            ->where ('users.house_allowance', '>', '0')
            ->select ('users.id as user_id', 'users.first_name_en', 'users.last_name_en', 'positions.name_en as position', 'users.house_allowance', 'payroll_report_users.id as payroll_report_user_id')
            ->orderBy ('users.house_allowance', 'DESC')->orderBy ('users.first_name_en')->orderBy ('users.last_name_en')
            ->get ();
        $house_payroll_records = PayrollRecord::whereNotNull ('house_allowance_percentage')
            ->where ('month', $payroll_report->month)
            ->whereIn ('user_id', $house_payroll_report_users->pluck ('user_id')->toArray ())->get ();

        // Cell Phone Allowance
        $cell_phone_budget_lines = DB::table ('detailed_proposal_budgets')
            ->join ('projects', 'projects.id', '=', 'detailed_proposal_budgets.project_id')
            ->join ('category_options', 'category_options.id', '=', 'detailed_proposal_budgets.category_option_id')
            ->select ('detailed_proposal_budgets.id', 'detailed_proposal_budgets.budget_line', 'projects.name_en as project', 'category_options.name_en as category_option')
            ->whereIn ('category_options.id', array(16035))
            ->orderBy ('projects.name_en')
            ->get ();
        $cell_phone_payroll_report_users = DB::table ('users')->join ('positions', 'positions.id', '=', 'users.position_id')
            ->join ('payroll_report_users', 'payroll_report_users.user_id', '=', 'users.id')
            ->where ('payroll_report_users.payroll_report_id', $id)
            ->where ('users.cell_phone_allowance', '>', '0')
            ->select ('users.id as user_id', 'users.first_name_en', 'users.last_name_en', 'positions.name_en as position', 'users.cell_phone_allowance', 'payroll_report_users.id as payroll_report_user_id')
            ->orderBy ('users.cell_phone_allowance', 'DESC')->orderBy ('users.first_name_en')->orderBy ('users.last_name_en')
            ->get ();
        $cell_phone_payroll_records = PayrollRecord::whereNotNull ('cell_phone_allowance_percentage')
            ->where ('month', $payroll_report->month)
            ->whereIn ('user_id', $cell_phone_payroll_report_users->pluck ('user_id')->toArray ())->get ();

        // Cost Of Living Allowance
        $cost_of_living_budget_lines = DB::table ('detailed_proposal_budgets')
            ->join ('projects', 'projects.id', '=', 'detailed_proposal_budgets.project_id')
            ->join ('category_options', 'category_options.id', '=', 'detailed_proposal_budgets.category_option_id')
            ->select ('detailed_proposal_budgets.id', 'detailed_proposal_budgets.budget_line', 'projects.name_en as project', 'category_options.name_en as category_option')
            ->whereIn ('category_options.id', array(16035))
            ->orderBy ('projects.name_en')
            ->get ();
        $cost_of_living_payroll_report_users = DB::table ('users')->join ('positions', 'positions.id', '=', 'users.position_id')
            ->join ('payroll_report_users', 'payroll_report_users.user_id', '=', 'users.id')
            ->where ('payroll_report_users.payroll_report_id', $id)
            ->where ('users.cost_of_living_allowance', '>', '0')
            ->select ('users.id as user_id', 'users.first_name_en', 'users.last_name_en', 'positions.name_en as position', 'users.cost_of_living_allowance', 'payroll_report_users.id as payroll_report_user_id')
            ->orderBy ('users.cost_of_living_allowance', 'DESC')->orderBy ('users.first_name_en')->orderBy ('users.last_name_en')
            ->get ();
        $cost_of_living_payroll_records = PayrollRecord::whereNotNull ('cost_of_living_allowance_percentage')
            ->where ('month', $payroll_report->month)
            ->whereIn ('user_id', $cost_of_living_payroll_report_users->pluck ('user_id')->toArray ())->get ();

        // Fuel Allowance
        $fuel_budget_lines = DB::table ('detailed_proposal_budgets')
            ->join ('projects', 'projects.id', '=', 'detailed_proposal_budgets.project_id')
            ->join ('category_options', 'category_options.id', '=', 'detailed_proposal_budgets.category_option_id')
            ->select ('detailed_proposal_budgets.id', 'detailed_proposal_budgets.budget_line', 'projects.name_en as project', 'category_options.name_en as category_option')
            ->whereIn ('category_options.id', array(16035))
            ->orderBy ('projects.name_en')
            ->get ();
        $fuel_payroll_report_users = DB::table ('users')->join ('positions', 'positions.id', '=', 'users.position_id')
            ->join ('payroll_report_users', 'payroll_report_users.user_id', '=', 'users.id')
            ->where ('payroll_report_users.payroll_report_id', $id)
            ->where ('users.fuel_allowance', '>', '0')
            ->select ('users.id as user_id', 'users.first_name_en', 'users.last_name_en', 'positions.name_en as position', 'users.fuel_allowance', 'payroll_report_users.id as payroll_report_user_id')
            ->orderBy ('users.fuel_allowance', 'DESC')->orderBy ('users.first_name_en')->orderBy ('users.last_name_en')
            ->get ();
        $fuel_payroll_records = PayrollRecord::whereNotNull ('fuel_allowance_percentage')
            ->where ('month', $payroll_report->month)
            ->whereIn ('user_id', $fuel_payroll_report_users->pluck ('user_id')->toArray ())->get ();

        // Appearance Allowance
        $appearance_budget_lines = DB::table ('detailed_proposal_budgets')
            ->join ('projects', 'projects.id', '=', 'detailed_proposal_budgets.project_id')
            ->join ('category_options', 'category_options.id', '=', 'detailed_proposal_budgets.category_option_id')
            ->select ('detailed_proposal_budgets.id', 'detailed_proposal_budgets.budget_line', 'projects.name_en as project', 'category_options.name_en as category_option')
            ->whereIn ('category_options.id', array(16035))
            ->orderBy ('projects.name_en')
            ->get ();
        $appearance_payroll_report_users = DB::table ('users')->join ('positions', 'positions.id', '=', 'users.position_id')
            ->join ('payroll_report_users', 'payroll_report_users.user_id', '=', 'users.id')
            ->where ('payroll_report_users.payroll_report_id', $id)
            ->where ('users.appearance_allowance', '>', '0')
            ->select ('users.id as user_id', 'users.first_name_en', 'users.last_name_en', 'positions.name_en as position', 'users.appearance_allowance', 'payroll_report_users.id as payroll_report_user_id')
            ->orderBy ('users.appearance_allowance', 'DESC')->orderBy ('users.first_name_en')->orderBy ('users.last_name_en')
            ->get ();
        $appearance_payroll_records = PayrollRecord::whereNotNull ('appearance_allowance_percentage')
            ->where ('month', $payroll_report->month)
            ->whereIn ('user_id', $appearance_payroll_report_users->pluck ('user_id')->toArray ())->get ();

        // Work Nature Allowance
        $work_nature_budget_lines = DB::table ('detailed_proposal_budgets')
            ->join ('projects', 'projects.id', '=', 'detailed_proposal_budgets.project_id')
            ->join ('category_options', 'category_options.id', '=', 'detailed_proposal_budgets.category_option_id')
            ->select ('detailed_proposal_budgets.id', 'detailed_proposal_budgets.budget_line', 'projects.name_en as project', 'category_options.name_en as category_option')
            ->whereIn ('category_options.id', array(16035))
            ->orderBy ('projects.name_en')
            ->get ();
        $work_nature_payroll_report_users = DB::table ('users')->join ('positions', 'positions.id', '=', 'users.position_id')
            ->join ('payroll_report_users', 'payroll_report_users.user_id', '=', 'users.id')
            ->where ('payroll_report_users.payroll_report_id', $id)
            ->where ('users.work_nature_allowance', '>', '0')
            ->select ('users.id as user_id', 'users.first_name_en', 'users.last_name_en', 'positions.name_en as position', 'users.work_nature_allowance', 'payroll_report_users.id as payroll_report_user_id')
            ->orderBy ('users.work_nature_allowance', 'DESC')->orderBy ('users.first_name_en')->orderBy ('users.last_name_en')
            ->get ();
        $work_nature_payroll_records = PayrollRecord::whereNotNull ('work_nature_allowance_percentage')
            ->where ('month', $payroll_report->month)
            ->whereIn ('user_id', $work_nature_payroll_report_users->pluck ('user_id')->toArray ())->get ();

        $payroll_users = DB::table ('users')->select ('payroll_report_users.id', 'users.first_name_en', 'users.last_name_en', 'positions.name_en as position', 'users.basic_salary',
            DB::raw ('sum(leaverequest.leavedays) as days'))
            ->groupBy ('payroll_report_users.id', 'users.first_name_en', 'users.last_name_en', 'positions.name_en', 'users.basic_salary')
            ->join ('positions', 'positions.id', '=', 'users.position_id')
            ->leftJoin ('leaverequest', 'leaverequest.userid', '=', 'users.id', function($query) {
                $query->on ('leavetypeid', '=', 50000)->on ('status', '=', 170);
            })
            ->join ('payroll_report_users', 'payroll_report_users.user_id', '=', 'users.id')
            ->where ('payroll_report_users.payroll_report_id', $id)
            ->distinct ()
            ->get ();

        return view ('layouts.payroll.payroll_report_user', compact ('payroll_report', 'payroll_report_users', 'payroll_records',
            'management_payroll_report_users', 'management_payroll_records', 'management_budget_lines',
            'transportation_payroll_report_users', 'transportation_payroll_records', 'transportation_budget_lines',
            'house_payroll_report_users', 'house_payroll_records', 'house_budget_lines',
            'cell_phone_payroll_report_users', 'cell_phone_payroll_records', 'cell_phone_budget_lines',
            'cost_of_living_payroll_report_users', 'cost_of_living_payroll_records', 'cost_of_living_budget_lines',
            'fuel_payroll_report_users', 'fuel_payroll_records', 'fuel_budget_lines',
            'appearance_payroll_report_users', 'appearance_payroll_records', 'appearance_budget_lines',
            'work_nature_payroll_report_users', 'work_nature_payroll_records', 'work_nature_budget_lines',
            'payroll_users'));
    }

    public function project_vacancy ($id)
    {

        $project = Project::find ($id);
        $departments = DB::table ('departments')
            ->select ('departments_missions.id', 'departments.name_en')
            ->join ('departments_missions', 'departments_missions.department_id', '=', 'departments.id')
            ->whereIN ('departments_missions.mission_id', function($query) use ($id) {
                $query->select ('departments_missions.mission_id')->from ('departments_missions')
                    ->join ('sectors_departments', 'sectors_departments.department_id', '=', 'departments_missions.id')
                    ->join ('sectors', 'sectors.id', '=', 'sectors_departments.sector_id')
                    ->join ('projects', 'projects.sector_id', '=', 'sectors_departments.id')
                    ->where ('projects.id', $id);
            })
            ->get ();
        $positions = Position::orderBy ('name_en')->get ();
        $vacancies = ProjectVacancy::where ('project_id', $id)->get ();
        return view ('layouts.payroll.project_vacancy', compact ('project', 'departments', 'positions', 'vacancies'));

    }

    public function save_project_vacancy (Request $request): ?JsonResponse
    {
        try {
            $ids = [];
            foreach ($request->vacancy as $value) {
                $value['project_id'] = $request->project_id;
                if (is_null ($value['id'])) {
                    unset($value['id']);
                    $new = ProjectVacancy::create ($value);
                    $ids[] = $new->id;
                } else {
                    $id = $value['id'];
                    unset($value['id']);
                    $ids[] = $id;
                    ProjectVacancy::find ($id)->update ($value);
                }
            }
            ProjectVacancy::whereNotIn ('id', $ids)->delete ();
            return $this->setStatusCode (200)->respond (['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => 'Something is error']);
        }
    }

    public function payroll_report_edit ($id)
    {
        $payroll_report = PayrollReport::find ($id);
        $missions = Mission::orderBy ('name_en')->get ();
        $payroll_report_users = PayrollReportUser::select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en as position')
            ->join ('users', 'users.id', '=', 'payroll_report_users.user_id')
            ->join ('positions', 'positions.id', '=', 'users.position_id')
            ->orderBy ('users.first_name_en')->orderBy ('last_name_en')
            ->where ('payroll_report_users.payroll_report_id', $id)
            ->get ();
        $users = DB::table ('users')
            ->select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en as position')
            ->orderBy ('users.first_name_en')->orderBy ('users.last_name_en')
            ->join ('positions', 'positions.id', '=', 'users.position_id')
            ->WhereNotIn ('users.id', function($query) use ($payroll_report) {
                $query->select ('user_id')->from ('payroll_report_users')
                    ->join ('payroll_reports', 'payroll_reports.id', '=', 'payroll_report_users.payroll_report_id')
                    ->where ('payroll_reports.month', $payroll_report->month);
            })
            ->get ();
        return view ('layouts.payroll.payroll_report_edit', compact ('payroll_report', 'missions', 'payroll_report_users', 'users'));
    }

    public function payroll_report_user_edit ($id)
    {
        $payroll_report = PayrollReport::find ($id);
        $payroll_report_users = PayrollReportUser::with (['payroll_report_records' => function($query) {
            $query->where ('salary_percentage', '>', '0');
        }]) ->select ('users.id as user_id', 'users.first_name_en', 'users.last_name_en', 'positions.name_en as position', 'detailed_proposal_budgets.budget_line',
                'category_options.name_en as category_option', 'users.basic_salary', 'projects.name_en as project', 'detailed_proposal_budgets.id as detailed_proposal_budget_id',
                'payroll_report_users.id')
            ->join ('payroll_reports', 'payroll_reports.id', '=', 'payroll_report_users.payroll_report_id')
            ->join ('users', 'users.id', '=', 'payroll_report_users.user_id')
            ->join ('positions', 'positions.id', '=', 'users.position_id')
            ->join ('category_options', 'category_options.position_group_id', '=', 'positions.position_group_id')
            ->join ('detailed_proposal_budgets', 'detailed_proposal_budgets.category_option_id', '=', 'category_options.id')
            ->join ('projects', 'projects.id', '=', 'detailed_proposal_budgets.project_id')
            ->where ('payroll_report_users.payroll_report_id', $id)
            ->orderBy ('users.first_name_en')->orderBy ('users.first_name_en')->orderBy ('projects.name_en')
            ->get ();

        // Management Allowance
        $management_budget_lines = DB::table ('detailed_proposal_budgets')
            ->join ('projects', 'projects.id', '=', 'detailed_proposal_budgets.project_id')
            ->join ('category_options', 'category_options.id', '=', 'detailed_proposal_budgets.category_option_id')
            ->select ('detailed_proposal_budgets.id as detailed_proposal_budget_id', 'detailed_proposal_budgets.budget_line', 'projects.name_en as project', 'category_options.name_en as category_option')
            ->whereIn ('category_options.id', array(16036))
            ->orderBy ('projects.name_en')
            ->distinct ()
            ->get ();
        $management_payroll_report_users = PayrollReportUser::with (['payroll_report_records' => function($query) {
            $query->where ('management_allowance_percentage', '>', '0');
        }])
            ->join ('users', 'users.id', '=', 'payroll_report_users.user_id')
            ->join ('positions', 'positions.id', '=', 'users.position_id')
            ->where ('payroll_report_users.payroll_report_id', $id)
            ->where ('users.management_allowance', '>', '0')
            ->select ('payroll_report_users.id', 'users.id as user_id', 'users.first_name_en', 'users.last_name_en', 'positions.name_en as position', 'users.management_allowance')
            ->orderBy ('users.first_name_en')->orderBy ('users.last_name_en')
            ->distinct ()
            ->get ();

        // Transportation Allowance
        $transportation_budget_lines = DB::table ('detailed_proposal_budgets')
            ->join ('projects', 'projects.id', '=', 'detailed_proposal_budgets.project_id')
            ->join ('category_options', 'category_options.id', '=', 'detailed_proposal_budgets.category_option_id')
            ->select ('detailed_proposal_budgets.id as detailed_proposal_budget_id', 'detailed_proposal_budgets.budget_line', 'projects.name_en as project', 'category_options.name_en as category_option')
            ->whereIn ('category_options.id', array(16036))
            ->orderBy ('projects.name_en')
            ->distinct ()
            ->get ();
        $transportation_payroll_report_users = PayrollReportUser::with (['payroll_report_records' => function($query) {
            $query->where ('transportation_allowance_percentage', '>', '0');
        }])
            ->join ('users', 'users.id', '=', 'payroll_report_users.user_id')
            ->join ('positions', 'positions.id', '=', 'users.position_id')
            ->where ('payroll_report_users.payroll_report_id', $id)
            ->where ('users.transportation_allowance', '>', '0')
            ->select ('payroll_report_users.id', 'users.id as user_id', 'users.first_name_en', 'users.last_name_en', 'positions.name_en as position', 'users.transportation_allowance')
            ->orderBy ('users.first_name_en')->orderBy ('users.last_name_en')
            ->distinct ()
            ->get ();

        // House Allowance
        $house_budget_lines = DB::table ('detailed_proposal_budgets')
            ->join ('projects', 'projects.id', '=', 'detailed_proposal_budgets.project_id')
            ->join ('category_options', 'category_options.id', '=', 'detailed_proposal_budgets.category_option_id')
            ->select ('detailed_proposal_budgets.id as detailed_proposal_budget_id', 'detailed_proposal_budgets.budget_line', 'projects.name_en as project', 'category_options.name_en as category_option')
            ->whereIn ('category_options.id', array(16036))
            ->orderBy ('projects.name_en')
            ->distinct ()
            ->get ();
        $house_payroll_report_users = PayrollReportUser::with (['payroll_report_records' => function($query) {
            $query->where ('house_allowance_percentage', '>', '0');
        }])
            ->join ('users', 'users.id', '=', 'payroll_report_users.user_id')
            ->join ('positions', 'positions.id', '=', 'users.position_id')
            ->where ('payroll_report_users.payroll_report_id', $id)
            ->where ('users.house_allowance', '>', '0')
            ->select ('payroll_report_users.id', 'users.id as user_id', 'users.first_name_en', 'users.last_name_en', 'positions.name_en as position', 'users.house_allowance')
            ->orderBy ('users.first_name_en')->orderBy ('users.last_name_en')
            ->distinct ()
            ->get ();

        // Cell Phone Allowance
        $cell_phone_budget_lines = DB::table ('detailed_proposal_budgets')
            ->join ('projects', 'projects.id', '=', 'detailed_proposal_budgets.project_id')
            ->join ('category_options', 'category_options.id', '=', 'detailed_proposal_budgets.category_option_id')
            ->select ('detailed_proposal_budgets.id as detailed_proposal_budget_id', 'detailed_proposal_budgets.budget_line', 'projects.name_en as project', 'category_options.name_en as category_option')
            ->whereIn ('category_options.id', array(16036))
            ->orderBy ('projects.name_en')
            ->distinct ()
            ->get ();
        $cell_phone_payroll_report_users = PayrollReportUser::with (['payroll_report_records' => function($query) {
            $query->where ('cell_phone_allowance_percentage', '>', '0');
        }])
            ->join ('users', 'users.id', '=', 'payroll_report_users.user_id')
            ->join ('positions', 'positions.id', '=', 'users.position_id')
            ->where ('payroll_report_users.payroll_report_id', $id)
            ->where ('users.cell_phone_allowance', '>', '0')
            ->select ('payroll_report_users.id', 'users.id as user_id', 'users.first_name_en', 'users.last_name_en', 'positions.name_en as position', 'users.cell_phone_allowance')
            ->orderBy ('users.first_name_en')->orderBy ('users.last_name_en')
            ->distinct ()
            ->get ();

        // Cost of Living Allowance
        $cost_of_living_budget_lines = DB::table ('detailed_proposal_budgets')
            ->join ('projects', 'projects.id', '=', 'detailed_proposal_budgets.project_id')
            ->join ('category_options', 'category_options.id', '=', 'detailed_proposal_budgets.category_option_id')
            ->select ('detailed_proposal_budgets.id as detailed_proposal_budget_id', 'detailed_proposal_budgets.budget_line', 'projects.name_en as project', 'category_options.name_en as category_option')
            ->whereIn ('category_options.id', array(16036))
            ->orderBy ('projects.name_en')
            ->distinct ()
            ->get ();
        $cost_of_living_payroll_report_users = PayrollReportUser::with (['payroll_report_records' => function($query) {
            $query->where ('cost_of_living_allowance_percentage', '>', '0');
        }])
            ->join ('users', 'users.id', '=', 'payroll_report_users.user_id')
            ->join ('positions', 'positions.id', '=', 'users.position_id')
            ->where ('payroll_report_users.payroll_report_id', $id)
            ->where ('users.cost_of_living_allowance', '>', '0')
            ->select ('payroll_report_users.id', 'users.id as user_id', 'users.first_name_en', 'users.last_name_en', 'positions.name_en as position', 'users.cost_of_living_allowance')
            ->orderBy ('users.first_name_en')->orderBy ('users.last_name_en')
            ->distinct ()
            ->get ();

        // Fuel Allowance
        $fuel_budget_lines = DB::table ('detailed_proposal_budgets')
            ->join ('projects', 'projects.id', '=', 'detailed_proposal_budgets.project_id')
            ->join ('category_options', 'category_options.id', '=', 'detailed_proposal_budgets.category_option_id')
            ->select ('detailed_proposal_budgets.id as detailed_proposal_budget_id', 'detailed_proposal_budgets.budget_line', 'projects.name_en as project', 'category_options.name_en as category_option')
            ->whereIn ('category_options.id', array(16036))
            ->orderBy ('projects.name_en')
            ->distinct ()
            ->get ();
        $fuel_payroll_report_users = PayrollReportUser::with (['payroll_report_records' => function($query) {
            $query->where ('fuel_allowance_percentage', '>', '0');
        }])
            ->join ('users', 'users.id', '=', 'payroll_report_users.user_id')
            ->join ('positions', 'positions.id', '=', 'users.position_id')
            ->where ('payroll_report_users.payroll_report_id', $id)
            ->where ('users.fuel_allowance', '>', '0')
            ->select ('payroll_report_users.id', 'users.id as user_id', 'users.first_name_en', 'users.last_name_en', 'positions.name_en as position', 'users.fuel_allowance')
            ->orderBy ('users.first_name_en')->orderBy ('users.last_name_en')
            ->distinct ()
            ->get ();

        // Appearance Allowance
        $appearance_budget_lines = DB::table ('detailed_proposal_budgets')
            ->join ('projects', 'projects.id', '=', 'detailed_proposal_budgets.project_id')
            ->join ('category_options', 'category_options.id', '=', 'detailed_proposal_budgets.category_option_id')
            ->select ('detailed_proposal_budgets.id as detailed_proposal_budget_id', 'detailed_proposal_budgets.budget_line', 'projects.name_en as project', 'category_options.name_en as category_option')
            ->whereIn ('category_options.id', array(16036))
            ->orderBy ('projects.name_en')
            ->distinct ()
            ->get ();
        $appearance_payroll_report_users = PayrollReportUser::with (['payroll_report_records' => function($query) {
            $query->where ('appearance_allowance_percentage', '>', '0');
        }])
            ->join ('users', 'users.id', '=', 'payroll_report_users.user_id')
            ->join ('positions', 'positions.id', '=', 'users.position_id')
            ->where ('payroll_report_users.payroll_report_id', $id)
            ->where ('users.appearance_allowance', '>', '0')
            ->select ('payroll_report_users.id', 'users.id as user_id', 'users.first_name_en', 'users.last_name_en', 'positions.name_en as position', 'users.appearance_allowance')
            ->orderBy ('users.first_name_en')->orderBy ('users.last_name_en')
            ->distinct ()
            ->get ();

        // Work Nature Allowance
        $work_nature_budget_lines = DB::table ('detailed_proposal_budgets')
            ->join ('projects', 'projects.id', '=', 'detailed_proposal_budgets.project_id')
            ->join ('category_options', 'category_options.id', '=', 'detailed_proposal_budgets.category_option_id')
            ->select ('detailed_proposal_budgets.id as detailed_proposal_budget_id', 'detailed_proposal_budgets.budget_line', 'projects.name_en as project', 'category_options.name_en as category_option')
            ->whereIn ('category_options.id', array(16036))
            ->orderBy ('projects.name_en')
            ->distinct ()
            ->get ();
        $work_nature_payroll_report_users = PayrollReportUser::with (['payroll_report_records' => function($query) {
            $query->where ('work_nature_allowance_percentage', '>', '0');
        }])
            ->join ('users', 'users.id', '=', 'payroll_report_users.user_id')
            ->join ('positions', 'positions.id', '=', 'users.position_id')
            ->where ('payroll_report_users.payroll_report_id', $id)
            ->where ('users.work_nature_allowance', '>', '0')
            ->select ('payroll_report_users.id', 'users.id as user_id', 'users.first_name_en', 'users.last_name_en', 'positions.name_en as position', 'users.work_nature_allowance')
            ->orderBy ('users.first_name_en')->orderBy ('users.last_name_en')
            ->distinct ()
            ->get ();
        $payroll_users =  PayrollReportUser::select ('users.id as user_id', 'users.first_name_en', 'users.last_name_en', 'positions.name_en as position',
            'category_options.name_en as category_option', 'users.basic_salary', 'projects.name_en as project',
            'payroll_report_users.id')
            ->join ('payroll_reports', 'payroll_reports.id', '=', 'payroll_report_users.payroll_report_id')
            ->join ('users', 'users.id', '=', 'payroll_report_users.user_id')
            ->join ('positions', 'positions.id', '=', 'users.position_id')
            ->join ('category_options', 'category_options.position_group_id', '=', 'positions.position_group_id')
            ->join ('detailed_proposal_budgets', 'detailed_proposal_budgets.category_option_id', '=', 'category_options.id')
            ->join ('projects', 'projects.id', '=', 'detailed_proposal_budgets.project_id')
            ->where ('payroll_report_users.payroll_report_id', $id)
            ->distinct ()
            ->orderBy ('users.first_name_en')->orderBy ('users.first_name_en')->orderBy ('projects.name_en')
            ->get ();

//        $payroll_users = DB::table ('users')
//            ->select ('users.id','users.first_name_en', 'users.last_name_en', 'positions.name_en as position', 'users.basic_salary',
//                'payroll_report_users.deduction', 'payroll_report_users.deduction_percentage', 'payroll_report_users.total_deduction', 'payroll_report_records.id')
//            ->groupBy ('users.id','users.first_name_en', 'users.last_name_en', 'positions.name_en', 'users.basic_salary', 'payroll_report_users.deduction',
//                'payroll_report_users.deduction_percentage', 'payroll_report_users.total_deduction', 'payroll_report_records.id')
//            ->join ('positions', 'positions.id', '=', 'users.position_id')
//            ->join ('payroll_report_users', 'payroll_report_users.user_id', '=', 'users.id')
//            ->join ('payroll_report_records', 'payroll_report_records.payroll_report_user_id', '=', 'payroll_report_users.id')
//            ->where ('payroll_report_users.payroll_report_id', $id)
//            ->distinct ()
//            ->get ();

        return view ('layouts.payroll.payroll_report_user_edit', compact ('payroll_report', 'payroll_report_users',
            'management_budget_lines', 'management_payroll_report_users',
            'transportation_budget_lines', 'transportation_payroll_report_users',
            'house_budget_lines', 'house_payroll_report_users',
            'cell_phone_budget_lines', 'cell_phone_payroll_report_users',
            'cost_of_living_budget_lines', 'cost_of_living_payroll_report_users',
            'fuel_budget_lines', 'fuel_payroll_report_users',
            'appearance_budget_lines', 'appearance_payroll_report_users',
            'work_nature_budget_lines', 'work_nature_payroll_report_users',
            'payroll_users'));
    }

    public function print ($id): void
    {


        $payroll = PayrollReport::where ('id', $id)->first ();

        PDF::setHeaderCallback (function($pdf) {
            $pdf->SetAutoPageBreak (false, PDF_MARGIN_BOTTOM);
            $img_file = K_PATH_IMAGES . 'back-ground-i.png';
            $pdf->Image ($img_file, 0, 0, 300, 210, '', '', '', false, 300, '', false, false, 0);
            $pdf->SetAutoPageBreak (true, PDF_MARGIN_BOTTOM);
        });

        PDF::setFooterCallback (function($pdf) {
            // Position at 15 mm from bottom
            $pdf->SetY (-15);
            $pdf->SetX (-15);
            // Set font
            $pdf->SetFont ('helveticaneueltarabiclight', 'I', 6);
            $pdf->SetTextColor (128, 128, 128);
            $pdf->SetFooterMargin (PDF_MARGIN_FOOTER);

            // Page number
            $pdf->Cell (0, 10, 'Page ' . $pdf->getAliasNumPage () . '/' . $pdf->getAliasNbPages (), 0, false, 'C', 0, '', 0, false, 'T', 'M');

        });
        PDF::SetMargins (PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        PDF::SetAuthor ('ERP QRCS');
        PDF::SetTitle ('Payroll-' . $id);
        PDF::SetSubject ('Payroll-' . $id);
        PDF::SetFont('helveticaneueltarabiclight','',5);
        PDF::AddPage ('L', 'A4');

        $table = '';
        foreach ($payroll->payroll_report_users as $key => $value) {
            $table_2 = '';
            $deduction = 0;
            $unpaid_leave = 0;
            foreach ($value->payroll_report_records as $key2 => $value2) {
                if ($key2==0){
                    $deduction += $value2->deduction + $value2->unpaid_leave_deduction;
                }
                $unpaid_leave = $value2->unpaid_leave_days;
                if ($value2->detailed_proposal_budget_id != '' && $value2->salary != '') {
                    $table_2 .= '<tr >
                                                  <td   width="35">' . $value2->detailed_proposal_budget->donor->name_en . '<<br>>' . '</td>

                                                  <td    width="80" >' . $value2->detailed_proposal_budget->project->name_en . '<br>' . '</td>
                                                  <td    width="30">' . $value2->detailed_proposal_budget->budget_line . '<br>' . '</td>
                                                  <td       width="27">' . $value2->salary . '<br>' . '</td>
</tr>';
                }


            }
            $total = ((int)$value->user->basic_salary + (int)$value->user->cell_phone_allowance + (int)$value->user->transportation_allowance + (int)$value->user->management_allowance + (int)$value->user->house_allowance + (int)$value->user->cost_of_living_allowance + (int)$value->user->appearance_allowance) - (int)$deduction;
            $table .= '<tr width="100%">
                                                   <td >' . ++$key . '</td>
                                                   <td >' . $value->user->department->department->name_en . '</td>
                                                   <td >' . $value->user->financial_code . '</td>
                                                   <td >' . $value->user->first_name_ar . ' ' . $value->user->last_name_ar . '</td>
                                                  <td >' . $value->user->full_name . '</td>
                                                  <td >' . $value->user->position->name_en . '</td>
                                                  <td>' . $value->user->basic_salary . '</td>
                                                  <td >' . $unpaid_leave . '</td>
                                                 <td   >' . $value->user->cell_phone_allowance . '</td>
                                                  <td >' . $value->user->transportation_allowance . '</td>
                                                  <td >' . $value->user->management_allowance . '</td>
                                                  <td >' . $value->user->house_allowance . '</td>
                                                  <td  >' . $value->user->cost_of_living_allowance . '</td>
                                                  <td  >' . $value->user->appearance_allowance . '</td>
                                                  <td >' . $deduction . '</td>
                                                  <td >' . $total . '</td>
                                                  <td ><table  border="0.1" >' . $table_2 . '</table></td>
                                                  <td ></td>
                                                  <td ></td>
                                                  <td ></td>
                                                  <td width="80"></td>
                                                  </tr>';

        }


        $tbl = '<table align="centre"  border="0.1" >
    <tr style="background-color:#e1e0dd">
        <th width="10" valign="centre" rowspan="2">#</th>
        <th rowspan="2">Department</th>
        <th rowspan="2">Financial Code</th>
        <th rowspan="2">Name Ar</th>
        <th rowspan="2">Name En</th>
        <th rowspan="2">Position</th>
        <th rowspan="2">Salary ($)</th>
        <th rowspan="2">Unpaid Leave</th>
        <th rowspan="2">Communications ($)</th>
        <th rowspan="2">Transportation ($)</th>
        <th rowspan="2">Management  ($)</th>
        <th rowspan="2">Housing ($)</th>
        <th rowspan="2">Cost Of Living ($)</th>
        <th rowspan="2">Appearance ($)</th>
        <th rowspan="2">Deduction ($)</th>
        <th width="20" rowspan="2">Total ($)</th>
        <th colspan="5">Allocate Project</th>
        <th width="80" rowspan="2">Remark</th>
    </tr>
    <tr  style="background-color:#e1e0dd">
        <th width="35">Donor </th>
        <th width="80">Project Name</th>
        <th width="30">BudgetLines</th>
        <th width="27">Allocate ($)</th>
    </tr>
    ' . $table . '
</table>';
        PDF::writeHTML ($tbl, true, false, false, false, '');
        PDF::Output ('Payroll-' . $id . '.pdf', 'I');

    }


}
