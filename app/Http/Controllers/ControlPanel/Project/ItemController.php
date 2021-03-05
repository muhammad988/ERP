<?php

namespace App\Http\Controllers\ControlPanel\Project;


use Illuminate\View\View;
use App\Model\ControlPanel\Item;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use App\Model\ControlPanel\ItemCategory;
use App\Http\Resources\ControlPanel\Project\Item\ItemCollection;
use App\Http\Resources\ControlPanel\Project\Item\Item as ItemEdit;
use App\Http\Requests\ControlPanel\Project\Item\Store;
use App\Http\Requests\ControlPanel\Project\Item\Update;

/**
 * Class ItemController
 * @package App\Http\Controllers\ControlPanel\Item
 */
class ItemController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index ():View
    {
        $this->data['item_categories'] = $this->select_box(new ItemCategory(),'id',\DB::raw('name_'.$this->lang.' as name' ),trans('common.please_select'));
        return view ('layouts.control_panel.project.item.index', $this->data);
    }

    /**
     * @param Store $request
     * @return JsonResponse|null
     */
    public function store (Store $request) : ?JsonResponse
    {
        try {
            Item::create ($request->all () + ['stored_by' => \Auth::user ()->full_name]);
            return $this->setStatusCode (200)->respond (['status' => true]);
        }catch(Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => ['Something is error']]);
        }
    }


    /**
     * @param Item $item
     * @return JsonResponse
     */
    public function edit (Item $item): JsonResponse
    {
        return $this->resources (new ItemEdit($item));
    }

    /**
     * @param Update $request
     * @return JsonResponse|null
     */
    public function update (Update $request) : ?JsonResponse
    {
        try {
            $mission = Item::find ($request->id);
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
            Item::destroy ($id);
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
        $query = Item::with('item_category')->whereNotNull ('id');
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
        return $this->resources (new ItemCollection($data));
    }
}
