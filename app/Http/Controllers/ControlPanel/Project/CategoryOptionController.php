<?php

namespace App\Http\Controllers\ControlPanel\Project;


use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use App\Model\ControlPanel\Hr\PositionGroup;
use App\Model\ControlPanel\Project\CategoryOption;
use App\Http\Resources\ControlPanel\Project\CategoryOption\CategoryOptionCollection;
use App\Http\Resources\ControlPanel\Project\CategoryOption\CategoryOption as CategoryOptionEdit;
use App\Http\Requests\ControlPanel\Project\CategoryOption\Store;
use App\Http\Requests\ControlPanel\Project\CategoryOption\Update;
use App\Model\ControlPanel\Project\Category;
use DB;

/**
 * Class CategoryOptionController
 * @package App\Http\Controllers\ControlPanel\CategoryOption
 */
class CategoryOptionController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index ():View
    {
        $this->data['categories'] = $this->select_box (new Category(), 'id', DB::raw ('name_' . $this->lang . ' as name'), trans ('common.please_select'));
        $this->data['position_group'] = $this->select_box (new PositionGroup(), 'id', DB::raw ('name_' . $this->lang . ' as name'), trans ('common.please_select'));

       return view ('layouts.control_panel.project.category_option.index', $this->data);
    }

    /**
     * @param Store $request
     * @return JsonResponse|null
     */
    public function store (Store $request) : ?JsonResponse
    {
        try {
            CategoryOption::create ($request->all () + ['stored_by' => \Auth::user ()->full_name]);
            return $this->setStatusCode (200)->respond (['status' => true]);
        }catch(Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => ['Something is error']]);
        }
    }

    /**
     * @param CategoryOption $category_option
     * @return JsonResponse
     */
    public function edit (CategoryOption $category_option)
    {
        return $this->resources (new CategoryOptionEdit($category_option));
    }

    public function update (Update $request) : ?JsonResponse
    {
        try {
            $mission = CategoryOption::find ($request->id);
            $mission->modified_by = \Auth::user ()->full_name;
            $mission->update ($request->all ());
            return $this->setStatusCode (200)->respond (['status' => true]);
        }catch(Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => ['Something is error']]);
        }
    }

    /**
     * @param $id
     * @return JsonResponse|null
     */
    public function destroy ($id) : ?JsonResponse
    {

        try {
            CategoryOption::destroy ($id);
            return $this->setStatusCode (200)->respond (['deleted' => ['This donor deleted']]);
        }catch(Exception $e) {
            return $this->setStatusCode (422)->respond (['delete' => ['This donor is used elsewhere that can not be deleted']]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function get_all (Request $request): JsonResponse
    {
        $page = $request->input ('pagination.page');
        $search = $request->input ('query.generalSearch', null);
        $perpage = $request->input ('pagination.perpage', 10);
        $sortOrder = $request->input ('sort.sort', 'asc');
        $sortField = $request->input ('sort.field', 'name_en');
        $offset = ($page - 1) * $perpage;
        $query = CategoryOption::with('category','position_group')->whereNotNull ('id');
        if(is_null ($search)) {
            $totalCount = $query->count ();
        } else {
            $query->whereRaw ("(name_en ilike '%$search%' or   name_ar ilike '%$search%')");
            $totalCount = $query->count ();
        }
        $query->offset ($offset)
            ->limit ($perpage)
            ->orderBy ($sortField, $sortOrder);
        $data = $query->get ();
        $request->offsetSet ('pages', ceil ($totalCount / $perpage));
        $request->offsetSet ('total', $totalCount);
        return $this->resources (new CategoryOptionCollection($data));
    }
}
