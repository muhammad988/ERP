<?php


namespace App\Http\Controllers\Leave;


use Auth;
use Exception;
use Carbon\Carbon;
use App\Model\Hr\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Model\Leave\ExtraDay;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use App\Model\ControlPanel\Hr\Position;
use App\Http\Requests\Leave\ExtraDay\Store;
use App\Http\Requests\Leave\ExtraDay\Update;
use App\Http\Resources\Leave\ExtraDay\ExtraDayEdit;
use App\Http\Resources\Leave\ExtraDay\ExtraDayCollection;

/**
 * Class ExtraDayController
 * @package App\Http\Controllers\Leave
 */
class ExtraDayController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index (): View
    {
        $this->data['users'] = $this->select_box (new User(), 'id', \DB::raw ('first_name_' . $this->lang . '  || \' \' || last_name_' . $this->lang . ' as name'), trans ('common.please_select'));
        $this->data['filter_user'] = $this->select_box (new User(), 'id', \DB::raw ('first_name_' . $this->lang . '  || \' \' || last_name_' . $this->lang . ' as name'), trans ('common.please_select'),'id in (select  distinct "user_id" from extra_days)');
        $this->data['filter_position'] = $this->select_box (new Position(), 'id', 'name_'. $this->lang .' as name', trans ('common.please_select'),'id in (select  distinct "position_id" from users where id in (select  distinct "user_id" from extra_days ) )');

        return view ('layouts.leave.extra_day.index', $this->data);
    }

    /**
     * @param Store $request
     * @return JsonResponse|null
     */
    public function store (Store $request): ?JsonResponse
    {
        try {
            $start_time = Carbon::parse ($request->start_time);
            $end_time = Carbon::parse ($request->end_time);
            $number_of_hours_for_user = User::find ($request->user_id)->number_of_hours * 60;
            $request->offsetSet ('number_of_minutes', $start_time->diffInMinutes ($end_time));
            $request->offsetSet ('number_of_days', $start_time->diffInMinutes ($end_time) / $number_of_hours_for_user);
            $request->offsetSet ('year', Carbon::parse ($request->date)->year);
            ExtraDay::create ($request->all () + ['stored_by' => Auth::user ()->full_name]);
            return $this->setStatusCode (200)->respond (['status' => true]);
        } catch (Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => ['Something is error']]);
        }
    }

    /**
     * @param ExtraDay $extra_day
     * @return JsonResponse
     */
    public function edit (ExtraDay $extra_day): ?JsonResponse
    {
            return $this->resources (new ExtraDayEdit($extra_day));

    }

    public function update (Update $request): ?JsonResponse
    {
        try {
            $extra_day = ExtraDay::find (1);
            $extra_day->modified_by = Auth::user ()->full_name;
            $start_time = Carbon::parse ($request->start_time);
            $end_time = Carbon::parse ($request->end_time);
            $number_of_hours_for_user = User::find ($request->user_id)->number_of_hours * 60;
            $request->offsetSet ('number_of_minutes', $start_time->diffInMinutes ($end_time));
            $request->offsetSet ('number_of_days', $start_time->diffInMinutes ($end_time) / $number_of_hours_for_user);
            $request->offsetSet ('year', Carbon::parse ($request->date)->year);
            $extra_day->update ($request->all ());
            return $this->setStatusCode (200)->respond (['status' => true]);
        } catch (Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => ['Something is error']]);
        }
    }

    /**
     * @param $id
     * @return JsonResponse|null
     */
    public function destroy ($id): ?JsonResponse
    {

        try {
            ExtraDay::destroy ($id);
            return $this->setStatusCode (200)->respond (['deleted' => ['This extra day deleted']]);
        } catch (Exception $e) {
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
        $query = ExtraDay::leftJoin ('users', 'extra_days.user_id', '=', 'users.id');
        if (!is_null ($search)) {
            $query->whereRaw ("(first_name_en || last_name_en ilike '%$search%' )");
        }
        if ($request->has('query.user_id')) {
            $query->where ("users.id",$request->input ('query.user_id'));
        }
        if ($request->has('query.position_id')) {
            $query->where ("users.position_id",$request->input ('query.position_id'));
        }
        $totalCount = $query->count ();

        $query->offset ($offset)
            ->limit ($perpage)
            ->orderBy ($sortField, $sortOrder);
        $data = $query->selectRaw ('extra_days.*,users.first_name_en  || \' \' ||  users.last_name_en as user_full_name')->get ();
        $request->offsetSet ('pages', ceil ($totalCount / $perpage));
        $request->offsetSet ('total', $totalCount);
        return $this->resources (new ExtraDayCollection($data));
    }

}
