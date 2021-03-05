<?php

use Carbon\Carbon;
use App\Model\Hr\User;
use App\Model\Leave\Leave;
use App\Model\Hr\Fingerprint;
use App\Model\Service\Service;
use App\Model\Service\ServiceItem;
use App\Model\Payroll\PayrollRecord;
use App\Model\Service\ServiceInvoice;
use App\Model\ControlPanel\Hr\Weekend;
use App\Model\ControlPanel\Hr\Holiday;
use Illuminate\Database\Eloquent\Builder;
use App\Model\Payroll\PayrollReportRecord;
use App\Model\ControlPanel\Project\Category;
use Illuminate\Database\Eloquent\Collection;
use App\Model\Project\DetailedProposalBudget;
use App\Model\ControlPanel\Project\CategoryOption;


/**
 * @param $start_date
 * @param $end_date
 * @return string
 */
function get_duration ($start_date, $end_date)
{
    $start = Carbon::parse ($start_date);
    $end = Carbon::parse ($end_date);
    $interval = $start->diff ($end);
    return $interval->format ('%y years %m months and %d days');
}


/**
 * @param $model
 * @param null $id
 * @param array $users
 * @return array
 */
function get_all_children ($model, $id = null, &$users = [])
{
    // Find subcategory IDs
    $get_users = $model::where ('parent_id', $id)->where ('disabled', 0)->get ();
    // Add each ID to the list and recursively find other subcategory IDs
    foreach ($get_users as $user) {
        $users[] = $user;
        get_all_children ($model, $user->id, $users);
    }
    return $users;
}

/**
 * @param $id
 * @return Builder[]|Collection
 */
function usersOnLevel ($id)
{
    return User::where ('parent_id', usersOnLevel ($id))->get ();
}

/**
 * @param $id
 * @param int $service_id
 * @return float|int|mixed
 */
function availability ($id, $service_id = 0)
{
    $budget = DetailedProposalBudget::find ($id);
    $total = ($budget->duration * $budget->unit_cost * $budget->chf * $budget->quantity) / 100;
    $total_item = 0;
    $services = ServiceItem::where ('detailed_proposal_budget_id', $budget->id)->where ('service_id', '!=', $service_id)->select ('service_id')->groupBy ('service_id')->get ();
    foreach ($services as $service) {
        if ($service->service->status_id_id != 171 && !$service->service->completed) {
            $service->code;
            $service_item = ServiceItem::where ('detailed_proposal_budget_id', $budget->id)->where ('service_id', $service->service_id)->get ();
            foreach ($service_item as $key => $item) {
                if ($item->exchange_rate) {
                    $total_item += ($item->quantity * $item->unit_cost) / $item->exchange_rate;
                } else {
                    $total_item += ($item->quantity * $item->unit_cost);
                }
            }
        } elseif ($service->service->status_id_id != 171 && $service->service->completed) {
            foreach (Service::where ('parent_id', $service->service_id)->get () as $key => $children) {
                if ($children->status_id_id == 170) {
                    $service_invoices = ServiceInvoice::where ('detailed_proposal_budget_id', $budget->id)->where ('service_id', $children->id)->get ();
                    foreach ($service_invoices as $service_invoice) {
                        if ($children->user_exchange_rate) {
                            $total_item += (($service_invoice->quantity * $service_invoice->unit_cost) / $service_invoice->exchange_rate) / $children->user_exchange_rate;
                        } else {
                            $total_item += ($service_invoice->quantity * $service_invoice->unit_cost) / $service_invoice->exchange_rate;
                        }
                    }
                } elseif ($children->status_id_id == 174) {
                    $service_item = ServiceItem::where ('detailed_proposal_budget_id', $budget->id)->where ('service_id', $service->service_id)->get ();
                    foreach ($service_item as $item) {
                        if ($item->exchange_rate) {
                            $total_item += ($item->quantity * $item->unit_cost) / $item->exchange_rate;
                        } else {
                            $total_item += ($item->quantity * $item->unit_cost);
                        }
                    }
                }

            }
        }
    }
    $salary = PayrollRecord::where ('detailed_proposal_budget_id', $id)->where ('status_id', true)->get ();
    $salary_2 = PayrollReportRecord::where ('detailed_proposal_budget_id', $id)->get ();
    $total_salary = 0;
    $total_salary_2 = 0;
    foreach ($salary as $key => $value) {
        $total_salary += $value->salary + $value->management_allowance + $value->transportation_allowance + $value->house_allowance + $value->cell_phone_allowance + $value->cost_of_living_allowance + $value->fuel_allowance + $value->appearance_allowance + $value->work_nature_allowance;
    }
    foreach ($salary_2 as $key => $value) {
        $total_salary_2 += $value->salary + $value->management_allowance + $value->transportation_allowance + $value->house_allowance + $value->cell_phone_allowance + $value->cost_of_living_allowance + $value->fuel_allowance + $value->appearance_allowance + $value->work_nature_allowance;
    }
    return $total - ($total_item + $total_salary + $total_salary_2);
}

