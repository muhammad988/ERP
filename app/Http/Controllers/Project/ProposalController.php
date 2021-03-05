<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\Proposal\Store;
use App\Http\Requests\Project\Proposal\Update;
use App\Model\ControlPanel\Hr\DepartmentMission;
use App\Model\ControlPanel\Hr\Mission;
use App\Model\ControlPanel\Hr\SectorDepartment;
use App\Model\NotificationType;
use App\Model\OrganisationUnit;
use App\Model\Project\BudgetCategory;
use App\Model\Project\Project;
use App\Model\Project\Proposal;
use App\Model\Project\ProposalBeneficiary;
use App\Model\Project\ProposalBudgets;
use App\Model\ProjectNotification;
use Auth;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

/**
 * Class ProposalController
 * @package App\Http\Controllers\Project
 */
class ProposalController extends Controller
{

    public function index ()
    {
        //
    }

    public function basic_data () : void
    {
        $mission_id = DepartmentMission::find (Auth::user ()->department_id)->mission_id;
        $this->data['missions'] = $this->select_box (new Mission(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), trans ('common.please_select'),
            'id=' . $mission_id . ' or
                 head_of_mission  = ' . Auth::id () . ' or
            finance_authority  = ' . Auth::id () . ' or
            finance_authority  = ' . Auth::id () . ' or
            accountant_authority  = ' . Auth::id () . ' or
           logistic_authority  = ' . Auth::id () . ' or
            procurement_authority  = ' . Auth::id () . ' or
            hr_authority  = ' . Auth::id () . 'or
            finance_responsibility  = ' . Auth::id () . ' or
            logistic_responsibility  = ' . Auth::id () . ' or
            procurement_responsibility  = ' . Auth::id () . ' or
            hr_responsibility = ' . Auth::id () . ' or
            accountant_responsibility = ' . Auth::id () . ' or
            it_responsibility = ' . Auth::id () . ' or
            im_responsibility  = ' . Auth::id () . ' or
            m_e_responsibility  = ' . Auth::id () . '');
        $this->data['organisation_unit'] = $this->select_box (new OrganisationUnit(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), trans ('common.please_select'), 'parent_id=51 ');
        $this->data['budget_categories'] = $this->select_box (new BudgetCategory(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), '', 'status=true','sort_order');
        $this->data['nested_url_department'] = route ('nested_department_mission');
        $this->data['nested_url_sector'] = route ('nested_sector_department');
    }


    /**
     * @return Factory|View
     */
    public function create ()
    {
        $this->basic_data ();
        return view ('layouts.project.proposal.create', $this->data);
    }


    /**
     * @param Store $request
     * @return JsonResponse|null
     */
    public function store (Store $request) : ?JsonResponse
    {

        try {
            $proposal = $request->proposal;
            $project = $request->project;
            $project['status_id'] =174;
            $project['stage_id'] = 1;
            $project = Project::create ($project + ['stored_by' => Auth::user ()->full_name, 'project_budget' => str_replace (',', '', $request->project_budget)]);
            Proposal::create ($request->proposal + ['project_id' => $project->id]);
            foreach($request->input ('beneficiary.men') as $key => $value) {
                $type = ($key == 0) ? '374764' : '374765';
                $beneficiary_records[] =
                    new ProposalBeneficiary([
                        'men'                         => str_replace (',', '', $value),
                        'women'                       => str_replace (',', '', $request->input ('beneficiary.women.' . $key . '')),
                        'boys'                        => str_replace (',', '', $request->input ('beneficiary.boys.' . $key . '')),
                        'girls'                       => str_replace (',', '', $request->input ('beneficiary.girls.' . $key . '')),
                        'project_beneficiary_type_id' => $type,
                        'stored_by'                   => Auth::user ()->full_name,
                    ]);
            }
            foreach($request->budget as $key => $value) {
                $budget_records[] =
                    new ProposalBudgets([
                        'budget_category_id' => $key,
                        'value'              => $value,
                        'stored_by'          => Auth::user ()->full_name,
                    ]);
            }
            $project->beneficiaries ()->saveMany ($beneficiary_records);
            $project->proposal_budgets ()->saveMany ($budget_records);
            $this->notification_project ($project->id, 'concept', 'proposal.show', 0, 7423);
            return $this->setStatusCode(200)->respond(['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['status' => false]);
        }
    }
    /**
     * @param Project $project
     * @return Factory|View
     */
    public function show (Project $project)
    {
        $this->data['project'] = $project;
        $this->data['status']= $this->status;
        $this->data['stage']= $this->stage ;
        $this->data['first_project_notification'] = $project->project_notification()->first();
        $this->data['last_project_notification'] = $project->project_notification()->latest('id')->first();
        return view ('layouts.project.proposal.show', $this->data);
    }

    /**
     * @param Project $project
     * @return Factory|View
     * @throws Exception
     */
    public function edit (Project $project)
    {
        $this->data['project'] = $project;
        $this->basic_data ();
        $sector_department = SectorDepartment::find ($project->sector_id);
        $this->data['mission_id'] = $sector_department->department->mission_id;
        $this->data['department_id'] = $sector_department->department_id;
        $this->data['departments'] = Mission::find ($this->data['mission_id'])->departments ()->pluck ('departments.name_en', 'departments_missions.id');
        $this->data['sectors'] = DepartmentMission::find ($sector_department->department_id)->sectors ()->pluck ('sectors.name_en', 'sectors_departments.id');
        return view ('layouts.project.proposal.edit', $this->data);
    }


    /**
     * @param Update $request
     * @param Project $project
     * @return JsonResponse
     */
    public function update (Update $request, Project $project) : ?JsonResponse
    {
        try {
            $proposal = $request->proposal;
            $proposal['catchment_area'] = str_replace (',', '', $proposal['catchment_area']);
            $project->modified_by = Auth::user ()->full_name;
            $project->update (['project_budget' => str_replace (',', '', $request->project_budget)] + $request->project);
            $update_proposal = Proposal::where ('project_id', $project->id)->first ();
            $update_proposal->update ($proposal);
            foreach($request->input ('beneficiary.type') as $key => $value) {
                $project->beneficiaries ()->where ('project_beneficiary_type_id', $request->input ('beneficiary.type.' . $key . ''))
                    ->update ([
                        'men'         => str_replace (',', '', $request->input ('beneficiary.men.' . $key . '')),
                        'women'       => str_replace (',', '', $request->input ('beneficiary.women.' . $key . '')),
                        'boys'        => str_replace (',', '', $request->input ('beneficiary.boys.' . $key . '')),
                        'girls'       => str_replace (',', '', $request->input ('beneficiary.girls.' . $key . '')),
                        'modified_by' => Auth::user ()->full_name,
                    ]);
            }
            foreach($request->budget as $key => $value) {
                $project->proposal_budgets ()->where ('budget_category_id', $key)
                    ->update ([
                        'value'       => str_replace (',', '', $value),
                        'modified_by' => Auth::user ()->full_name,
                    ]);
            }
            return $this->setStatusCode (200)->respond (['status' => true]);
        }catch(Exception $e) {
            return $this->setStatusCode (422)->respond ([ 'error' => 'Something is error']);
        }
    }


    public function action (Request $request)
    {
        if($request->action == 'accept') {
            $this->notification_project ($request->id, 'concept', 'proposal.show', 0, 7423);
        }elseif($request->action == 'reject') {
            $notification_check = ProjectNotification::where ('url_id', $request->id)->where ('receiver', Auth::id ())->where ('status_id', $this->in_progress)->latest ('id')->first ();
            $type_id = NotificationType::where ('module_name', 'concept')->latest ('id')->first ()->id;
            $this->new_notification_project ($request->id, $type_id, 'proposal.show', 50005, $this->in_progress, $notification_check->requester, $notification_check->requester, 1);
            $notification_check->status_id=170;
            $notification_check->update();
            $project= Project::find ($request->id);
            $project->status_id=171;
            $project->update ();
        }elseif($request->action == 'confirm') {
            $notification_check = ProjectNotification::where ('url_id', $request->id)->where ('receiver', Auth::id ())->where ('status_id', $this->in_progress)->latest ('id')->first ();
            $notification_check->status_id=170;
            $notification_check->update();
        }
        return redirect ('home');

    }

}
