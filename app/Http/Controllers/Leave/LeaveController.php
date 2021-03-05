<?php


namespace App\Http\Controllers\Leave;


use Auth;
use Carbon\Carbon;
use App\Model\Status;
use App\Model\Hr\User;
use Illuminate\View\View;
use App\Model\Leave\Leave;
use App\Model\Leave\LeaveType;
use App\Model\Project\Project;
use App\Model\OrganisationUnit;
use App\Exports\Leave\LeaveList;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Model\ControlPanel\Hr\Weekend;
use App\Model\ControlPanel\Hr\Holiday;
use Illuminate\Contracts\View\Factory;
use App\Model\ControlPanel\Hr\Position;
use App\Model\ControlPanel\Hr\Department;
use App\Model\ControlPanel\Hr\ContractType;
use App\Http\Resources\Leave\LeaveCollection;
use Illuminate\Contracts\Foundation\Application;
use App\Model\ControlPanel\Hr\DepartmentMission;
use App\Http\Requests\Leave\Daily\Store as DailyStore;
use App\Http\Requests\Leave\Hourly\Store as HourlyStore;
use Illuminate\Http\Request;
use Str;
use Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


/**
 * Class LeaveController
 * @package App\Http\Controllers\Leave
 */
class LeaveController extends Controller
{
    /**
     * @return View
     */
    public function index ():View
    {
//        $this->data['nested_url_department_multiple'] = route ('nested_department_mission_multiple');
//        $this->data['nested_url_sector_multiple'] = route ('nested_sector_department_multiple');
//        $this->data['missions'] = $this->select_box (new Mission(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), '');
        $this->data['departments'] = $this->select_box (new Department(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), '');
//        $this->data['position_categories'] = $this->select_box (new PositionCategory(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), '', 'id in (select  distinct "position_category_id" from users)');
        $this->data['contract_types'] = $this->select_box (new ContractType(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), '', 'id in (select  distinct "contract_type_id" from users)');
        $this->data['users'] = $this->select_box (new User(), 'id', \DB::raw ('first_name_' . $this->lang . '  || \' \' || last_name_' . $this->lang . ' as name'), trans ('common.please_select'));
        $this->data['organisation_units'] = $this->select_box (new OrganisationUnit(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), '', 'id in (select  distinct "organisation_unit_id" from users)');
        $this->data['projects'] = $this->select_box (new Project(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), '', 'id in (select  distinct "project_id" from users)');
        $this->data['statuses'] = $this->select_box (new Status(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), '', 'id in (select  distinct "status_id" from leaves)');
        $this->data['leave_types'] = $this->select_box (new LeaveType(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), '', 'id in (select  distinct "leave_type_id" from leaves)');
        $this->data['positions'] = $this->select_box (new Position(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), '', 'id in (select  distinct "position_id" from users)');
        return view ('layouts.leave.index', $this->data);

    }