/**
 * @param $id
 * @param $month
 * @param $user_id
 * @return bool|mixed
 */
function salary_month ($id, $month, $user_id)
{

    $salary = PayrollRecord::where ('user_id', $user_id)->where ('detailed_proposal_budget_id', $id)->where ('month', $month)->first ();
    if (is_null ($salary)) {
        return true;
    }
    return $salary->status_id;
}

function getHourly ($start, $end)
{
    $starttime = Carbon::parse ($start);
    $endtime = Carbon::parse ($end);
    $totalMinutesDuration = $endtime->diffInSeconds ($starttime);
    return gmdate ('H:i', $totalMinutesDuration);

}

/**
 * @param $start
 * @param $end
 * @param $user_id
 * @param $type
 * @return array
 * @throws Exception
 */
function work_hours ($start, $end, $user_id, $type)
{
    $in = null;
    $first_in = null;
    $out = null;
    $last_out = null;
    $time = 0;
    $time_of_leave = 0;
    $start = Carbon::parse ($start);
    $end = Carbon::parse ($end);
    $start_2 = Carbon::parse ($start);
    $end_2 = Carbon::parse ($end);
    $start_3 = Carbon::parse ($start);
    $end_3 = Carbon::parse ($end);

    if ($start_2->format ('Y-m-d') == $end_2->format ('Y-m-d')) {
        $fingerprint = Fingerprint::where ('user_id', $user_id)->whereDate ('time', $start_2->format ('Y-m-d'))->orderBy ('time')->get ();
    } else {
        $fingerprint = Fingerprint::where ('user_id', $user_id)->whereBetween ('time', [$start_2->subHours (4), $end_2->addHours (4)])->orderBy ('time')->get ();
    }

    foreach ($fingerprint as $k => $v) {

        if (trim ($v->state) == 'Check in' && is_null ($in)) {

            if (is_null ($first_in)) {
                $first_in =Carbon::parse ($v->time);
            }
            $in = $v->time;
        }
        if (trim ($v->state) == 'Check out' && is_null ($out)) {
            $out = $v->time;
            $last_out = Carbon::parse ($v->time);
        }

        if (!is_null ($in) && !is_null ($out)) {
            $in = new Carbon($in);
            $out = new Carbon($out);
            $time += $in->diffInSeconds  ($out);

            $in = null;
            $out = null;
        }
    }
    if (!is_null ($last_out)) {
        if ($last_out > $end_3->addMinutes (30)){
            $time -= $end_3->diffInSeconds  ($last_out);
        }
        $last_out=  $last_out->format('Y-m-d h:i a');
    }
    if (!is_null ($first_in)) {
        if ($first_in < $start_3->subMinutes (30)){
            $time -=$first_in->diffInSeconds  ($start_3);
        }
        $first_in=  $first_in->format('Y-m-d h:i a');
    }
if ($start->diffInSeconds($end) > $time &&( !is_null ($first_in) && !is_null ($last_out))  ){
    $start_time=$start->format ('H:i');
    $end_time=$end->format ('H:i');
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
        })->where ('end_date', $end)->where ('user_id', $user_id)->whereNotNull  ('start_time')->where ('status_id', '!=', 171)->select ('start_time','end_time')->get ();
    foreach ($checkExist as $k=>$v){
        $start_3 = Carbon::parse ($v->start_time);
        $end_3 = Carbon::parse ($v->end_time);
        $time_of_leave+=$start_3->diffInSeconds($end_3);
    }
    if (($start->diffInSeconds($end) < ($time+$time_of_leave ) )&& $time_of_leave!=0 ){
        $type=['b'=>'اجازة ساعية'];

    }else{
        $type=['a'=>'متأخر'];
    }
}
if ((is_null ($last_out) && !is_null ($last_out)) || ((!is_null ($last_out) && is_null ($last_out)) )){
    $type=['a'=>'خطأ بصمة'];
}
    if (is_null ($first_in) && is_null ($last_out)) {
        $check_leave = Leave::where (
            function($query) use ($start, $end) {
                $query->where (
                    [
                        ['start_date', '>=', $start->format ('Y-m-d')],
                        ['end_date', '<=', $end->format ('Y-m-d')],
                    ])->ORwhere (
                    [
                        ['start_date', '<=', $end->format ('Y-m-d')],
                        ['end_date', '>=', $end->format ('Y-m-d')],
                    ])->Orwhere (
                    [
                        ['start_date', '<=', $start->format ('Y-m-d')],
                        ['end_date', '>=', $start->format ('Y-m-d')],
                    ]);
            })->where ('user_id', $user_id)->whereNull ('start_time')->where ('status_id', '!=', 171)->first ();
        if (!is_null ($check_leave)){
            $type = ['b' => "اجازة يومية"];
        }elseif($start!=$end){
            $type=['c'=>'غياب'];
        }
    }

