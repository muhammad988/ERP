<?php

namespace App\Http\Controllers\ControlPanel\Project;


use App\Model\Currency;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use App\Http\Resources\ControlPanel\Project\Currency\CurrencyCollection;
use App\Http\Resources\ControlPanel\Project\Currency\Currency as CurrencyEdit;
use App\Http\Requests\ControlPanel\Project\Currency\Store;
use App\Http\Requests\ControlPanel\Project\Currency\Update;


/**
 * Class CurrencyController
 * @package App\Http\Controllers\ControlPanel\Project
 */
class CurrencyController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index ():View
    {
        return view ('layouts.control_panel.project.currency.index', $this->data);
    }

    /**
     * @param Store $request
     * @return JsonResponse|null
     */
    public function store (Store $request) : ?JsonResponse
    {
        try {
            Currency::create ($request->all () + ['stored_by' => \Auth::user ()->full_name]);
            return $this->setStatusCode (200)->respond (['status' => true]);
        }catch(Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => ['Something is error']]);
        }
    }

    /**
     * @param Currency $currency
     * @return JsonResponse
     */
    public function edit (Currency $currency)
    {
        return $this->resources (new CurrencyEdit($currency));
    }

    public function update (Update $request) : ?JsonResponse
    {
        try {
            $mission = Currency::find ($request->id);
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
            Currency::destroy ($id);
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
        $query = Currency::whereNotNull ('id');
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
        return $this->resources (new CurrencyCollection($data));
    }
}
