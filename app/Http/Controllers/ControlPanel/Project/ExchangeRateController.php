<?php

namespace App\Http\Controllers\ControlPanel\Project;


use App\Model\Currency;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Exception;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use App\Model\ControlPanel\Hr\Mission;
use App\Model\ControlPanel\ExchangeRate;
use App\Http\Resources\ControlPanel\Project\ExchangeRate\ExchangeRateCollection;
use App\Http\Resources\ControlPanel\Project\ExchangeRate\ExchangeRate as ExchangeRateEdit;
use App\Http\Requests\ControlPanel\Project\ExchangeRate\Store;
use App\Http\Requests\ControlPanel\Project\ExchangeRate\Update;


/**
 * Class ExchangeRateController
 * @package App\Http\Controllers\ControlPanel\Project
 */
class ExchangeRateController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index ():View
    {
        $this->data['missions'] = $this->select_box (new Mission(), 'id', DB::raw ('name_' . $this->lang . ' as name'), trans ('common.please_select'));
        $this->data['currencies'] = $this->select_box (new Currency(), 'id', DB::raw ('name_' . $this->lang . ' as name'), trans ('common.please_select'));
        return view ('layouts.control_panel.project.exchange_rate.index', $this->data);
    }

    /**
     * @param Store $request
     * @return JsonResponse|null
     */
    public function store (Store $request) : ?JsonResponse
    {
        try {
            ExchangeRate::create ($request->all () + ['stored_by' => \Auth::user ()->full_name]);
            return $this->setStatusCode (200)->respond (['status' => true]);
        }catch(Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => ['Something is error']]);
        }
    }

    /**
     * @param ExchangeRate $exchange_rate
     * @return JsonResponse
     */
    public function edit (ExchangeRate $exchange_rate)
    {
        return $this->resources (new ExchangeRateEdit($exchange_rate));
    }

    public function update (Update $request) : ?JsonResponse
    {
        try {
            $mission = ExchangeRate::find ($request->id);
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
            ExchangeRate::destroy ($id);
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
        $sortOrder = $request->input ('sort.sort', 'DESC');
        $sortField = $request->input ('sort.field', 'due_date');
        $offset = ($page - 1) * $perpage;
        $query = ExchangeRate::with ('currency','mission');
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
        return $this->resources (new ExchangeRateCollection($data));
    }
}
