<?php

namespace App\Http\Controllers\Project;

use DB;
use PDF;
use Auth;
use Carbon\Carbon;
use App\Model\Stage;
use App\Model\Backup;
use App\Model\Status;
use App\Model\Hr\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Model\Project\Output;
use App\Model\Project\Outcome;
use App\Model\Project\Project;
use App\Model\NotificationType;
use App\Model\Project\Activitie;
use App\Model\Project\Indicator;
use Illuminate\Http\JsonResponse;
use App\Model\ProjectNotification;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use App\Model\ControlPanel\Hr\Sector;
use App\Model\Project\ProjectAccount;
use Illuminate\Http\RedirectResponse;
use App\Model\Project\BudgetCategory;
use App\Model\ControlPanel\Hr\Mission;
use App\Model\Project\DetailedProposal;
use App\Model\ControlPanel\Project\Unit;
use App\Model\ControlPanel\Hr\Department;
use App\Model\ControlPanel\Project\Donor;
use App\Model\Project\ProposalBeneficiary;
use App\Model\ProjectNotificationStructure;
use App\Http\Requests\Project\Project\Store;
use App\Http\Requests\Project\Project\Update;
use App\Model\Project\DetailedProposalBudget;
use App\Model\ControlPanel\Hr\SectorDepartment;
use App\Model\ControlPanel\Hr\DepartmentMission;
use App\Model\ControlPanel\Project\ProjectDonor;
use App\Http\Resources\Project\ProjectCollection;
use App\Model\ControlPanel\Project\ActivityPhase;
use App\Model\ControlPanel\Project\ProjectReport;
use App\Model\ControlPanel\Project\CategoryOption;
use App\Model\ControlPanel\Project\ProjectDonorPayment;
use App\Model\ControlPanel\Project\ProjectResponsibility;
use App\Http\Resources\DetailedProposalBudget\DetailedProposalBudgetCollection;

/**
 * Class ProjectController
 * @package App\Http\Controllers\Project
 */
