<?php

namespace App\Http\Controllers\ControlPanel\Hr;


use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use App\Http\Requests\ControlPanel\Hr\Mission\AuthorityUpdate;
use App\Http\Requests\ControlPanel\Hr\Mission\ManagementDepartmentStore;
use App\Http\Requests\ControlPanel\Hr\Mission\ManagementDepartmentUpdate;
use App\Http\Requests\ControlPanel\Hr\Mission\ManagementSectorStore;
use App\Http\Requests\ControlPanel\Hr\Mission\Store;
use App\Http\Requests\ControlPanel\Hr\Mission\StoreBudget;
use App\Http\Requests\ControlPanel\Hr\Mission\Update;
use App\Http\Resources\ControlPanel\Hr\Mission\MissionBudgetCollection;
use App\Http\Resources\ControlPanel\Hr\Mission\MissionCollection;
use App\Http\Resources\ControlPanel\Hr\Mission\MissionDepartmentEdit;
use App\Http\Resources\ControlPanel\Hr\Mission\MissionEdit;
use App\Http\Resources\ControlPanel\Hr\Mission\MissionSectorDepartmentEdit;
use App\Model\ControlPanel\Hr\Department;
use App\Model\ControlPanel\Hr\DepartmentMission;
use App\Model\ControlPanel\Hr\Mission;
use App\Model\ControlPanel\Hr\Sector;
use App\Model\ControlPanel\Hr\SectorDepartment;
use App\Model\ControlPanel\Project\CategoryOption;
use App\Model\ControlPanel\Project\Unit;
use App\Model\Hr\User;
use App\Model\Mission\MissionBudget;
use App\Model\Mission\MissionBudgetLine;
use App\Model\OrganisationUnit;
use App\Model\ProjectNotificationStructure;
use Auth;
use DB;
use Error;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class MissionController
 * @package App\Http\Controllers\ControlPanel\Hr
 */