//if (is_null ($last_out) && is_null ($last_out)){
////    $fingerprint = Leave::where ('user_id', $user_id)->where ('start_date', [$start, $end])->orderBy ('time')->get ();
//    $type=['c'=>'غياب'];
//}
    return ['time' =>$time, 'entry' =>$first_in, 'exit' =>$last_out, 'type' => $type ];
}

function AddPlayTime ($oldPlayTime, $PlayTimeToAdd)
{
    $old = explode (":", $oldPlayTime);
    $play = explode (":", $PlayTimeToAdd);
    $hours = $old[0] + $play[0];
    $minutes = $old[1] + $play[1];
    if ($minutes > 59) {
        $minutes = $minutes - 60;
        $hours++;
    }
    if ($minutes < 10) {
        $minutes = "0" . $minutes;
    }
    if ($minutes == 0) {
        $minutes = "00";
    }
    $sum = $hours . ":" . $minutes;
    return $sum;
}

/**
 * @param $line
 * @param int $project_id
 * @return float|int
 */
function availability_with_project_id ($line, $project_id = 0)
{
    $budget = DetailedProposalBudget::Where ('budget_line', "$line")->Where ('project_id', "$project_id")->first ();
    $total = ($budget->duration * $budget->unit_cost * $budget->chf * $budget->quantity) / 100;
    $total_item = 0;
    $services = ServiceItem::where ('detailed_proposal_budget_id', $budget->id)->select ('service_id')->groupBy ('service_id')->get ();
    foreach ($services as $service) {
        if ($service->service->status_id_id != 171 && !$service->service->completed) {
            $service->code;
            $service_item = ServiceItem::where ('detailed_proposal_budget_id', $budget->id)->where ('service_id', $service->service_id)->get ();
            foreach ($service_item as $key => $item) {
                if ($item->exchange_rate) {
                    $total_item += ($item->quantity * $item->unit_cost) / $item->exchange_rate;
                } else {
                    $total_item += ($item->quantity * $item->unit_cost);
                }
            }
        } elseif ($service->service->status_id_id != 171 && $service->service->completed) {
            foreach ($service->service->children as $key => $children) {
                $service_invoices = ServiceInvoice::where ('detailed_proposal_budget_id', $budget->id)->where ('service_id', $children->id)->get ();
                foreach ($service_invoices as $service_invoice) {
                    if ($children->user_exchange_rate) {
                        $total_item += (($service_invoice->quantity * $service_invoice->unit_cost) / $service_invoice->exchange_rate) / $children->user_exchange_rate;
                    } else {
                        $total_item += ($service_invoice->quantity * $service_invoice->unit_cost) / $service_invoice->exchange_rate;
                    }
                }
            }
        }

    }
    return $total - $total_item;

}

/**
 * @param int $id
 * @return float|int
 */
function availability_with_service_id ($id = 0)
{
    $service_item = ServiceItem::find ($id);
    $total = $service_item->quantity * $service_item->unit_cost;
    $total_item = 0;
    $service_invoices = ServiceInvoice::where ('service_item_id', $id)->get ();
    foreach ($service_invoices as $service_invoice) {
        $total_item += (($service_invoice->quantity * $service_invoice->unit_cost) / $service_invoice->exchange_rate);
    }
    return $total - $total_item;


}

/**
 * @param $line
 * @param int $project_id
 * @return mixed
 */
