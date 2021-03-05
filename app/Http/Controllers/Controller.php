<?php

namespace App\Http\Controllers;

use Response;
use App\Model\Hr\User;
use App\Model\NotificationCycle;
use Illuminate\Http\JsonResponse;
use App\Model\NotificationReceiver;
use App\Model\NotificationType;
use App\Model\Project\Project;
use App\Model\ProjectNotification;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Session;
use function is_null;


/**
 * Class Controller
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    use DispatchesJobs;
    use ValidatesRequests;
    use AuthorizesRequests;
    protected $data = [];
    protected $lang = '';
    private $statusCode = 200;
    protected $in_progress = 174;
    protected $status = [];
    protected $stage = [];


    public function __construct ()
    {
        $this->status = (object)['in_progress' => 174, 'in_progress_2' => 170];
        $this->stage = (object)['concept' => 1, 'in_progress_2' => 170];
        $this->middleware ('auth');
        $this->middleware (function($request, $next) {
            $this->lang = app ()->getLocale ();
            if (Session::has ('lang')) {
                app ()->setLocale (Session::get ('lang'));
                $this->lang = app ()->getLocale ();
            }
            return $next($request);
        });
    }


    /**
     * @param $model
     * @param $key
     * @param $title
     * @param $first_title
     * @param null $where
     * @param string $order_by
     * @return array
     */
    public function select_box ($model, $key, $title, $first_title, $where = null, $order_by = 'name'): array
    {
        $select_box_data = $model->select ($key, DB::raw ($title));
        if (!is_null ($where)) {
            $collection = collect ($select_box_data->whereRaw (DB::raw ($where))->orderBy ($order_by)->get ());
        } else {
            $collection = collect ($select_box_data->orderBy ('name')->get ());
        }
        $select_box_data = $collection->mapWithKeys (function($item) {
            return [$item['id'] => $item['name']];
        });

        if ($first_title) {
            $select_box_data->prepend ($first_title, '');
        }

        return $select_box_data->all ();

    }

    /**
     * @return int
     */
    public function getStatusCode (): int
    {
        return $this->statusCode;
    }

    /**
     * @param Request $request
     * @return string
     */
    public function duration (Request $request): string
    {
        $start = Carbon::parse ($request->start_date)->subDay ();
        $end = Carbon::parse ($request->end_date);
        $duration = $start->diff ($end);
        return $duration->format ('%y years %m months and %d days');

    }

    /**
     * @param int $statusCode
     *
     * @return $this
     */
    public function setStatusCode ($statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }


    /**
     * @param $data
     * @param array $headers
     * @return JsonResponse
     */
    public function respond ($data, $headers = []): JsonResponse
    {
        return Response::json ($data, $this->getStatusCode (), $headers);
    }

