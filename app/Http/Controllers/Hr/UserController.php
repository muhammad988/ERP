<?php

namespace App\Http\Controllers\Hr;


use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Model\ControlPanel\Center;
use App\Http\Controllers\Controller;
use App\Http\Requests\Hr\User\Status;
use Illuminate\Contracts\View\Factory;
use App\Http\Requests\Hr\User\StatusUpdate;
use App\Http\Requests\Hr\User\Store;
use App\Http\Requests\Hr\User\Update;
use App\Http\Resources\Hr\User\UserCollection;
use Illuminate\Contracts\Foundation\Application;
use App\Http\Transformer\User\UserEditTransformer;
//use App\Http\Transformer\User\UserOrgChatTransformer;
use App\Model\ControlPanel\Hr\ContractType;
use App\Model\ControlPanel\Hr\Department;
use App\Model\ControlPanel\Hr\DepartmentMission;
use App\Model\ControlPanel\Hr\Education;
use App\Model\ControlPanel\Hr\TypeOfContract;
use App\Model\ControlPanel\Hr\Major;
use App\Model\ControlPanel\Hr\MaritalStatus;
use App\Model\ControlPanel\Hr\Mission;
use App\Model\ControlPanel\Hr\Nationality;
use App\Model\ControlPanel\Hr\Position;
use App\Model\ControlPanel\Hr\PositionCategory;
use App\Model\ControlPanel\Hr\UserGroup;
use App\Model\ControlPanel\Hr\VisaType;
use App\Model\Hr\User;
use App\Model\OrganisationUnit;
use App\Model\Project\Project;
use Illuminate\Http\Request;
use Auth;


/**
 * Class UserController
 * @package App\Http\Controllers\Hr
 */