class MissionController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index ()
    {

        $this->data['missions'] = $this->select_box (new Mission(), 'id', DB::raw ('name_' . $this->lang . ' as name'), trans ('common.please_select'));
        $this->data['organisation_unit'] = $this->select_box (new OrganisationUnit(), 'id', DB::raw ('name_' . $this->lang . ' as name'), trans ('common.please_select'), 'parent_id=51');
        return view ('layouts.control_panel.hr.mission.index', $this->data);

    }

    public function store (Store $request) : ?JsonResponse
    {
        try {
            Mission::create ($request->all () + ['stored_by' => \Auth::user ()->full_name]);
            return $this->setStatusCode (200)->respond (['status' => true]);
        }catch(Exception $e) {
            return $this->setStatusCode (422)->respond (['status' => false]);
        }
    }

    public function edit (Mission $mission) : JsonResponse
    {
        return $this->resources (new MissionEdit($mission));

    }

    public function update (Update $request) : ?JsonResponse
    {
        try {
            $mission = Mission::find ($request->id);
            $mission->modified_by = \Auth::user ()->full_name;
            $mission->update ($request->all ());
            return $this->setStatusCode (200)->respond (['status' => true]);
        }catch(Exception $e) {
            return $this->setStatusCode (422)->respond (['status' => false]);
        }
    }

    public function destroy ($id) : ?JsonResponse
    {

        try {
            Mission::destroy ($id);
            return $this->setStatusCode (200)->respond (['deleted' => ['This item deleted']]);
        }catch(Exception $e) {
            return $this->setStatusCode (422)->respond (['delete' => ['This item is used elsewhere that can not be deleted']]);
        }
    }

    public function get_all (Request $request) : JsonResponse
    {
        $page = $request->input ('pagination.page');
        $search = $request->input ('query.generalSearch', null);
        $perpage = $request->input ('pagination.perpage', 10);
        $sortOrder = $request->input ('sort.sort', 'asc');
        $sortField = $request->input ('sort.field', 'id');
        $offset = ($page - 1) * $perpage;
        $query = Mission::with ('parent');

        if(!is_null ($search)) {
            $query->whereRaw ("(name_en ilike '%$search%' or   name_ar ilike '%$search%')");
            $totalCount = $query->count ();
        }else {
            $totalCount = $query->count ();
        }
        $query->offset ($offset)
            ->limit ($perpage)
            ->orderBy ($sortField, $sortOrder);
        $data = $query->get ();
        $request->offsetSet ('pages', ceil ($totalCount / $perpage));
        $request->offsetSet ('total', $totalCount);
        return $this->resources (new MissionCollection($data));
    }

    public function index_budget (Request $request)
    {
        $this->data['id'] = $request->mission;
        return view ('layouts.control_panel.hr.mission.budget.index', $this->data);

    }

    public function get_all_budget (Request $request) : JsonResponse
    {
        $page = $request->input ('pagination.page');
        $search = $request->input ('query.generalSearch', null);
        $perpage = $request->input ('pagination.perpage', 10);
        $sortOrder = $request->input ('sort.sort', 'asc');
        $sortField = $request->input ('sort.field', 'id');
        $offset = ($page - 1) * $perpage;
        $query = MissionBudget::where ('mission_id', $request->id);
        if(!is_null ($search)) {
            $query->whereRaw ("(name_en ilike '%$search%' or   name_ar ilike '%$search%')");
            $totalCount = $query->count ();
        }else {
            $totalCount = $query->count ();
        }
        $query->offset ($offset)
            ->limit ($perpage)
            ->orderBy ($sortField, $sortOrder);
        $data = $query->get ();
        $request->offsetSet ('pages', ceil ($totalCount / $perpage));
        $request->offsetSet ('total', $totalCount);
        return $this->resources (new MissionBudgetCollection($data));
    }

    public function create_budget (Mission $mission)
    {
        $this->data['mission'] = $mission;

        $this->data['category_options'] = $this->select_box (new CategoryOption(), 'id', DB::raw ('name_' . $this->lang . ' as name'), trans ('common.please_select'), 'parent_id=14738');
        $this->data['units'] = $this->select_box (new Unit(), 'id', DB::raw ('name_' . $this->lang . ' as name'), trans ('common.please_select'));
        return view ('layouts.control_panel.hr.mission.budget.create', $this->data);

    }

    public function store_budget (StoreBudget $request) : ?JsonResponse
    {

        try {
            $mission_budget = $request->mission_budget;
            $mission_budget = MissionBudget::create ($mission_budget + ['stored_by' => Auth::user ()->full_name]);
            $total_budget = 0;
            $budget = [];
            $data = ['374766' => 'personnel', '374767' => 'supplies', '374768' => 'equipment', '374769' => 'contractual', '374770' => 'travel', '374771' => 'trans', '374772' => 'general', '374773' => 'support_cost'];
            foreach($data as $name) {
                if(isset($request["$name"])) {
                    foreach($request["$name"] as $key => $value) {
                        $total_budget += ($value['duration'] * $value['quantity'] * $value['unit_cost'] * $value['chf']) / 100;
                        $value['stored_by'] = Auth::user ()->full_name;
                        $value['budget_category_id'] = 374766;
                        unset($value['total']);
                        $budget[] = new MissionBudgetLine($value);
                    }
                }
            }
            $mission_budget->mission_budget_line ()->saveMany ($budget);

            return $this->setStatusCode (200)->respond (['status' => true]);
        }catch(Exception $e) {
            return $this->setStatusCode (422)->respond (['status' => false]);
        }
    }

    public function show_budget ($id)
    {
        $this->data['mission_budget'] = MissionBudget::find ($id);
//        $this->data['mission_id'] = $this->data['mission_budget']->mission_id;
//        $this->data['stage'] = $this->stage;
        $this->data['budget_categories'] = \DB::table ('budget_categories')->get ();
        $this->data['total_budgets'] = 0;
        return view ('layouts.control_panel.hr.mission.budget.show', $this->data);

    }

    public function edit_budget ($id)
    {
        $this->data['mission_budget'] = MissionBudget::find ($id);
        $this->data['mission_id'] = $this->data['mission_budget']->mission_id;
        $this->data['category_options'] = $this->select_box (new CategoryOption(), 'id', DB::raw ('name_' . $this->lang . ' as name'), trans ('common.please_select'), 'parent_id=14738');
        $this->data['units'] = $this->select_box (new Unit(), 'id', DB::raw ('name_' . $this->lang . ' as name'), trans ('common.please_select'));
        return view ('layouts.control_panel.hr.mission.budget.edit', $this->data);

    }

    public function update_budget (Request $request) : ?JsonResponse
    {
        try {
        $data_mission_budget = $request->mission_budget;
        $mission_budget = MissionBudget::find ($data_mission_budget['id']);
        $mission_budget->modified_by = Auth::user ()->full_name;
        $mission_budget->update ($data_mission_budget);
        $total_budget = 0;
        $budget = [];
        $ids = [];
        $data = ['374766' => 'personnel', '374767' => 'supplies', '374768' => 'equipment', '374769' => 'contractual', '374770' => 'travel', '374771' => 'trans', '374772' => 'general', '374773' => 'support_cost'];
        foreach($data as $key => $name) {
            if(isset($request["$name"])) {
                foreach($request["$name"] as $value) {
                    if(isset($value['budget_id']) && !is_null ($value['budget_id'])) {
                        $ids[] = $value['budget_id'];
                        $value['modified_by'] = Auth::user ()->full_name;
                    }else{
                        $value['budget_id']=null;
                        $value['stored_by'] = Auth::user ()->full_name;
                        $value['budget_category_id'] = $key;
                    }
                    MissionBudgetLine::updateOrCreate  (['id' => $value['budget_id']], $value);
                }
            }
        }

        $mission_budget->mission_budget_line ()->saveMany ($budget);

        return $this->setStatusCode (200)->respond (['status' => true]);
        }catch(Exception $e) {
            return $this->setStatusCode (422)->respond (['status' => false]);
        }

    }

    public function management (Mission $mission)
    {

        $this->data['departments'] = $this->select_box (new Department(), 'id', DB::raw ('name_' . $this->lang . ' as name'), trans ('common.please_select'));
        $this->data['mission'] = $mission;
        $this->data['nested_url_superior'] = route ('nested_superior_department');
        $this->data['nested_url_department'] = route ('nested_department_mission');
        $this->data['authority_update'] = route ('mission.management_authority_update');
        $this->data['authority'] = [
            0  => 'head_of_mission',
            1  => 'finance_responsibility',
            2  => 'logistic_responsibility',
            3  => 'procurement_responsibility',
            4  => 'hr_responsibility',
            5  => 'accountant_responsibility',
            6  => 'it_responsibility',
            7  => 'im_responsibility',
            8  => 'm_e_responsibility',
            9  => 'treasurer_responsibility',
            10 => 'mission_budget_holder',
        ];
        $this->data['missions'] = $this->select_box (new Mission(), 'id', DB::raw ('name_' . $this->lang . ' as name'), trans ('common.please_select'));

        $this->data['users'] = $this->select_box (new User(), DB::raw ('id'), DB::raw ('first_name_' . $this->lang . '  || \' \' || last_name_' . $this->lang . ' as name'), trans ('common.please_select'), DB::raw ('disabled=0'));

        return view ('layouts.control_panel.hr.mission.management', $this->data);

    }


    public function management_department_store (ManagementDepartmentStore $request) : ?JsonResponse
    {
        try {
            if(isset($request->status)) {
                $request->offsetSet ('status', 1);
            }else {

                $request->offsetSet ('status', 0);
            }
            $mission = Mission::find ($request->mission_id);
            if($mission->departments ()->where ('departments_missions.department_id', $request->department_id)->exists ()) {
                throw new Error();
            }
            $mission->departments ()->attach ($request->department_id, ['start_date' => $request->start_date, 'status' => $request->status, 'end_date' => $request->end_date, 'parent_id' => $request->parent_id, 'stored_by' => \Auth::user ()->full_name]);
            $data = DepartmentMission::where ('departments_missions.department_id', $request->department_id)->where ('departments_missions.mission_id', $request->mission_id)->first ();
            return $this->resources (new MissionDepartmentEdit($data));
        }catch(Exception $e) {
            return $this->setStatusCode (422)->respond (['status' => false, 'message' => 'Something is error']);
        }catch(Error $e) {
            return $this->setStatusCode (422)->respond (['status' => false, 'message' => 'This department already exists']);

        }
    }

    public function management_department_edit ($id) : JsonResponse
    {
        $data = DepartmentMission::where ('departments_missions.id', $id)->first ();
        return $this->resources (new MissionDepartmentEdit($data));
    }

    public function management_department_sector_store (ManagementSectorStore $request) : ?JsonResponse
    {


        try {
            $sector = Sector::find ($request->sector_id);
            if($sector->departments ()->where ('sectors_departments.department_id', $request->department_id)->exists ()) {
                throw new Error();
            }
            $sector->departments ()->attach ($request->department_id, ['stored_by' => \Auth::user ()->full_name]);
            $data = SectorDepartment::where ('sectors_departments.department_id', $request->department_id)->where ('sectors_departments.sector_id', $request->sector_id)->first ();
            return $this->resources (new MissionSectorDepartmentEdit($data));
        }catch(Exception $e) {
            return $this->setStatusCode (422)->respond (['status' => false, 'message' => 'Something is error']);
        }catch(Error $e) {
            return $this->setStatusCode (422)->respond (['status' => false, 'message' => 'This sector already exists']);

        }
    }

    public function management_department_sector_edit ($id)
    {
        $this->data['data'] = DepartmentMission::where ('departments_missions.id', $id)->with ('department', 'mission')->first ();
        $this->data['sector'] = SectorDepartment::where ('department_id', $id)->with ('department', 'sector')->get ();
        $this->data['id'] = $id;
        $this->data['sectors'] = $this->select_box (new Sector(), 'id', DB::raw ('name_' . $this->lang . ' as name'), trans ('common.please_select'));
        return view ('layouts.control_panel.hr.mission.sector_management', $this->data);

//        $data=DepartmentMission::where('departments_missions.id',$id)->first();
//       return $this->resources(new MissionDepartmentEdit($data));
    }

    public function management_department_update (ManagementDepartmentUpdate $request) : ?JsonResponse
    {
        try {
            if(isset($request->status)) {
                $request->offsetSet ('status', 1);
            }else {

                $request->offsetSet ('status', 0);
            }
            $department = DepartmentMission::find ($request->id);
            $department->modified_by = \Auth::user ()->full_name;
            $department->update ($request->all ());
            $data = DepartmentMission::find ($request->id);
            return $this->resources (new MissionDepartmentEdit($data));
        }catch(Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => 'Something is error']);
        }
    }

    public function management_department_destroy ($id) : ?JsonResponse
    {
        try {
            DepartmentMission::destroy ($id);
            return $this->setStatusCode (200)->respond (['deleted' => ['This item deleted']]);
        }catch(Exception $e) {
            return $this->setStatusCode (422)->respond (['delete' => ['This item is used elsewhere that can not be deleted']]);
        }
    }

    public function management_department_sector_destroy ($id) : ?JsonResponse
    {
        try {
            SectorDepartment::destroy ($id);
            return $this->setStatusCode (200)->respond (['deleted' => ['This item deleted']]);
        }catch(Exception $e) {
            return $this->setStatusCode (422)->respond (['delete' => ['This item is used elsewhere that can not be deleted']]);
        }
    }

    public function management_authority_update (AuthorityUpdate $request) : ?JsonResponse
    {
        try {
            $mission = Mission::find ($request->id);
            $mission->modified_by = \Auth::user ()->full_name;
            $mission["$request->name"] = $request->user_id;
            $mission->update ();
            ProjectNotificationStructure::where('mission_id',$request->id)
                ->update([$request->name=>$request->user_id]);
            return $this->setStatusCode (200)->respond (['success' => 'success']);
        }catch(Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => 'Something is error']);
        }
    }
}
