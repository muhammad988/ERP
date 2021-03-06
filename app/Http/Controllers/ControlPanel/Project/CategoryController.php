<?php

namespace App\Http\Controllers\ControlPanel\Project;


use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Exception;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Model\Project\BudgetCategory;
use Illuminate\Contracts\View\Factory;
use App\Model\ControlPanel\Project\Category;
use App\Http\Resources\ControlPanel\Project\Category\CategoryCollection;
use App\Http\Resources\ControlPanel\Project\Category\Category as CategoryEdit;
use App\Http\Requests\ControlPanel\Project\Category\Store;
use App\Http\Requests\ControlPanel\Project\Category\Update;


/**
 * Class CategoryController
 * @package App\Http\Controllers\ControlPanel\Project
 */
class CategoryController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index ():View
    {
        $this->data['budget_category'] = $this->select_box (new BudgetCategory(), 'id', DB::raw ('name_' . $this->lang . ' as name'), trans ('common.please_select'));
        return view ('layouts.control_panel.project.category.index', $this->data);
    }
    /**
     * @param Store $request
     * @return JsonResponse|null
     */
    public function store (Store $request) : ?JsonResponse
    {
        try {
            Category::create ($request->all () + ['stored_by' => \Auth::user ()->full_name]);
            return $this->setStatusCode (200)->respond (['status' => true]);
        }catch(Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => ['Something is error']]);
        }
    }

    /**
     * @param Category $category
     * @return JsonResponse
     */
    public function edit (Category $category): JsonResponse
    {
        return $this->resources (new CategoryEdit($category));
    }

    /**
     * @param Update $request
     * @return JsonResponse|null
     */
    public function update (Update $request): ?JsonResponse
    {
        try {
            $category = Category::find ($request->id);
            $category->modified_by = \Auth::user ()->full_name;
            $category->update ($request->all ());
            return $this->setStatusCode (200)->respond (['status' => true]);
        }
        catch(Exception $e) {
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
            Category::where ('id',$id)->delete ();
            return $this->setStatusCode (200)->respond (['deleted' => ['This category deleted']]);
        }catch(Exception $e) {
            return $this->setStatusCode (422)->respond (['delete' => ['This category is used elsewhere that can not be deleted']]);
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
        $query = Category::whereNotNull ('id');
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
        return $this->resources (new CategoryCollection($data));
    }
}
