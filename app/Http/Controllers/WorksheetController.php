<?php

namespace App\Http\Controllers;


use Auth;
use Carbon\Carbon;
use App\Model\Hr\User;
use App\Model\Worksheet;
use Illuminate\View\View;
use App\Model\WorkStatus;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Worksheet\Store;
use Illuminate\Contracts\View\Factory;
use App\Http\Requests\Worksheet\Update;
use App\Http\Resources\Worksheet\WorksheetList;
use App\Http\Resources\Worksheet\WorksheetEdit;
use App\Http\Resources\Worksheet\WorksheetCollection;

/**
 * Class AuthorityController
 * @package App\Http\Controllers
 */
class WorksheetController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index ()
    {

        if (Auth::user ()->department->department->id != 372086) {

            $collection = collect (get_all_children (new User(), 3613))->sortBy ('first_name_en');
            $select_box_data = $collection->mapWithKeys (function($item) {
                return [$item['id'] => $item['first_name_en'] . " " . $item['last_name_en']];
            });
//            $select_box_data->prepend (trans ('common.please_select'), '');
            $this->data['users'] = $select_box_data;
        } else {
            $this->data['users'] = $this->select_box (new User(), 'id', 'first_name_' . $this->lang . '  || \' \' || last_name_' . $this->lang . ' as name', trans ('common.please_select'), 'disabled=0');

        }
        $this->data['work_statuses'] = $this->select_box (new WorkStatus(), 'id', 'name_ar as name', trans ('common.please_select'));

        return view ('layouts.worksheet.index', $this->data);

    }

    /**
     * @param Store $request
     * @return JsonResponse|null
     */
    public function store (Store $request)
    {
        try {
            foreach ($request->user_id as $user) {
                $period = Carbon::parse ($request->start_date)->daysUntil ($request->end_date);
                foreach ($period as $key => $date) {
                    if ($request->work_status_id == 377393 || $request->work_status_id == 377394 || $request->work_status_id == 377395 ){
                        $start_date = Carbon::parse ($date->format ('Y-m-d') . $request->get (\Str::lower ($date->isoFormat ('dddd')) . '_start_time'));
                        $end_date = Carbon::parse ($date->format ('Y-m-d') . $request->get (\Str::lower ($date->isoFormat ('dddd')) . '_end_time'));
                    }else{
                        $start_date = Carbon::parse ($date->format ('Y-m-d') . '00:00:00');
                        $end_date = Carbon::parse ($date->format ('Y-m-d') . '00:00:00');
                    }

                        $add_day = $request->get (\Str::lower ($date->isoFormat ('dddd')) . '_add_day');
                        $work_status_id = $request->get (\Str::lower ($date->isoFormat ('dddd')) . '_work_status_id');
                        if ($add_day) {
                            $end_date->addDay ();
                        }else{
                            $add_day=false;
                        }
                        if (Worksheet::where ('user_id', $user)->whereDate ('start_date', $date->format ('Y-m-d'))->exists ()) {
                            Worksheet::where ('user_id', $user)->whereDate ('start_date', $date->format ('Y-m-d'))->update (['work_status_id'  => $work_status_id,'user_id'  => $user, 'start_date' => $start_date,
                                                                                                                             'end_date' => $end_date, 'add_day' => $add_day, 'stored_by' => Auth::user ()->full_name]
                            );
                        } else {
                            Worksheet::Create (['work_status_id'  => $work_status_id,'user_id'  => $user, 'start_date' =>$start_date,
                                                'end_date' => $end_date, 'add_day' => $add_day, 'stored_by' => Auth::user ()->full_name]
                            );
                        }

                }
            }
            return $this->setStatusCode (200)->respond (['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => ['Something is error']]);
        }

    }

    public function edit (Worksheet $worksheet): ?JsonResponse
    {
        try {
            return $this->resources (new WorksheetEdit($worksheet));
        } catch (\Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => ['Something is error']]);
        }

    }

    public function update (Update $request): ?JsonResponse
    {


        try {
            $worksheet = Worksheet::find ($request->id);
            if ($request->work_status_id == 377393 || $request->work_status_id == 377394 || $request->work_status_id == 377395 ){
                $start_date = Carbon::parse (Carbon::parse ($worksheet->start_date)->format ('Y-m-d') . $request->start_time);
                $end_date = Carbon::parse (Carbon::parse ($worksheet->start_date)->format ('Y-m-d') . $request->end_time);
            }else{
                $start_date = Carbon::parse (Carbon::parse ($worksheet->start_date)->format ('Y-m-d') . '00:00:00');
                $end_date = Carbon::parse (Carbon::parse ($worksheet->start_date)->format ('Y-m-d') .  '00:00:00');
            }

            $add_day = $request->add_day;
            if ($add_day) {
                $end_date->addDay ();
            }else{
                $add_day=false;
            }
            $worksheet->add_day = $add_day;
            $worksheet->start_date = $start_date;
            $worksheet->end_date = $end_date;
            $worksheet->work_status_id = $request->work_status_id;
            $worksheet->modified_by = \Auth::user ()->full_name;
            $worksheet->update ();

            return $this->setStatusCode (200)->respond (['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => ['Something is error']]);
        }

    }


    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy ($id):JsonResponse
    {
        try {
            Worksheet::destroy ($id);
            return $this->setStatusCode (200)->respond (['deleted' => ['This item deleted']]);
        } catch (\Exception $e) {
            return $this->setStatusCode (422)->respond (['delete' => ['Something is error']]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function get_all (Request $request)
    {
        $page = $request->input ('pagination.page');
        $search = $request->input ('query.generalSearch', null);
        $perpage = $request->input ('pagination.perpage', 10);
        $sortOrder = $request->input ('sort.sort', 'asc');
        $sortField = $request->input ('sort.field', 'start_date');
        $offset = ($page - 1) * $perpage;
        $query = Worksheet::leftJoin ('users', 'users.id', '=', 'employee_worksheets.user_id')
            ->selectRaw('employee_worksheets.*,users.first_name_en || \' \' || users.last_name_en as name_en,users.first_name_ar || \' \' || users.last_name_ar as name_ar');


        if (!is_null ($search)) {
            $query->whereRaw (
                "(first_name_en || last_name_en ilike '%$search%' ) or  (first_name_ar || last_name_ar ilike '%$search%')");
        }

        $totalCount = $query->count ();

        $query->offset ($offset)
            ->limit ($perpage)
            ->orderBy ($sortField, $sortOrder);
        $data = $query->get ();
        $request->offsetSet ('pages', ceil ($totalCount / $perpage));
        $request->offsetSet ('total', $totalCount);
        return $this->resources (new WorksheetCollection($data));
    }


}
