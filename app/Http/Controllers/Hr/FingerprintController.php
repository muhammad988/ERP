<?php


namespace App\Http\Controllers\Hr;


use DB;
use Auth;
use Excel;
use Exception;
use Carbon\Carbon;
use App\Model\Hr\User;
use App\Model\Worksheet;
use Illuminate\View\View;
use App\Model\WorkStatus;
use Illuminate\Http\Request;
use App\Model\Hr\Fingerprint;
use App\Model\Project\Project;
use Illuminate\Http\JsonResponse;
use App\Model\ControlPanel\Center;
use App\Http\Controllers\Controller;
use App\Imports\Hr\FingerprintImport;
use App\Model\ControlPanel\Hr\Position;
use App\Model\ControlPanel\Hr\Department;
use App\Model\ControlPanel\Hr\ContractType;
use App\Http\Requests\Hr\Fingerprint\Store;
use App\Http\Requests\Hr\Fingerprint\Import;
use App\Exports\Fingerprint\FingerprintReport;
use App\Model\ControlPanel\Hr\DepartmentMission;
use App\Http\Resources\Hr\Fingerprint\FingerprintEdit;
use App\Http\Resources\Hr\Fingerprint\ReportCollection;
use App\Http\Resources\Hr\Fingerprint\FingerprintCollection;


/**
 * Class LeaveController
 * @package App\Http\Controllers\Leave
 */
class FingerprintController extends Controller
{
    /**
     * @return View
     */
    public function index (): View
    {

        $this->data['departments'] = $this->select_box (new Department(), 'id', DB::raw ('name_' . $this->lang . ' as name'), '');
        $this->data['contract_types'] = $this->select_box (new ContractType(), 'id', DB::raw ('name_' . $this->lang . ' as name'), '', 'id in (select  distinct "contract_type_id" from users)');
        $this->data['users'] = $this->select_box (new User(), 'id', DB::raw ('first_name_' . $this->lang . '  || \' \' || last_name_' . $this->lang . ' as name'), trans ('common.please_select'));
        $this->data['centers'] = $this->select_box (new Center(), 'id', DB::raw ('name_' . $this->lang . ' as name'), '', 'id in (select  distinct "center_id" from users)');
        $this->data['projects'] = $this->select_box (new Project(), 'id', DB::raw ('name_' . $this->lang . ' as name'), '', 'id in (select  distinct "project_id" from users)');
        $this->data['positions'] = $this->select_box (new Position(), 'id', DB::raw ('name_' . $this->lang . ' as name'), '', 'id in (select  distinct "position_id" from users)');
        $this->data['nested_url_position'] = route ('nested_position_department');
        return view ('layouts.hr.fingerprint.index', $this->data);

    }

    /**
     * @param $user_id
     * @return View
     */
    public function index_user ($user_id): View
    {
        $this->data['centers'] = $this->select_box (new Center(), 'id', DB::raw ('name_' . $this->lang . ' as name'), '', 'id in (select  distinct "center_id" from users)');

        $this->data['id'] = $user_id;
        return view ('layouts.hr.fingerprint.fingerprint_user.index', $this->data);

    }

    /**
     * @param Store $request
     * @return JsonResponse
     */
    public function store (Store $request): JsonResponse
    {
        try {
            $time = Carbon::parse ($request->day . $request->time)->format ('Y-m-d H:i:s');
            $request->offsetSet ('time', $time);
            $worksheet = Worksheet::with ('user')->find ($request->id);
            Fingerprint::create ($request->all () + ['index' => time (), 'user_id' => $worksheet->user->id, 'financial_code' => $worksheet->user->financial_code, 'stored_by' => Auth::user ()->full_name]);
            return $this->setStatusCode (200)->respond (['status' => true]);
        } catch (Exception $e) {
            return $this->setStatusCode (422)->respond (['status' => false]);

        }
    }

    /**
     * @param Fingerprint $fingerprint
     * @return JsonResponse
     */
    public function edit (Fingerprint $fingerprint): JsonResponse
    {
        return $this->resources (new FingerprintEdit($fingerprint));

    }

