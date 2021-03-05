<?php

namespace App\Http\Controllers\ControlPanel\Hr;


use App\Http\Controllers\Controller;
use App\Http\Requests\ControlPanel\Hr\UserType\Store;
use App\Http\Requests\ControlPanel\Hr\UserType\Update;
use App\Http\Resources\ControlPanel\Hr\UserType\UserTypeCollection;
use App\Http\Resources\ControlPanel\Hr\UserType\UserTypeList;
use App\Model\ControlPanel\Hr\UserType;
use Illuminate\Http\Request;

class UserTypeController extends Controller
{

    public function index()
    {

        return view('layouts.control_panel.hr.user_type.index',$this->data);
    }

    public function create()
    {


    }


    public function store(Store $request): ?\Illuminate\Http\JsonResponse
    {
        try {
            UserType::create($request->all());
            return $this->setStatusCode(200)->respond(['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['status' => false]);
        }
    }

    public function show($id)
    {
        //
    }


    public function edit(UserType $user_type): \Illuminate\Http\JsonResponse
    {
        return $this->resources(new UserTypeList($user_type));

    }


    public function update(Update $request): ?\Illuminate\Http\JsonResponse
    {

        try {
            $data=  UserType::find($request->input('id'));
            $data->update($request->all());
            return $this->setStatusCode(200)->respond(['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['status' => false]);
        }
    }


    public function destroy($id): ?\Illuminate\Http\JsonResponse
    {

        try {
            UserType::destroy($id);
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
        $query = UserType::whereNotNull('name_en');

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
        return $this->resources(new UserTypeCollection($data));
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
