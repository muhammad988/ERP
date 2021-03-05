<?php

namespace App\Http\Controllers\ControlPanel\Hr;


use App\Http\Controllers\Controller;
use App\Http\Requests\ControlPanel\Hr\Department\Store;
use App\Http\Requests\ControlPanel\Hr\Department\Update;
use App\Http\Resources\ControlPanel\Hr\Department\DepartmentCollection;
use App\Http\Resources\ControlPanel\Hr\Department\DepartmentList;
use App\Model\ControlPanel\Hr\Department;
use App\Model\ControlPanel\Hr\DepartmentMission;
use App\Model\ControlPanel\Hr\Mission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    public function index()
    {
        return view('layouts.control_panel.hr.department.index',$this->data);

    }

    public function create()
    {


    }


    public function store(Store $request) : ?JsonResponse
    {
        try {
            Department::create($request->all());
            return $this->setStatusCode(200)->respond(['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['status' => false]);
        }
    }

    public function show($id)
    {
        //
    }


    public function edit(Department $department): JsonResponse
    {
        return $this->resources(new DepartmentList($department));

    }


    public function update(Update $request): ?JsonResponse
    {
        try {
            $department=  Department::find($request->input('id'));
            $department->update($request->all());
            return $this->setStatusCode(200)->respond(['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['status' => false]);
        }
    }


    public function destroy($id)
    {

        try {
            Department::destroy($id);
            return $this->setStatusCode(200)->respond(['deleted'=>['This item deleted']]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['delete'=>['This item is used elsewhere that can not be deleted']]);
        }
    }

    public function get_all(Request $request): JsonResponse
    {
        $page = $request->input('pagination.page');
        $search = $request->input('query.generalSearch',null);
        $perpage = $request->input('pagination.perpage',10);
        $sortOrder = $request->input('sort.sort','asc');
        $sortField = $request->input('sort.field','name_en');
        $offset = ($page-1) * $perpage;
        $query = Department::whereNotNull('name_en');

        if (!is_null($search)) {
            $query->whereRaw("name_en ilike '%$search%' or name_ar ilike '%$search%'");
            $totalCount = $query->count();
        } else {
            $totalCount = $query->count();
        }
        $query->offset($offset)
              ->limit($perpage)
              ->orderBy($sortField,$sortOrder);
        $data = $query->get();
        $request->offsetSet('pages',ceil($totalCount / $perpage));
        $request->offsetSet('total',$totalCount);
        return $this->resources(new DepartmentCollection($data));
    }
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function nested_select(Request $request): ?JsonResponse
    {
        try {
            if ($request->input('id')!=null){
                $data = Mission::find($request->input('id'))->departments()->pluck('departments.name_en', 'departments_missions.id');
                return $this->respond($data);
            }

            return $this->setStatusCode(422)->respond(['error'=>'not find']);

        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['error'=>'not find']);
        }

    }

    /**
     * @param Request $request
     * @return JsonResponse|null
     */
    public function nested_select_multiple(Request $request): ?JsonResponse
    {

        try {
            if ($request->input('id')!=null){
                $data=DepartmentMission::whereIn('mission_id',$request->input('id'))->select('department_id')->distinct()->with('department')->get();
                $array=[];
                foreach ($data as $key=>$value){
                    $array[$value->department->id] = $value->department->name_en;
                }
                return $this->respond($array);
            }
            return $this->setStatusCode(422)->respond(['error'=>'not find']);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['error'=>'not find']);
        }

    }
}
