<?php

namespace App\Http\Controllers\ControlPanel\Hr;


use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Model\NotificationType;
use App\Model\NotificationCycle;
use Illuminate\Http\JsonResponse;
use App\Model\NotificationReceiver;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use App\Http\Requests\ControlPanel\Hr\Nationality\Store;
use App\Http\Requests\ControlPanel\Hr\Nationality\Update;
use App\Http\Resources\ControlPanel\Hr\NotificationCycle\NotificationCycle as info;
use App\Http\Resources\ControlPanel\Hr\NotificationCycle\NotificationCycleCollection;

/**
 * Class NotificationCycleController
 * @package App\Http\Controllers\ControlPanel\Hr
 */
class NotificationCycleController extends Controller
{

    /**
     * @return Factory|View
     */
    public function index (): View
    {
        $this->data['notification_receiver'] = $this->select_box (new NotificationReceiver(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), trans ('common.please_select'));
        $this->data['notification_type'] = $this->select_box (new NotificationType(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), trans ('common.please_select'));
        return view ('layouts.control_panel.hr.notification_cycle.index', $this->data);
    }

    /**
     * @param Store $request
     * @return JsonResponse|null
     */
    public function store (Store $request): ?JsonResponse
    {
        try {
            NotificationCycle::create ($request->all ());
            return $this->setStatusCode (200)->respond (['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode (422)->respond (['status' => false]);
        }
    }


    /**
     * @param NotificationCycle $notification_cycle
     * @return JsonResponse
     */
    public function edit (NotificationCycle $notification_cycle): JsonResponse
    {
        return $this->resources (new info($notification_cycle));

    }


    /**
     * @param Update $request
     * @return JsonResponse|null
     */
    public function update (Update $request): ?JsonResponse
    {

        try {
            $data = NotificationCycle::find ($request->input ('id'));
            if (!$request->has ('authorized')) {
                $request->merge (['authorized' => false]);
            }else{
                $request->merge (['authorized' => true]);
            }
            $data->update ($request->all ());
            return $this->setStatusCode (200)->respond (['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode (422)->respond (['status' => false]);
        }
    }


    /**
     * @param $id
     * @return JsonResponse|null
     */
    public function destroy ($id): ?JsonResponse
    {

        try {
            NotificationCycle::destroy ($id);
            return $this->setStatusCode (200)->respond (['deleted' => ['This item deleted']]);
        } catch (\Exception $e) {
            return $this->setStatusCode (422)->respond (['delete' => ['This item is used elsewhere that can not be deleted']]);
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
        $query = NotificationCycle::whereNotNull ('name_en');

        if (!is_null ($search)) {
            $query->whereRaw ("( name_en ilike '%$search%')");
            $totalCount = $query->count ();
        } else {
            $totalCount = $query->count ();
        }
        $query->offset ($offset)
            ->limit ($perpage)
            ->orderBy ($sortField, $sortOrder)
            ->orderBy ('group_number', $sortOrder);
        $data = $query->get ();
        $request->offsetSet ('pages', ceil ($totalCount / $perpage));
        $request->offsetSet ('total', $totalCount);
        return $this->resources (new NotificationCycleCollection($data));
    }



}