class UserController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index ():View
    {
        $this->data['missions'] = $this->select_box(new Mission(),'id',\DB::raw('name_' . $this->lang . ' as name'),'');
        $this->data['projects'] = $this->select_box(new Project(),'id',\DB::raw('name_' . $this->lang . ' as name'),'');
        $this->data['departments'] = $this->select_box(new Department(),'id',\DB::raw('name_' . $this->lang . ' as name'),'');
        $this->data['contracts'] = $this->select_box(new ContractType(),'id',\DB::raw('name_' . $this->lang . ' as name'),'');
        $this->data['type_of_contracts'] = $this->select_box(new TypeOfContract(),'id',\DB::raw('name_' . $this->lang . ' as name'),'');
        $this->data['positions'] = $this->select_box(new Position(),'id',\DB::raw('name_' . $this->lang . ' as name'),'');
        $this->data['nationalities'] = $this->select_box(new Nationality(),'id',\DB::raw('name_' . $this->lang . ' as name'),'');
        $this->data['superior'] = $this->select_box(new User(),\DB::raw('id'),\DB::raw('first_name_' . $this->lang . '  || \' \' || last_name_' . $this->lang . ' as name'),'',\DB::raw('disabled=0 and department_id = '. \Auth::user()->department_id .''));
//        $this->data['nested_url_superior'] = route('nested_superior_department');
        $this->data['nested_url_position'] = route('nested_position_department');
//        $this->data['nested_url_department'] = route('nested_department_mission');
        $this->data['nested_url_department_multiple'] = route('nested_department_mission_multiple');

        return view('layouts.hr.employee.index',$this->data);

    }

    /**
     * @param $id
     * @return Factory|View
     */
    public function show ($id){
        $this->data['user']=User::with ('organisation_unit')->find($id);
        return view('layouts.hr.employee.view',$this->data);
    }

    /**
     * @return Factory|View
     */
    public function create ()
    {
        $this->data['title'] = trans('common.add') . ' ' . trans('hr.employee');
        $this->data['nested_url_position'] = route('nested_position_category');
        $this->data['nested_url_superior'] = route('nested_superior_department');
        $this->data['nested_url_department'] = route('nested_department_mission');
        $this->data['organisation_unit'] = $this->select_box(new OrganisationUnit(),'id',\DB::raw('name_' . $this->lang . ' as name'),trans('common.please_select'),'parent_id=51');
        $this->data['marital_statuses'] = $this->select_box(new MaritalStatus(),'id',\DB::raw('name_' . $this->lang . ' as name'),trans('common.please_select'));
        $this->data['missions'] = $this->select_box(new Mission(),'id',\DB::raw('name_' . $this->lang . ' as name'),trans('common.please_select'));
        $this->data['educations'] = $this->select_box(new Education(),'id',\DB::raw('name_' . $this->lang . ' as name'),trans('common.please_select'));
        $this->data['nationalities'] = $this->select_box(new Nationality(),'id',\DB::raw('name_' . $this->lang . ' as name'),trans('common.please_select'));
        $this->data['visa_type'] = $this->select_box(new VisaType(),'id',\DB::raw('name_' . $this->lang . ' as name'),trans('common.please_select'));
        $this->data['position_categories'] = $this->select_box(new PositionCategory(),'id',\DB::raw('name_' . $this->lang . ' as name'),trans('common.please_select'));
        $this->data['positions'] = $this->select_box(new Position(),'id',\DB::raw('name_' . $this->lang . ' as name'),trans('common.please_select'));
        $this->data['departments'] = $this->select_box(new Department(),'id',\DB::raw('name_' . $this->lang . ' as name'),trans('common.please_select'));
        $this->data['contracts'] = $this->select_box(new ContractType(),'id',\DB::raw('name_' . $this->lang . ' as name'),trans('common.please_select'));
        $this->data['user_group'] = $this->select_box(new UserGroup(),'id',\DB::raw('name_' . $this->lang . ' as name'),trans('common.please_select'));
        $this->data['projects'] = $this->select_box(new Project(),'id',\DB::raw('name_' . $this->lang . ' as name'),trans('common.please_select'));
        $this->data['majors'] = $this->select_box(new Major(),'id',\DB::raw('name_' . $this->lang . ' as name'),trans('common.please_select'));
        $this->data['type_of_contract'] = $this->select_box(new TypeOfContract(),'id',\DB::raw('name_' . $this->lang . ' as name'),trans('common.please_select'));
        $this->data['users'] = $this->select_box(new User(),\DB::raw('id'),\DB::raw('first_name_' . $this->lang . '  || \' \' || last_name_' . $this->lang . ' as name'),trans('common.please_select'),\DB::raw('disabled=0'));
        $this->data['center'] =$this->select_box(new Center(),'id','name_' . $this->lang . ' as name',trans('common.please_select'));
        return view('layouts.hr.employee.create',$this->data);
    }

    /**
     * @param Store $request
     * @return JsonResponse|null
     */
    public function store (Store $request): ?JsonResponse
    {

        try {
            $this->request_replace($request);
            User::create($request->all()+['stored_by'=>\Auth::user ()->full_name]);
            return $this->setStatusCode(200)->respond(['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['error' => ['Something is error']]);
        }

    }

    /**
     * @param $id
     * @return Factory|View
     */
    public function edit ($id)
    {
        $user = User::find($id);
        $this->data['nested_url_position'] = route('nested_position_category');
        $this->data['nested_url_superior'] = route('nested_superior_department');
        $this->data['nested_url_department'] = route('nested_department_mission');
        $this->data['marital_statuses'] = $this->select_box(new MaritalStatus(),'id','name_' . $this->lang . ' as name',trans('common.please_select'));
        $this->data['educations'] = $this->select_box(new Education(),'id','name_' . $this->lang . ' as name',trans('common.please_select'));
        $this->data['nationalities'] = $this->select_box(new Nationality(),'id','name_' . $this->lang . ' as name',trans('common.please_select'));
        $this->data['visa_type'] = $this->select_box(new VisaType(),'id','name_' . $this->lang . ' as name',trans('common.please_select'));
        $this->data['position_categories'] = $this->select_box(new PositionCategory(),'id','name_' . $this->lang . ' as name',trans('common.please_select'));
        $this->data['positions'] = $this->select_box(new Position(),'id','name_' . $this->lang . ' as name',trans('common.please_select'));
        $this->data['departments'] = $this->select_box(new Department(),'id','name_' . $this->lang . ' as name',trans('common.please_select'));
        $this->data['contracts'] = $this->select_box(new ContractType(),'id','name_' . $this->lang . ' as name',trans('common.please_select'));
        $this->data['user_group'] = $this->select_box(new UserGroup(),'id','name_' . $this->lang . ' as name',trans('common.please_select'));
        $this->data['projects'] = $this->select_box(new Project(),'id','name_' . $this->lang . ' as name',trans('common.please_select'));
        $this->data['majors'] = $this->select_box(new Major(),'id','name_' . $this->lang . ' as name',trans('common.please_select'));
        $this->data['type_of_contract'] = $this->select_box(new TypeOfContract(),'id','name_' . $this->lang . ' as name',trans('common.please_select'));
        $this->data['users'] = $this->select_box(new User(),'id','first_name_' . $this->lang . '  || \' \' || last_name_' . $this->lang . ' as name',trans('common.please_select'),'disabled=0');
        $this->data['organisation_unit'] = $this->select_box(new OrganisationUnit(),'id',\DB::raw('name_' . $this->lang . ' as name'),trans('common.please_select'),'parent_id=51 ');
        $this->data['missions'] = $this->select_box(new Mission(),'id',\DB::raw('name_' . $this->lang . ' as name'),trans('common.please_select'));
        $this->data['departments'] = Mission::find($user->department->mission_id)->departments()->pluck('departments.name_en','departments_missions.id');
        $this->data['center'] =$this->select_box(new Center(),'id','name_' . $this->lang . ' as name',trans('common.please_select'));
        $users = User::where('department_id',$user->department_id)->select('id',\DB::raw('first_name_' . $this->lang . '  || \' \' || last_name_' . $this->lang . ' as name'));
        $collection = collect($users->get());
        $select_box_data = $collection->mapWithKeys(
            function ($item) {
                return [$item['id'] => $item['name']];
            });
        $this->data['superior'] = $select_box_data;
//        $userTransformer = new UserEditTransformer();
//        $edit_user = $userTransformer->transform($user);
        $this->data['user'] = $user;
        return view('layouts.hr.employee.edit',$this->data);
    }

    /**
     * @param Update $request
     * @return JsonResponse|null
     */
    public function update (Update $request): ?JsonResponse
    {
        try {

            $this->request_replace($request);
            $user = User::find($request->id);
            $user->update($request->all()+[  'modified_by'=>\Auth::user ()->full_name]);
            return $this->setStatusCode(200)->respond(['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['error' => ['Something is error']]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function get_all (Request $request)
    {
        $page = $request->input('pagination.page');
        $search = $request->input('query.generalSearch',null);
        $perpage = $request->input('pagination.perpage',10);
        $sortOrder = $request->input('sort.sort','asc');
        $sortField = $request->input('sort.field','first_name_en');
        $offset = ($page - 1) * $perpage;
        $query = User::join('positions', 'users.position_id', '=', 'positions.id')
            ->leftJoin('nationalities', 'users.nationality_id', '=', 'nationalities.id')
            ->join('missions', 'users.mission_id', '=', 'missions.id');
        if (!is_null($search)) {
            $query->whereRaw("(first_name_en || last_name_en ilike '%$search%' ) or  (first_name_ar || last_name_ar ilike '%$search%')");
        }
        if (isset($request->mission) && !isset($request->department) ) {
            $data=DepartmentMission::whereIn('mission_id',$request->mission)->select('id')->get();
            $query->whereIn('users.department_id',$data);
        }
        if (!isset($request->mission) && isset($request->department) ) {
            $data=DepartmentMission::whereIn('department_id',$request->department)->select('id')->get();
            $query->whereIn('users.department_id',$data);
        }
        if (isset($request->department,$request->mission)) {
            foreach ($request->mission as $mission_id){
                $data=DepartmentMission::whereIn('department_id',$request->department)->where('mission_id',$mission_id)->select('id')->get();
                $query->whereIn('users.department_id',$data);
            }

        }
        if (isset($request->position) ) {
            $query->whereIn('users.position_id',$request->position);
        }
        if (isset($request->nationality) ) {
            $query->whereIn('users.nationality_id',$request->nationality);
        }
        if (isset($request->project) ) {
            $query->whereIn('users.project_id',$request->project);
        }
        if (isset($request->contract) ) {
            $query->whereIn('users.contract_id',$request->contract);
        }
        if (isset($request->type_of_contract) ) {
            $query->whereIn('users.type_of_contract_id',$request->type_of_contract);
        }
        if (isset($request->disabled) ) {
            $query->where('users.disabled',$request->disabled);
        }
        if (isset($request->start_date) ) {
            $query->whereDate('users.start_date','>=',$request->start_date);
        }
        if (isset($request->end_date) ) {
            $query->whereDate('users.end_date','<=',$request->end_date);
        }


        $totalCount = $query->count();

        $query->offset($offset)
              ->limit($perpage)
              ->orderBy($sortField,$sortOrder);
        $data = $query->select('users.*','positions.name_en as position_name','missions.name_en as mission_name','nationalities.name_en as nationality_name')->get();
        $request->offsetSet('pages',ceil($totalCount / $perpage));
        $request->offsetSet('total',$totalCount);
        return $this->resources(new UserCollection($data));
    }

    public function nested_select_superior (Request $request): ?JsonResponse
    {
        try {
            if ($request->input('id') != null) {
                $users = User::where('department_id',$request->input('id'))->select('id',\DB::raw('first_name_' . $this->lang . '  || \' \' || last_name_' . $this->lang . ' as name'));
                $collection = collect($users->get());
                $select_box_data = $collection->mapWithKeys(
                    function ($item) {
                        return [$item['id'] => $item['name']];
                    });
                return $this->respond($select_box_data);
            }
            return $this->setStatusCode(422)->respond(['error' => 'not find']);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['error' => 'not find']);
        }

    }

    public function request_replace (Request $request): void
    {
        $request->merge(
            [
                'password'                 => \Hash::make($request->password),
            ]);

    }

    public function status (Status $request): ?JsonResponse
    {
        try {
            $user=User::where('id',$request->id)->select('id','disabled')->first();
            $count = $user->children()->where('disabled','0')->count();
            return $this->setStatusCode(200)->respond(['count' => $count ,'disabled' => $user->disabled]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['error' => 'not find']);
        }
    }
    public function status_update (StatusUpdate $request) : ?JsonResponse
    {
        try {
            $user=User::find($request->id);
            $user->disable_date=$request->disable_date;
            $user->disabled = $user->disabled == 0 ?   1 : 0;
            $user->update();
            if (!is_null($request->parent_id)){
                User::where('parent_id',$request->id)->update(['parent_id'=>$request->parent_id]);
                User::where('id',$request->parent_id)->update(['parent_id'=>$user->parent_id]);
            }
            return $this->setStatusCode(200)->respond(['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['error' => ['Something is error']]);
        }
    }

    /**
     * @return Application|Factory|View
     */
    public function org_chart ()
    {
        $users=  User::with ('parent','position')->get ();
        $manager = new Manager();
        $resource = new Collection($users, new UserOrgChatTransformer());
        $this->data['users']=$manager->createData($resource)->toJson();
        return view('layouts.hr.employee.org_chart',$this->data);
    }

    /**
     * @return Application|Factory|View
     */
    public function profile ()
    {
        return view('layouts.hr.employee.profile',$this->data);
    }

    /**
     * @return Application|Factory|View
     */
    public function change_password ()
    {
        return view('layouts.hr.employee.change_password',$this->data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function profile_update (Request $request)
    {
        try {
        $data=$request->all ();
        if($request->hasFile ('photo')) {
            $file = $request->file ('photo');
             $filename = \Str::lower($file->getClientOriginalName());
            $file->move ('assets/media/users/', $filename);
            $data['photo'] = $filename;
        }
        User::find ( Auth::id ())->update ($data);
        return $this->setStatusCode(200)->respond(['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['error' => ['Something is error']]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function change_password_update (Request $request)
    {
        try {
            $data['password']=\Hash::make($request->password);
        User::find ( Auth::id ())->update ($data);
        return $this->setStatusCode(200)->respond(['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['error' => ['Something is error']]);
        }
    }
}
