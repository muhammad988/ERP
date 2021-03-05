<?php

namespace App\Http\Controllers\ControlPanel\Hr;


use Illuminate\View\View;
use App\Model\NotificationType;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use App\Http\Requests\ControlPanel\Hr\NotificationType\Store;
use App\Http\Requests\ControlPanel\Hr\NotificationType\Update;
use Illuminate\Http\Request;
use App\Http\Resources\ControlPanel\Hr\NotificationType\NotificationTypeCollection;
use App\Http\Resources\ControlPanel\Hr\NotificationType\NotificationType as info;


/**
 * Class NotificationTypeController
 * @package App\Http\Controllers\ControlPanel\Hr
 */
class NotificationTypeController extends Controller
{

    /**
     * @return Factory|View
     */
    public function index()
    {

        return view('layouts.control_panel.hr.notification_type.index',$this->data);
    }


    /**
     * @param Store $request
     * @return JsonResponse|null
     */
    public function store(Store $request): ?JsonResponse
    {
        try {
            NotificationType::create($request->all());
            return $this->setStatusCode(200)->respond(['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['status' => false]);
        }
    }




    /**
     * @param NotificationType $notification_type
     * @return JsonResponse
     */
    public function edit(NotificationType $notification_type): JsonResponse
    {
        return $this->resources(new info($notification_type));

    }


    /**
     * @param Update $request
     * @return JsonResponse|null
     */
    public function update(Update $request): ?JsonResponse
    {

        try {
            $data=  NotificationType::find($request->input('id'));
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
            NotificationType::destroy($id);
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
        $query = NotificationType::whereNotNull('name_en');

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
        return $this->resources(new NotificationTypeCollection($data));
    }



}