function get_budget_id ($line, $project_id = 0)
{
    $budget = DetailedProposalBudget::Where ('budget_line', "$line")->Where ('project_id', "$project_id")->first ();
    return $budget->id;

}

/**
 * @param int $budget_category_id
 * @return array
 */
function category_options ($budget_category_id = 0)
{
    $id = Category::where ('budget_category_id', $budget_category_id)->first ()->id;
    $select_box_data = CategoryOption::select (['id', 'name_en']);
    $collection = collect ($select_box_data->where ('category_id', $id)->orderBy ('name_en')->get ());

    $select_box_data = $collection->mapWithKeys (function($item) {
        return [$item['id'] => $item['name_en']];
    });

    $select_box_data->prepend (trans ('common.please_select'), '');

    return $select_box_data->all ();

}

function getDurationLeaveRequest ($start_date, $end_date)
{
    $datetime1 = Carbon::parse ($start_date);
    $datetime2 = Carbon::parse ($end_date);
    $duration_days = $datetime1->diff ($datetime2)->days;
    return $duration_days + 1;
}

function getDurationLeaveRequestWithoutWeekends ($start_date, $end_date, $user_id)
{
    $i = 0;
    $dates = [];
    $dates_holiday = [];
    $datetime1 = Carbon::parse ($start_date);
    $datetime2 = Carbon::parse ($end_date);
    $from_date = new DateTime($start_date);
    $to_date = new DateTime($end_date);
    $duration_days = $datetime1->diff ($datetime2)->days;
    // $day_name= Carbon::parse($start_date)->format('l');

    $days = \App\Weekend::join ('contract_types', 'contract_types.weekendid', '=', 'weekends.weekendid')
        ->join ('empstructures', 'users.contract_type_id', '=', 'contract_types.contracttypeid')
        ->join ('users', 'users.id', '=', 'empstructures.user_id')->where ('users.id', $user_id)->select ('weekends.days')->first ();
    $day_name = json_decode ($days->days, true);


    // $contract_type = \App\Contracttype::join('empstructures', 'users.contract_type_id', '=', 'contract_types.contracttypeid')
    // ->join('users', 'users.id', '=', 'empstructures.user_id')->where('users.id',$user_id)->select('contract_types.nameen')->first();
    // $contract_type->nameen;

    $holiday_days = Holiday::join ('contract_types', 'contract_types.holidayid', '=', 'holiday.holidayid')
        ->join ('empstructures', 'users.contract_type_id', '=', 'contract_types.contracttypeid')
        ->join ('users', 'users.id', '=', 'empstructures.user_id')->where ('users.id', $user_id)->select ('holiday.days')->first ();
    $holiday_date = json_decode ($holiday_days->days, true);

    for ($date = $from_date; $date <= $to_date; $date->modify ('+1 day')) {

        $dates['date'] = $date->format ('l');
        $dates_holiday['date'] = $date->format ('Y-m-d');

        if (in_array ($dates_holiday['date'], $holiday_date)) {

            $i++;

        } elseif (in_array ($dates['date'], $day_name)) {

            $i++;


        }


    }

    return ($duration_days - $i) + 1;

}//
function get_duration_leave_contract_type ($start_date, $end_date, $user_id, $weekends_included, $holidays_included)
{
    $weekend = 0;
    $holiday = 0;
    $dates = [];
    $star_date = Carbon::parse ($start_date);
    $end_date = Carbon::parse ($end_date);
    $duration_days = $end_date->diffInDays ($star_date) + 1;
    if ($weekends_included != true) {
        $days = Weekend::join ('contract_types', 'contract_types.weekend_id', '=', 'weekends.id')
            ->join ('users', 'users.contract_type_id', '=', 'contract_types.id')
            ->where ('users.id', $user_id)->select ('weekends.days')->first ();
        $day_name = json_decode ($days->days, true);
        for ($date = $star_date; $date <= $end_date; $date->addDay ()) {
            $dates['date'] = $date->format ('l');
            if (in_array ($dates['date'], $day_name)) {
                $weekend++;
            }
        }
        $duration_days -= ($weekend);
    }

    if ($holidays_included != true) {
        $holiday_days = Holiday::join ('contract_types', 'contract_types.holiday_id', '=', 'holidays.id')
            ->join ('users', 'users.contract_type_id', '=', 'contract_types.id')
            ->where ('users.id', $user_id)->select ('holidays.days')->first ();

        $holiday_date = json_decode ($holiday_days->days, true);
        for ($date = $star_date; $date <= $end_date; $date->addDay ()) {
            $dates['date'] = $date->format ('Y-m-d');
            if (in_array ($dates['date'], $holiday_date, true)) {
                $holiday++;
            }
        }
        $duration_days -= ($holiday);
    }
    return $duration_days;

}

