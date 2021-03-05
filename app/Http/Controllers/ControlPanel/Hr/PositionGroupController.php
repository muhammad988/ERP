<?php

namespace App\Http\Controllers\ControlPanel\Hr;


use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use App\Http\Requests\ControlPanel\Hr\PositionGroup\Store;
use App\Http\Requests\ControlPanel\Hr\PositionGroup\Update;
use App\Http\Resources\ControlPanel\Hr\PositionGroup\PositionGroupCollection;
use App\Http\Resources\ControlPanel\Hr\PositionGroup\PositionGroup as info;
use App\Model\ControlPanel\Hr\Department;
use App\Model\ControlPanel\Hr\Mission;
use App\Model\ControlPanel\Hr\PositionGroup;
use App\Model\ControlPanel\Hr\PositionCategory;
use Illuminate\Http\Request;

/**
 * Class PositionGroupController
 * @package App\Http\Controllers\ControlPanel\Hr
 */
class PositionGroupController extends Controller
{


    /**
     * @return Factory|View
     */
    public function index():View
    {
        return view('layouts.control_panel.hr.position_group.index',$this->data);
    }


    /**
     * @param Store $request
     * @return JsonResponse|null
     */
    public function store(Store $request): ?JsonResponse
    {
        try {
            PositionGroup::create($request->all());
            return $this->setStatusCode(200)->respond(['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['status' => false]);
        }
    }
    /**
     * @param PositionGroup $position_group
     * @return JsonResponse
     */
    public function edit(PositionGroup $position_group): JsonResponse
    {
        return $this->resources(new info($position_group));

    }


    /**
     * @param Update $request
     * @return JsonResponse|null
     */
    public function update(Update $request): ?JsonResponse
    {
        try {
            $position_group=  PositionGroup::find($request->input('id'));
            $position_group->update($request->all());
            return $this->setStatusCode(200)->respond(['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['status' => false]);
        }
    }


    /**
     * @param $id
     * @return JsonResponse|null
     */
    public function destroy($id): ?JsonResponse
    {
        try {
            PositionGroup::destroy($id);
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
        $query = PositionGroup::whereNotNull ('id');

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
        return $this->resources(new PositionGroupCollection($data));
    }
}
