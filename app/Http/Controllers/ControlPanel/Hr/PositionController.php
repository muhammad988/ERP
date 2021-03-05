<?php

namespace App\Http\Controllers\ControlPanel\Hr;


use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use App\Model\ControlPanel\Hr\DepartmentMission;
use App\Http\Requests\ControlPanel\Hr\Position\Store;
use App\Http\Requests\ControlPanel\Hr\Position\Update;
use App\Http\Resources\ControlPanel\Hr\Position\PositionCollection;
use App\Http\Resources\ControlPanel\Hr\Position\PositionList;
use App\Model\ControlPanel\Hr\Department;
use App\Model\ControlPanel\Hr\Position;
use App\Model\ControlPanel\Hr\PositionCategory;
use Illuminate\Http\Request;

/**
 * Class PositionController
 * @package App\Http\Controllers\ControlPanel\Hr
 */
class PositionController extends Controller
{

    /**
     * @return Factory|View
     */
    public function index():View
    {
        $this->data['departments'] = $this->select_box(new Department(),'id',\DB::raw('name_'.$this->lang.' as name' ),trans('common.please_select'));
        $this->data['position_categories'] = $this->select_box(new PositionCategory(),'id',\DB::raw('name_'.$this->lang.' as name' ),trans('common.please_select'));
        $this->data['nested_url'] = route('nested_position_categories');
        return view('layouts.control_panel.hr.position.index',$this->data);
    }


    /**
     * @param Store $request
     * @return JsonResponse|null
     */
    public function store(Store $request): ?JsonResponse
    {
        try {
            Position::create($request->all());
            return $this->setStatusCode(200)->respond(['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['status' => false]);
        }
    }




    /**
     * @param Position $position
     * @return JsonResponse
     */
    public function edit(Position $position): JsonResponse
    {
        return $this->resources(new PositionList($position));

    }


    /**
     * @param Update $request
     * @return JsonResponse
     */
    public function update(Update $request): JsonResponse
    {
        try {
            $position=  Position::find($request->input('id'));
            $position->update($request->all());
            return $this->setStatusCode(200)->respond(['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['status' => false]);
        }
    }


    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {

        try {
            Position::destroy($id);
            return $this->setStatusCode(200)->respond(['deleted'=>['This item deleted']]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['delete'=>['This item is used elsewhere that can not be deleted']]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function get_all(Request $request): JsonResponse
    {
        $page = $request->input('pagination.page');
        $search = $request->input('query.generalSearch',null);
        $perpage = $request->input('pagination.perpage',10);
        $sortOrder = $request->input('sort.sort','asc');
        $sortField = $request->input('sort.field','name_en');
        $offset = ($page-1) * $perpage;
        $query = Position::with('department','position_category');

        if (!is_null($search)) {
            $query->whereRaw("(name_en || name_en ilike '%$search%' ) or  (name_ar || name_ar ilike '%$search%')");
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
        return $this->resources(new PositionCollection($data));
    }

    public function nested_select_category (Request $request):JsonResponse
    {
        try {
            if ($request->input('id') != null) {
                $users = Position::where('position_category_id',$request->input('id'))->select('id',\DB::raw('name_en as name'));
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

    public function nested_select_department(Request $request): ?JsonResponse
    {

        try {
            if ($request->input('id')!=null){

                $data=DepartmentMission::whereIn('department_id',$request->input('id'))->select('department_id')->distinct()->get();
                $users = Position::whereIn('department_id',$data)->select('id',\DB::raw('name_en as name'));
                $collection = collect($users->get());
                $select_box_data = $collection->mapWithKeys(
                    function ($item) {
                        return [$item['id'] => $item['name']];
                    });
                return $this->respond($select_box_data);
            }
            return $this->setStatusCode(422)->respond(['error'=>'not find']);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['error'=>'not find']);
        }

    }
}
