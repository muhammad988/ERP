<?php

namespace App\Http\Controllers;


use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Authority\Store;
use Illuminate\Contracts\View\Factory;
use App\Http\Requests\Authority\Update;
use App\Http\Resources\Authority\UserRole\UserRoleCollection;
use App\Http\Resources\Authority\UserRole\UserRoleEdit;
use App\Model\Authority\Role;
use App\Model\Authority\UserRole;
use App\Model\ControlPanel\Hr\Department;
use App\Model\ControlPanel\Hr\Mission;
use App\Model\Hr\User;
use App\Model\Project\Project;
use Illuminate\Http\Request;

/**
 * Class AuthorityController
 * @package App\Http\Controllers
 */
class AuthorityController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index ()
    {
        $this->data['missions'] = $this->select_box(new Mission(),'id',\DB::raw('name_' . $this->lang . ' as name'),trans('common.please_select'));
        $this->data['roles'] = $this->select_box(new Role(),'id',\DB::raw('name_' . $this->lang . ' as name'),trans('common.please_select'));
        $this->data['projects'] = $this->select_box(new Project(),'id',\DB::raw('name_' . $this->lang . ' as name'),trans('common.please_select'));
        $this->data['departments'] = $this->select_box(new Department(),'id',\DB::raw('name_' . $this->lang . ' as name'),trans('common.please_select'));
        $this->data['users'] = $this->select_box(new User(),\DB::raw('id'),\DB::raw('first_name_' . $this->lang . '  || \' \' || last_name_' . $this->lang . ' as name'),trans('common.please_select'),\DB::raw('disabled=0'));
        $this->data['nested_url_superior'] = route('nested_superior_department');
        $this->data['nested_url_position'] = route('nested_position_department');
        $this->data['nested_url_department'] = route('nested_department_mission');
        return view('layouts.authority.index',$this->data);

    }

    /**
     * @param Store $request
     * @return JsonResponse|null
     */
    public function store (Store $request): ?JsonResponse
    {

        try {
            foreach ($request->user_id as $user) {
                if (!is_null($request->project_id)) {
                    foreach ($request->project_id as $project) {
                        UserRole::create($request->except('user_id','project_id') + ['user_id' => $user,'project_id' => $project,'stored_by' => \Auth::user()->full_name]);
                    }
                } else {
                    UserRole::create($request->except('user_id','project_id') + ['user_id' => $user,'stored_by' => \Auth::user()->full_name]);
                }

            }
            return $this->setStatusCode(200)->respond(['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['error' => ['Something is error']]);
        }

    }

    public function edit (UserRole $user_role): ?JsonResponse
    {
        try {

            return $this->resources(new UserRoleEdit($user_role));
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['error' => ['Something is error']]);
        }

    }

    public function update (Update $request): ?JsonResponse
    {


        try {

            $user_role = UserRole::find($request->id);
            $user_role->view = !$request->view ? false : true;
            $user_role->add = !$request->add ? false : true;
            $user_role->update = !$request->update ? false : true;
            $user_role->disable = !$request->disable ? false : true;
            $user_role->delete = !$request->delete ? false : true;
            $user_role->modified_by = \Auth::user()->full_name;
            $user_role->update($request->all());

            return $this->setStatusCode(200)->respond(['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['error' => ['Something is error']]);
        }

    }


    public function destroy ($id): ?JsonResponse
    {
//        $user_role=UserRole::find($id);
//        $this->authorize('delete', $user_role);
        try {
            UserRole::destroy($id);
            return $this->setStatusCode(200)->respond(['deleted'=>['This item deleted']]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['delete'=>['This item is used elsewhere that can not be deleted']]);
        }
    }

    public function get_all (Request $request)
    {
        $page = $request->input('pagination.page');
        $search = $request->input('query.generalSearch',null);
        $perpage = $request->input('pagination.perpage',10);
        $sortOrder = $request->input('sort.sort','asc');
        $sortField = $request->input('sort.field','user_id');
        $offset = ($page - 1) * $perpage;
        $query = UserRole::leftJoin('users','users.id','=','user_roles.user_id')
                         ->leftJoin('roles','roles.id','=','user_roles.role_id')
                         ->leftJoin('projects','projects.id','=','user_roles.project_id')
                         ->select('users.first_name_en  as first_name','users.last_name_en  as last_name','roles.name_en as role_name','projects.name_en as project_name','user_roles.*');


        if (!is_null($search)) {
            $query->whereRaw(
                "(users.first_name_en || users.last_name_en ilike '%$search%'
            or  projects.name_en  ilike '%$search%'
            or  projects.name_ar ilike '%$search%'
            or  roles.name_en ilike '%$search%')");
        }

        $totalCount = $query->count();

        $query->offset($offset)
              ->limit($perpage)
              ->orderBy($sortField,$sortOrder);
        $data = $query->get();
        $request->offsetSet('pages',ceil($totalCount / $perpage));
        $request->offsetSet('total',$totalCount);
        return $this->resources(new UserRoleCollection($data));
    }


}
