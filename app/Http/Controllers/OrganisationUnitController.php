<?php

namespace App\Http\Controllers;


use Illuminate\Http\JsonResponse;
use App\Model\ControlPanel\Hr\Mission;
use App\Http\Resources\OrganisationUnit\OrganisationUnitSelectCollection;
use App\Model\OrganisationUnit;
use Illuminate\Http\Request;

/**
 * Class OrganisationUnitController
 * @package App\Http\Controllers
 */
class OrganisationUnitController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function tree_view (Request $request): JsonResponse
    {
        if ($request->parent=='#'){
            $data= OrganisationUnit::where('parent_id','0')->get();
        }else{
            $data= OrganisationUnit::where('parent_id',$request->parent)->get();
        }

        return $this->resources(new  OrganisationUnitSelectCollection($data));

    }

    /**
     * @param Request $request
     * @return JsonResponse|null
     */
    public function nested_organisation_unit_mission_multiple (Request $request): ?JsonResponse
    {
        try {
            if ($request->input('id')!=null){
                $data=Mission::whereIn('organisation_unit_id',$request->input('id'))->get();
                $array=[];
                foreach ($data as $key=>$value){
                    $array[$value->id] = $value->name_en;
                }
                return $this->respond($array);
            }
            return $this->setStatusCode(422)->respond(['error'=>'not find']);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['error'=>'not find']);
        }

    }
}
