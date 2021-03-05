<?php

namespace App\Http\Controllers\ControlPanel\Hr;


use App\Http\Controllers\Controller;
use App\Http\Requests\ControlPanel\Hr\Nationality\Store;
use App\Http\Requests\ControlPanel\Hr\Nationality\Update;
use App\Http\Resources\ControlPanel\Hr\Nationality\NationalityCollection;
use App\Http\Resources\ControlPanel\Hr\Nationality\NationalityList;
use App\Model\ControlPanel\Hr\nationality;
use Illuminate\Http\Request;

/**
 * Class NationalityController
 * @package App\Http\Controllers\ControlPanel\Hr
 */
class NationalityController extends Controller
{

    public function index()
    {

        return view('layouts.control_panel.hr.nationality.index',$this->data);
    }

    public function create()
    {


    }


    public function store(Store $request): ?\Illuminate\Http\JsonResponse
    {
        try {
            Nationality::create($request->all());
            return $this->setStatusCode(200)->respond(['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['status' => false]);
        }
    }

    public function show($id)
    {
        //
    }


    public function edit(Nationality $nationality): \Illuminate\Http\JsonResponse
    {
        return $this->resources(new NationalityList($nationality));

    }


    public function update(Update $request): ?\Illuminate\Http\JsonResponse
    {

        try {
            $data=  Nationality::find($request->input('id'));
            $data->update($request->all());
            return $this->setStatusCode(200)->respond(['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['status' => false]);
        }
    }


    public function destroy($id): ?\Illuminate\Http\JsonResponse
    {

        try {
            Nationality::destroy($id);
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
        $query = Nationality::whereNotNull('name_en');

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
        return $this->resources(new NationalityCollection($data));
    }



}
