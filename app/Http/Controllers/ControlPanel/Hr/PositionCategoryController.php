<?php

namespace App\Http\Controllers\ControlPanel\Hr;


use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use App\Http\Requests\ControlPanel\Hr\PositionCategory\Store;
use App\Http\Requests\ControlPanel\Hr\PositionCategory\Update;
use App\Http\Resources\ControlPanel\Hr\PositionCategory\PositionCategoryCollection;
use App\Http\Resources\ControlPanel\Hr\PositionCategory\PositionCategory as info;
use App\Model\ControlPanel\Hr\Department;
use App\Model\ControlPanel\Hr\Mission;
use App\Model\ControlPanel\Hr\PositionCategory;
use Illuminate\Http\Request;

/**
 * Class PositionCategoryController
 * @package App\Http\Controllers\ControlPanel\Hr
 */
class PositionCategoryController extends Controller
{

    /**
     * @return Factory|View
     */
    public function index():View
    {
        $this->data['position_categories'] = $this->select_box(new PositionCategory(),'id',\DB::raw('name_'.$this->lang.' as name' ),trans('common.please_select'));
        return view('layouts.control_panel.hr.position_category.index',$this->data);
    }

    public function create()
    {


    }


    public function store(Store $request): ?\Illuminate\Http\JsonResponse
    {
        try {
            PositionCategory::create($request->all());
            return $this->setStatusCode(200)->respond(['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['status' => false]);
        }
    }

    public function show($id)
    {
        //
    }


    public function edit(PositionCategory $position_category): \Illuminate\Http\JsonResponse
    {
        return $this->resources(new info($position_category));

    }


    public function update(Update $request): ?\Illuminate\Http\JsonResponse
    {
        try {
            $position=  PositionCategory::find($request->input('id'));
            $position->update($request->all());
            return $this->setStatusCode(200)->respond(['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['status' => false]);
        }
    }


    public function destroy($id)
    {

        try {
            PositionCategory::destroy($id);
            return $this->setStatusCode(200)->respond(['deleted'=>['This item deleted']]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['delete'=>['This item is used elsewhere that can not be deleted']]);
        }
    }

    public function get_all(Request $request): \Illuminate\Http\JsonResponse
    {
        $page = $request->input('pagination.page');
        $search = $request->input('query.generalSearch',null);
        $perpage = $request->input('pagination.perpage',10);
        $sortOrder = $request->input('sort.sort','asc');
        $sortField = $request->input('sort.field','name_en');
        $offset = ($page-1) * $perpage;
        $query = PositionCategory::with('parent');

        if (is_null ($search)) {
            $totalCount = $query->count();
        } else {
            $query->whereRaw("(name_en || name_en ilike '%$search%' ) or  (name_ar || name_ar ilike '%$search%')");
            $totalCount = $query->count();
        }
        $query->offset($offset)
              ->limit($perpage)
              ->orderBy($sortField,$sortOrder);
        $data = $query->get();
        $request->offsetSet('pages',ceil($totalCount / $perpage));
        $request->offsetSet('total',$totalCount);
        return $this->resources(new PositionCategoryCollection($data));
    }



}