    /**
     * @param Store $fingerprint
     * @return JsonResponse
     */
    public function update (Store $fingerprint): JsonResponse
    {
        try {
            $time = Carbon::parse ($fingerprint->day . $fingerprint->time)->format ('Y-m-d H:i:s');
            $fingerprint->offsetSet ('time', $time);
            $data = Fingerprint::find ($fingerprint->id);
            $data->modified_by = Auth::user ()->full_name;
            $data->update ($fingerprint->all ());
            return $this->setStatusCode (200)->respond (['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode (422)->respond (['status' => false]);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {

        try {
            Fingerprint::destroy($id);
            return $this->setStatusCode(200)->respond(['deleted'=>['This item deleted']]);
        } catch (\Exception $e) {
            return $this->setStatusCode(422)->respond(['delete'=>['This item is used elsewhere that can not be deleted']]);
        }
    }
    /**
     * @return View
     */
    public function index_report ():View
    {
        $this->data['departments'] = $this->select_box (new Department(), 'id', DB::raw ('name_' . $this->lang . ' as name'), '');
        $this->data['users'] = $this->select_box (new User(), 'id', DB::raw ('first_name_' . $this->lang . '  || \' \' || last_name_' . $this->lang . ' as name'), trans ('common.please_select'));
        $this->data['centers'] = $this->select_box (new Center(), 'id', DB::raw ('name_' . $this->lang . ' as name'), '', 'id in (select  distinct "center_id" from users)');
        $this->data['projects'] = $this->select_box (new Project(), 'id', DB::raw ('name_' . $this->lang . ' as name'), '', 'id in (select  distinct "project_id" from users)');
        $this->data['positions'] = $this->select_box (new Position(), 'id', DB::raw ('name_' . $this->lang . ' as name'), '', 'id in (select  distinct "position_id" from users)');
        $this->data['nested_url_superior'] = route ('nested_superior_department');
        $this->data['nested_url_position'] = route ('nested_position_department');
        $this->data['nested_url_department_multiple'] = route ('nested_department_mission_multiple');
        if (Auth::user ()->department->department->id != 372086) {
            $collection = collect (get_all_children (new User(), 3613))->sortBy ('first_name_en');
            $select_box_data = $collection->mapWithKeys (function($item) {
                return [$item['id'] => $item['first_name_en'] . " " . $item['last_name_en']];
            });
            $this->data['users'] = $select_box_data;
        } else {
            $this->data['users'] = $this->select_box (new User(), 'id', 'first_name_' . $this->lang . '  || \' \' || last_name_' . $this->lang . ' as name', trans ('common.please_select'), 'disabled=0');

        }
        $this->data['work_statuses'] = $this->select_box (new WorkStatus(), 'id', 'name_ar as name', '');

        return view ('layouts.hr.fingerprint.index_report', $this->data);

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function get_report (Request $request): JsonResponse
    {
        $page = $request->input ('pagination.page');
        $search = $request->input ('search');
        $perpage = $request->input ('pagination.perpage', 10);
        $sortOrder = $request->input ('sort.sort', 'asc');
        $sortField = $request->input ('sort.field', 'start_date');
        $offset = ($page - 1) * $perpage;

        $query = Worksheet::leftJoin ('users', 'employee_worksheets.user_id', '=', 'users.id')
            ->leftJoin ('work_statuses', 'employee_worksheets.work_status_id', '=', 'work_statuses.id')
            ->leftJoin ('positions', 'users.position_id', '=', 'positions.id')
            ->leftJoin ('centers', 'users.center_id', '=', 'centers.id');

        if (isset($request->start_date)) {
            $query->whereDate ('employee_worksheets.start_date', '>=', $request->start_date);
        }

        if (isset($request->end_date)) {
            $query->whereDate ('employee_worksheets.end_date', '<=', $request->end_date);
        }

        if (!is_null ($search)) {
            $query->whereRaw ("(first_name_en || last_name_en ilike '%$search%' ) or  (first_name_ar || last_name_ar ilike '%$search%') or  positions.name_ar ilike '%$search%' ");
        }

        if (isset($request->center)) {
            $query->whereIn ('users.center_id', $request->center);
        }

        if (isset($request->work_status)) {
            $query->whereIn ('employee_worksheets.work_status_id', $request->work_status);
        }

        if (isset($request->department)) {
            $data = DepartmentMission::whereIn ('department_id', $request->department)->select ('id')->get ();
            $query->whereIn ('users.department_id', $data);
        }

        if (isset($request->position)) {
            $query->whereIn ('users.position_id', $request->position);
        }

        if (isset($request->project)) {
            $query->whereIn ('users.project_id', $request->project);
        }

        $totalCount = $query->count ();
        $query->offset ($offset)
            ->limit ($perpage)
            ->orderBy ($sortField, $sortOrder);
        $data = $query->selectRaw ('employee_worksheets.*,employee_worksheets.start_date as assumed_entry,employee_worksheets.end_date as assumed_exit,work_statuses.name_ar as assumed_work_status,users.id as user_id,users.financial_code,
        centers.name_ar as center_name_en, positions.name_en as position_name_ar,users.first_name_en || \' \' || users.last_name_en as user_full_name_en,
        users.first_name_ar || \' \' || users.last_name_ar as user_full_name_ar,users.id as user_id')
            ->get ();
        $request->offsetSet ('pages', ceil ($totalCount / $perpage));
        $request->offsetSet ('total', $totalCount);
        return $this->resources (new ReportCollection($data));
    }

    /**
     * @param Import $request
     * @return JsonResponse
     */
    public function import (Import $request): JsonResponse
    {
        try {
            ini_set ('memory_limit', '2048M');
            set_time_limit (300);
            $fingerprint = new FingerprintImport();
            Excel::import ($fingerprint, request ()->file ('file'));
            return $this->setStatusCode (200)->respond (['status'              => true,
                                                         'error_row'           => $fingerprint->get_error_row (),
                                                         'error_row_count'     => $fingerprint->get_error_row_count ()
                                                         , 'success_row_count' => $fingerprint->get_success_row_count (),
                                                         'row_count'           => $fingerprint->get_row_count ()]);
        } catch (\Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => ['Something is error']]);
        }
    }

    public function export_report (Request $request)
    {
        ini_set ('memory_limit', '2048M');


        $query = Worksheet::leftJoin ('users', 'employee_worksheets.user_id', '=', 'users.id')
            ->leftJoin ('work_statuses', 'employee_worksheets.work_status_id', '=', 'work_statuses.id')
            ->leftJoin ('positions', 'users.position_id', '=', 'positions.id')
            ->leftJoin ('centers', 'users.center_id', '=', 'centers.id');

        if (isset($request->start_date)) {
            $query->whereDate ('employee_worksheets.start_date', '>=', $request->start_date);
        }

        if (isset($request->end_date)) {
            $query->whereDate ('employee_worksheets.end_date', '<=', $request->end_date);
        }

        if (!is_null ($request->search)) {
            $query->whereRaw ("(first_name_en || last_name_en ilike '%$request->search%' ) or  (first_name_ar || last_name_ar ilike '%$request->search%') or  positions.name_ar ilike '%$request->search%' ");
        }

        if (isset($request->center)) {
            $query->whereIn ('users.center_id', $request->center);
        }

        if (isset($request->work_status)) {
            $query->whereIn ('employee_worksheets.work_status_id', $request->work_status);
        }

        if (isset($request->department)) {
            $data = DepartmentMission::whereIn ('department_id', $request->department)->select ('id')->get ();
            $query->whereIn ('users.department_id', $data);
        }

        if (isset($request->position)) {
            $query->whereIn ('users.position_id', $request->position);
        }

        if (isset($request->project)) {
            $query->whereIn ('users.project_id', $request->project);
        }

        $query->orderBy ('start_date', 'asc');
        $data = $query->selectRaw ('employee_worksheets.*,employee_worksheets.start_date as assumed_entry,employee_worksheets.end_date as assumed_exit,work_statuses.name_ar as assumed_work_status,users.id as user_id,users.financial_code,
        centers.name_ar as center_name_en, positions.name_en as position_name_ar,users.first_name_en || \' \' || users.last_name_en as user_full_name_en,
        users.first_name_ar || \' \' || users.last_name_ar as user_full_name_ar,users.id as user_id')
            ->get ();
        return Excel::download (new FingerprintReport($data), 'fingerprint-report.xlsx');

//        try {
//            ini_set ('memory_limit', '2048M');
//            set_time_limit (300);
//            $fingerprint = new FingerprintImport();
//            Excel::import ($fingerprint, request ()->file ('file'));
//            return $this->setStatusCode (200)->respond (['status'              => true,
//                                                         'error_row'           => $fingerprint->get_error_row (),
//                                                         'error_row_count'     => $fingerprint->get_error_row_count ()
//                                                         , 'success_row_count' => $fingerprint->get_success_row_count (),
//                                                         'row_count'           => $fingerprint->get_row_count ()]);
//        } catch (\Exception $e) {
//            return $this->setStatusCode (422)->respond (['error' => ['Something is error']]);
//        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */

    public function get_all (Request $request): JsonResponse
    {
        $page = $request->input ('pagination.page');
        $search = $request->input ('search', null);
        $perpage = $request->input ('pagination.perpage', 10);
        $sortOrder = $request->input ('sort.sort', 'asc');
        $sortField = $request->input ('sort.field', 'time');
        $offset = ($page - 1) * $perpage;
          $query = Fingerprint::leftJoin ('users', 'fingerprints.user_id', '=', 'users.id')
            ->leftJoin ('positions', 'users.position_id', '=', 'positions.id');

        if (!is_null ($search)) {
            $query->whereRaw ("(first_name_en || last_name_en ilike '%$search%' ) or  (first_name_ar || last_name_ar ilike '%$search%') ");
        }

        if (isset($request->department_ids)) {
            $data = DepartmentMission::whereIn ('department_id', $request->department_ids)->select ('id')->get ();
            $query->whereIn ('users.department_id', $data);
        }
        if (isset($request->position_ids)) {
            $query->whereIn ('users.position_id', $request->position_ids);
        }
        if (isset($request->center_ids)) {
            $query->whereIn ('users.center_id', $request->center_ids);
        }
        if (isset($request->project_ids)) {
            $project_ids = $request->project_ids;
            $query->whereIn ('users.project_id', $project_ids);
        }

        if (isset($request->start_date)) {
            $query->whereDate ('fingerprints.time', '>=', $request->start_date);
        }
        if (isset($request->end_date)) {
            $query->whereDate ('fingerprints.time', '<=', $request->end_date);
        }
        $totalCount = $query->count ();
        $query->offset ($offset)
            ->limit ($perpage)
            ->orderBy ($sortField, $sortOrder);
        $data = $query->selectRaw ('fingerprints.*,users.first_name_en || \' \' || users.last_name_en as user_full_name_en,users.first_name_ar || \' \' || users.last_name_ar as user_full_name_ar')->get ();
        $request->offsetSet ('pages', ceil ($totalCount / $perpage));
        $request->offsetSet ('total', $totalCount);
        return $this->resources (new FingerprintCollection($data));
    }

    /**
     * @param Worksheet $worksheet
     * @param Request $request
     * @return JsonResponse
     */

    public function get_fingerprint_user (Worksheet $worksheet, Request $request)
    {
        $page = $request->input ('pagination.page');
        $search = $request->input ('search');
        $perpage = $request->input ('pagination.perpage', 10);
        $sortOrder = $request->input ('sort.sort', 'asc');
        $sortField = $request->input ('sort.field', 'time');
        $offset = ($page - 1) * $perpage;
        $star_date = Carbon::parse ($worksheet->start_date)->startOfDay ();
        $end_date = Carbon::parse ($worksheet->end_date)->endOfDay ();
        $query = Fingerprint::whereBetween ('time', [$star_date, $end_date])->leftJoin ('users', 'fingerprints.user_id', '=', 'users.id')
            ->leftJoin ('positions', 'users.position_id', '=', 'positions.id');

        if (!is_null ($search)) {
            $query->whereRaw ("(first_name_en || last_name_en ilike '%$search%' ) or  (first_name_ar || last_name_ar ilike '%$search%') ");
        }

        if (isset($request->department_ids)) {
            $data = DepartmentMission::whereIn ('department_id', $request->department_ids)->select ('id')->get ();
            $query->whereIn ('users.department_id', $data);
        }
        if (isset($request->position_ids)) {
            $query->whereIn ('users.position_id', $request->position_ids);
        }
        if (isset($request->center_ids)) {
            $query->whereIn ('users.center_id', $request->center_ids);
        }
        if (isset($request->project_ids)) {
            $project_ids = $request->project_ids;
            $query->whereIn ('users.project_id', $project_ids);
        }

        if (isset($request->start_date)) {
            $query->whereDate ('fingerprints.time', '>=', $request->start_date);
        }
        if (isset($request->end_date)) {
            $query->whereDate ('fingerprints.time', '<=', $request->end_date);
        }
        $totalCount = $query->count ();
        $query->offset ($offset)
            ->limit ($perpage)
            ->orderBy ($sortField, $sortOrder);
        $data = $query->selectRaw ('fingerprints.*,users.first_name_en || \' \' || users.last_name_en as user_full_name_en,users.first_name_ar || \' \' || users.last_name_ar as user_full_name_ar')->get ();
        $request->offsetSet ('pages', ceil ($totalCount / $perpage));
        $request->offsetSet ('total', $totalCount);
        return $this->resources (new FingerprintCollection($data));
    }
}
