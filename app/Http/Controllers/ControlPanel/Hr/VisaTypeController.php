<?php

namespace App\Http\Controllers\ControlPanel\Hr;


use App\Http\Controllers\Controller;
use App\Http\Requests\ControlPanel\Hr\VisaType\Store;
use App\Http\Requests\ControlPanel\Hr\VisaType\Update;
use App\Http\Resources\ControlPanel\Hr\VisaType\visaTypeCollection;
use App\Http\Resources\ControlPanel\Hr\VisaType\visaTypeList;
use App\Model\ControlPanel\Hr\VisaType;
use Illuminate\Http\Request;

class VisaTypeController extends Controller
{

    public function index()
    {
        return view('layouts.control_panel.hr.visa_type.index',$this->data);
    }

    public function create()
    {


    }


    public function store(Store $request): ?\Illuminate\Http\JsonResponse
    {
        try {
            VisaType::create($request->all());
            return $this->setStatusCode(200)->respond(['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['status' => false]);
        }
    }

    public function show($id)
    {
        //
    }


    public function edit(VisaType $visa_type): \Illuminate\Http\JsonResponse
    {
        return $this->resources(new visaTypeList($visa_type));
    }


    public function update(Update $request): ?\Illuminate\Http\JsonResponse
    {
        try {
            $data=  VisaType::find($request->input('id'));
            $data->update($request->all());
            return $this->setStatusCode(200)->respond(['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['status' => false]);
        }
    }


    public function destroy($id)
    {

        try {
            VisaType::destroy($id);
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
        $query = VisaType::whereNotNull('name_en');

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
        return $this->resources(new visaTypeCollection($data));
    }

}