function check_for_holidays ($start_date, $end_date, $user_id, $weekends_included, $requested_days = 0)
{
    $numberofhours = \Auth::user ()->number_of_hours;
    $weekend = 0;
    $dates = [];
    $start_date = Carbon::parse ($start_date);
    $end_date = Carbon::parse ($end_date);
    $duration_days = $end_date->diffInDays ($start_date) + 1;
    if ($weekends_included == true) {
        $days = Weekend::join ('contract_types', 'contract_types.weekend_id', '=', 'weekends.id')
            ->join ('users', 'users.contract_type_id', '=', 'contract_types.id')
            ->where ('users.id', $user_id)->select ('weekends.days')->first ();
        $day_name = json_decode ($days->days, true);
        $count = count ($day_name);
        $yesterday_name = $start_date->subDay ()->format ('l');
        if (in_array ($yesterday_name, $day_name, true)) {
            $start_date->subDays ($count)->format ('l');
            $start_date->toDateString ();
            if ($requested_days == 0) {
                $checkExistDateStart = Leave::whereDate ('end_date', $start_date)->where ('user_id', $user_id)->where ('status_id', '!=', 171)->where ('leave_type_id', 50000)->count ();
                if ($checkExistDateStart != 0) {
                    $weekend += $count;
                }
            }
            $checkExistTimeStart = Leave::whereDate ('end_date', $start_date)->where ('user_id', $user_id)->where ('status_id', '!=', 171)->where ('leave_type_id', 50001)->sum ('leave_days');
            if (($checkExistTimeStart + $requested_days) >= 0.875) {
                $checkExistDateStart = Leave::whereDate ('end_date', $start_date)->where ('user_id', $user_id)->where ('status_id', '!=', 171)->where ('leave_type_id', 50000)->count ();
                if ($checkExistDateStart != 0) {
                    $weekend += $count;
                }
            }
        }
        $tomorrow_name = $end_date->modify ('+1 day')->format ('l');
        if (in_array ($tomorrow_name, $day_name, true)) {
            $end_date->modify ('+' . $count . ' day');
            $end_date->toDateString ();
            if ($requested_days == 0) {
                $checkExistEnd = Leave::whereDate ('start_date', $end_date)->where ('user_id', $user_id)->where ('status_id', '!=', 171)->where ('leave_type_id', 50000)->count ();
                if ($checkExistEnd != 0 && $requested_days == 0) {
                    $weekend += $count;
                }
            }
            $checkExistTimeEnd = Leave::whereDate ('start_date', $end_date)->where ('user_id', $user_id)->where ('status_id', '!=', 171)->where ('leave_type_id', 50001)->sum ('leave_days');
            if (($checkExistTimeEnd + $requested_days) >= 0.875) {
                $checkExistEnd = Leave::whereDate ('start_date', $end_date)->where ('user_id', $user_id)->where ('status_id', '!=', 171)->where ('leave_type_id', 50000)->count ();
                if ($checkExistEnd != 0 && $requested_days == 0) {
                    $weekend += $count;
                }
            }
        }
    }
    return $weekend;
}//
function getDurationLeaveRequestWithoutHolidays ($start_date, $end_date, $user_id)
{
    $i = 0;
    $dates_holiday = [];
    $datetime1 = Carbon::parse ($start_date);
    $datetime2 = Carbon::parse ($end_date);
    $from_date = new DateTime($start_date);
    $to_date = new DateTime($end_date);
    $duration_days = $datetime1->diff ($datetime2)->days;
    // $day_name= Carbon::parse($start_date)->format('l');


    $holiday_days = Holiday::join ('contract_types', 'contract_types.holiday_id', '=', 'holidays.id')
        ->join ('users', 'users.contract_type_id', '=', 'contract_types.id')
        ->where ('users.id', $user_id)->select ('holidays.days')->first ();
    $holiday_date = json_decode ($holiday_days->days, true);

    for ($date = $from_date; $date <= $to_date; $date->modify ('+1 day')) {

        $dates_holiday['date'] = $date->format ('Y-m-d');

        if (in_array ($dates_holiday['date'], $holiday_date, true)) {

            $i++;

        }


    }

    return ($duration_days - $i) + 1;

}