    /**
     * @param Request $request
     * @return BinaryFileResponse
     */
    public function export (Request $request): BinaryFileResponse
    {
//        $query = Leave:: with ('leave_type','user.position','user.organisation_unit','user.department.department','status','user.project');
        $query = Leave::leftJoin('users', 'leaves.user_id', '=', 'users.id')
            ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
            ->leftJoin('projects', 'users.project_id', '=', 'projects.id')
            ->leftJoin('departments_missions', 'users.department_id', '=', 'departments_missions.id')
            ->leftJoin('departments', 'departments_missions.department_id', '=', 'departments.id')
            ->leftJoin('statuses', 'leaves.status_id', '=', 'statuses.id')
            ->leftJoin('leave_types', 'leaves.leave_type_id', '=', 'leave_types.id');
        $search=$request->search;
        if(!is_null ($search)) {
            $query->whereRaw  ("(first_name_en || last_name_en ilike '%$search%' ) or  (first_name_ar || last_name_ar ilike '%$search%') or  positions.name_en ilike '%$search%' or  leave_types.name_en ilike '%$search%'");
        }
        if (isset($request->status_ids)) {
            $query->whereIn ('leaves.status_id', explode (',',$request->status_ids));
        }
        if (isset($request->department_ids)) {
            $data=DepartmentMission::whereIn('department_id',explode (',',$request->department_ids))->select('id')->get();
            $query->whereIn ('users.department_id', $data);

        }
        if (isset($request->position_ids)) {
            $query->whereIn ('users.position_id',explode (',', $request->position_ids));
        }
        if (isset($request->organisation_unit_ids)) {
            $query->whereIn ('users.organisation_unit_id', explode (',', $request->organisation_unit_ids));

        }
        if (isset($request->project_ids)) {
            $query->whereIn ('users.project_id', explode (',', $request->project_ids));
        }

        if (!is_null($request->start_date)) {
            $query->whereDate ('leaves.start_date', '>=', $request->start_date);
        }
        if (!is_null($request->end_date)) {
            $query->whereDate ('leaves.end_date', '<=', $request->end_date);
        }
        if (!is_null($request->min)) {
            $query->where ('leaves.leave_days', '>=', $request->min);
        }
        if (!is_null($request->max)) {
            $query->where ('leaves.leave_days', '<=', $request->max);
        }


        $data = $query->orderByRaw  ('department_name,user_full_name_en,position_name')->selectRaw('leaves.*,departments.name_en as department_name,projects.name_en as project_name,users.financial_code as user_financial_code,
        users.first_name_en ||\' \'|| users.last_name_en as user_full_name_en,users.first_name_ar || \' \' || users.last_name_ar as user_full_name_ar,positions.name_en as position_name,
        leave_types.name_en as leave_type_name,statuses.name_en as status_name')->get ();

        return Excel::download (new LeaveList($data), 'leave.xlsx');

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
        $sortField = $request->input ('sort.field', 'name_en');
        $offset = ($page - 1) * $perpage;
        $query = Leave::leftJoin('users', 'leaves.user_id', '=', 'users.id')
            ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
            ->leftJoin('statuses', 'leaves.status_id', '=', 'statuses.id')
            ->leftJoin('leave_types', 'leaves.leave_type_id', '=', 'leave_types.id');
//        $query = Leave::with ('leave_type','user','user.position','user.position','status','user.project');
        if(!is_null ($search)) {
            $query->whereRaw  ("(first_name_en || last_name_en ilike '%$search%' ) or  (first_name_ar || last_name_ar ilike '%$search%') or  positions.name_en ilike '%$search%' or  leave_types.name_en ilike '%$search%'");
        }
        if (isset($request->status_ids)) {
            $query->whereIn ('leaves.status_id', $request->status_ids);
        }
        if (isset($request->department_ids)) {
            $data=DepartmentMission::whereIn('department_id',$request->department_ids)->select('id')->get();
                    $query->whereIn ('users.department_id', $data);
        }
        if (isset($request->position_ids)) {
            $query->whereIn ('users.position_id',  $request->position_ids);
        }
        if (isset($request->organisation_unit_ids)) {
                    $query->whereIn ('users.organisation_unit_id', $request->organisation_unit_ids);
        }
        if (isset($request->project_ids)) {
           $project_ids= $request->project_ids;
            $query->whereIn ('users.project_id', $project_ids);
        }

        if (isset($request->start_date)) {
            $query->whereDate ('leaves.start_date', '>=', $request->start_date);
        }
        if (isset($request->end_date)) {
            $query->whereDate ('leaves.end_date', '<=', $request->end_date);
        }
        if (isset($request->min_leave_period)) {
            $query->where ('leaves.leave_days', '>=', $request->min_leave_period);
        }
        if (isset($request->max_leave_period)) {
            $query->where ('leaves.leave_days', '<=', $request->max_leave_period);
        }



        $totalCount = $query->count ();

        $query->offset ($offset)
            ->limit ($perpage)
            ->orderBy ($sortField, $sortOrder);
        $data = $query->selectRaw('leaves.*,users.first_name_en || \' \' || users.last_name_en as user_full_name,positions.name_en as position_name,leave_types.name_en as leave_type_name,statuses.name_en as status_name')->get ();
        $request->offsetSet ('pages', ceil ($totalCount / $perpage));
        $request->offsetSet ('total', $totalCount);
        return $this->resources (new LeaveCollection($data));
    }

    /**
     * @return Application|Factory|View
     */
    public function daily_create ()
    {
        $this->data['leave_types'] = $this->select_box (new LeaveType(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), trans ('common.please_select'), 'hourly=false');
        $this->data['on_behalf_users'] = $this->select_box (new User(), 'id', \DB::raw ('first_name_' . $this->lang . '  || \' \' || last_name_' . $this->lang . ' as name'), trans ('common.please_select'), 'on_behalf_user_id=' . Auth::id () . '');

        return view ('layouts.leave.daily.daily_create', $this->data);

    }

    /**
     * @param DailyStore $request
     * @return JsonResponse|RedirectResponse
     */
    public function daily_store (DailyStore $request)
    {
        $data = explode ('to', $request->date_range);
        [$start_date, $end_date] = $data;
        echo $start_date;
        $leave = new Leave();
        $leave->leave_type_id = $request->leave_type_id;
        $requester_id = Auth::id ();
        if ($request->on_behalf_of_id != null) {
            $requester_id = $request->on_behalf_of_id;
            $leave->user_id = $request->on_behalf_of_id;
            $leave->on_behalf_user_id = Auth::id ();
        }
        else {
            $leave->user_id = Auth::id ();
        }
        $contract_type = Auth::user ()->contract_type;
        $requested_days =0;

        if ($request->leave_type_id == 50000) {
            $massage = $this->validation_annual_leave ($request);
            $requested_days = get_duration_leave_contract_type ($start_date, $end_date, $requester_id, $contract_type->weekends_included, $contract_type->holidays_included);
            $checkForHolidays = check_for_holidays ($start_date, $end_date, $requester_id, $contract_type->weekends_included);
            $requested_days+=$checkForHolidays;
        }
        elseif ($request->leave_type_id == 55161) {
            $requested_days = getDurationLeaveRequest($start_date,$end_date);

            $massage = $this->validation_death_leave ($request);
        }
        elseif ($request->leave_type_id == 50017) {
            $requested_days = getDurationLeaveRequestWithoutWeekends($start_date,$end_date,$requester_id);
            $massage = $this->validation_business_leave ($request);
        }
        elseif ($request->leave_type_id == 50019) {
            $massage = $this->validation_motherhood_leave ($request);
            $requested_days = getDurationLeaveRequest($start_date,$end_date);

        }
        elseif ($request->leave_type_id == 212637) {
            $massage = $this->validation_nursing_leave ($request);
            $requested_days = getDurationLeaveRequest($start_date,$end_date);

        }
        elseif ($request->leave_type_id == 55151) {
            $massage = $this->validation_fatherhood_leave ($request);
            $requested_days = get_duration_leave_contract_type($start_date,$end_date,$requester_id,false,false);

        }
        elseif ($request->leave_type_id == 313622) {
            $requested_days = get_duration_leave_contract_type ($start_date, $end_date, $requester_id, $contract_type->weekends_included, $contract_type->holidays_included);
            $massage = $this->validation_patient_accompanying_leave ($request);
        }
        elseif ($request->leave_type_id == 50018) {
            $massage = $this->validation_sick_leave ($request);
            $requested_days = get_duration_leave_contract_type($start_date,$end_date,$requester_id,true,true);

        }
        elseif ($request->leave_type_id == 50002) {
            $holiday_days = Holiday::join('contract_types','contract_types.holiday_id','=','holiday.id')
                ->join('users','users.contract_type_id','=','contract_types.id')
                ->where('users.id',$requester_id)->select('holidays.days')->first();

            $weekend_days = Weekend::join('contract_types','contract_types.weekend_id','=','weekends.id')
                ->join('users','users.contract_type_id','=','contract_types.id')
                ->where('users.id',$requester_id)->select('weekends.days')->first();
            $weekend = json_decode($weekend_days->days,true);
            $weekend = count($weekend);
//        echo $weekend;
            $holiday_date = json_decode($holiday_days->days,true);

            if ($contract_type->contracttypeid==209372 ||$contract_type->contracttypeid==190 ){
                Carbon::setWeekendDays(
                    [
                        Carbon::SUNDAY,
                        Carbon::SATURDAY,
                    ]);
                Carbon::setWeekStartsAt(Carbon::MONDAY);
            }
            elseif($contract_type->contracttypeid==65){
                Carbon::setWeekendDays(
                    [
                        Carbon::FRIDAY,
                        Carbon::SATURDAY,
                    ]);
                Carbon::setWeekStartsAt(Carbon::SUNDAY);
            }
            elseif($contract_type->contracttypeid==66722 || $contract_type->contracttypeid==263313 || $contract_type->contracttypeid==263312){
                Carbon::setWeekendDays(
                    [
                        Carbon::FRIDAY,
                    ]);
                Carbon::setWeekStartsAt(Carbon::SATURDAY);
            }
            else{
                Carbon::setWeekendDays(
                    [
                        Carbon::SUNDAY,
                        Carbon::SATURDAY,
                    ]);
                Carbon::setWeekStartsAt(Carbon::MONDAY);
            }

            $key = 0;
            $countHoliday = 0;
            $dayCount = Carbon::parse($start_date)->diffInDays(Carbon::parse($end_date)) + 1;
            for (  $leave_day=0 ; $leave_day<$dayCount;$leave_day++)
            {
                $date=Carbon::parse($data['unpaid_leave_start_date'])->addDay($leave_day);

                if (Carbon::parse($data['unpaid_leave_start_date'])->endOfWeek()->format('Y-m-d') == Carbon::parse($date)->format('Y-m-d') && $leave_day <= 5) {
                    for ($i = 0; $i < 7; $i++) {
                        if (!Carbon::parse($data['unpaid_leave_start_date'])->startOfWeek()->addDay($i)->isWeekend()) {
                            $days["$key"]["$i"] = Carbon::parse($data['unpaid_leave_start_date'])->startOfWeek()->addDay($i)->format('Y-m-d');
                        }
                    }
                    ++$key;
                }elseif (Carbon::parse($date)->startOfWeek()->format('Y-m-d') == Carbon::parse($date)->format('Y-m-d') ) {
                    for ($i = 0; $i < 7; $i++) {
                        if (!Carbon::parse($date)->startOfWeek()->addDay($i)->isWeekend() ) {
                            $days["$key"]["$i"] = Carbon::parse($date)->startOfWeek()->addDay($i)->format('Y-m-d');
                        }
                    }
                    ++$key;
                } elseif (Carbon::parse($data['unpaid_leave_end_date'])->startOfWeek()->format('Y-m-d') == Carbon::parse($date)->format('Y-m-d')) {
                    for ($i = 0; $i < 7; $i++) {
                        if (!Carbon::parse($date)->startOfWeek()->addDay($i)->isWeekend() ) {
                            $days["$key"]["$i"] = Carbon::parse($date)->startOfWeek()->addDay($i)->format('Y-m-d');
                        }
                    }
                    ++$key;
                } elseif ($dayCount < 7) {
                    for ($i = 0; $i < 7; $i++) {
                        if (!Carbon::parse($date)->startOfWeek()->addDay($i)->isWeekend()) {
                            $days['0']["$i"] = Carbon::parse($date)->startOfWeek()->addDay($i)->format('Y-m-d');
                        }
                    }
                }
            }
            $dayOfUnpaidRequest = [];
            $dayOfUnpaid = Leave::where('leave_type_id',50002)->where('status_id','!=',170)->select(['start_date','end_date'])->get();
            foreach ($dayOfUnpaid as $day) {
                for ( $leave_day=0 ; $leave_day<$dayCount;$leave_day++)
                {
                    $date=Carbon::parse($start_date)->addDay($leave_day);

                    if (!Carbon::parse($date)->isWeekend() || !in_array ($date, $holiday_date, true)) {
                        $dayOfUnpaidRequest[] = $date->format ('Y-m-d');
                    }
                }
            }
            for ( $leave_day=0 ; $leave_day<$dayCount;$leave_day++)
            {
                $date=Carbon::parse($data['unpaid_leave_start_date'])->addDay($leave_day);
                $dayOfUnpaidRequest[] = $date->format ('Y-m-d');
            }
            $dayOfUnpaidRequest = array_unique($dayOfUnpaidRequest);

            $count = 0;
            $countHoliday2=0;
            $arrayHoliday= [];
            for ( $leave_day=0 ; $leave_day<$dayCount;$leave_day++)
            {
                $date=Carbon::parse($data['unpaid_leave_start_date'])->addDay($leave_day);
                foreach ($days as $day) {
                    if (in_array ($date->format ('Y-m-d'), $holiday_date, true) && $dayCount >= 30) {
                        $arrayHoliday[] = $date->format ('Y-m-d');

                    } elseif (in_array ($date->format ('Y-m-d'), $holiday_date, true) && $dayCount < 30) {
                        if (($key2 = array_search ($date->format ('Y-m-d'), $day, true)) !== false) {
                            unset($day[$key2]);
                        }
                    }
                    if (in_array ($date->format ('Y-m-d'), $day, true)) {
                        $count++;
                    }
                }
            }
            $arrayHoliday = array_unique($arrayHoliday);
            foreach ($days as $day) {
                $ifFind = 1;
                foreach ($day as $value) {
                    if (!in_array ($value, $dayOfUnpaidRequest, true)) {
                        $ifFind = 0;
                        break;
                    }
                }
                if ($ifFind) {
                    $count += $weekend;
                }
            }
            $daysBefore = [];
            for ($i = 1; $i > 0; $i++) {
                $thisDay = Carbon::parse($data['unpaid_leave_start_date'])->subDay($i);
                if ($thisDay->isWeekend()) {
                    $i++;
                    $thisDay = Carbon::parse($data['unpaid_leave_start_date'])->subDay($i);

                }
                if ($thisDay->isWeekend()) {
                    $i++;
                    $thisDay = Carbon::parse($data['unpaid_leave_start_date'])->subDay($i);

                }
                if (!in_array ($thisDay->format ('Y-m-d'), $dayOfUnpaidRequest, true)) {
                    break;
                } else {
                    $daysBefore[] = $thisDay->format ('Y-m-d');
                }
            }


            for ($i = 1; $i > 0; $i++) {
                $thisDay = Carbon::parse($data['unpaid_leave_end_date'])->addDay($i);
                if ($thisDay->isWeekend()) {
                    $i++;
                    $thisDay = Carbon::parse($data['unpaid_leave_end_date'])->addDay($i);

                }
                if ($thisDay->isWeekend()) {
                    $i++;
                    $thisDay = Carbon::parse($data['unpaid_leave_end_date'])->addDay($i);

                }
                if (!in_array ($thisDay->format ('Y-m-d'), $dayOfUnpaidRequest, true)) {
                    break;
                } else {
                    $daysBefore[] = $thisDay->format ('Y-m-d');
                }
            }
            $countHolidayBefore = 0;

            foreach ($daysBefore as $dayBefore) {
                if (in_array($dayBefore,$holiday_date) && count($daysBefore) >= 30) {
                    $countHolidayBefore++;
                }
            }
            if ($countHolidayBefore > count($arrayHoliday)   && count($daysBefore) >= 30)  {
                $countHolidayBefore -= count ($arrayHoliday);

            }
            elseif($countHolidayBefore <  count($arrayHoliday)  && count($daysBefore) >= 30) {
                $countHolidayBefore = count($arrayHoliday)  - $countHolidayBefore;

            }
            $requested_days += $countHolidayBefore;
            $massage = $this->validation_unpaid_leave ($request);
        }
        elseif ($request->leave_type_id == 55160) {
            $massage = $this->validation_wedding_leave ($request);
            $requested_days = getDurationLeaveRequest($start_date,$end_date);

        }
        else{
            $requested_days = get_duration_leave_contract_type ($start_date, $end_date, $requester_id, $contract_type->weekends_included, $contract_type->holidays_included);
            $checkForHolidays = check_for_holidays ($start_date, $end_date, $requester_id, $contract_type->weekends_included);
            $requested_days+=$checkForHolidays;
            $massage = $this->validation_annual_leave ($request);
        }
        if ($massage != 'allowed') {
            return $this->setStatusCode (422)->respond (['error' => [$massage]]);
        }
        $leave->leave_days = $requested_days ;
        if (Auth::id () == 267257 || $request->on_behalf_of_id == 267257) {
            $leave->status_id = 170;
        }
        else {
            $leave->status_id = 174;
        }
        $leave_type_name=LeaveType::find ($leave->leave_type_id)->name_en;
        $leave->name_en = $leave_type_name;

        if ( $request->hasFile('file')) {
            $path = $request->file('file')->store(
                Str::slug($leave_type_name, '-'),'public'
            );
            $leave->file = $path;
        }
        $leave->stored_by = Auth::user ()->username;
        $leave->start_date = $start_date;
        $leave->end_date = $end_date;
        $leave->reason =  $request->reason ?? 'No Reason';
        $leave->save();
//        $leaverequest_maxid = $leave->leaverequestid;
//        if (Auth::id() == 267257 || $request->on_behalf_of_id == 267257) {
//            $this->notificationLeaveRequest('112548',$leaverequest_maxid,39191,'reviewAnnual.leave',null,'50010',$requester_id);
//        } else {
//            $employeenext_user_id = Employee::find($employeeNext)->Empstructure->User->user_id;
//            if ($employeenext_user_id == 267257 && $requested_days > 5) {
//                $notificationCycle = getnotificationCycleLeaveRequest($requested_days,39191,$requester_id);
//                $array = json_decode($notificationCycle,true);
//                $user = \App\Empstructure::getUserIdByPosition($array['position'][0]);
//                $employeenext_user_id = $user->user_id;
//            }
//            $this->notificationLeaveRequest($employeenext_user_id,$leaverequest_maxid,39191,'viewAnnualAction.leave',null,'50010',$requester_id);
//        }

        return redirect ()->route ('cycleAnnual.leave', ['operationId' => $leaverequest_maxid]);

    }

    /**
     * @param Leave $leave
     * @return Application|Factory|View
     */
    public function daily_show(Leave $leave){
        $this->data['leave']=$leave;
        return view ('layouts.leave.daily.show', $this->data);
    }

    public function hourly_create ()
    {
        $this->data['leave_types'] = $this->select_box (new LeaveType(), 'id', \DB::raw ('name_' . $this->lang . ' as name'), trans ('common.please_select'), 'hourly=true');
        $this->data['on_behalf_users'] = $this->select_box (new User(), 'id', \DB::raw ('first_name_' . $this->lang . '  || \' \' || last_name_' . $this->lang . ' as name'), trans ('common.please_select'), 'on_behalf_user_id=' . Auth::id () . '');
        return view ('layouts.leave.hourly.hourly_create', $this->data);

    }

    public function hourly_store (HourlyStore $request)
    {


        if ($request->leave_type_id == 101883 ||  $request->leave_type_id == 375479 ) {
            $massage = $this->validation_hourly_unpaid_leave  ($request);
        } else{
            $massage = $this->validation_hourly_leave  ($request);
        }
        if ($massage != 'allowed') {
            return $this->setStatusCode (422)->respond (['error' => [$massage]]);
        }
        $leave = new Leave();
        $leave->leave_type_id = $request->leave_type_id;

        $leave_type_name=LeaveType::find ($leave->leave_type_id)->name_en;
        $leave->name_en = $leave_type_name;

        if ( $request->hasFile('file')) {
            $path = $request->file('file')->store(
                Str::slug($leave_type_name, '-'),'public'
            );
            $leave->file = $path;
        }
        $start_time = Carbon::parse ($request->start_time);
        $end_time = Carbon::parse ($request->end_time);
        $requester_id = Auth::id ();
        $date = Carbon::parse ($request->date);
        $nursing = User::where (
        function($query) use ($date) {
                $query->where (
                    [
                        ['start_nursing_date', '>=', $date],
                        ['end_nursing_date', '<=', $date],
                    ])->ORwhere (
                    [
                        ['start_nursing_date', '<=', $date],
                        ['end_nursing_date', '>=', $date],
                    ])->Orwhere (
                    [
                        ['start_nursing_date', '<=', $date],
                        ['end_nursing_date', '>=', $date],
                    ]);
            })->first ();
        if ($request->on_behalf_of_id != null) {
            $requester_id = $request->on_behalf_of_id;
            $leave->user_id = $request->on_behalf_of_id;
            if (is_null ($nursing)) {
                $hours = (User::find ($request->on_behalf_of_id)->number_of_hours) * 60;
            } else {
                $hours = (User::find ($request->on_behalf_of_id)->current_number_of_hours) * 60;
            }
            $leave->on_behalf_user_id = Auth::id ();
        }
        else {
            $leave->user_id = Auth::id ();
            if (is_null ($nursing)) {
                $hours = Auth::user ()->number_of_hours * 60;
            } else {
                $hours = Auth::user ()->current_number_of_hours * 60;
            }
        }
        $totalMinutesDuration = $end_time->diffInMinutes ($start_time);
        $requested_days = $totalMinutesDuration / $hours;
        $requested_days = round ($requested_days, 3);
        $leave->leave_days = $requested_days;
        if (Auth::id () == 267257 || $request->on_behalf_of_id == 267257) {
            $leave->status_id = 170;
        }
        else {
            $leave->status_id = 174;
        }
        $leave->stored_by = Auth::user ()->full_name;
        $leave->start_date = $date;
        $leave->end_date = $date;
        $leave->start_time = $request->start_time;
        $leave->end_time = $request->end_time;
        $leave->reason = $request->reason ?? 'No Reason';
        $leave->save ();
//        $leaverequest_maxid = $leave->leaverequestid;
//        //$notificationCycle  = getnotificationCycleHourlyLeaveRequest(50009, $requester_id);
//        // echo $notificationCycle;
//        if (Auth::id() == 267257 || $request->on_behalf_of_id  == 267257) {
//            $this->notificationLeaveRequest(112548,$leaverequest_maxid,50009,'reviewHourly.leave',null,'50010',$requester_id);
//        } else {
//            $employeenext_user_id = Employee::find($employeeNext)->Empstructure->User->user_id;
//
//            $this->notificationLeaveRequest($employeenext_user_id,$leaverequest_maxid,50009,'viewHourlyAction.leave',null,'50010',$requester_id);
//        }
        return redirect ()->route ('cycleHourly.leave', ['operationId' => $leaverequest_maxid]);

    }

    public function hourly_show(Leave $leave){
        $this->data['leave']=$leave;
        return view ('layouts.leave.hourly.show', $this->data);
    }


    public function available_days(Request $request){
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $user_id = Auth::id ();
        $start_date_end = Carbon::parse($end_date)->endOfMonth();
        $start_date_end_year = Carbon::parse($end_date)->year;

        $user=User::find($user_id);
        $requester_id = $user->id;
        $date = $user->accumulated_days;
        $date2 = $user->extra_days;
        $date3 = $user->advanced_balance;
        $all_days = $user->balance;

        $daysMin = Leave::where('user_id',$requester_id)
            ->whereDate('start_date','<=',$start_date_end)
            ->whereYear('start_date','=',$start_date_end_year)
            ->where('status_id','!=',171)
            ->where(
                function ($query) {
                    $query->where('leave_type_id','=',50000)->Orwhere('leave_type_id','=',50001);
                })->selectRaw('sum(leave_days) as sum')->first();

        $takenDaysMin = $daysMin->sum;

        $month_now = Carbon::parse($end_date)->month;


        $avail_days_1 = ((($all_days * $month_now) / 12) - $takenDaysMin) + $date + $date2 + 1 + $date3;
        if ($month_now == 12) {
            return $avail_days_1 - 1;

        } else {
            return $avail_days_1;

        }
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function report($id){
        $this->data['user'] = User::find($id);
//        $contract_type = ContractType::join('users','users.contract_type_id','=','contract_types.id')
//            ->where('users.id',$id)->select('contract_types.leave_period_id')->first();
//        $leaveperiod = LeavePeriod::where('id',$contract_type->leave_period_id)->select('leave_period')->first();
        $leave_days = Leave::whereIn('leave_type_id',[50001,50000])->where('status_id','!=',171)->where('user_id',$id)->selectRaw('sum(leave_days) as sum')->first();
        $this->data['leave_days'] = $leave_days->sum;
        $this->data['totalDays'] = $this->data['user']->balance;
        $this->data['totalDaysAnnual'] = 0;
        $this->data['totalHourly'] = '0:00';
        $this->data['totalHourlyUnpaid'] = '0:00';
        $this->data['totalHourlyBusiness'] = '0:00';
        $this->data['sickHourly'] = '0:00';
        $this->data['totalDaysSick'] = 0;
        $this->data['totalDaysMotherhood'] = 0;
        $this->data['totalDaysPatientAccompanying'] = 0;
        $this->data['totalDaysFatherhood'] = 0;
        $this->data['totalDaysWedding'] = 0;
        $this->data['totalDaysDeath'] = 0;
        $this->data['totalDaysBusiness'] = 0;
        $this->data['totalDaysUnpaid'] = 0;
        $this->data['accumulatedDays'] = $this->data['user']->accumulated_days;
        $this->data['extra_days'] = $this->data['user']->extra_days;
        $this->data['title'] = 'erp';
        $this->data['i'] = 1;
        $sick = $this->data['user']->leave_request(185872);
        $doctor = $this->data['user']->leave_request(185873);
        $sick = collect($sick);
        $this->data['dataSickHourly'] = $sick->concat($doctor)->sortBy('start_date');

        return view ('layouts.leave.report', $this->data);
    }


    /**
     * @param $request
     * @return string|null
     */
    public function validation_annual_leave ($request): ?string
    {
//        $data = Input::all();
        $data = explode ('to', $request->date_range);
        [$start_date, $end_date] = $data;
        $start_date = Carbon::parse ($start_date);
        $end_date = Carbon::parse ($end_date);
        $start_date_end = Carbon::parse ($end_date)->endOfMonth ();
        $start_date_end_year = Carbon::parse ($end_date)->year;

        $requester_id = Auth::id ();
        $date = Auth::user ()->accumulated_days;
        $date2 = Auth::user ()->extra_days;
        $date3 = Auth::user ()->advanced_balance;
        $all_days = Auth::user ()->balance;
        if (isset($request->on_behalf_of_id) && $request->on_behalf_of_id != null) {
            $requester_id = $request->on_behalf_of_id;

            $date = User::find ($request->on_behalf_of_id)->accumulated_days;
            $date2 = User::find ($request->on_behalf_of_id)->extra_days;
            $date3 = User::find ($request->on_behalf_of_id)->advanced_balance;
            $all_days = User::find ($request->on_behalf_of_id)->balance;

        }
        $contract_type = ContractType::join ('users', 'users.contract_type_id', '=', 'contract_types.id')
            ->where ('users.id', $requester_id)->select ('contract_types.name_en', 'contract_types.weekends_included', 'contract_types.holidays_included', 'contract_types.leave_period_id')->first ();

        $requested_days = get_duration_leave_contract_type ($start_date, $end_date, $requester_id, $contract_type->weekends_included, $contract_type->holidays_included);
        $checkForHolidays = check_for_holidays ($start_date, $end_date, $requester_id, $contract_type->weekends_included);

        $daysMin = Leave::where ('user_id', $requester_id)
            ->whereDate ('start_date', '<=', $start_date_end)
            ->whereYear ('start_date', '=', $start_date_end_year)
            ->where ('status_id', '!=', 171)
            ->where (
                function($query) {
                    $query->where ('leave_type_id', '=', 50000)->Orwhere ('leave_type_id', '=', 50001);
                })->selectRaw ('sum(leave_days) as sum')->first ();
        $takenDaysMin = $daysMin->sum;

        $daysMax = Leave::where ('user_id', $requester_id)
            ->whereDate ('start_date', '>=', $start_date_end)
            ->whereYear ('start_date', '=', $start_date_end_year)
            ->where ('status_id', '!=', 171)
            ->where (
                function($query) {
                    $query->where ('leave_type_id', '=', 50000)->Orwhere ('leave_type_id', '=', 50001);
                })->selectRaw ('sum(leave_days) as sum')->first ();
        $takenDaysMax = $daysMax->sum;

        $month_now = Carbon::parse ($end_date)->month;
        $checkExist = Leave::where (
            function($query) use ($start_date, $end_date) {
                $query->where (
                    [
                        ['start_date', '>=', $start_date],
                        ['end_date', '<=', $end_date],
                    ])->ORwhere (
                    [
                        ['start_date', '<=', $end_date],
                        ['end_date', '>=', $end_date],
                    ])->Orwhere (
                    [
                        ['start_date', '<=', $start_date],
                        ['end_date', '>=', $start_date],
                    ]);
            })->where (
            function($query) use ($start_date, $end_date) {
                $query->Orwhere (
                    [
                        ['leave_type_id', 50001],
                    ])->Orwhere (
                    [
                        ['leave_type_id', 50000],
                    ]);
            })->where ('user_id', $requester_id)->where ('leave_type_id', '!=', 212637)->where ('status_id', '!=', 171)->select ('start_date')->count ();

        $avail_days_1 = ((($all_days * $month_now) / 12) - $takenDaysMin) + $date + $date2 + 1 + $date3;
        $avail_days_2 = $requested_days + $takenDaysMax + $takenDaysMin;
        if ($start_date > $end_date) {
            if ($request->lang == 'en') {
                return 'The end date must be a date after start date';
            } elseif ($request->lang == 'ar') {
                return 'يجب أن يكون تاريخ الانتهاء  بعد تاريخ البدء';
            }
        } elseif ($checkExist > 0) {
            if ($request->lang == 'en') {
                return 'Please choose another date,This date is already chosen';
            } elseif ($request->lang == 'ar') {
                return 'يرجى اختيار تاريخ آخر ، تم اختيار هذا التاريخ مسبقاً';
            }
        } elseif ($avail_days_2 > ($all_days + $date + $date2)) {
            if ($request->lang == 'en') {
                return 'You do not have enough days';
            } elseif ($request->lang == 'ar') {
                return 'ليس لديك ما يكفي من الأيام';
            }
        } elseif ($avail_days_1 < $requested_days) {
            if ($request->lang == 'en') {
                return 'You do not have enough days';
            } elseif ($request->lang == 'ar') {
                return 'ليس لديك ما يكفي من الأيام';
            }
        } elseif ($requested_days == 0) {
            if ($request->lang == 'en') {
                return 'This day is holidays or weekend';
            } elseif ($request->lang == 'ar') {
                return 'هذا اليوم هو يوم عطلة أو عطلة نهاية الأسبوع';
            }
        } elseif (($checkExist <= 0) && ($avail_days_1 <= ($all_days + $date + $date2) || $avail_days_2 <= ($all_days + $date + $date2))) {
            return 'allowed';
        }
    }

    /**
     * @param $request
     * @return string|null
     */
    public function validation_hourly_leave ($request): ?string
    {
        $start_time = Carbon::parse ($request->start_time);
        $end_time = Carbon::parse ($request->end_time);
        if (!isset($request->lang)) {
            $request->lang = 'en';
        }
        $totalMinutesDuration = $end_time->diffInMinutes ($start_time);
        if ($request->on_behalf_of_id != null) {
            $hours = (User::find ($request->on_behalf_of_id)->number_of_hours) * 60;
            $date = User::find ($request->on_behalf_of_id)->accumulated_days;
            $date2 = User::find ($request->on_behalf_of_id)->extra_days;
            $date3 = User::find ($request->on_behalf_of_id)->advanced_balance;

            $requester_id = $request->on_behalf_of_id;
            $all_days = User::find ($request->on_behalf_of_id)->balance;
        } else {
            $hours = (Auth::user ()->number_of_hours) * 60;
            $date = Auth::user ()->accumulated_days;
            $date2 = Auth::user ()->extra_days;
            $requester_id = Auth::id ();
            $date3 = Auth::user ()->advanced_balance;
            $all_days = Auth::user ()->balance;
        }
        $requested_days = $totalMinutesDuration / $hours;
        $start_date = Carbon::parse ($request->date);
        $end_date = $start_date;

        $contract_type = ContractType::join ('users', 'users.contract_type_id', '=', 'contract_types.id')
            ->where ('users.id', $requester_id)->select ('contract_types.*')->first ();
        $checkForHolidays = check_for_holidays ($start_date, $end_date, $requester_id, $contract_type->weekends_included, $requested_days);

        $start_date_end = Carbon::parse ($end_date)->endOfMonth ();
        $start_date_end_year = Carbon::parse ($end_date)->year;
        $daysMin = Leave::where ('user_id', $requester_id)
            ->whereDate ('start_date', '<=', $start_date_end)
            ->whereYear ('start_date', '=', $start_date_end_year)
            ->where ('status_id', '!=', 171)
            ->where (
                function($query) {
                    $query->where ('leave_type_id', '=', 50000)->Orwhere ('leave_type_id', '=', 50001);
                })->selectRaw ('sum(leave_days) as sum')->first ();
        $takenDaysMin = $daysMin->sum;

        $daysMax = Leave::where ('user_id', $requester_id)
            ->whereDate ('start_date', '>=', $start_date_end)
            ->whereYear ('start_date', '=', $start_date_end_year)
            ->where ('status_id', '!=', 171)
            ->where (
                function($query) {
                    $query->where ('leave_type_id', '=', 50000)->Orwhere ('leave_type_id', '=', 50001);
                })->selectRaw ('sum(leave_days) as sum')->first ();
        $takenDaysMax = $daysMax->sum;

        $month_now = Carbon::parse ($end_date)->month;


        $checkExist = Leave::where (
            function($query) use ($start_time, $end_time) {
                $query->where (
                    [
                        ['start_time', '>=', $start_time],
                        ['end_time', '<=', $end_time],
                    ])->ORwhere (
                    [
                        ['start_time', '<=', $end_time],
                        ['end_time', '>=', $end_time],
                    ])->Orwhere (
                    [
                        ['start_time', '<=', $start_time],
                        ['end_time', '>=', $start_time],
                    ]);
            })->where ('end_date', $end_date)->where ('user_id', $requester_id)->where ('leave_type_id', '!=', 212637)->where ('status_id', '!=', 171)->select ('start_time')->count ();

        $checkExistHourly = Leave::where (
            function($query) use ($start_date, $end_date) {
                $query->where (
                    [
                        ['start_date', '>=', $start_date],
                        ['end_date', '<=', $end_date],
                    ])->ORwhere (
                    [
                        ['start_date', '<=', $end_date],
                        ['end_date', '>=', $end_date],
                    ])->Orwhere (
                    [
                        ['start_date', '<=', $start_date],
                        ['end_date', '>=', $start_date],
                    ]);
            })->whereNotIn ('leave_type_id', [185872, 375479, 185873, 101883, 50001,212637])->where ('user_id', $requester_id)->where ('status_id', '!=', 171)->select ('start_date')->count ();


        $avail_days_1 = ((($all_days * $month_now) / 12) - $takenDaysMin) + $date + $date2 + 1 + $date3;
        $avail_days_2 = $requested_days + ($takenDaysMax + $takenDaysMin);


        $contract_start_time = Carbon::parse ($contract_type->start_time)->format ('H:i');
        $contract_end_time = Carbon::parse ($contract_type->end_time)->format ('H:i');

        if ($start_time > $end_time) {
            if ($request->lang == 'en') {
                return 'The end time must be a date after start time';
            } elseif ($request->lang == 'ar') {
                return 'يجب أن يكون وقت النهاية بعد وقت البدء';
            }
        } elseif ($start_time->format ('H:i') < $contract_start_time || $end_time->format ('H:i') > $contract_end_time) {
            if ($request->lang == 'en') {
                return 'Your work day from ' . $contract_start_time . ' to ' . $contract_end_time;
            } elseif ($request->lang == 'ar') {
                return ' يوم عملك من ' . $contract_start_time . ' إلى ' . $contract_end_time;
            }
        } elseif ($checkExist > 0) {
            if ($request->lang == 'en') {
                return 'Please choose another date,This time is already chosen';
            } elseif ($request->lang == 'ar') {
                return 'يرجى اختيار تاريخ آخر ، تم اختيار هذا الوقت مسبقا';
            }
        } elseif ($checkExistHourly > 0) {
            if ($request->lang == 'en') {
                return 'Please choose another date,This date is already chosen';
            } elseif ($request->lang == 'ar') {
                return 'يرجى اختيار تاريخ آخر ، تم اختيار هذا التاريخ مسبقا';
            }
        } elseif ($avail_days_2 > ($all_days + $date + $date2)) {
            if ($request->lang == 'en') {
                return 'You do not have enough days';
            } elseif ($request->lang == 'ar') {
                return 'ليس لديك ما يكفي من الأيام';
            }
        } elseif ($avail_days_1 < $requested_days) {
            if ($request->lang == 'en') {
                return 'You do not have enough days';
            } elseif ($request->lang == 'ar') {
                return 'ليس لديك ما يكفي من الأيام';
            }
        } elseif ($requested_days == 0) {
            if ($request->lang == 'en') {
                return 'The end time must be a date after start time';
            } elseif ($request->lang == 'ar') {
                return 'يجب أن يكون وقت الانتهاء تاريخًا بعد وقت البدء';
            }
        } elseif ($checkForHolidays != 0) {
            return 'add';
        } elseif (($checkExist <= 0) && ($avail_days_1 <= ($all_days + $date + $date2) || $avail_days_2 <= ($all_days + $date + $date2))) {
            return 'allowed';
        }
    }

    /**
     * @param $request
     * @return string|null
     */
    public function validation_hourly_unpaid_leave ($request): ?string
    {

        $start_time = Carbon::parse ($request->start_time);
        $end_time = Carbon::parse ($request->end_time);
        $totalMinutesDuration = $end_time->diffInMinutes ($start_time);
        if (!isset($request->lang)) {
            $request->lang = 'en';
        }

        if ($request->on_behalf_of_id != null) {
            $hours = (User::find ($request->on_behalf_of_id)->number_of_hours) * 60;
            $requester_id = $request->on_behalf_of_id;
        } else {
            $hours = (Auth::user ()->number_of_hours) * 60;
            $requester_id = Auth::id ();

        }
        $requested_days = $totalMinutesDuration / $hours;
        $start_date = Carbon::parse ($request->date);
        $end_date = $start_date;
        $checkExist = Leave::where (
            function($query) use ($start_time, $end_time) {
                $query->where (
                    [
                        ['start_time', '>=', $start_time],
                        ['end_time', '<=', $end_time],
                    ])->ORwhere (
                    [
                        ['start_time', '<=', $end_time],
                        ['end_time', '>=', $end_time],
                    ])->Orwhere (
                    [
                        ['start_time', '<=', $start_time],
                        ['end_time', '>=', $start_time],
                    ]);
            })->where ('end_date', $end_date)->where ('leave_type_id', '!=', 212637)->where ('user_id', $requester_id)->where ('status_id', '!=', 171)->select ('start_time')->count ();

        $checkExistHourly = Leave::where (
            function($query) use ($start_date, $end_date) {
                $query->where (
                    [
                        ['start_date', '>=', $start_date],
                        ['end_date', '<=', $end_date],
                    ])->ORwhere (
                    [
                        ['start_date', '<=', $end_date],
                        ['end_date', '>=', $end_date],
                    ])->Orwhere (
                    [
                        ['start_date', '<=', $start_date],
                        ['end_date', '>=', $start_date],
                    ]);


            })->whereNotIn ('leave_type_id', [185872, 375479, 185873, 101883, 50001,212637])->where ('user_id', $requester_id)->where ('status_id', '!=', 171)->select ('start_date')->count ();
        $contract_type = ContractType::join ('users', 'users.contract_type_id', '=', 'contract_types.id')->where ('users.id', $requester_id)->select ('contract_types.*')->first ();
        $contract_start_time = Carbon::parse ($contract_type->start_time)->format ('H:i');
        $contract_end_time = Carbon::parse ($contract_type->end_time)->format ('H:i');

        if ($start_time > $end_time) {
            if ($request->lang == 'en') {
                return 'The end time must be a date after start time';
            } elseif ($request->lang == 'ar') {
                return 'يجب أن يكون وقت النهاية بعد وقت البدء';
            }
        } elseif ($start_time->format ('H:i') < $contract_start_time || $end_time->format ('H:i') > $contract_end_time) {
            if ($request->lang == 'en') {
                return 'Your work day from ' . $contract_start_time . ' to ' . $contract_end_time;
            } elseif ($request->lang == 'ar') {
                return ' يوم عملك من ' . $contract_start_time . ' إلى ' . $contract_end_time;
            }
        } elseif ($checkExist > 0) {
            if ($request->lang == 'en') {
                return 'Please choose another date,This time is already chosen';
            } elseif ($request->lang == 'ar') {
                return 'يرجى اختيار تاريخ آخر ، تم اختيار هذا الوقت مسبقا';
            }
        } elseif ($checkExistHourly > 0) {
            if ($request->lang == 'en') {
                return 'Please choose another date,This time is already chosen';
            } elseif ($request->lang == 'ar') {
                return 'يرجى اختيار تاريخ آخر ، تم اختيار هذا الوقت مسبقا';
            }
        } elseif ($requested_days == 0) {
            if ($request->lang == 'en') {
                return 'The end time must be a date after start time';
            } elseif ($request->lang == 'ar') {
                return 'يجب أن يكون وقت الانتهاء تاريخًا بعد وقت البدء';
            }
        } elseif ($checkExist <= 0) {
            return 'allowed';
        }
    }

    /**
     * @param $request
     * @return string|null
     */
    public function validation_unpaid_leave ($request): ?string
    {
        $data = explode ('to', $request->date_range);
        [$start_date, $end_date] = $data;
        $start_date = Carbon::parse ($start_date);
        $end_date = Carbon::parse ($end_date);
        if (!isset($request->lang)) {
            $request->lang = 'en';
        }
        $requester_id = Auth::id ();
        if ($request->on_behalf_of_id != null) {
            $requester_id = $request->on_behalf_of_id;
        }
        $contract_type = ContractType::join ('users', 'users.contract_type_id', '=', 'contract_types.id')
            ->where ('users.id', $requester_id)->select ('contract_types.name_en', 'contract_types.weekends_included', 'contract_types.holidays_included', 'contract_types.leave_period_id')->first ();
        $requested_days = get_duration_leave_contract_type ($start_date, $end_date, $requester_id, $contract_type->weekends_included, $contract_type->holidays_included);
        $date_exist = Leave::where (
            function($query) use ($start_date, $end_date) {
                $query->where (
                    [
                        ['start_date', '>=', $start_date],
                        ['end_date', '<=', $end_date],
                    ])->ORwhere (
                    [
                        ['start_date', '<=', $end_date],
                        ['end_date', '>=', $end_date],
                    ])->Orwhere (
                    [
                        ['start_date', '<=', $start_date],
                        ['end_date', '>=', $start_date],
                    ]);
            })->where ('user_id', $requester_id)->where ('leave_type_id', '!=', 212637)->where ('status_id', '!=', 171)->select ('start_date')->count ();
        if ($start_date > $end_date) {
            if ($request->lang == 'en') {
                return 'The end date must be a date after start date';
            } elseif ($request->lang == 'ar') {
                return 'يجب أن يكون تاريخ الانتهاء  بعد تاريخ البدء';
            }
        } elseif ($date_exist > 0) {
            if ($request->lang == 'en') {
                return 'Please choose another date,This date is already chosen';
            } elseif ($request->lang == 'ar') {
                return 'يرجى اختيار تاريخ آخر ، تم اختيار هذا التاريخ مسبقاً';
            }
        } elseif ($requested_days == 0) {
            if ($request->lang == 'en') {
                return 'This day is holidays or weekend';
            } elseif ($request->lang == 'ar') {
                return 'هذا اليوم هو يوم عطلة أو عطلة نهاية الأسبوع';
            }
        } elseif ($date_exist == 0) {
            return 'allowed';
        }
    }

    /**
     * @param $request
     * @return string|null
     */
    public function validation_business_leave ($request): ?string
    {
        $data = explode ('to', $request->date_range);
        [$start_date, $end_date] = $data;
        $start_date = Carbon::parse ($start_date);
        $end_date = Carbon::parse ($end_date);
        if (!isset($request->lang)) {
            $request->lang = 'en';
        }
        $requester_id = Auth::id ();
        if ($request->on_behalf_of_id != null) {
            $requester_id = $request->on_behalf_of_id;
        }
        $date_exist = Leave::where (
            function($query) use ($start_date, $end_date) {
                $query->where (
                    [
                        ['start_date', '>=', $start_date],
                        ['end_date', '<=', $end_date],
                    ])->ORwhere (
                    [
                        ['start_date', '<=', $end_date],
                        ['end_date', '>=', $end_date],
                    ])->Orwhere (
                    [
                        ['start_date', '<=', $start_date],
                        ['end_date', '>=', $start_date],
                    ]);
            })->where ('user_id', $requester_id)->where ('leave_type_id', '!=', 212637)->where ('status_id', '!=', 171)->select ('start_date')->count ();
        if ($start_date > $end_date) {
            if ($request->lang == 'en') {
                return 'The end date must be a date after start date';
            } elseif ($request->lang == 'ar') {
                return 'يجب أن يكون تاريخ الانتهاء  بعد تاريخ البدء';
            }
        } elseif ($date_exist > 0) {
            if ($request->lang == 'en') {
                return 'Please choose another date,This date is already chosen';
            } elseif ($request->lang == 'ar') {
                return 'يرجى اختيار تاريخ آخر ، تم اختيار هذا التاريخ مسبقاً';
            }
        } elseif ($date_exist == 0) {
            return 'allowed';
        }
    }

    /**
     * @param $request
     * @return string|null
     */
    public function validation_sick_leave ($request): ?string
    {
        $data = explode ('to', $request->date_range);
        [$start_date, $end_date] = $data;
        $start_date = Carbon::parse ($start_date);
        $end_date = Carbon::parse ($end_date);
        if (!isset($request->lang)) {
            $request->lang = 'en';
        }
        $requester_id = Auth::id ();
        if ($request->on_behalf_of_id != null) {
            $requester_id = $request->on_behalf_of_id;
        }
        $checkExist = Leave::where (
            function($query) use ($start_date, $end_date) {
                $query->where (
                    [
                        ['start_date', '>=', $start_date],
                        ['end_date', '<=', $end_date],
                    ])->ORwhere (
                    [
                        ['start_date', '<=', $end_date],
                        ['end_date', '>=', $end_date],
                    ])->Orwhere (
                    [
                        ['start_date', '<=', $start_date],
                        ['end_date', '>=', $start_date],
                    ]);
            })->where ('user_id', $requester_id)->where ('leave_type_id', '!=', 212637)->where ('status_id', '!=', 171)->select ('start_date')->count ();
        if ($start_date > $end_date) {
            if ($request->lang == 'en') {
                return 'The end date must be a date after start date';
            } elseif ($request->lang == 'ar') {
                return 'يجب أن يكون تاريخ الانتهاء  بعد تاريخ البدء';
            }
        } elseif ($checkExist > 0) {
            if ($request->lang == 'en') {
                return 'Please choose another date,This date is already chosen';
            } elseif ($request->lang == 'ar') {
                return 'يرجى اختيار تاريخ آخر ، تم اختيار هذا التاريخ مسبقاً';
            }

        } elseif ($checkExist == 0) {
            return 'allowed';
        }
    }

    /**
     * @param $request
     * @return string|null
     */
    public function validation_patient_accompanying_leave ($request): ?string
    {
        $data = explode ('to', $request->date_range);
        [$start_date, $end_date] = $data;
        $start_date = Carbon::parse ($start_date);
        $end_date = Carbon::parse ($end_date);
        if (!isset($request->lang)) {
            $request->lang = 'en';
        }
        $requester_id = Auth::id ();
        if ($request->on_behalf_of_id != null) {
            $requester_id = $request->on_behalf_of_id;
        }
        $checkExist = Leave::where (
            function($query) use ($start_date, $end_date) {
                $query->where (
                    [
                        ['start_date', '>=', $start_date],
                        ['end_date', '<=', $end_date],
                    ])->ORwhere (
                    [
                        ['start_date', '<=', $end_date],
                        ['end_date', '>=', $end_date],
                    ])->Orwhere (
                    [
                        ['start_date', '<=', $start_date],
                        ['end_date', '>=', $start_date],
                    ]);
            })->where ('user_id', $requester_id)->where ('leave_type_id', '!=', 212637)->where ('status_id', '!=', 171)->select ('start_date')->count ();
        if ($start_date > $end_date) {
            if ($request->lang == 'en') {
                return 'The end date must be a date after start date';
            } elseif ($request->lang == 'ar') {
                return 'يجب أن يكون تاريخ الانتهاء  بعد تاريخ البدء';
            }
        } elseif ($checkExist > 0) {
            if ($request->lang == 'en') {
                return 'Please choose another date,This date is already chosen';
            } elseif ($request->lang == 'ar') {
                return 'يرجى اختيار تاريخ آخر ، تم اختيار هذا التاريخ مسبقاً';
            }

        } elseif ($checkExist == 0) {
            return 'allowed';
        }
    }

    /**
     * @param $request
     * @return string|null
     */
    public function validation_motherhood_leave ($request): ?string
    {
        $data = explode ('to', $request->date_range);
        [$start_date, $end_date] = $data;
        $start_date = Carbon::parse ($start_date);
        $end_date = Carbon::parse ($end_date);
        $date_diff = $end_date->diffInDays ($start_date);
        $requester_id = Auth::id ();
        if ($request->on_behalf_of_id != null) {
            $requester_id = $request->on_behalf_of_id;

        }
        if (!isset($request->lang)) {
            $request->lang = 'en';
        }
        $start_date_work = $start_time = Carbon::parse (Auth::user ()->start_date)->addYear (1);
        $contract_type = ContractType::join ('users', 'users.contract_type_id', '=', 'contract_types.id')->where ('users.id', Auth::id ())->select ('contract_types.*')->first ();
        if (Carbon::now () >= $start_date_work) {
            $count_of_date = $contract_type->more_than_year;
        } else {
            $count_of_date = $contract_type->less_than_year;
        }
        $date_exist = Leave::where (
            function($query) use ($start_date, $end_date) {
                $query->where (
                    [
                        ['start_date', '>=', $start_date],
                        ['end_date', '<=', $end_date],
                    ])->ORwhere (
                    [
                        ['start_date', '<=', $end_date],
                        ['end_date', '>=', $end_date],
                    ])->Orwhere (
                    [
                        ['start_date', '<=', $start_date],
                        ['end_date', '>=', $start_date],
                    ]);
            })->where ('user_id', $requester_id)->where ('leave_type_id', '!=', 212637)->where ('status_id', '!=', 171)->select ('start_date')->count ();

        if ($start_date > $end_date) {
            if ($request->lang == 'en') {
                return 'The end date must be a date after start date';
            } elseif ($request->lang == 'ar') {
                return 'يجب أن يكون تاريخ الانتهاء  بعد تاريخ البدء';
            }
        } elseif ($count_of_date < $date_diff) {
            if ($request->lang == 'en') {
                return 'Maternity leave only ' . $count_of_date . ' days';
            } elseif ($request->lang == 'ar') {
                return 'إجازة الأمومة فقط ' . $count_of_date . ' يوم ';
            }
        } elseif ($date_exist > 0) {
            if ($request->lang == 'en') {
                return 'Please choose another date,This date is already chosen';
            } elseif ($request->lang == 'ar') {
                return 'يرجى اختيار تاريخ آخر ، تم اختيار هذا التاريخ مسبقاً';
            }

        } elseif ($date_exist == 0) {
            return 'allowed';
        }
    }

    /**
     * @param $request
     * @return string|null
     */
    public function validation_nursing_leave ($request): ?string
    {
        $data = explode ('to', $request->date_range);
        [$start_date, $end_date] = $data;
        $start_date = Carbon::parse ($start_date);
        $end_date = Carbon::parse ($end_date);
        $start_date_carbon = Carbon::parse ($start_date);
        $requester_id = Auth::id ();
        if ($request->on_behalf_of_id != null) {
            $requester_id = $request->on_behalf_of_id;

        }
        if (!isset($request->lang)) {
            $request->lang = 'en';
        }
        $date_exist = Leave::where (
            function($query) use ($start_date, $end_date) {
                $query->where (
                    [
                        ['start_date', '>=', $start_date],
                        ['end_date', '<=', $end_date],
                    ])->ORwhere (
                    [
                        ['start_date', '<=', $end_date],
                        ['end_date', '>=', $end_date],
                    ])->Orwhere (
                    [
                        ['start_date', '<=', $start_date],
                        ['end_date', '>=', $start_date],
                    ]);
            })->where ('user_id', $requester_id)->where ('status_id', '!=', 171)->where ('leave_type_id', 212637)->select ('start_date')->count ();

        $start_date_carbon->addYear (1);
        if ($start_date > $end_date) {
            if ($request->lang == 'en') {
                return 'The end date must be a date after start date';
            } elseif ($request->lang == 'ar') {
                return 'يجب أن يكون تاريخ الانتهاء  بعد تاريخ البدء';
            }
        } elseif ($end_date > $start_date_carbon) {
            if ($request->lang == 'en') {
                return 'Nursing leave only 12 months';
            } elseif ($request->lang == 'ar') {
                return 'إجازة التمريض فقط 12 شهرًا';
            }
        } elseif ($date_exist > 0) {
            if ($request->lang == 'en') {
                return 'Please choose another date,This date is already chosen';
            } elseif ($request->lang == 'ar') {
                return 'يرجى اختيار تاريخ آخر ، تم اختيار هذا التاريخ مسبقاً';
            }
        } elseif ($date_exist == 0) {
            return 'allowed';
        }
    }

    /**
     * @param $request
     * @return string|null
     */
    public function validation_fatherhood_leave ($request): ?string
    {
        $data = explode ('to', $request->date_range);
        [$start_date, $end_date] = $data;
        $start_date = Carbon::parse ($start_date);
        $end_date = Carbon::parse ($end_date);
        $datetime1 = Carbon::parse ($start_date);
        $datetime2 = Carbon::parse ($end_date);
        if (!isset($request->lang)) {
            $request->lang = 'en';
        }
//        $all_days= $duration_days = $datetime1->diff($datetime2)->days;
        $all_days = get_duration_leave_contract_type ($datetime1, $datetime2, Auth::id (), false, false);
//        echo $all_days;
        $requester_id = Auth::id ();
        if ($request->on_behalf_of_id != null) {
            $requester_id = $request->on_behalf_of_id;

        }

        $start_date_exist = 0;
        $end_date_exist = 0;

//        $start_date_exist = Leave::where('start_date', $start_date)->where('user_id', $requester_id)->where('status_id', '!=', 171)->select('start_date')->count();
//        $end_date_exist   = Leave::where('end_date', $end_date)->where('user_id', $requester_id)->where('status_id', '!=', 171)->select('end_date')->count();

        $date_exist = Leave::where (
            function($query) use ($start_date, $end_date) {
                $query->where (
                    [
                        ['start_date', '>=', $start_date],
                        ['end_date', '<=', $end_date],
                    ])->ORwhere (
                    [
                        ['start_date', '<=', $end_date],
                        ['end_date', '>=', $end_date],
                    ])->Orwhere (
                    [
                        ['start_date', '<=', $start_date],
                        ['end_date', '>=', $start_date],
                    ]);
            })->where ('user_id', $requester_id)->where ('status_id', '!=', 171)->where ('leave_type_id', '!=', 212637)->select ('start_date')->count ();
        if ($start_date > $end_date) {
            if ($request->lang == 'en') {
                return 'The end date must be a date after start date';
            } elseif ($request->lang == 'ar') {
                return 'يجب أن يكون تاريخ الانتهاء  بعد تاريخ البدء';
            }
        } elseif ($date_exist > 0) {
            if ($request->lang == 'en') {
                return 'Please choose another date,This date is already chosen';
            } elseif ($request->lang == 'ar') {
                return 'يرجى اختيار تاريخ آخر ، تم اختيار هذا التاريخ مسبقاً';
            }

        } elseif ($all_days > 5) {
            if ($request->lang == 'en') {
                return 'Can not be more than 5 days';
            } elseif ($request->lang == 'ar') {
                return 'لا يمكن أن يكون أكثر من 5 أيام';
            }

        } elseif ($date_exist == 0) {
            return 'allowed';
        }
    }

    /**
     * @param $request
     * @return string|null
     */
    public function validation_wedding_leave ($request): ?string
    {
        $data = explode ('to', $request->date_range);
        [$start_date, $end_date] = $data;
        $start_date = Carbon::parse ($start_date);
        $end_date = Carbon::parse ($end_date);
        if (!isset($request->lang)) {
            $request->lang = 'en';
        }

        $datetime1 = Carbon::parse ($start_date);
        $datetime2 = Carbon::parse ($end_date);
        $all_days = $duration_days = $datetime1->diff ($datetime2)->days;
        $requester_id = Auth::id ();
        if ($request->on_behalf_of_id != null) {
            $requester_id = $request->on_behalf_of_id;

        }
        $date_exist = Leave::where (
            function($query) use ($start_date, $end_date) {
                $query->where (
                    [
                        ['start_date', '>=', $start_date],
                        ['end_date', '<=', $end_date],
                    ])->ORwhere (
                    [
                        ['start_date', '<=', $end_date],
                        ['end_date', '>=', $end_date],
                    ])->Orwhere (
                    [
                        ['start_date', '<=', $start_date],
                        ['end_date', '>=', $start_date],
                    ]);
            })->where ('user_id', $requester_id)->where ('leave_type_id', '!=', 212637)->where ('status_id', '!=', 171)->select ('start_date')->count ();
        $date_wedding = Leave::where ('user_id', $requester_id)->where ('leave_type_id', 55160)->where ('status_id', '!=', 171)->select ('start_date')->count ();
        if ($start_date > $end_date) {
            if ($request->lang == 'en') {
                return 'The end date must be a date after start date';
            } elseif ($request->lang == 'ar') {
                return 'يجب أن يكون تاريخ الانتهاء  بعد تاريخ البدء';
            }
        } elseif ($date_exist > 0) {
            if ($request->lang == 'en') {
                return 'Please choose another date,This date is already chosen';
            } elseif ($request->lang == 'ar') {
                return 'يرجى اختيار تاريخ آخر ، تم اختيار هذا التاريخ مسبقاً';
            }
        } elseif ($date_wedding > 0) {
            if ($request->lang == 'en') {
                return 'Wedding leave request cann\'t be more than once';
            } elseif ($request->lang == 'ar') {
                return 'لا يمكن أن يكون طلب إجازة زواج أكثر من مرة';
            }

        } elseif ($all_days + 1 > 3) {
            if ($request->lang == 'en') {
                return 'Can not be more than 3 days';
            } elseif ($request->lang == 'ar') {
                return 'لا يمكن أن يكون أكثر من 3 أيام';
            }

        } elseif ($date_exist == 0) {
            return 'allowed';
        }
    }

    /**
     * @param $request
     * @return string|null
     */
    public function validation_death_leave ($request): ?string
    {
        $data = explode ('to', $request->date_range);
        [$start_date, $end_date] = $data;
        $start_date = Carbon::parse ($start_date);
        $end_date = Carbon::parse ($end_date);
        if (!isset($request->lang)) {
            $request->lang = 'en';
        }

        $datetime1 = Carbon::parse ($start_date);
        $datetime2 = Carbon::parse ($end_date);
        $all_days = $duration_days = $datetime1->diff ($datetime2)->days;
        $requester_id = Auth::id ();
        if ($request->on_behalf_of_id != null) {
            $requester_id = $request->on_behalf_of_id;
        }
        $start_date_exist = 0;
        $end_date_exist = 0;
//        $start_date_exist = Leave::where('start_date', $start_date)->where('user_id', $requester_id)->where('status_id', '!=', 171)->select('start_date')->count();
//        $end_date_exist   = Leave::where('end_date', $end_date)->where('user_id', $requester_id)->where('status_id', '!=', 171)->select('end_date')->count();

        $date_exist = Leave::where (
            function($query) use ($start_date, $end_date) {
                $query->where (
                    [
                        ['start_date', '>=', $start_date],
                        ['end_date', '<=', $end_date],
                    ])->ORwhere (
                    [
                        ['start_date', '<=', $end_date],
                        ['end_date', '>=', $end_date],
                    ])->Orwhere (
                    [
                        ['start_date', '<=', $start_date],
                        ['end_date', '>=', $start_date],
                    ]);
            })->where ('user_id', $requester_id)->where ('leave_type_id', '!=', 212637)->where ('status_id', '!=', 171)->select ('start_date')->count ();
        if ($start_date > $end_date) {
            if ($request->lang == 'en') {
                return 'The end date must be a date after start date';
            } elseif ($request->lang == 'ar') {
                return 'يجب أن يكون تاريخ الانتهاء  بعد تاريخ البدء';
            }
        } elseif ($date_exist > 0) {
            if ($request->lang == 'en') {
                return 'Please choose another date,This date is already chosen';
            } elseif ($request->lang == 'ar') {
                return 'يرجى اختيار تاريخ آخر ، تم اختيار هذا التاريخ مسبقاً';
            }

        } elseif ($all_days + 1 > 3) {
            if ($request->lang == 'en') {
                return 'Can not be more than 3 days';
            } elseif ($request->lang == 'ar') {
                return 'لا يمكن أن يكون أكثر من 3 أيام';
            }

        } elseif ($date_exist == 0) {
            return 'allowed';
        }
    }

}
