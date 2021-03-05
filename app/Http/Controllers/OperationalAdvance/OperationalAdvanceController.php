<?php

namespace App\Http\Controllers\OperationalAdvance;

use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Http\Resources\OperationalAdvance\OperationalAdvanceCollection;
use App\Model\Currency;
use App\Model\Hr\User;
use App\Model\NotificationCycle;
use App\Model\NotificationReceiver;
use App\Model\NotificationType;
use App\Model\Project\Project;
use App\Model\ProjectNotification;
use App\Model\ProjectNotificationStructure;
use App\Model\Service\OperationalAdvance;
use App\Model\Service\OperationalAdvanceInvoice;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class OperationalAdvanceController
 * @package App\Http\Controllers\OperationalAdvance
 */
class OperationalAdvanceController extends Controller
{


    //
    /**
     * @return View
     */
    public function index () : View
    {

        return view ('layouts.operational_advance.index');
    }
    //

    /**
     * @param $id
     * @return Factory|RedirectResponse|Redirector|View
     */
    public function show ($id)
    {
        $this->data['check_notification'] = ProjectNotification::where ('url_id', $id)->where ('receiver', Auth::id ())->where ('status_id', $this->in_progress)->first ();
        if(is_null ($this->data['check_notification'])) {
            return redirect ('home');
        }
       $this->data['service']= OperationalAdvance::find($id);
        return view ('layouts.operational_advance.show',$this->data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function get_all (Request $request): JsonResponse
    {
        $page = $request->input ('pagination.page');
        $search = $request->input ('query.generalSearch', null);
        $per_page = $request->input ('pagination.perpage', 10);
        $sortOrder = $request->input ('sort.sort', 'asc');
        $sortField = $request->input ('sort.field', 'id');
        $offset = ($page - 1) * $per_page;
        $query = OperationalAdvance::with ('project', 'currency', 'status', 'user_recipient');
        if(!is_null ($search)) {
            $query->where (function ($query) use ($search) {
                $query->whereHas ('project', function ($query) use ($search) {
                    $query->where ('name_en', 'ILIKE', "%$search%");
                })->orWhereHas ('currency', function ($query) use ($search) {
                    $query->where ('name_en', 'ILIKE', "%$search%");
                });
                $query->orwhere ('code', 'ILIKE', "%$search%");
            });
        }
        if(isset($request->start_date)) {
            $query->whereDate ('created_at', '>=', $request->start_date);
        }
        if(isset($request->end_date)) {
            $query->whereDate ('created_at', '<=', $request->end_date);
        }
        if(isset($request->max_total)) {
            $query->where ('total_currency', '<=', $request->max_total);
        }
        if(isset($request->min_total)) {
            $query->where ('total_currency', '>=', $request->min_total);
        }
        $totalCount = $query->count ();
        $query->offset ($offset)
            ->limit ($per_page)
            ->orderBy ($sortField, $sortOrder);
        $data = $query->get ();
        $request->offsetSet ('pages', ceil ($totalCount / $per_page));
        $request->offsetSet ('total', $totalCount);
        return $this->resources (new OperationalAdvanceCollection($data));
    }
    /**
     * @return View
     */
    public function create () : View
    {
        $this->data['projects'] = Project::orderBy ('name_en')
            ->join ('project_responsibilities', 'project_responsibilities.project_id', '=', 'projects.id')
            ->where ('project_responsibilities.project_manager', Auth::user ()->id)
            ->orWhere ('project_responsibilities.project_officer', 'like', '%' . Auth::user ()->id . '%')
            ->select (['projects.id','projects.name_en'])
            ->get ();
        $this->data['currencies'] = Currency::orderBy ('name_en')->get ();
        $this->data['recipients'] = User::select (['id', 'first_name_en', 'last_name_en'])->where ('mission_id', Auth::user ()->mission_id)->where ('service_receiver', 't')->get ();
        return view ('layouts.operational_advance.operational_advance', $this->data);
    }

    /**
     * @param Request $request
     * @return JsonResponse|null
     */
    public function store (Request $request): ?JsonResponse
    {
        try {
        $data = $request->data;
        $dt = Carbon::now ();
        $count = OperationalAdvance::where('service_type_id','375829')->whereYear ('created_at', '=', $dt->year)->count ();
        $code = str_pad ($count + 1, 4, '0', STR_PAD_LEFT);
        $data['status_id'] = '174';
        $data['code'] = 'OA ' . $code . '-' . $dt->year;
        $data['total_dollar'] = $data['total_currency'] / $data['user_exchange_rate'];
            $oa_service= OperationalAdvance::create ($data);
            $url='operational_advance.show';
            $this->notification ($data['total_currency'], "$oa_service->id", 'operational_advance', "$url", $count = 0, '180355', false, false, false);
            return $this->setStatusCode (200)->respond (['status' => true]);
        }catch(\Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => ['Something is error']]);
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function action (Request $request)
    {
        $check_notification = ProjectNotification::where ('url_id', $request->id)->where ('receiver', Auth::id ())->where ('status_id', $this->in_progress)->first ();
        if(is_null ($check_notification)) {
            return redirect ('home');
        }
        if($request->action == 'accept') {
            $this->notification ("$request->project_id", "$check_notification->url_id", 'operational_advance', "$check_notification->url", $count = 0, '180355', false, false, false);
        }elseif($request->action == 'reject') {
            $this->new_notification_project_authorized ($request->id, $check_notification->notification_type_id, 'payment_order.show', 107535, $this->in_progress, $check_notification->requester, $check_notification->requester, 0, false);
            $check_notification->status_id = 171;
            $check_notification->update ();
            $service = OperationalAdvance::find ($request->id);
            $service->status_id = 171;
            $service->update ();
        }elseif($request->action == 'confirm') {
            $check_notification->status_id = 170;
            $check_notification->modified_by = Auth::user ()->full_name;
            $check_notification->update ();
        }
        return redirect ('home');
    }
    /**
     * @param string $project_id
     * @param string $url_id
     * @param int $type
     * @param string $url
     * @param int $count
     * @param string $message_id
     * @param bool $manager
     * @param bool $last
     * @param bool $my
     * @return bool|null
     */
    public function notification ($project_id = '', $url_id = '', $type = 0, $url = '', $count = 0, $message_id = '0', $manager = false, $last = false, $my = false) : ?bool
    {
        $structure = ProjectNotificationStructure::where ('project_id', $project_id)->first ();
        $notification = ProjectNotification::where ('url_id', $url_id)->where ('status_id', $this->in_progress)->latest ('id')->first ();
        if($my) {
            $notification = ProjectNotification::where ('url_id', $url_id)->latest ('id')->first ();
        }
        if(is_null ($notification)) {

            if($count == 0) {
                $requester = Auth::id ();
            }else {
                $notification_2 = ProjectNotification::where ('url_id', $url_id)->latest ('id')->first ();
                $requester = $notification_2->requester;
            }
            $type_id = NotificationType::where ('module_name', $type)->latest ('id')->first ()->id;
            $delegated_user_id = null;
        }else {
            $requester = $notification->requester;
            $receiver = $notification->receiver;
            $type_id = $notification->notification_type_id;
            $delegated_user_id = $notification->delegated_user_id;
            if($receiver != Auth::id ()) {
                return false;
            }
            $notification->status_id = 170;
            $notification->modified_by = Auth::user ()->full_name;
            $notification->update ();
        }
        if($type_id == '') {
            $type_id = NotificationType::where ('module_name', $type)->latest ('id')->first ()->id;

        }
//        echo $type_id;
        $cycles = NotificationCycle::where ('notification_type_id', $type_id)->orderBy ('orderby')->get ();
        $count_notification = count (ProjectNotification::where ('url_id', $url_id)->where ('notification_type_id', $type_id)->groupBy ('step')->select ('step')->get ());
        if($count_notification == 1) {
            --$count_notification;
        }
        if(isset($cycles[$count_notification + $count]) && $cycles[$count_notification + $count]->notification_receiver_id == 375431) {
            $count_notification_step = ProjectNotification::where ('url_id', $url_id)->where ('notification_type_id', $type_id)->where ('step', '375431')->select ('step')->count ();
            if($cycles[$count_notification + $count]->number_of_superiors == 0) {
                if($delegated_user_id != null) {
                    $parent_user = User::find ($notification->delegated_user_id)->parent_id;
                }elseif($count_notification_step == 0) {
                    $parent_user = User::find ($requester)->parent_id;
                }else {
                    $parent_user = Auth::user ()->parent_id;
                }
                $next_user = User::where ('position_id', '!=', 32)->find ($parent_user);
                if(is_null ($next_user)) {
                    $this->notification ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                    return true;
                }
                $user_id = $this->delegation_or_disabled ($next_user->id, 0);
                if($this->check_notification ($user_id, $url_id) || $this->check_notification ($next_user->id, $url_id)) {
                    $this->notification ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                    return true;
                }
                if($user_id == $next_user->id) {
                    $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, true);
                }else {
                    $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, true, $next_user->id);
                }

            }else {
                $count_notification_step = ProjectNotification::where ('url_id', $url_id)->where ('step', 375431)->count ();
                if($count_notification_step == $cycles[$count_notification + $count]->number_of_superiors) {
                    $this->notification ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                }else {

                    if($count_notification_step == 0) {
                        $parent_user = User::find ($requester)->parent_id;
                    }else {
                        $parent_user = Auth::user ()->parent_id;
                    }
                    $next_user = User::where ('position_id', '!=', 32)->find ($parent_user);
                    if(is_null ($next_user)) {
                        $this->notification ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                        return true;
                    }
                    $user_id = $this->delegation_or_disabled ($next_user->id, 0);
                    if($this->check_notification ($user_id, $url_id) || $this->check_notification ($next_user->id, $url_id)) {
                        $this->notification ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                        return true;
                    }
                    if($user_id == $next_user->id) {
                        $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, true);
                    }else {
                        $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, true, $next_user->id);
                    }
                }
            }
        }else {
            if(isset($cycles[$count_notification + $count])) {
                if($cycles[$count_notification + $count]->notification_receiver_id == 375483) {
                    $recipient = OperationalAdvance::find ($url_id)->recipient;
                    if(is_null ($recipient)) {
                        $this->notification ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                        return true;
                    }
                    $user_id = $this->delegation_or_disabled ($recipient);
                    if($this->check_notification ($recipient, $url_id) || $this->check_notification ($user_id, $url_id)) {
                        $this->notification ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                        return true;
                    }
                    if($user_id == $recipient) {

                        $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id,  $cycles[$count_notification +
                        $count]->authorized);
                    }else {
                        $delegated_user_id = $requester;
                        $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id,  $cycles[$count_notification +
                        $count]->authorized, $delegated_user_id);
                    }
                }elseif($cycles[$count_notification + $count]->notification_receiver_id == 375467 && $manager) {

                    $receiver_name = NotificationReceiver::where ('id', $cycles[$count_notification + $count]->notification_receiver_id)->first ();
                    $receiver_id = $structure[$receiver_name->name_en];
                    $user_id = $this->delegation_or_disabled ($receiver_id);
                    if($this->check_notification ($receiver_id, $url_id) || $this->check_notification ($user_id, $url_id)) {
                        $this->notification ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                        return true;
                    }
                    if($user_id == $receiver_id) {
                        $this->new_notification_project_authorized ($url_id, $type_id, 'service.project_manager', $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id,
                            $cycles[$count_notification + $count]->authorized);
                    }else {
                        $delegated_user_id = $receiver_id;
                        $this->new_notification_project_authorized ($url_id, $type_id, 'service.project_manager', $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id,
                            $cycles[$count_notification + $count]->authorized, $delegated_user_id);
                    }
                }else {
                    $receiver_name = NotificationReceiver::where ('id', $cycles[$count_notification + $count]->notification_receiver_id)->first ();
                    $receiver_id = $structure[$receiver_name->name_en];
                    if(is_null ($receiver_id)) {
                        $this->notification ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                    }else {
                        $user_id = $this->delegation_or_disabled ($receiver_id);
                        if(is_null ($user_id)) {
                            $this->notification ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                            return true;
                        }
                        if($cycles[$count_notification + $count]->authorized) {
                            if($this->check_notification ($receiver_id, $url_id) || $this->check_notification ($user_id, $url_id)) {
                                $this->notification ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                                return true;
                            }
                            if($user_id == $receiver_id) {
                                $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id,  $cycles[$count_notification +
                                $count]->authorized);
                            }else {
                                $delegated_user_id = $receiver_id;
                                $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id,  $cycles[$count_notification +
                                $count]->authorized, $delegated_user_id);
                            }
                        }elseif(!$cycles[$count_notification + $count]->authorized) {

                            if($user_id == $receiver_id) {
                                $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id,  $cycles[$count_notification +
                                $count]->authorized);
                                $user_id = $this->delegation_or_disabled ($requester);
                                if(!is_null ($user_id) && $user_id == $requester) {
                                    $this->new_notification_project_authorized ($url_id, $type_id, $url, '457086', $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, false);
                                }else {
                                    $this->new_notification_project_authorized ($url_id, $type_id, $url, '457086', $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, false, $delegated_user_id);
                                }
                            }else {
                                $delegated_user_id = $receiver_id;
                                $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id,  $cycles[$count_notification +
                                $count]->authorized, $delegated_user_id);

                                $user_id = $this->delegation_or_disabled ($requester);
                                if(!is_null ($user_id) && $user_id == $requester) {
                                    $this->new_notification_project_authorized ($url_id, $type_id, $url, '457086', $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, false);
                                }else {
                                    $this->new_notification_project_authorized ($url_id, $type_id, $url, '457086', $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, false, $requester);
                                }
                            }
                            OperationalAdvance::where ('id', $url_id)->update (['status_id' => 170]);

                        }
                    }
                }
            }else {
                $user_id = $this->delegation_or_disabled ($requester);
                if(!is_null ($user_id) && $user_id == $requester) {
                    $this->new_notification_project_authorized ($url_id, $type_id, $url, '457086', $this->in_progress, $requester, $user_id, 0, false);
                }else {
                    $this->new_notification_project_authorized ($url_id, $type_id, $url, '457086', $this->in_progress, $requester, $user_id, 0, false, $requester);
                }
                 OperationalAdvance::where ('id', $url_id)->update (['status_id' => 170]);
                return true;
            }

        }
        return true;
    }

    /**
     * @param $id
     * @return Factory|RedirectResponse|Redirector|View
     */
    public function project_manager ($id)
    {
        $services = OperationalAdvance::find ($id);
        $check_notification = ProjectNotification::where ('url_id', $id)->where ('receiver', Auth::id ())->where ('status_id', $this->in_progress)->first ();
        if(is_null ($check_notification)) {
            return redirect ('home');
        }
            $route = route ('service.update');

        $service_items = OperationalAdvanceInvoice::where ('operational_advance_id', $id)->get ();
        $budget_lines = DB::table ('detailed_proposal_budgets')->join ('operational_advances', 'operational_advances.project_id', '=', 'detailed_proposal_budgets.project_id')
            ->join ('category_options', 'category_options.id', '=', 'detailed_proposal_budgets.category_option_id')
            ->where ('operational_advances.id', $id)->select ('detailed_proposal_budgets.id', 'detailed_proposal_budgets.budget_line', 'category_options.name_en')->get ();
        return view ('layouts.operational_advance.project_manager', compact ('services', 'service_items', 'route', 'budget_lines'));
    }
}