//    public function respondWithPagination( $totalCount, $data): \Illuminate\Http\JsonResponse
//    {
//        return $this->respond(
//            array_merge($data, [
//                'totalCount' => $totalCount
//            ])
//        );
//    }
//    public function resourcesWithPagination( $totalCount, $data): \Illuminate\Http\JsonResponse
//    {
//        return $this->resources(($data)->additional(['totalCount' => $totalCount]) );
//    }
    /**
     * @param $data
     * @return JsonResponse
     */
    public function resources ($data): JsonResponse
    {
        return $data->response ()->setStatusCode ($this->getStatusCode ());
    }

    /**
     * @param string $project_id
     * @param int $type
     * @param string $url
     * @param int $count
     * @param string $message_id
     * @return bool
     */
    public function notification_project ($project_id = '', $type = 0, $url = 'NULL', $count = 0, $message_id = '0'): ?bool
    {
        $notification = ProjectNotification::where ('url_id', $project_id)->where ('status_id', $this->in_progress)->latest ('id')->first ();

        if (is_null ($notification)) {
            if ($count == 0) {
                $requester = Auth::id ();
            } else {
                $notification_2 = ProjectNotification::where ('url_id', $project_id)->latest ('id')->first ();
                if (is_null ($notification_2)) {
                    $requester = Auth::id ();
                } else {
                    $requester = $notification_2->requester;
                }
            }
            $type_id = NotificationType::where ('module_name', $type)->latest ('id')->first ()->id;
            $delegated_user_id = null;
        } else {
            $requester = $notification->requester;
            $receiver = $notification->receiver;
            $type_id = $notification->notification_type_id;
            $delegated_user_id = $notification->delegated_user_id;

            if ($receiver != Auth::id ()) {
                return false;
            }
            $notification->status_id = 170;
            $notification->modified_by = Auth::user ()->full_name;
            $notification->update ();
        }

        $cycles = NotificationCycle::where ('notification_type_id', $type_id)->orderBy ('orderby')->get ();
        $count_notification = count (ProjectNotification::where ('url_id', $project_id)->where ('notification_type_id', $type_id)->groupBy ('step')->select ('step')->get ());

        if (isset($cycles[$count_notification + $count]) && $cycles[$count_notification + $count]->notification_receiver_id == 375431) {
            if ($cycles[$count_notification + $count]->number_of_superiors == 0) {
                if ($delegated_user_id != null) {
                    $parent_user = User::find ($notification->delegated_user_id)->parent_id;
                } else {
                    $parent_user = Auth::user ()->parent_id;
                }
                $next_user = User::where ('position_id', '!=', 32)->find ($parent_user);
                if (is_null ($next_user)) {
                    $this->notification_project ($project_id, $type, $url, $count + 1, $message_id);
                    return true;
                }
                $user_id = $this->delegation_or_disabled ($next_user->id);
                if ($user_id) {
                    $this->new_notification_project ($project_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id);
                } else {
                    $this->notification_project ($project_id, $type, $url, $count + 1, $message_id);
                    return true;
                }
            } else {
                $count_notification_step = ProjectNotification::where ('url_id', $project_id)->where ('step', 375431)->count ();
                if ($count_notification_step == $cycles[$count_notification + $count]->number_of_superiors) {
                    $this->notification_project ($project_id, $type_id, $url, $count+1);
                    return true;
                }
            }
        } else {
            $submission_type_id = NotificationType::where ('module_name', 'submission')->first ()->id;
//            if (($count_notification + $count == count ($cycles)) && ($type_id == $submission_type_id)) {
////                $this->new_notification_project ($project_id, $type_id, $url, $message_id, $this->in_progress, $requester, 1, $cycles[$count_notification]->notification_receiver_id);
//            } else
            if ((($count_notification + $count) == count ($cycles)) && ($type_id != $submission_type_id)) {
                $this->new_notification_project ($project_id, $submission_type_id, 'project.create', '50006', $this->in_progress, $requester, $requester);
                return true;
            } else {
                $receiver_name = NotificationReceiver::where ('id', $cycles[$count_notification + $count]->notification_receiver_id)->first ();
                $receiver_id = User::where ('id', $requester)->first ()->mission[$receiver_name->name_en];
                $delegated_user_id = $receiver_id;
                $user_id = $this->delegation_or_disabled ($receiver_id);
                if (is_null ($user_id)) {
                    $this->notification_project ($project_id, $type, $url, $count + 1, $message_id);
                    return true;
                }
                if (is_null ($notification)) {
                    $this->new_notification_project ($project_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $delegated_user_id);
                } elseif ($notification->step != $cycles[$count_notification + $count]->notification_receiver_id) {
                    $this->new_notification_project ($project_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $delegated_user_id);
                } else {
                    $this->notification_project ($project_id, $type, $url, $count + 1, $message_id);
                    return true;
                }

            }
        }
        return true;
    }

    /**
     * @param $user_id
     * @param int $count
     * @return bool|int|mixed
     */
    public function delegation_or_disabled ($user_id, $count = 0)
    {
        if ($count == 0) {
            $next_user = User::find ($user_id);
        } else {
            $next_user = User:: where ('position_id', '!=', 32)->find ($user_id);
            if (is_null ($next_user)) {
                return false;
            }
        }

        if ($next_user->delegation) {
            $next_user_2 = User::find ($next_user->delegation_user_id);
            if ($next_user_2->delegation) {
                $this->delegation_or_disabled ($next_user_2->id, $count+1);
            } else {
                return $next_user_2->id;
            }

        } elseif (!$next_user->delegation) {
            if ($next_user->disabled) {

                $user_id_2 = User::find ($user_id)->parent_id;
                $this->delegation_or_disabled ($user_id_2, $count+1);
            } else {
                return $next_user->id;
            }
        } else {
            return $user_id;
        }
        return $user_id;

    }

    /**
     * @param $user_id
     * @param $url_id
     * @return bool
     */
    public function check_notification ($user_id, $url_id): bool
    {
        return ProjectNotification::where ('url_id', $url_id)->whereRaw ("( delegated_user_id =$user_id or receiver=$user_id or requester=$user_id)")->exists ();

    }

