<?php


namespace App\Http\Controllers\Leave;


use Auth;
use Exception;
use Carbon\Carbon;
use App\Model\Hr\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Model\Leave\AccumulatedDay;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use App\Http\Requests\Leave\AccumulatedDay\Store;
use App\Http\Requests\Leave\AccumulatedDay\Update;
use App\Http\Resources\Leave\AccumulatedDay\AccumulatedDayEdit;
use App\Http\Resources\Leave\AccumulatedDay\AccumulatedDayCollection;

/**
 * Class AccumulatedDayController
 * @package App\Http\Controllers\Leave
 */
class AccumulatedDayController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index ():View
    {
        $this->data['users'] = $this->select_box (new User(), 'id', \DB::raw ('first_name_' . $this->lang . '  || \' \' || last_name_' . $this->lang . ' as name'), trans ('common.please_select'));

        return view ('layouts.leave.accumulated_day.index', $this->data);
    }

    /**
     * @param Store $request
     * @return JsonResponse|null
     */
    public function store (Store $request) : ?JsonResponse
    {
        try {
            AccumulatedDay::create ($request->all () + ['stored_by' => \Auth::user ()->full_name]);
            return $this->setStatusCode (200)->respond (['status' => true]);
        }catch(Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => ['Something is error']]);
        }
    }

    /**
     * @param AccumulatedDay $Accumulated_day
     * @return JsonResponse
     */
    public function edit (AccumulatedDay $Accumulated_day): JsonResponse
    {
        return $this->resources (new AccumulatedDayEdit($Accumulated_day));
    }

    public function update (Update $request) : ?JsonResponse
    {
        try {
            $mission = AccumulatedDay::find ($request->id);
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
            AccumulatedDay::destroy ($id);
            return $this->setStatusCode (200)->respond (['deleted' => ['This accumulated day deleted']]);
        }catch(Exception $e) {
            return $this->setStatusCode (422)->respond (['delete' => ['Something is error']]);
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
        $sortField = $request->input ('sort.field', 'user_full_name');
        $offset = ($page - 1) * $perpage;
        $query = AccumulatedDay::leftJoin ('users', 'accumulated_days.user_id', '=', 'users.id');
        if (!is_null ($search)) {
            $query->whereRaw ("(first_name_en || last_name_en ilike '%$search%' )");
        }
        $totalCount = $query->count ();
        $query->offset ($offset)
            ->limit ($perpage)
            ->orderBy ($sortField, $sortOrder);
        $data = $query->selectRaw ('accumulated_days.*,users.first_name_en  || \' \' ||  users.last_name_en as user_full_name')->get ();
        $request->offsetSet ('pages', ceil ($totalCount / $perpage));
        $request->offsetSet ('total', $totalCount);
        return $this->resources (new AccumulatedDayCollection($data));
    }

}
