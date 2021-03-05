<?php

namespace App\Http\Controllers\ControlPanel\Hr;


use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ControlPanel\Hr\TypeOfContract\Store;
use App\Http\Requests\ControlPanel\Hr\TypeOfContract\Update;
use App\Http\Resources\ControlPanel\Hr\TypeOfContract\TypeOfContractCollection;
use App\Http\Resources\ControlPanel\Hr\TypeOfContract\TypeOfContractList;
use App\Model\ControlPanel\Hr\TypeOfContract;
use Illuminate\Http\Request;

/**
 * Class TypeOfContractController
 * @package App\Http\Controllers\ControlPanel\Hr
 */
class TypeOfContractController extends Controller
{

    public function index()
    {
        return view('layouts.control_panel.hr.type_of_contract.index',$this->data);
    }




    /**
     * @param Store $request
     * @return JsonResponse|null
     */
    public function store(Store $request): ?JsonResponse
    {
        try {
            TypeOfContract::create($request->all());
            return $this->setStatusCode(200)->respond(['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['status' => false]);
        }
    }


    /**
     * @param TypeOfContract $type_of_contract
     * @return JsonResponse
     */
    public function edit(TypeOfContract $type_of_contract): JsonResponse
    {
        return $this->resources(new TypeOfContractList($type_of_contract));
    }


    /**
     * @param Update $request
     * @return JsonResponse|null
     */
    public function update(Update $request): ?JsonResponse
    {
        try {
            $data=  TypeOfContract::find($request->input('id'));
            $data->update($request->all());
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
            TypeOfContract::destroy($id);
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
        $query = TypeOfContract::whereNotNull('name_en');

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
        return $this->resources(new TypeOfContractCollection($data));
    }

}
