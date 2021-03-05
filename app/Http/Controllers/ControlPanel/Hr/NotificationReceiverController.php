<?php

namespace App\Http\Controllers\ControlPanel\Hr;


use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Model\NotificationReceiver;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use App\Http\Requests\ControlPanel\Hr\NotificationReceiver\Store;
use App\Http\Requests\ControlPanel\Hr\NotificationReceiver\Update;
use App\Http\Resources\ControlPanel\Hr\NotificationReceiver\NotificationReceiverCollection;
use App\Http\Resources\ControlPanel\Hr\NotificationReceiver\NotificationReceiver as info;
use Illuminate\Http\Request;

/**
 * Class NotificationReceiverController
 * @package App\Http\Controllers\ControlPanel\Hr
 */
class NotificationReceiverController extends Controller
{

    /**
     * @return Factory|View
     */
    public function index():View
    {

        return view('layouts.control_panel.hr.notification_receiver.index',$this->data);
    }

    public function create()
    {


    }


    public function store(Store $request): ?JsonResponse
    {
        try {
            NotificationReceiver::create($request->all());
            return $this->setStatusCode(200)->respond(['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['status' => false]);
        }
    }

    public function show($id)
    {
        //
    }


    /**
     * @param NotificationReceiver $notification_receiver
     * @return JsonResponse
     */
    public function edit(NotificationReceiver $notification_receiver): JsonResponse
    {
        return $this->resources(new info($notification_receiver));

    }


    /**
     * @param Update $request
     * @return JsonResponse|null
     */
    public function update(Update $request): ?JsonResponse
    {

        try {
            $data=  NotificationReceiver::find($request->input('id'));
            $data->update($request->all());
            return $this->setStatusCode(200)->respond(['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['status' => false]);
        }
    }


    /**
     * @param $id
     * @return JsonResponse|null
     */
    public function destroy($id): ?JsonResponse
    {

        try {
            NotificationReceiver::destroy($id);
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
        $query = NotificationReceiver::whereNotNull('name_en');

        if (!is_null($search)) {
            $query->whereRaw("( name_en ilike '%$search%'  or   name_ar ilike '%$search%')");
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
        return $this->resources(new NotificationReceiverCollection($data));
    }



}