class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index (): View
    {
        $this->data['nested_url_department_multiple'] = route ('nested_department_mission_multiple');
        $this->data['nested_url_sector_multiple'] = route ('nested_sector_department_multiple');
        $this->data['missions'] = $this->select_box (new Mission(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), '');
        $this->data['departments'] = $this->select_box (new Department(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), '');
        $this->data['sectors'] = $this->select_box (new Sector(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), '');
        $this->data['stages'] = $this->select_box (new Stage(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), '', 'id in (select  distinct "stage_id" from projects)');
        $this->data['statuses'] = $this->select_box (new Status(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), '', 'id in (select  distinct "status_id" from projects)');
        return view ('layouts.project.index', $this->data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index_budget_line ($project_id): View
    {
        $this->data['id'] = $project_id;
        return view ('layouts.project.index_budget_line', $this->data);
    }


    /**
     * @param Project $project
     * @param Request $request
     * @return JsonResponse
     */
    public function get_budget_line (Project $project, Request $request)
    {
//       print_r ($request->all ()) ;
//       print_r ($project);
        $page = $request->input ('pagination.page');
        $search = $request->input ('query.generalSearch', null);
        $perpage = $request->input ('pagination.perpage', 10);
        $sortOrder = $request->input ('sort.sort', 'asc');
        $sortField = $request->input ('sort.field', 'budget_line');
        $offset = ($page - 1) * $perpage;
        $query = $project->detailed_proposal_budget ();
        if (!is_null ($search)) {
            $query->whereRaw ("(budget_line  ilike '%$search%' )");
        }
        $totalCount = $query->count ();
//
        $query->offset ($offset)
            ->limit ($perpage)
            ->orderBy ($sortField, $sortOrder);
        $data = $query->get ();
        $request->offsetSet ('pages', ceil ($totalCount / $perpage));
        $request->offsetSet ('total', $totalCount);
        return $this->resources (new DetailedProposalBudgetCollection($data));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function get_all (Request $request): JsonResponse
    {
        $page = $request->input ('pagination.page');
        $search = $request->input ('query.generalSearch', null);
        $perpage = $request->input ('pagination.perpage', 10);
        $sortOrder = $request->input ('sort.sort', 'asc');
        $sortField = $request->input ('sort.field', 'name_en');
        $offset = ($page - 1) * $perpage;
        $query = Project::with ('stage', 'sector', 'status');
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
            $query->whereIn ('sector_id', $data_sector_ids);

        }
        if (!isset($request->mission_ids) && isset($request->department_ids) && !isset($request->sector_ids)) {
            $data_sector_ids = [];
            $missions = DepartmentMission::whereIn ('department_id', $request->department_ids)->with ('sectors')->get ();
            foreach ($missions as $mission) {
                foreach ($mission->sectors as $sector) {
                    $data_sector_ids[] = $sector->pivot->id;
                }
            }
            $query->whereIn ('sector_id', $data_sector_ids);
        }
        if (isset($request->department_ids, $request->sector_ids) && !isset($request->mission_ids)) {
            $query->whereIn ('sector_id', $request->sector_ids);
        }
        if (isset($request->department_ids, $request->mission_ids) && !isset($request->sector_ids)) {
            $missions = DepartmentMission::whereIn ('department_id', $request->department_ids)->whereIn ('mission_id', $request->mission_ids)->with ('sectors')->get ();
            foreach ($missions as $mission) {
                foreach ($mission->sectors as $sector) {
                    $data_sector_ids[] = $sector->pivot->id;
                }
            }
            $query->whereIn ('sector_id', $data_sector_ids);
        }
        if (isset($request->department_ids, $request->mission_ids, $request->sector_ids)) {

            $query->whereIn ('sector_id', $request->sector_ids);
        }
        if (!isset($request->department_ids, $request->mission_ids) && isset($request->sector_ids)) {
            $sector_ids = SectorDepartment::whereIn ('sector_id', $request->sector_ids)->select ('id')->get ();
            $query->whereIn ('sector_id', $sector_ids);
        }
        if (isset($request->status_ids)) {
            $query->whereIn ('status_id', $request->status_ids);
        }
        if (isset($request->stage_ids)) {
            $query->whereIn ('stage_id', $request->stage_ids);
        }

        if (isset($request->start_date)) {
            $query->whereDate ('start_date', '>=', $request->start_date);
        }
        if (isset($request->end_date)) {
            $query->whereDate ('end_date', '<=', $request->end_date);
        }
        if (isset($request->max_budget)) {
            $query->where ('project_budget', '<=', $request->max_budget);
        }
        if (isset($request->min_budget)) {
            $query->where ('project_budget', '>=', $request->min_budget);
        } else {
            $query->where ('project_budget', '>=', 1);

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

    /**
     * Show the form for creating a new resource.
     *
     * @param Project $project
     * @return View
     */
    public function create (Project $project): View
    {
        $this->data['project'] = $project;
        $backup = Backup::where ('code', $project->id)->first ();
        if (!\is_null ($backup)) {
            $this->data['data_value'] = json_decode ($backup['datavalue']);
            $this->data['data_array'] = json_decode ($backup['datavalue'], true);
        }
        $this->data['budget_categories'] = $this->select_box (new BudgetCategory(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), '', 'status=true', 'sort_order');

//        $this->data['activity_phase'] = ActivityPhase::pluck ('name_en', 'id');
        $this->data['missions'] = $this->select_box (new Mission(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), trans ('common.please_select'));
        $this->data['category_options'] = $this->select_box (new CategoryOption(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), trans ('common.please_select'), 'parent_id=14738');
        $this->data['donors'] = $this->select_box (new Donor(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), trans ('common.please_select'));
        $this->data['units'] = $this->select_box (new Unit(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), trans ('common.please_select'));
        $this->data['nested_url_department'] = route ('nested_department_mission');
        $this->data['nested_url_superior'] = route ('nested_superior_department');
        return view ('layouts.project.create', $this->data);
    }

    /**
     * @param Request $request
     * @return JsonResponse|null
     * @throws \Exception
     */
    public function saveAndContinue (Request $request): ?JsonResponse
    {
        $data = $request->all ();
        $backup = new Backup();
        $backupDelete = Backup::where ('code', $data['id'])->first ();
        if ($backupDelete != null) {
            $backupDelete->delete ();
        }
        $data_josn = json_encode ($data);
        $backup->datavalue = $data_josn;
        $backup->projectname = '';
        $backup->userid = \Auth::user ()->userid;
        $backup->type = 'Submission';
        $backup->code = $data['id'];
        if (!$backup->save ()) {
            return $this->setStatusCode (422)->respond (['status' => false]);
        }

        return $this->setStatusCode (200)->respond (['status' => true]);
    }

    /**
     * @param Store $request
     * @return JsonResponse
     */
    public function store (Store $request): ?JsonResponse
    {
        try {
            $project = Project::find ($request->id);
            $project_budget = 0;
            $budget = [];
            DetailedProposal::updateOrCreate (['project_id' => $request->id], $request->project + ['project_id' => $request->id]);
            foreach ($request->budget as $item) {
                foreach ($item as $value) {
                    $project_budget += ($value['duration'] * $value['quantity'] * $value['unit_cost'] * $value['chf']) / 100;
                    $value['stored_by'] = Auth::user ()->full_name;
                    $budget[] = new DetailedProposalBudget($value);
                }
            }
            if (isset($request->beneficiary)) {
                foreach ($request->beneficiary as $key => $value) {
                    $beneficiary_records[] =
                        new ProposalBeneficiary([
                            'men'                         => $value['men'],
                            'women'                       => $value['women'],
                            'boys'                        => $value['boys'],
                            'girls'                       => $value['girls'],
                            'organisation_unit_id'        => $value['organisation_unit'],
                            'project_beneficiary_type_id' => 375445,
                            'stored_by'                   => Auth::user ()->full_name,
                        ]);
                }
                $project->submission_beneficiaries ()->saveMany ($beneficiary_records);

            }
            if (isset($request->description)) {
                foreach ($request->description as $key => $value) {
                    $new_key = $key + 1;
                    $outcome = new Outcome();
                    $outcome->name_en = "Outcome.$new_key";
                    $outcome->description = $value;
                    $outcome->project_id = $request->id;
                    $outcome->stored_by = Auth::user ()->full_name;
                    $outcome->save ();
                    if ($request->has ('output_description_' . $new_key)) {
                        foreach ($request->input ('output_description_' . $new_key) as $key_1 => $value_1) {
                            $new_key_1 = $key_1 + 1;
                            $output = new Output();
                            $output->name_en = "Output.$new_key.$new_key_1";
                            $output->description = $value_1;
                            $output->assumption = $request->input ('output_assumption_' . $new_key . '.' . $key_1);
                            $output->outcome_id = $outcome->id;
                            $output->stored_by = Auth::user ()->full_name;
                            $output->save ();
                            if ($request->has ('activity_description_' . $new_key . $new_key_1)) {
                                foreach ($request->input ('activity_description_' . $new_key . $new_key_1) as $key2 => $value2) {
                                    $start_date = Carbon::parse ($request->input ("start_date_$new_key$new_key_1" . '.' . $key2));
                                    $end_date = Carbon::parse ($request->input ("end_date_$new_key$new_key_1" . '.' . $key2));
                                    $diff_days = $start_date->diffInDays ($end_date);
                                    $new_key_2 = $key2 + 1;
                                    $activity = new Activitie();
                                    $activity->name_en = "Activity.$new_key.$new_key_1.$new_key_2";
                                    $activity->activity_phase_id = $request->input ("activity_phase_$new_key$new_key_1" . '.' . $key2);
                                    $activity->responsibility = $request->input ("responsibility_$new_key$new_key_1" . '.' . $key2);
                                    $activity->output_id = $output->id;
                                    $activity->stored_by = Auth::user ()->full_name;
                                    $activity->status_id = 147066;
                                    $activity->start_date = $request->input ("start_date_$new_key$new_key_1" . '.' . $key2);
                                    $activity->end_date = $request->input ("end_date_$new_key$new_key_1" . '.' . $key2);
                                    $activity->direct_cost = $request->input ("cost_$new_key$new_key_1" . '.' . $key2);
                                    $activity->planned_progress = number_format ((float)(($diff_days / $request->total_day) * 100), 2, '.', '');
                                    $activity->days = $diff_days;
                                    $activity->duration = ceil ($diff_days / 30);
                                    $activity->precent_of_cost = number_format ((float)($activity->direct_cost / $request->total_cost) * 100, 2, '.', '');
                                    $activity->total_percentage = number_format ((float)($activity->planned_progress + $activity->precent_of_cost) / 2, 2, '.', '');
                                    $activity->indirect_cost = number_format ((float)($activity->total_percentage * $request->total_indirect) / 100, 2, '.', '');
                                    $activity->description = $value2;
                                    $activity->save ();

                                }
                            }
                            if ($request->has ('indicator_description_' . $new_key . $new_key_1)) {
                                foreach ($request->input ('indicator_description_' . $new_key . $new_key_1) as $key3 => $value3) {
                                    $new_key3 = $key3 + 1;
                                    $indicator = new Indicator();
                                    $indicator->name_en = "Indicator.$new_key.$new_key_1.$new_key3";
                                    $indicator->output_id = $output->id;
                                    $indicator->description = $value3;
                                    $indicator->means_of_verification = $request->input ("start_date_$new_key$new_key_1" . '.' . $key3);
                                    $indicator->save ();
                                }
                            }
                        }
                    }
                }
            }
            $project->detailed_proposal_budget ()->saveMany ($budget);
            $project->stage_id = 2;
            $project->project_budget = $project_budget;
            if ($request->file ('plan_file')) {
                $file = $request->file ('plan_file');
                $file->move ('file/m_&_e_plan', $file->getClientOriginalName ());
                $project->file_plan = $file->getClientOriginalName ();
            }
            $project->update ();
            $this->notification_project_submission ($request->id, 'submission', 'project.show', 0, 50006, false, false);
            return $this->setStatusCode (200)->respond (['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => 'Something is error']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Project $project
     * @return View
     */
    public function show (Project $project): View
    {
        $this->data['project'] = $project;
        $this->data['status'] = $this->status;
        $this->data['stage'] = $this->stage;
        $this->data['notification_check'] = ProjectNotification::where ('url_id', $project->id)->where ('receiver', Auth::id ())->where ('status_id', $this->in_progress)->exists ();
        $this->data['first_project_notification'] = $project->project_notification ()->first ();
        $this->data['last_project_notification'] = $project->project_notification ()->latest ('id')->first ();
        $this->data['budget_categories'] = \DB::table ('budget_categories')->get ();
        $this->data['total_budgets'] = 0;
        return view ('layouts.project.show', $this->data);
    }


    /**
     * @param Project $project
     * @return View
     */
    public function edit (Project $project): View
    {
        $this->data['project'] = $project;
        $this->data['activity_phase'] = ActivityPhase::pluck ('name_en', 'id');
        $this->data['budget_categories'] = $this->select_box (new BudgetCategory(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), '', 'status=true', 'sort_order');
        $this->data['missions'] = $this->select_box (new Mission(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), trans ('common.please_select'));
        $this->data['category_options'] = $this->select_box (new CategoryOption(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), trans ('common.please_select'), 'parent_id=14738');
        $this->data['donors'] = $this->select_box (new Donor(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), trans ('common.please_select'));
        $this->data['units'] = $this->select_box (new Unit(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), trans ('common.please_select'));
        $this->data['nested_url_department'] = route ('nested_department_mission');
        $this->data['nested_url_superior'] = route ('nested_superior_department');
        return view ('layouts.project.edit', $this->data);
    }


    /**
     * @param Update $request
     * @return JsonResponse|null
     */
    public function update (Update $request): ?JsonResponse
    {
        try {
            $project_budget = 0;
            $budget = [];
            $ids = [];
            $project = Project::find ($request->id);
            foreach ($request->budget as $item) {
                foreach ($item as $value) {
                    $project_budget += ($value['duration'] * $value['quantity'] * $value['unit_cost'] * $value['chf']) / 100;
                    $value['modified_by'] = Auth::user ()->full_name;
                    if (isset($value['budget_id'])) {
                        $data = (new DetailedProposalBudget($value))->toArray ();
                        DetailedProposalBudget::find ($value['budget_id'])->update ($data);
                        $ids[] = $value['budget_id'];

                    } else {
                        $budget[] = new DetailedProposalBudget($value);
                    }
                }
            }
            if (count ($ids)) {
                DetailedProposalBudget::whereNotIn ('id', $ids)->delete ();
            }
            if (count ($budget)) {
                $project->detailed_proposal_budget ()->saveMany ($budget);
            }
            $project->submission_beneficiaries ()->delete ();
            foreach ($project->outcomes as $outcome) {
                Outcome::where ('id', $outcome->id)->first ()->delete ();
            }
            if (isset($request->beneficiary)) {
                foreach ($request->beneficiary as $key => $value) {
                    $beneficiary_records[] =
                        new ProposalBeneficiary([
                            'men'                         => $value['men'],
                            'women'                       => $value['women'],
                            'boys'                        => $value['boys'],
                            'girls'                       => $value['girls'],
                            'organisation_unit_id'        => $value['organisation_unit'],
                            'project_beneficiary_type_id' => 375445,
                            'stored_by'                   => Auth::user ()->full_name,
                        ]);
                }
            }
            $project->submission_beneficiaries ()->saveMany ($beneficiary_records);
            if (isset($request->description)) {
                foreach ($request->description as $key => $value) {
                    $new_key = $key + 1;
                    $outcome = new Outcome();
                    $outcome->name_en = "Outcome.$new_key";
                    $outcome->description = $value;
                    $outcome->project_id = $request->id;
                    $outcome->stored_by = Auth::user ()->full_name;
                    $outcome->save ();
                    if ($request->has ('output_description_' . $new_key)) {
                        foreach ($request->input ('output_description_' . $new_key) as $key_1 => $value_1) {
                            $new_key_1 = $key_1 + 1;
                            $output = new Output();
                            $output->name_en = "Output.$new_key.$new_key_1";
                            $output->description = $value_1;
                            $output->assumption = $request->input ('output_assumption_' . $new_key . '.' . $key_1);
                            $output->outcome_id = $outcome->id;
                            $output->stored_by = Auth::user ()->full_name;
                            $output->save ();

                            if ($request->has ('activity_description_' . $new_key . $new_key_1)) {
                                foreach ($request->input ('activity_description_' . $new_key . $new_key_1) as $key2 => $value2) {
                                    $start_date = Carbon::parse ($request->input ("start_date_$new_key$new_key_1" . '.' . $key2));
                                    $end_date = Carbon::parse ($request->input ("end_date_$new_key$new_key_1" . '.' . $key2));
                                    $diff_days = $start_date->diffInDays ($end_date);
                                    $new_key_2 = $key2 + 1;
                                    $activity = new Activitie();
                                    $activity->name_en = "Activity.$new_key.$new_key_1.$new_key_2";
                                    $activity->activity_phase_id = $request->input ("activity_phase_$new_key$new_key_1" . '.' . $key2);
                                    $activity->responsibility = $request->input ("responsibility_$new_key$new_key_1" . '.' . $key2);
                                    $activity->output_id = $output->id;
                                    $activity->stored_by = Auth::user ()->full_name;
                                    $activity->status_id = 147066;
                                    $activity->start_date = $request->input ("start_date_$new_key$new_key_1" . '.' . $key2);
                                    $activity->end_date = $request->input ("end_date_$new_key$new_key_1" . '.' . $key2);
                                    $activity->direct_cost = $request->input ("cost_$new_key$new_key_1" . '.' . $key2);
                                    $activity->planned_progress = number_format ((float)(($diff_days / $request->total_day) * 100), 2, '.', '');
                                    $activity->days = $diff_days;
                                    $activity->duration = ceil ($diff_days / 30);
                                    $activity->precent_of_cost = number_format ((float)($activity->direct_cost / $request->total_cost) * 100, 2, '.', '');
                                    $activity->total_percentage = number_format ((float)($activity->planned_progress + $activity->precent_of_cost) / 2, 2, '.', '');
                                    $activity->indirect_cost = number_format ((float)($activity->total_percentage * $request->total_indirect) / 100, 2, '.', '');
                                    $activity->description = $value2;
                                    $activity->save ();

                                }
                            }
                            if ($request->has ('indicator_description_' . $new_key . $new_key_1)) {
                                foreach ($request->input ('indicator_description_' . $new_key . $new_key_1) as $key3 => $value3) {
                                    $new_key3 = $key3 + 1;
                                    $indicator = new Indicator();
                                    $indicator->name_en = "Indicator.$new_key.$new_key_1.$new_key3";
//                                $indicator->outcome_id = $outcome->id;
                                    $indicator->output_id = $output->id;
                                    $indicator->description = $value3;
                                    $indicator->means_of_verification = $request->input ("start_date_$new_key$new_key_1" . '.' . $key3);
                                    $indicator->save ();
                                }
                            }
                        }
                    }
                }
            }
            $project->project_budget = $project_budget;
            $project->modified_by = Auth::user ()->full_name;
            $project_2 = $request->project;
            $project_2['modified_by'] = Auth::user ()->full_name;
            $project->detailed_proposal->update ($project_2);
            if ($request->file ('plan_file')) {
                $file = $request->file ('plan_file');
                $file->move ('file/m_&_e_plan', $file->getClientOriginalName ());
                $project->file_plan = $file->getClientOriginalName ();
            }
            $project->update ();
            return $this->setStatusCode (200)->respond (['success' => 'success']);
        } catch (\Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => 'Something is error']);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse|null
     */
    public function nested_select_multiple (Request $request): ?JsonResponse
    {

        try {
            if ($request->input ('id') != null) {
                if ($request->department_id) {
                    $data = Project::whereIn ('sector_id', $request->input ('id'))->get ();
                } else {
                    $id = SectorDepartment::wherein ('sector_id', $request->input ('id'))->pluck ('id');
                    $data = Project::whereIn ('sector_id', $id)->get ();
                }
                $array = [];
                foreach ($data as $key => $value) {
                    $array[$value->id] = $value->name_en;
                }
                return $this->respond ($array);
            }
            return $this->setStatusCode (422)->respond (['error' => 'not find']);
        } catch (\Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => 'not find']);
        }

    }
//    /**
//     * @param Project $project
//     */
//    public function destroy (Project $project) : void
//    {
//        //
//    }
//

    /**
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function action (Request $request)
    {
//        if (is_null ($check_notification)) {
//            return redirect ('home');
//        }
        if ($request->action == 'accept') {
            $this->notification_project_submission ($request->id, 'submission', 'project.show', 0, 50006, false, false);
        } elseif ($request->action == 'reject') {
            $check_notification = ProjectNotification::where ('url_id', $request->id)->where ('receiver', Auth::id ())->where ('status_id', $this->in_progress)->latest ('id')->first ();
            $type_id = NotificationType::where ('module_name', 'submission')->latest ('id')->first ()->id;
            $this->new_notification_project ($request->id, $type_id, 'project.show', 136313, $this->in_progress, $check_notification->requester, $check_notification->requester, 1);
            $check_notification->status_id = 171;
            $check_notification->update ();
            ProjectNotification::where ('url_id', $request->id)->where ('status_id', $this->in_progress)->delete ();
            $project = Project::find ($request->id);
            $project->status_id = 171;
            $project->update ();
        } elseif ($request->action == 'confirm') {
            $check_notification = ProjectNotification::where ('url_id', $request->id)->where ('receiver', Auth::id ())->where ('status_id', $this->in_progress)->latest ('id')->first ();
            $check_notification->status_id = 170;
            $check_notification->update ();
        }
        return redirect ('home');
    }


    public function cycle ($id)
    {
        $this->data['notifications'] = ProjectNotification::where ('url_id', $id)->orderBy ('id')->with ('user_receiver')->get ();
        return view ('layouts.project.cycle', $this->data);
    }

    public function project_info (Project $project)
    {
//        $project = Project::find ( $id);
        return $project;
    }

    public function responsibility (Project $project)
    {
        $this->data['project'] = $project;
        $this->data['nested_url_superior'] = route ('nested_superior_department');
        $this->data['nested_url_department'] = route ('nested_department_mission');
        $this->data['responsibility_update'] = route ('project.responsibility_update');
        $this->data['responsibility'] = [
            1 => 'project_manager',
            2 => 'program_manager',
            3 => 'project_accountant',
            4 => 'project_officer',
            5 => 'head_of_department',
        ];
        $this->data['project_responsibility'] = ProjectResponsibility::where ('project_id', $project->id)->first ();

        $this->data['missions'] = $this->select_box (new Mission(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), trans ('common.please_select'));

        $this->data['users'] = $this->select_box (new User(), \DB::raw ('id'), \DB::raw ('first_name_' . $this->lang . '  || \' \' || last_name_' . $this->lang . ' as name'), null, \DB::raw ('disabled=0'));
        return view ('layouts.project.responsibility', $this->data);

    }

    public function responsibility_update (Request $request)
    {
        try {
            if ($request->name == 'project_officer') {
                $user_id = json_encode ($request->user_id);
//                ProjectResponsibility::updateOrCreate (['project_id'=>$request->id],['modified_by'=>Auth::user ()->full_name,"$request->name"=> $user_id]);
                $mission = Mission::find ($request->mission_id);
                ProjectNotificationStructure::updateOrCreate (['project_id' => $request->id],
                    ['modified_by'                => Auth::user ()->full_name,
                     'head_of_mission'            => $mission->head_of_mission,
                     'finance_authority'          => $mission->finance_authority,
                     'accountant_authority'       => $mission->accountant_authority,
                     'logistic_authority'         => $mission->logistic_authority,
                     'procurement_authority'      => $mission->procurement_authority,
                     'hr_authority'               => $mission->hr_authority,
                     'finance_responsibility'     => $mission->finance_responsibility,
                     'logistic_responsibility'    => $mission->logistic_responsibility,
                     'procurement_responsibility' => $mission->procurement_responsibility,
                     'hr_responsibility'          => $mission->hr_responsibility,
                     'accountant_responsibility'  => $mission->accountant_responsibility,
                     'it_responsibility'          => $mission->it_responsibility,
                     'im_responsibility'          => $mission->im_responsibility,
                     'm_e_responsibility'         => $mission->m_e_responsibility,
                     "$request->name"             => $user_id]
                );
            } else {
                $user_id = $request->user_id;
                ProjectResponsibility::updateOrCreate (['project_id' => $request->id], ['modified_by' => Auth::user ()->full_name, "$request->name" => $user_id]);
                $mission = Mission::find ($request->mission_id);
                ProjectNotificationStructure::updateOrCreate (['project_id' => $request->id],
                    ['modified_by'                => Auth::user ()->full_name,
                     'head_of_mission'            => $mission->head_of_mission,
                     'finance_authority'          => $mission->finance_authority,
                     'accountant_authority'       => $mission->accountant_authority,
                     'logistic_authority'         => $mission->logistic_authority,
                     'procurement_authority'      => $mission->procurement_authority,
                     'hr_authority'               => $mission->hr_authority,
                     'finance_responsibility'     => $mission->finance_responsibility,
                     'logistic_responsibility'    => $mission->logistic_responsibility,
                     'procurement_responsibility' => $mission->procurement_responsibility,
                     'hr_responsibility'          => $mission->hr_responsibility,
                     'accountant_responsibility'  => $mission->accountant_responsibility,
                     'it_responsibility'          => $mission->it_responsibility,
                     'im_responsibility'          => $mission->im_responsibility,
                     'm_e_responsibility'         => $mission->m_e_responsibility,
                     "$request->name"             => $user_id]
                );
            }

            return $this->setStatusCode (200)->respond (['success' => 'success']);
        } catch (\Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => 'Something is error']);
        }
    }

    public function donor_management (Project $project)
    {
        $this->data['project'] = $project;
        $this->data['payment_number'] = DB::table ('payment_numbers')->pluck ('name_en', 'id')->prepend (trans ('common.please_select'), '');
        $this->data['report_types'] = DB::table ('report_types')->pluck ('name_en', 'id')->prepend (trans ('common.please_select'), '');
        return view ('layouts.project.donor_management.planned.create', $this->data);
    }

    public function donorPaymentRequestStore (Request $request)
    {
        if ($request->outer_list) {
            $ids_1 = [];
            $ids_2 = [];
            $ids_3 = [];
            $ids_donor = [];
            foreach ($request->outer_list as $key => $list) {
                $new = [];
                $ids_donor[] = $list['donor_id'];
                $new['donor_id'] = $list['donor_id'];
                $new['project_id'] = $request->project_id;
                $new['project_name_en'] = $list['project_name_en'];
                $new['project_code'] = $list['project_code'];
                $new['monetary'] = $list['monetary'];
                $new['in_kind'] = $list['in_kind'];
                $new['modifiedby'] = Auth::user ()->full_name;
                $new['storedby'] = Auth::user ()->full_name;
                if (isset($list['proposal_file'])) {
                    $file = $list['proposal_file'];
                    $filename = Carbon::now ()->timestamp . $key . '_proposal.pdf';
                    $file->move ('file/donor', $filename);
                    $new['proposal_file'] = $filename;
                }
                if (isset($list['budget_file'])) {
                    $file = $list['budget_file'];
                    $filename = Carbon::now ()->timestamp . $key . '_budget.pdf';
                    $file->move ('file/donor', $filename);
                    $new['budget_file'] = $filename;
                }
                if (isset($list['agreement_file'])) {
                    $file = $list['agreement_file'];
                    $filename = Carbon::now ()->timestamp . $key . '_agreement.pdf';
                    $file->move ('file/donor', $filename);
                    $new['agreement_file'] = $filename;
                }
                if (isset($list['delegation_file'])) {
                    $file = $list['delegation_file'];
                    $filename = Carbon::now ()->timestamp . $key . '_delegation.pdf';
                    $file->move ('file/donor', $filename);
                    $new['delegation_file'] = $filename;
                }
                if (isset($list['financial_documents_file'])) {
                    $file = $list['financial_documents_file'];
                    $filename = Carbon::now ()->timestamp . $key . '_financial_documents.pdf';
                    $file->move ('file/donor', $filename);
                    $new['financial_documents_file'] = $filename;
                }
                if (isset($list['raca_file'])) {
                    $file = $list['raca_file'];
                    $filename = Carbon::now ()->timestamp . $key . '_raca.pdf';
                    $file->move ('file/donor', $filename);
                    $new['raca_file'] = $filename;
                }
                ProjectDonor::updateOrCreate (['project_id' => $request->project_id, 'donor_id' => $list['donor_id']], $new);
                ProjectDonor::where ('project_id', $request->project_id)->whereNotIn ('donor_id', $ids_donor)->delete ();
                if (isset($list['donorAgreedReports_list'])) {
                    foreach ($list['donorAgreedReports_list'] as $donor_list) {
                        $new2 = [];
                        $new2['report_type_id'] = $donor_list['report_type_id'];
                        $new2['donor_id'] = $list['donor_id'];
                        $new2['project_id'] = $request->project_id;
                        $new2['name_en'] = $donor_list['name_en'];
                        $new2['due_date'] = $donor_list['due_date'];
                        if (!is_null ($donor_list['id'])) {
                            $ids_2[] = $donor_list['id'];
                            ProjectReport::updateOrCreate (['id' => $donor_list['id']], $new2);
                        } else {
                            $id = ProjectReport::create ($new2);
                            $ids_2[] = $id->id;
                        }
                    }
                    ProjectReport::where ('donor_id', $list['donor_id'])->where ('project_id', $request->project_id)->whereNotIn ('id', $ids_2)->delete ();
                }
                if (isset($list['donorAgreedPayments_list'])) {
                    foreach ($list['donorAgreedPayments_list'] as $payment_list) {
                        $new3 = [];
                        $new3['payment_number_id'] = $payment_list['payment_number_id'];
                        $new3['due_date'] = $payment_list['due_date'];
                        $new3['agreed_amount'] = $payment_list['agreed_amount'];
                        $new3['donor_id'] = $list['donor_id'];
                        $new3['project_id'] = $request->project_id;
                        if (!is_null ($donor_list['id'])) {
                            $ids_3[] = $payment_list['id'];
                            ProjectDonorPayment::updateOrCreate (['id' => $donor_list['id']], $new3);
                        } else {
                            $id = ProjectDonorPayment::create ($new3);
                            $ids_3[] = $id->id;
                        }
                    }
                    ProjectDonorPayment::where ('donor_id', $list['donor_id'])->where ('project_id', $request->project_id)->whereNotIn ('id', $ids_3)->delete ();
                }
                Project::find ($request->project_id)->update (['edit_plan_donor_management' => false]);
            }
        }
        return redirect ('home');
    }

    public function donorPaymentActualRequestStore (Request $request)
    {
        foreach ($request->id as $id) {
            $ids = [];
            if (!is_null ($request->input ('received_payment_' . $id . ''))) {
                $payment = ProjectDonorPayment::find ($id);
                $payment->received_payment = $request->input ('received_payment_' . $id . '');
                $payment->receiving_date = $request->input ('receiving_date_' . $id . '');
                if ($request->hasFile ('payment_file_' . $id . '')) {
                    $file = $request->file ('payment_file_' . $id . '');
                    $filename = Carbon::now ()->timestamp . $id . '.pdf';
                    $file->move ('file/donor', $filename);
                    $payment->payment_file = $filename;
                }
                $payment->update ();
            }
            foreach ($request->input ('usable_' . $id . '') as $usable) {
                if (is_null ($usable['id'])) {
                    $new = new ProjectAccount();
                    $new->amount = $usable['amount'];
                    $new->payment_date = $usable['payment_date'];
                    $new->project_donor_payment_id = $id;
                    $new->project_id = $request->project_id;
                    if (!is_null ($new->amount)) {
                        $new->save ();
                        $ids[] = $new->id;

                    }
                } else {
                    $new = ProjectAccount::find ($usable['id']);
                    $new->amount = $usable['amount'];
                    $new->payment_date = $usable['payment_date'];
                    $new->project_donor_payment_id = $id;
                    $new->project_id = $request->project_id;
                    $new->update ();
                    $ids[] = $usable['id'];
                }
            }
            ProjectAccount::where ('project_donor_payment_id', $id)->whereNotIn ('id', $ids)->delete ();
        }
        return redirect ('home');
    }

    public function saveDonorManagementOngoingActualPayments (Project $project)
    {
        $this->data['project'] = $project;
        return view ('layouts.project.donor_management.actual.payments.create', $this->data);
    }

    public function hq_payment ($id)
    {
        $project = Project::with ('project_accounts_payments', 'project_accounts_refunds')
            ->where ('id', $id)->first ();
        return view ('layouts.project.hq_payment', compact ('project'));
    }

    public function hq_payment_store_or_update (Request $request)
    {
        try {
            foreach ($request->payments as $payment) {
                if (isset ($payment['id'])) {
                    $ids[] = $payment['id'];
                    $id = $payment['id'];
                    $payment['project_id'] = $request->project_id;
                    $payment['department_id'] = 372096;
                    unset($payment['id']);
                    ProjectAccount::where ('id', $id)->update ($payment);
                } else {
                    $payment['department_id'] = 372096;
                    $payment['project_id'] = $request->project_id;
                    $id = ProjectAccount::create ($payment);
                    $ids[] = $id->id;
                }
            }
            foreach ($request->refunds as $refund) {
                if (isset ($refund['id'])) {
                    $ids[] = $refund['id'];
                    $id = $refund['id'];
                    $refund['project_id'] = $request->project_id;
                    $refund['department_id'] = 372096;
                    unset($refund['id']);
                    ProjectAccount::where ('id', $id)->update ($refund);
                } else {
                    $refund['department_id'] = 372096;
                    $refund['project_id'] = $request->project_id;
                    $id = ProjectAccount::create ($refund);
                    $ids[] = $id->id;
                }
            }
            ProjectAccount::whereNotIn ('id', $ids)->where ('project_id', $request->project_id)->where ('department_id', 372096)->delete ();
            return $this->setStatusCode (200)->respond (['success' => ['success']]);
        } catch (\Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => ['Something is error']]);
        }

    }

// Nami
    public function donorPaymentRequest ()
    {
        return view ('layouts.project.donor_payment_request.create');
    }

    public function submission_pdf (Project $project)
    {


        $firstPageConceptGeneralInformaion =
            '
<style>
h3.underline{
text-decoration: underline;
}
h4.italic{
font-style: italic;
}
table{
width: 100%;
border-collapse: collapse;
font-size: 10px;
}
th{
border: 1px solid black;
border-collapse: collapse;
padding-left: 8px;
text-align: left;
}
td{
border: 1px solid black;
border-collapse: collapse;
padding-left: 8px;
text-align: center;
}
div.line2{
width: 100%;
height: 10px;
border-bottom: 1px dashed black;
position: absolute;
}
div.line1{
width: 100%;
height: 10px;
border-bottom: 1px dashed black;
position: absolute;
}
</style>
<div align="center">
            <h1>Mission</h1>
            <h3>' . $project->name_en . '</h3>
            <h5>' . $project->sector->department->department->name_en . '</h5>
            <p>' . $project->sector->name_en . '</p>
            </div>
            <div align="center">
            <h1>Project Concept</h1>
            </div>
            <h3 class="underline">General Information</h3>
            &nbsp;
            <table cellpadding="5">
            <tr>
            <th>Project name</th>
            <td>MHPSS</td>
            </tr>
            <tr>
            <th>Project Code</th>
            <td>' . $project->code . '</td>
            </tr>
            <tr>
            <th>Sector</th>
            <td>' . $project->sector->sector->name_en . '</td>
            </tr>
            <tr>
            <th>Department</th>
            <td>' . $project->sector->department->department->name_en . '</td>
            </tr>
            <tr>
            <th>Start Date</th>
            <td>' . $project->start_date . '</td>
            </tr>
            <tr>
            <th >End Date</th>
            <td >' . $project->end_date . '</td>
            </tr>
            <tr>
            <th>Duration</th>
            <td>' . get_duration ($project->start_date, $project->end_date) . '</td>
            </tr>
            <tr>
            <th>Location</th>
            <td>' . $project->organisation_unit->name_en . '</td>
            </tr>
</table>
            ';
        $beneficiaries_tr = '';
        foreach ($project->beneficiaries as $key => $value) {
            $total = $value->men + $value->women + $value->boys + $value->girls;
            $beneficiaries_tr .= '<tr>
                                    <td>' . $value->type_name_en . ' </td>
                                  <td> ' . $project->organisation_unit->name_en . ' </td>
                                    <td  >' . $value->men . '</td>
                                    <td  >' . $value->women . '</td>
                                    <td  >' . $value->boys . '</td>
                                    <td  >' . $value->girls . '</td>
                                    <td >' . $total . '</td>
                                </tr>';
        }

        $secondPageConceptBeneficiaries = '
<style>
h3{
text-decoration: underline;
}
h4{
font-style: italic;
}
table{
border-collapse: collapse;
font-size: 10px;
}
th{
border: 1px solid black;
border-collapse: collapse;
padding-left: 8px;
text-align: left;
padding: 15px;
text-align: center;
font-size: 10px;
}
td{
font-size: 10px;
padding: 15px;
border: 1px solid black;
border-collapse: collapse;
padding-left: 8px;
text-align: center;
}
.container {
    width: auto;
    margin-top: 0%;
    border-radius: 10px;
    display:inline-block;
    min-height: 100px;
    height: 500px;
    position: absolute;
}
div.line1{
width: 100%;
height: 10px;
border-bottom: 1px dashed red;
position: absolute;
}
div.textarea{
width:auto;
height:500px;
min-height:400px;
}

</style>
<h3>Beneficiaries</h3>
<h4>Beneficiaries Type</h4>
        <table  cellpadding="5" align="center" style="width:100%">
        <tr>
    <th style="width: 25%;">Type</th>
    <th style="width: 15%;">Men</th>
    <th style="width: 15%;">Women</th>
    <th style="width: 15%;">Boys</th>
    <th style="width: 15%;">Girls</th>
    <th style="width: 15%; background-color: lightgrey">Total</th>
  </tr>
  ' . $beneficiaries_tr . '
</table>
<br>
<div></div>
<h4>Indirect Beneficiaries</h4>
<div class="textarea">' . $project->proposal->indirect_beneficiaries . '</div>
<div ></div>
<h4>Catchment Area: ' . $project->proposal->catchment_area . '</h4>
        ';
        $thirdPageConceptObjectivesAndRisks = '
<style>
h3{
text-decoration: underline;
}
h4{
font-style: italic;
}
div.textarea{
width:auto;
height:500px;
min-height:400px;
}
table{
border-collapse: collapse;
font-size: 10px;
}
th{
border: 1px solid #dddddd;
border-collapse: collapse;
padding-left: 8px;
text-align: left;
padding: 15px;
}
td{
padding: 15px;
border: 1px solid #dddddd;
border-collapse: collapse;
padding-left: 8px;
text-align: left;
}
.container {
    width: auto;
    margin-top: 0%;
    border-radius: 10px;
    display:inline-block;
    min-height: 100px;
    height: 500px;
    position: absolute;
}
div.line1{
width: 100%;
height: 10px;
border-bottom: 1px dashed red;
position: absolute;
}
</style>

<h3>Objectives and Risks</h3>
<br>
<h4>Project Summary</h4>
<div class="textarea">' . $project->proposal->project_summary . '</div>
&nbsp;
<h4>Overall Objectives</h4>
<div class="textarea">' . $project->proposal->overall_objective . '</div>

        ';
        $fourthPageConceptNeedAssessment = '
<style>
h3{
text-decoration: underline;
}
h4{
font-style: italic;
}
div.textarea{
width:auto;
height:500px;
min-height:400px;
}
table{
border-collapse: collapse;
font-size: 10px;
}
th{
border: 1px solid #dddddd;
border-collapse: collapse;
padding-left: 8px;
text-align: left;
padding: 15px;
}
td{
padding: 15px;
border: 1px solid #dddddd;
border-collapse: collapse;
padding-left: 8px;
text-align: left;
}
.container {
    width: auto;
    margin-top: 0%;
    border-radius: 10px;
    display:inline-block;
    min-height: 100px;
    height: 500px;
    position: absolute;
}
div.line1{
width: 100%;
height: 10px;
border-bottom: 1px dashed red;
position: absolute;
}
</style>
        <h4>Needs Assessment</h4>
<div class="textarea">' . $project->proposal->needs_assessment . '</div>
        ';
        $proposal_budgets_tr = '';
        foreach ($project->proposal_budgets as $key => $value) {
            $proposal_budgets_tr .= ' <tr>
                                    <th class="text-center"> ' . ++$key . ' </th>
                                    <td>' . $value->budget_name_en . ' </td>
                                    <td class="text-center money">' . $value->value . ' $</td>
                                </tr>';
        }
        $proposal_budgets_tr .= '<tr>
                                <th class="text-center"> ' . ++$key . ' </th>
                                <td>Total</td>
                                <td class="text-center money">' . $project->proposal_budgets->sum ('value') . ' $</td>
                            </tr>';


        $fifthPageconceptBudget = '

<style>
h3{
text-decoration: underline;
}
h4{
font-style: italic;
}
table{
width: 100%;
border-collapse: collapse;
font-size: 10px;
}
th{
border: 1px solid black;
border-collapse: collapse;
padding-left: 8px;
text-align: center;
}
td{
border: 1px solid black;
border-collapse: collapse;
padding-left: 8px;
text-align: center;
}
div.textarea{
width:auto;
height:500px;
min-height:400px;
}
</style>
<h3>Budget Summary</h3>
&nbsp;
            <table cellpadding="5">
            <tr>
            <th style="width: 5%">#</th>
            <th style="width: 60%;text-align: left">Budget Line</th>
            <th style="width: 35%">Value ($)</th>
            </tr>
             ' . $proposal_budgets_tr . '
</table>

        ';
        // Begin Project Details
        $sixthPageSubmissionPrjectDetails_1 = '
<style>
h3{
text-decoration: underline;
}
h4{
font-style: italic;
}
table{
width: 100%;
border-collapse: collapse;
font-size: 10px;
}
div.textarea{
width:auto;
height:500px;
min-height:400px;
}
th{
border: 1px solid black;
border-collapse: collapse;
padding-left: 8px;
text-align: left;
}
td{
border: 1px solid black;
border-collapse: collapse;
padding-left: 8px;
text-align: center;
}
div.line2{
width: 100%;
height: 10px;
border-bottom: 1px dashed black;
position: absolute;
}
div.line1{
width: 100%;
height: 10px;
border-bottom: 1px dashed red;
position: absolute;
}
</style>

<h1 style="text-align: center">Project Detailed Proposal</h1>
<h3>Project Summary</h3>
<h4>Context</h4>
<div class="textarea">' . $project->detailed_proposal->context . '</div>
&nbsp;
<h4>Link To Cluster Objectives</h4>
<div class="textarea">' . $project->detailed_proposal->link_to_cluster_objectives . '</div> ';

        $outcome_table = '';
        $output_table = '';
        $activate_table = '';

        foreach ($project->outcomes as $key => $outcome) {
            $outcome_table .= '<table>
<tr>
<td style="text-align: left;"><h5>Outcome (' . ++$key . ') </h5></td>
</tr>
</table>
<div></div>
<table>
<tr>
<td style="text-align: left;"><h6>Description</h6></td>
<td style="text-align: right"><h6>' . $outcome->name_en . '</h6></td>
</tr>
</table>
<div>' . $outcome->description . '</div>
';
            foreach ($outcome->outputs as $key_2 => $output) {


                $outcome_table .= '  <h5>Output (' . $key . '.' . ++$key_2 . ')</h5>
<table>
<tr>
<td style="text-align: left;"><h6>Description </h6></td>
<td style="text-align: right"><h6> ' . $output->name_en . ' </h6></td>
</tr>
</table>
<div>' . $output->description . '</div>
<br>
<table>
<tr>
<td style="text-align: left;"><h6>Assumption Risk </h6></td>
<td style="text-align: right"><h6> ' . $output->name_en . ' </h6></td>
</tr>
</table>
<div>' . $output->assumption . '</div>';
                foreach ($output->activities as $key_3 => $activate) {

                    $outcome_table .= '<h5>Activity (' . $key . '.' . $key_2 . '.' . ++$key_3 . ')</h5>
<table>
<tr>
<td style="text-align: left;"><h6>Description </h6></td>
<td style="text-align: right"><h6>' . $activate->name_en . ' </h6></td>
</tr>
</table>
<div> ' . $activate->description . '</div>
<br>
<table>
<tr>
<td style="text-align: left;"><h6>Activity Details</h6></td>
<td style="text-align: right"><h6>' . $activate->name_en . ' </h6></td>
</tr>
</table>
<table cellpadding="5">
<tr>
<td style="text-align: center;border: 1px solid black;
border-collapse: collapse;
padding-left: 8px;
text-align: center;"><h6>Activity Phase </h6>
</td>
<td colspan="2" style="text-align: center;border: 1px solid black;
border-collapse: collapse;
padding-left: 8px;
text-align: center;"><h6>' . $activate->phase_name_en . ' </h6>
</td>
</tr>
<tr>
<td style="text-align: center;border: 1px solid black;
border-collapse: collapse;
padding-left: 8px;
text-align: center;"><h6>Responsibility </h6>
</td>
<td colspan="2" style="text-align: center;border: 1px solid black;
border-collapse: collapse;
padding-left: 8px;
text-align: center;"><h6>' . $activate->first_name_en . ' ' . $activate->last_name_en . '</h6>
</td>
</tr>
<tr>
<td style="text-align: center;border: 1px solid black;
border-collapse: collapse;
padding-left: 8px;"><h6>Start Date </h6>
</td>
<td colspan="2" style="text-align: center;border: 1px solid black;
border-collapse: collapse;
padding-left: 8px;"><h6>' . $activate->start_date . '</h6>
</td>
</tr>
<tr>
<td style="text-align: center;border: 1px solid black;
border-collapse: collapse;
padding-left: 8px;
text-align: center;"><h6>End Date </h6>
</td>
<td colspan="2" style="text-align: center;border: 1px solid black;
border-collapse: collapse;
padding-left: 8px;
text-align: center;"><h6>' . $activate->end_date . '</h6>
</td>
</tr>
</table>';
                }
                $indicator_table = '';
                foreach ($output->indicators as $key_4 => $indicator) {
                    $outcome_table .= '  <h5>Indicator (Indicator (' . $key . '.' . $key_2 . '.' . ++$key_4 . '))</h5>
<table>
<tr>
<td style="text-align: left;"><h6>Description </h6></td>
<td style="text-align: right"><h6>' . $indicator->name_en . '</h6></td>
</tr>
</table>
<div>' . $indicator->description . '</div>
<br>
<table>
<tr>
<td style="text-align: left;"><h6>Means of Verifications</h6></td>
<td style="text-align: right"><h6>' . $indicator->name_en . ' </h6></td>
</tr>
</table>
<div>' . $indicator->means_of_verification . '</div>
</div>';
                }
            }
        }


        $seventhPageSubmissionPrjectDetails_2 = '
<style>
h3{
text-decoration: underline;
}
h4{
font-style: italic;
}
div.textarea{
width:auto;
height:500px;
min-height:400px;
}
table{
width: 100%;
border-collapse: collapse;
font-size: 10px;
}
th{
border: 1px solid #9d9d9d;
border-collapse: collapse;
padding-left: 8px;
text-align: left;
}
td{
border: 1px solid #9d9d9d;
border-collapse: collapse;
padding-left: 8px;
text-align: center;
}
div.line2{
width: 100%;
height: 10px;
border-bottom: 1px dashed black;
position: absolute;
}
div.line1{
width: 100%;
height: 10px;
border-bottom: 1px dashed red;
position: absolute;
}
div.line3{
width: 100%;
border-bottom: 1px dashed lightskyblue;
border-top: 1px dashed lightskyblue;
position: absolute;
}
</style>
        <h4>Implementation Plan</h4>
<div class="textarea">' . $project->detailed_proposal->implementation_plan . '</div>
        ';
        $eighthPageSubmissionLogicalFrameWork_1 = '
<style>
h6{
border-bottom: 1px solid black;
}
div.textarea{
width:auto;
height:500px;
min-height:400px;
}
h3{
text-decoration: underline;
}
h4{
font-style: italic;
}
table{
width: 100%;
border-collapse: collapse;
}
th{
border: 1px solid #9d9d9d;
border-collapse: collapse;
padding-left: 8px;
text-align: left;
}
div.line2{
width: 100%;
height: 10px;
border-bottom: 1px dashed black;
position: absolute;
}
div.line1{
width: 100%;
height: 10px;
border-bottom: 1px dashed red;
position: absolute;
}
div.line3{
width: 100%;
border-bottom: 1px dashed lightskyblue;
border-top: 1px dashed lightskyblue;
border-right: 1px dashed lightskyblue;
border-left: 1px dashed lightskyblue;
position: absolute;
height: 10px;
}
</style>

<h3>Logical Frame Work</h3>
<h4>Overall Objective</h4>
<div class="textarea">' . $project->detailed_proposal->overall_objective . '</div>
<h4>Outcomes</h4>
<div>' . $outcome_table . ' ';
        $ninthPageSubmissionProjectComplementary = '
        <style>
h6{
border-bottom: 1px solid black;
}
div.textarea{
width:auto;
height:500px;
min-height:400px;
}
h3{
text-decoration: underline;
}
h4{
font-style: italic;
}
table{
width: 100%;
border-collapse: collapse;
}
th{
border: 1px solid #9d9d9d;
border-collapse: collapse;
padding-left: 8px;
text-align: left;
}
div.line2{
width: 100%;
height: 10px;
border-bottom: 1px dashed black;
position: absolute;
}
div.line1{
width: 100%;
height: 10px;
border-bottom: 1px dashed red;
position: absolute;
}
div.line3{
width: 100%;
border-bottom: 1px dashed lightskyblue;
position: absolute;
height: 10px;
}
</style>
<h3>Project Complementary</h3>
<h4>Monitoring & Evaluation</h4>
<div>' . $project->detailed_proposal->monitoring_evaluation . ';</div>
<h4>Reporting</h4>
<div>' . $project->detailed_proposal->reporting . '</div>

<h4>Gender Marker</h4>
<div>' . $project->detailed_proposal->gender_marker . '</div>
        ';
        $tenthPageSubmissionProjectBudgetStyle = '
        <style>
       h6{
border-bottom: 1px solid black;
}
h6.categoryTotal{
border-bottom: 1px dashed black;
}
div.textarea{
width:auto;
height:500px;
min-height:400px;
}
h3{
text-decoration: underline;
}
h4{
font-style: italic;
}
table.b{
border: 1px solid black;
width: 100%;
border-collapse: collapse;
}
th.b{
border: 1px solid black;
border-collapse: collapse;
padding-left: 8px;
text-align: left;
}
td.b{
border: 1px solid black;
border-collapse: collapse;
padding-left: 8px;
text-align: left;
}
div.line2{
width: 100%;
height: 10px;
border-bottom: 1px dashed black;
position: absolute;
}
div.line1{
width: 100%;
height: 10px;
border-bottom: 1px dashed red;
position: absolute;
}
div.spaceBetweenBudgetLines{
width: 100%;
height: 2px;
position: absolute;
}
div.line3{
width: 100%;
border-bottom: 1px dashed lightskyblue;
position: absolute;
height: 10px;
}
</style>
        ';
        PDF::setHeaderCallback (function($pdf) {

            // disable auto-page-break
            $pdf->SetAutoPageBreak (false, PDF_MARGIN_BOTTOM);
            // set bacground image
            $img_file = K_PATH_IMAGES . 'back-ground.png';
            $pdf->Image ($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
            // restore auto-page-break status
            $pdf->SetAutoPageBreak (true, PDF_MARGIN_BOTTOM);


        });

// Custom Footer
        PDF::setFooterCallback (function($pdf) {
            // Position at 15 mm from bottom
            $pdf->SetY (-15);
            $pdf->SetX (-15);
            // Set font
            $pdf->SetFont ('helvetica', 'I', 8);
            $pdf->SetTextColor (128, 128, 128);
            $pdf->SetFooterMargin (PDF_MARGIN_FOOTER);

            // Page number
            $pdf->Cell (0, 10, 'Page ' . $pdf->getAliasNumPage () . '/' . $pdf->getAliasNbPages (), 0, false, 'C', 0, '', 0, false, 'T', 'M');

        });
        PDF::SetMargins (PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        PDF::SetFont ('helvetica', 8);
//        PDF::AddPage();
//        PDF::Bookmark('Page 1', 0, 0, '', 'B', array(0,64,128));
//        PDF::Cell(0, 10, 'Chapter 1', 0, 1, 'L');$index_link = PDF::AddLink();
//        PDF::SetLink($index_link, 0, '*1');
//        PDF::Cell(0, 10, 'Link to INDEX', 0, 1, 'R', false, $index_link);
//        for ($i = 2; $i < 12; $i++) {
//            PDF::AddPage();
//            PDF::Bookmark('Chapter '.$i, 0, 0, '', 'B', array(0,64,128));
//            PDF::Cell(0, 10, 'Chapter '.$i, 0, 1, 'L');
//        }
//        PDF::addTOCPage();
//        PDF::addTOC(1, 'courier', '.', 'INDEX', 'B', array(128,0,0));
//        PDF::endTOCPage();
        PDF::AddPage ('P', 'A4');
        PDF::writeHTML ($firstPageConceptGeneralInformaion, true, false, true, false, '');
        PDF::SetTitle ('Project MHPSS-2109 Submission');
        PDF::AddPage ('P', 'A4');
        PDF::writeHTML ($secondPageConceptBeneficiaries, true, false, true, false, '');
        PDF::AddPage ();
        PDF::writeHTML ($thirdPageConceptObjectivesAndRisks, true, false, true, false, '');
        PDF::AddPage ();
        PDF::writeHTML ($fourthPageConceptNeedAssessment, true, false, true, false, '');
        PDF::AddPage ();
        PDF::writeHTML ($fifthPageconceptBudget, true, false, true, false, '');
        PDF::AddPage ();
        PDF::writeHTML ($sixthPageSubmissionPrjectDetails_1, true, false, true, false, '');
        PDF::AddPage ();
        PDF::writeHTML ($seventhPageSubmissionPrjectDetails_2, true, false, true, false, '');
        PDF::AddPage ();
        PDF::writeHTML ($eighthPageSubmissionLogicalFrameWork_1, true, false, true, false, '');
        PDF::AddPage ();
        PDF::writeHTML ($ninthPageSubmissionProjectComplementary, true, false, true, false, '');
        PDF::AddPage ();
        PDF::Bookmark ('Budget');
        $budget_categories = \DB::table ('budget_categories')->get ();

        foreach ($budget_categories as $key_1 => $budget_category) {
            $budget_1_tr = '';
            $budget_1 = '';
            $budget_1_data = '';
            $total_budget_1 = 0;
            foreach ($project->detailed_proposal_budget->where ('budget_category_id', $budget_category->id) as $key => $value) {
                $total = ($value->unit_cost * $value->chf * $value->quantity * $value->duration) / 100;
                $total_budget_1 += $total;
                $in_kind = $value->in_kind === true ? "S" : "D";
                $budget_1_tr .= '<tr>
<td class="b" style="width: 5%">' . $value->budget_line . '</td>
<td class="b" style="width: 15%;text-align: center">' . $value->category_option_name_en . '</td>
<td class="b" style="text-align: center; width: 10%">' . $value->unit_name_en . '</td>
<td class="b" style="width: 10%">' . $value->unit_cost . ' $</td>
<td class="b" style="text-align: center;width: 10%">' . $value->duration . '</td>
<td class="b" style="width: 10%">' . $value->quantity . '</td>
<td class="b" style="text-align: center;width: 10%">' . $value->chf . '</td>
<td class="b" style="width: 10%">' . $total . ' $</td>
<td class="b" style="text-align: center; width: 10%">' . $value->donor_name_en . '</td>
<td class="b" style="text-align: center;width: 10%">' . $in_kind . '</td>
</tr>
<tr>
<td class="b" colspan="2" style="text-align: center">Description</td>
<td class="b" colspan="8">' . $value->description . '</td>
</tr>
<tr>
<td></td>
</tr>';

            }
            if ($key_1 == 0) {
                $table = '<table>
<tr>
<td>
<h3>Budget</h2>
</td>
<td>
<h6 style="text-align: right;">Budget Total: ' . $project->project_budget . ' $</h6>
</td>
</tr>
</table><br><br>';
            } else {
                $table = '';
            }
            $budget_1_data .= '
' . $table . '

<table>
<tr>
<td>
<h4>' . $budget_category->name_en . '</h4>
</td>
<td>
<h6 class="categoryTotal" style="text-align: right;">Category Total: ' . $total_budget_1 . ' $</h6>
</td>
</tr>
</table>
        ';
            $budget_1 .= '
<table class="b" style="font-size: 10px" cellpadding="5">
<tr>
<th class="b" style="width: 5%;text-align: center">#</th>
<th class="b" style="width: 15%;text-align:center">Category Option</th>
<th class="b" style="width: 10%;text-align: center">Unit</th>
<th class="b" style="width: 10%;text-align: center">Unit Cost</th>
<th class="b" style="width: 10%;text-align: center">Duraion</th>
<th class="b" style="width: 10%;text-align: center">Quantity</th>
<th class="b" style="width: 10%;text-align: center">CHF</th>
<th class="b" style="width: 10%;text-align: center">Total</th>
<th class="b" style="width: 10%;text-align: center">Donor</th>
<th class="b" style="width: 10%;text-align: center">D/S</th>
</tr>
' . $budget_1_tr . '

<tfoot>
<tr>
<td colspan="10" style="text-align: right;font-size: 8px;">
<b>Category Total: ' . $total_budget_1 . '$</b>
</td>
</tr>
</tfoot>
</table>
<br><br><br>';
//            PDF::writeHTMLCell (0, '', '', '', $tenthPageSubmissionProjectBudgetStyle . $budget_1_data . $budget_1, 0, 2, false, false, 'L', false);
            PDF::writeHTML ($tenthPageSubmissionProjectBudgetStyle . $budget_1_data . $budget_1, true, false, true, false, '');
        }
//        PDF::writeHTMLCell(0, '', '', '', $tenthPageSubmissionProjectBudgetStyle.$tenthPageSubmissionProjectBudgetPersonnelData,0,2,false,false,'L',false);
//        PDF::writeHTML($tenthPageSubmissionProjectBudgetStyle.$budget_1, true, false, true, false, '');
//        $htmllong = PDF::getStringHeight (0, $budget_1, false, true, '', 1);
//        $pageHeight = PDF::getPageHeight ('11');
//        $getY = PDF::GetX ();
//        echo '<script>alert('.$pageHeight.')</script>';
//        echo '<script>alert('.$htmllong.')</script>';
//        echo '<script>alert('.$htmllong / $pageHeight.')</script>';
//        PDF::AddPage ();
//        PDF::Cell (0, 10, 'Page ' . $htmllong . '/' . $pageHeight . ':' . $getY, 0, false, 'C', 0, '', 0, false, 'T', 'M');
        PDF::Output ('Project_MHPSS-2109_Submission.pdf');

    }

}
