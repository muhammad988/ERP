<?php

namespace App\Http\Controllers\ControlPanel\Hr;


use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use App\Http\Requests\ControlPanel\Hr\Sector\Store;
use App\Http\Requests\ControlPanel\Hr\Sector\Update;
use App\Http\Resources\ControlPanel\Hr\Sector\SectorCollection;
use App\Http\Resources\ControlPanel\Hr\Sector\SectorList;
use App\Model\ControlPanel\Hr\DepartmentMission;
use App\Model\ControlPanel\Hr\Sector;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class SectorController
 * @package App\Http\Controllers\ControlPanel\Hr
 */
class SectorController extends Controller
{

    /**
     * @return Factory|View
     */
    public function index():View
    {

        return view('layouts.control_panel.hr.sector.index',$this->data);
    }


    /**
     * @param Store $request
     * @return JsonResponse|null
     */
    public function store(Store $request): ?JsonResponse
    {
        try {
            Sector::create($request->all());
            return $this->setStatusCode(200)->respond(['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['error' => ['Something is error']]);
        }
    }

    /**
     * @param Sector $sector
     * @return JsonResponse
     */
    public function edit(Sector $sector): JsonResponse
    {
        return $this->resources(new SectorList($sector));

    }

    /**
     * @param Update $request
     * @return JsonResponse|null
     */
    public function update(Update $request): ?JsonResponse
    {
        try {
            $sector=  Sector::find($request->input('id'));
            $sector->update($request->all());
            return $this->setStatusCode(200)->respond(['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['status' => false]);
        }
    }

    /**
     * @param $id
     * @return JsonResponse|null
     */
    public function destroy($id) : ?JsonResponse
    {

        try {
            Sector::destroy($id);
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
        $query = Sector::whereNotNull('name_en');

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
        return $this->resources(new SectorCollection($data));
    }

    /**
     * @param Request $request
     * @return JsonResponse|null
     */
    public function nested_select(Request $request) : ?JsonResponse
    {
        try {
            if ($request->input('id')!=null){
                $data = DepartmentMission::find($request->input('id'))->sectors()->pluck('sectors.name_en', 'sectors_departments.id');
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
    public function nested_select_multiple(Request $request) : ?JsonResponse
    {
        try {
            if ($request->id !=null){
                     if ($request->mission_id !=null){
                         $data=DepartmentMission::whereIn('department_id',$request->id) ->whereIn('mission_id',$request->mission_id)->with('sectors')->get();
                     }else{
                         $data=DepartmentMission::whereIn('department_id',$request->id)->with('sectors')->get();
                     }
                $array=[];
                foreach ($data as $key=>$value){
                    foreach ($value->sectors as $sector) {
                        $sector_ids[]= $sector->pivot->id;
                        $array[$sector->pivot->id] = $sector->name_en;
                        }
                }
                return $this->respond($array);
            }

            return $this->setStatusCode(422)->respond(['error'=>'not find']);

        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['error'=>'not find']);
        }

    }
}