//    /**
//     * @param $user_id
//     * @param $url_id
//     * @return bool
//     */
//    public function check_notification_receiver ($user_id, $url_id): bool
//    {
//        return ProjectNotification::where ('url_id', $url_id)->whereRaw ("( delegated_user_id =$user_id or receiver=$user_id )")->exists ();
//
//    }

    /**
     * @param string $project_id
     * @param int $type
     * @param string $url
     * @param int $count
     * @param string $message_id
     * @param bool $last
     * @param bool $my
     * @return bool|null
     */
    public function notification_project_submission ($project_id = '', $type = 0, $url = 'NULL', $count = 0, $message_id = '0', $last = false, $my = true): ?bool
    {
        $count_insert = 0;
        $notification_check = ProjectNotification::where ('url_id', $project_id)->where ('receiver', Auth::id ())->where ('status_id', $this->in_progress)->latest ('id')->first ();
        if (is_null ($notification_check) && !$my) {
            return false;
        }
        $notification = ProjectNotification::where ('url_id', $project_id)->where ('step', '!=', 0)->where ('receiver', Auth::id ())->where ('status_id', $this->in_progress)->latest ('id')->first ();
        if (is_null ($notification)) {
            $requester = Auth::id ();
            $delegated_user_id = null;
            $type_id = NotificationType::where ('module_name', $type)->latest ('id')->first ()->id;
            $notification_first = ProjectNotification::where ('url_id', $project_id)->where ('step', 0)->where ('receiver', Auth::id ())->where ('status_id', $this->in_progress)->latest ('id')->first ();
            if (!is_null ($notification_first)) {
                $notification_first->status_id = 170;
                $notification_first->modified_by = Auth::user ()->full_name;
                $notification_first->update ();
            }
        } else {
            $requester = $notification->requester;
            $delegated_user_id = $notification->delegated_user_id;

            $receiver = $notification->receiver;
            $type_id = $notification->notification_type_id;
            if ($receiver != Auth::id ()) {
                return false;
            }
            $notification->status_id = 170;
            $notification->modified_by = Auth::user ()->full_name;
            $notification->update ();
        }
//
        $cycles = NotificationCycle::where ('notification_type_id', $type_id)->orderBy ('orderby')->get ();
        $count_notification = count (ProjectNotification::where ('url_id', $project_id)->where ('notification_type_id', $type_id)->where ('step', '!=',0)->where ('message_id', 50006)->groupBy ('step')->select ('step')->get ()) ;
        if (isset($cycles[$count_notification + $count]) && $cycles[$count_notification + $count]->notification_receiver_id == 375431) {
//
            if ($cycles[$count_notification + $count]->number_of_superiors == 0) {
                if ($delegated_user_id != null) {
                    $parent_user = User::find ($notification->delegated_user_id)->parent_id;
                } else {
                    $parent_user = Auth::user ()->parent_id;
                }
                $next_user = User::where ('position_id', '!=', 32)->find ($parent_user);
                if (is_null ($next_user)) {
                    $this->notification_project_submission ($project_id, $type, $url, $count + 1, $message_id);
                    return true;
                }
                $user_id = $this->delegation_or_disabled ($next_user->id);
                if ($user_id ) {
                    $this->new_notification_project ($project_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id);
                } else {
                    $this->notification_project_submission ($project_id, $type, $url, $count + 1, $message_id);

                }
            } else {
                $count_notification_step = ProjectNotification::where ('url_id', $project_id)->where ('message_id', 50006)->where ('step', 375431)->count ();
                if ($count_notification_step == $cycles[$count_notification + $count]->number_of_superiors) {
                    $this->notification_project_submission ($project_id, $type_id, $url, $count+1);
                    return true;
                }
            }
        } else {
            $notification_3 = ProjectNotification::where ('url_id', $project_id)->first ();
            $requester = $notification_3->requester;
            $cycles = NotificationCycle::where ('notification_type_id', $type_id)->where ('notification_receiver_id', '!=', 375417)->orderBy ('orderby')->get ();
            $notification_count = ProjectNotification::where ('url_id', $project_id)->where ('receiver', Auth::id ())->where ('step', '!=', 375431)->where ('message_id', 50006)->where ('status_id', 170)->count ();
            if (!$notification_count) {
                foreach ($cycles as $cycle) {
                    $receiver_name = NotificationReceiver::where ('id', $cycle->notification_receiver_id)->first ();
                    $receiver_id = User::where ('id', $requester)->first ()->mission[$receiver_name->name_en];
                    if (!is_null ($receiver_id) && !$this->check_notification ($receiver_id, $project_id)) {
                        $count_insert = 1;
                        $user_id = $this->delegation_or_disabled ($receiver_id);
                        if ($user_id) {
                            $this->new_notification_project ($project_id, $type_id, $url, $message_id, $this->in_progress, $requester, $receiver_id, $cycles[$count_notification + $count]->notification_receiver_id);
                        }
                    }

                }
                if ($count_insert == 0) {
                    $this->notification_project_submission ($project_id, $type, $url, $count + 1, $message_id);
                    return true;
                }
            } else {
                $notification_count_1 = ProjectNotification::where ('url_id', $project_id)->where ('status_id', 174)->count ();
                $notification_count_3 = ProjectNotification::where ('url_id', $project_id)->where ('message_id', 50006)->where ('step', 375417)->count ();
                if ($last) {
                    $this->new_notification_project ($project_id, $type_id, $url, 376069, $this->in_progress, $requester, $requester, 1, $delegated_user_id);
                } elseif (!$notification_count_1 && !$notification_count_3) {
                    $cycles = NotificationCycle::where ('notification_receiver_id', 375417)->first ();
                    $receiver_name = NotificationReceiver::where ('id', $cycles->notification_receiver_id)->first ();
                    $receiver_id = User::where ('id', $requester)->first ()->mission[$receiver_name->name_en];
                    if (!is_null ($receiver_id)) {
                        $user_id = $this->delegation_or_disabled ($receiver_id);
                        if ($user_id!=$receiver_id) {
                            $delegated_user_id = $receiver_id;
                        }else{
                            $delegated_user_id = null;
                        }
                        $this->new_notification_project ($project_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles->notification_receiver_id, $delegated_user_id);
                    }
                } elseif ($notification_count_3) {
                    $project = Project::find ($project_id);
                    $project->status_id = 170;
                    $project->update ();
                    $this->notification_project_submission ($project_id, 'submission', 'project.show', 2, 50006, true);
                    return true;
                }
            }
        }
return true;
    }

    /**
     * @param string $url_id
     * @param string $type
     * @param string $url
     * @param string $message_id
     * @param string $status_id
     * @param string $requester
     * @param string $receiver
     * @param string $delegated_user_id
     * @param int $step
     * @return bool
     */
    public function new_notification_project ($url_id = null, $type = '', $url = 'NULL', $message_id = '0', $status_id = '0', $requester = '', $receiver = '', $step = 0, $delegated_user_id = null): bool
    {
        $notification = new ProjectNotification();
        if ($type) {
            $notification->notification_type_id = $type;

        }
        $notification->url_id = $url_id;
        $notification->requester = $requester;
        $notification->sender = Auth::id ();
        $notification->step = $step;
        $notification->receiver = $receiver;
        if ($delegated_user_id) {
            $notification->delegated_user_id = $delegated_user_id;
        }
        $notification->url = $url;
        $notification->stored_by = Auth::user ()->full_name;
        $notification->message_id = $message_id;
        $notification->status_id = $status_id;
        $notification->save ();
        return true;
    }


    /**
     * @param null $url_id
     * @param string $type
     * @param string $url
     * @param string $message_id
     * @param string $status_id
     * @param string $requester
     * @param string $receiver
     * @param int $step
     * @param $authorized
     * @param null $delegated_user_id
     * @return bool
     */
    public function new_notification_project_authorized ($url_id = null, $type = '', $url = 'NULL', $message_id = '0', $status_id = '0', $requester = '', $receiver = '', $step = 0, $authorized, $delegated_user_id = null): bool
    {
        $notification = new ProjectNotification();
        if ($type) {
            $notification->notification_type_id = $type;

        }
        $notification->url_id = $url_id;
        $notification->requester = $requester;
        $notification->sender = Auth::id ();
        $notification->step = $step;
        $notification->receiver = $receiver;
        if ($delegated_user_id) {
            $notification->delegated_user_id = $delegated_user_id;
        }
        $notification->url = $url;
        $notification->stored_by = Auth::user ()->full_name;
        $notification->authorized = $authorized;
        $notification->message_id = $message_id;
        $notification->status_id = $status_id;
        $notification->save ();
        return true;
    }
}
