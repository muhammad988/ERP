<?php

namespace App\Http\Controllers\ControlPanel\Hr;


use App\Http\Controllers\Controller;
use App\Http\Requests\ControlPanel\Hr\MaritalStatus\Store;
use App\Http\Requests\ControlPanel\Hr\MaritalStatus\Update;
use App\Http\Resources\ControlPanel\Hr\MaritalStatus\MaritalStatusCollection;
use App\Http\Resources\ControlPanel\Hr\MaritalStatus\MaritalStatusList;
use App\Model\ControlPanel\Hr\MaritalStatus;
use Illuminate\Http\Request;

class MaritalStatusController extends Controller
{

    public function index()
    {

        return view('layouts.control_panel.hr.marital_status.index',$this->data);
    }

    public function create()
    {


    }


    public function store(Store $request): ?\Illuminate\Http\JsonResponse
    {
        try {
            MaritalStatus::create($request->all());
            return $this->setStatusCode(200)->respond(['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['status' => false]);
        }
    }

    public function show($id)
    {
        //
    }


    public function edit(MaritalStatus $marital_status): \Illuminate\Http\JsonResponse
    {
        return $this->resources(new MaritalStatusList($marital_status));

    }


    public function update(Update $request): ?\Illuminate\Http\JsonResponse
    {

        try {
            $data=  MaritalStatus::find($request->input('id'));
            $data->update($request->all());
            return $this->setStatusCode(200)->respond(['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['status' => false]);
        }
    }


    public function destroy($id)
    {

        try {
            MaritalStatus::destroy($id);
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
        $query = MaritalStatus::whereNotNull('name_en');

        if (!is_null($search)) {
            $query->whereRaw("( name_en ilike '%$search%'  or   name_ar ilike '%$search%')");
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
        return $this->resources(new MaritalStatusCollection($data));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
//    public function nested_select(Request $request)
//    {
//        try {
//            if ($request->input('id')!=null){
//                $positions = PositionCategory::find($request->input('id'))->positions()->pluck('positions.name_en', 'positions.id');
//                return $this->respond($positions);
//            }
//
//            return $this->setStatusCode(422)->respond(['error'=>'not find']);
//
//        } catch (\Exception $e) {
//            return $this->setStatusCode(422)->respond(['error'=>'not find']);
//        }
//
//    }

}
