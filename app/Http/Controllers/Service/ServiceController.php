<?php

namespace App\Http\Controllers\Service;

use DB;
use Auth;
use Carbon\Carbon;
use App\Model\Hr\User;
use App\Model\Currency;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Model\Project\Project;
use App\Model\Service\Service;
use App\Model\NotificationType;
use App\Model\ControlPanel\Item;
use App\Model\NotificationCycle;
use Illuminate\Http\JsonResponse;
use App\Model\Service\ServiceType;
use App\Model\ProjectNotification;
use App\Model\Service\PaymentType;
use App\Model\Service\ServiceItem;
use Illuminate\Routing\Redirector;
use App\Model\NotificationReceiver;
use App\Model\Service\ServiceModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Service\Store;
use App\Model\ControlPanel\Supplier;
use App\Model\Service\PaymentMethod;
use App\Model\Service\ServiceMethod;
use App\Model\Service\ServiceInvoice;
use Illuminate\Http\RedirectResponse;
use App\Model\ControlPanel\Hr\Mission;
use Illuminate\Contracts\View\Factory;
use App\Model\ControlPanel\Project\Unit;
use App\Model\ProjectNotificationStructure;
use App\Model\Project\DetailedProposalBudget;
use App\Http\Resources\Service\ServiceCollection;
use App\Http\Resources\Service\ServiceTypeCollection;
use App\Http\Resources\Service\ServiceOfficeCollection;
use App\Model\ControlPanel\Project\ProjectResponsibility;


/**
 * Class ServiceController
 * @package App\Http\Controllers\Service
 */
class ServiceController extends Controller
{
    //
    /**
     * @return View
     */
    public function index (): View
    {

        return view ('layouts.services.index', $this->data);
    }

    /**
     * @param $id
     * @return View
     */
    public function expense_index ($id): View
    {
        $this->data['id'] = $id;
        $this->data['type'] = 'expense';
        $m_id = Service::where ('services.parent_id', null)->where ('ser.status_id', '!=', 171)
            ->where ('services.status_id', 170)->where ('services.project_id', $id)
            ->join ('services as ser', 'services.id', '=', 'ser.parent_id')->distinct ()->pluck ('services.service_method_id');
        $p_id = Service::where ('services.parent_id', null)->where ('ser.status_id', '!=', 171)
            ->where ('services.status_id', 170)->where ('services.project_id', $id)
            ->join ('services as ser', 'services.id', '=', 'ser.parent_id')->distinct ()->pluck ('services.payment_method_id');

        $t_id = Service::where ('services.parent_id', null)->where ('ser.status_id', '!=', 171)
            ->where ('services.status_id', 170)->where ('services.project_id', $id)
            ->join ('services as ser', 'services.id', '=', 'ser.parent_id')->distinct ()->pluck ('services.service_type_id');
        $r_id = Service::where ('services.parent_id', null)->where ('ser.status_id', '!=', 171)
            ->where ('services.status_id', 170)->where ('services.project_id', $id)
            ->join ('services as ser', 'services.id', '=', 'ser.parent_id')->distinct ()->pluck ('services.requester');

        $this->data['service_method'] = ServiceMethod::whereIn ('id', $m_id)->orderBy ('name_en')->pluck ('name_en', 'id');
        $this->data['payment_method'] = PaymentMethod::whereIn ('id', $p_id)->orderBy ('name_en')->pluck ('name_en', 'id');
        $this->data['service_type'] = ServiceType::whereIn ('id', $t_id)->orderBy ('name_en')->pluck ('name_en', 'id');
        $this->data['requester'] = user::whereIn ('id', $r_id)->orderBy ('first_name_en')->get (['id', 'first_name_en', 'last_name_en'])->pluck ('full_name', 'id');
        return view ('layouts.services.expense_index', $this->data);
    }

    /**
     * @param $id
     * @return View
     */
    public function reserved_index ($id): View
    {
        $this->data['id'] = $id;
        $this->data['type'] = 'reserved';
        $m_id = Service::where ('parent_id', null)->where ('project_id', $id)->where ('completed', false)->distinct ()->pluck ('service_method_id');
        $p_id = Service::where ('parent_id', null)->where ('project_id', $id)->where ('completed', false)->distinct ()->pluck ('payment_method_id');
        $t_id = Service::where ('parent_id', null)->where ('project_id', $id)->where ('completed', false)->distinct ()->pluck ('service_type_id');
        $r_id = Service::where ('parent_id', null)->where ('project_id', $id)->where ('completed', false)->distinct ()->pluck ('services.requester');
        $this->data['service_method'] = ServiceMethod::whereIn ('id', $m_id)->orderBy ('name_en')->pluck ('name_en', 'id');
        $this->data['payment_method'] = PaymentMethod::whereIn ('id', $p_id)->orderBy ('name_en')->pluck ('name_en', 'id');
        $this->data['service_type'] = ServiceType::whereIn ('id', $t_id)->orderBy ('name_en')->pluck ('name_en', 'id');
        $this->data['requester'] = user::whereIn ('id', $r_id)->orderBy ('first_name_en')->get (['id', 'first_name_en', 'last_name_en'])->pluck ('full_name', 'id');

        return view ('layouts.services.expense_index', $this->data);
    }

    /**
     * @return View
     */
    public function office_index (): View
    {
        Service::distinct ()->pluck ('parent_id');
        $serviceMethods = ServiceMethod::orderBy ('name_en')->get ();
        $paymentMethods = PaymentMethod::orderBy ('name_en')->get ();
        $paymentTypes = PaymentType::orderBy ('name_en')->get ();
        return view ('layouts.services.office_index', $this->data);
    }

    /**
     * @return View
     */
    public function create (): View
    {
        $projects = Project::orderBy ('name_en')->get ();
        $serviceModels = ServiceModel::orderBy ('name_en')->get ();
        $serviceMethods = ServiceMethod::orderBy ('name_en')->get ();
        $paymentMethods = PaymentMethod::orderBy ('name_en')->get ();
        $paymentTypes = PaymentType::orderBy ('name_en')->get ();
        $currencies = Currency::orderBy ('name_en')->get ();
        $budgetLines = DetailedProposalBudget::orderBy ('budget_line')->get ();
        $items = Item::orderBy ('name_en')->get ();
        $units = Unit::orderBy ('name_en')->get ();
        return view ('layouts.services.create', compact ('projects', 'serviceModels', 'serviceMethods', 'paymentMethods', 'paymentTypes', 'currencies', 'units', 'budgetLines', 'items'));
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
        $query = Service::with ('project', 'currency', 'status', 'service_type', 'payment_method', 'service_method', 'service_requester');
//        $query = Service::with ('project','currency','status','service_type','payment_method','service_method');
        if (!is_null ($search)) {
            $query->where (function($query) use ($search) {
                $query->whereHas ('project', function($query) use ($search) {
                    $query->where ('name_en', 'ILIKE', "%$search%");
                })->orWhereHas ('currency', function($query) use ($search) {
                    $query->where ('name_en', 'ILIKE', "%$search%");
                });
                $query->orwhere ('code', 'ILIKE', "%$search%");
            });
        }
        $query->whereRaw ('(service_type_id != ? and service_type_id != ? and service_model_id != ?)', [375650, 375649, 375449]);
        if (isset($request->start_date)) {
            $query->whereDate ('created_at', '>=', $request->start_date);
        }
        if (isset($request->end_date)) {
            $query->whereDate ('created_at', '<=', $request->end_date);
        }
        if (isset($request->max_total)) {
            $query->where ('total_currency', '<=', $request->max_total);
        }
        if (isset($request->min_total)) {
            $query->where ('total_currency', '>=', $request->min_total);
        }
        $query->where ('total_currency', '>=', 1);

        $totalCount = $query->count ();
        $query->offset ($offset)
            ->limit ($per_page)
            ->orderBy ($sortField, $sortOrder);
        $data = $query->get ();
        $request->offsetSet ('pages', ceil ($totalCount / $per_page));
        $request->offsetSet ('total', $totalCount);
        return $this->resources (new ServiceCollection($data));
    }
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function get_dashboard (Request $request): JsonResponse
    {
        $page = $request->input ('pagination.page');
        $search = $request->input ('query.generalSearch', 'test');
        $per_page = $request->input ('pagination.perpage', 10);
        $sortOrder = $request->input ('sort.sort', 'asc');
        $sortField = $request->input ('sort.field', 'id');
        $offset = ($page - 1) * $per_page;
        $query = Service::with ('project', 'currency', 'status', 'service_type', 'payment_method', 'service_method', 'service_requester');
//        $query->where (function($query) use ($search) {
//            $query->whereHas ('project', function($query) use ($search) {
//                $query->where ('name_en', 'sounds like', "%test%");
//            });
//        });
        $project= new ProjectNotificationStructure();

        $table = $project->getTable();

        $columns = \DB::getSchemaBuilder()->getColumnListing($table);
        $project_ids =  ProjectNotificationStructure::select ('project_id');
        unset($columns['22'],$columns['23'],$columns['24'],$columns['25'],$columns['0'],$columns['1'],$columns['2']);
        foreach($columns as $column)
        {
            $project_ids->orWhere($column,  Auth::id ());
        }
        $data_1=$project_ids->get ();


        $ids=ProjectResponsibility::select ('project_id')->where ('project_officer','ILIKE', '%'.Auth::id().'%')->get ();
        $query->whereRaw ('(service_type_id != ? and service_type_id != ? and service_model_id != ?)', [375650, 375649, 375449]);
        $query->where ('total_currency', '>=', 1);
        $query->where (function($query) use ($data_1,$ids) {
                $query->whereIn ('project_id', $data_1);
                $query->orWhereIn ('project_id', $ids);
        });
        $totalCount = 20;
        $query->offset ($offset)
            ->limit ($per_page)
            ->orderBy ('id','desc');
        $data = $query->get ();
        $request->offsetSet ('pages', ceil ($totalCount / $per_page));
        $request->offsetSet ('total', $totalCount);
        return $this->resources (new ServiceCollection($data));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function get_service_type (Request $request): JsonResponse
    {
        $page = $request->input ('pagination.page');
        $search = $request->input ('query.generalSearch', null);
        $per_page = $request->input ('pagination.perpage', 10);
        $sortOrder = $request->input ('sort.sort', 'asc');
        $sortField = $request->input ('sort.field', 'services.id');
        $offset = ($page - 1) * $per_page;
        if ($request->type == 'reserved') {
            $query = Service::where ('services.project_id', $request->project_id)->where ('services.completed', false)->with ('service_requester', 'project', 'currency', 'status', 'service_type', 'payment_method', 'service_method')
                ->join ('services as ser', 'services.id', '=', 'ser.parent_id');
        } else {
            $query = Service::where ('ser.status_id', '!=', 171)->where ('services.status_id', 170)->where ('services.project_id', $request->project_id)->with ('service_requester', 'project', 'currency', 'status', 'service_type', 'payment_method', 'service_method')
                ->join ('services as ser', 'services.id', '=', 'ser.parent_id');
//            $query->whereHas ('children', function ($query) {
//                $query->where ('total_currency', '>=', 1)->where ('status_id', '!=', 174);
//            });
        }
        if (!is_null ($search)) {
            $query->where ('services.code', 'ILIKE', "%$search%");
        }
        if (isset($request->service_method_ids)) {
            $query->whereHas ('service_method', function($query) use ($request) {
                $query->whereIn ('id', $request->service_method_ids);
            });
        }
        if (isset($request->service_type_ids)) {
            $query->whereHas ('service_type', function($query) use ($request) {
                $query->whereIn ('id', $request->service_type_ids);
            });
        }
        if (isset($request->payment_method_ids)) {
            $query->whereHas ('payment_method', function($query) use ($request) {
                $query->whereIn ('id', $request->payment_method_ids);
            });
        }
        if (isset($request->close)) {
            $query->where ('services.completed', $request->close);
        }
        if (isset($request->requester_ids)) {
            $query->where ('services.requester', $request->requester_ids);
        }
        if (isset($request->group_by)) {
            $query->orderBy ($request->group_by);
        }
        $query->whereRaw ('(services.service_type_id != ? and services.service_type_id != ? and services.service_model_id != ?)', [375650, 375649, 375449]);
        if (isset($request->start_date)) {
            $query->whereDate ('services.created_at', '>=', $request->start_date);
        }
        if (isset($request->end_date)) {
            $query->whereDate ('services.created_at', '<=', $request->end_date);
        }
        if (isset($request->max_total)) {
            $query->where ('services.total_usd', '<=', $request->max_total);
        }
        if (isset($request->min_total)) {
            $query->where ('services.total_usd', '>=', $request->min_total);
        }
        $query->where ('services.total_usd', '>=', 1);

        $totalCount = $query->count ();
        $query->offset ($offset)
            ->limit ($per_page)
            ->orderBy ($sortField, $sortOrder);
        $data = $query->selectRaw ('services.* ,services.code , sum(ser.total_usd) as c_total')->groupBy ('services.code', 'services.id')->get ();
        $request->offsetSet ('pages', ceil ($totalCount / $per_page));
        $request->offsetSet ('total', $totalCount);
        return $this->resources (new ServiceTypeCollection($data));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function office_list (Request $request): JsonResponse
    {
        $page = $request->input ('pagination.page');
        $search = $request->input ('query.generalSearch', null);
        $per_page = $request->input ('pagination.perpage', 10);
        $sortOrder = $request->input ('sort.sort', 'asc');
        $sortField = $request->input ('sort.field', 'id');
        $offset = ($page - 1) * $per_page;
        $query = Service::with ('project', 'currency', 'status', 'service_type', 'payment_method', 'service_method');
//        $query = Service::with ('project','currency','status','service_type','payment_method','service_method');
        if (!is_null ($search)) {
            $query->where (function($query) use ($search) {
                $query->whereHas ('project', function($query) use ($search) {
                    $query->where ('name_en', 'ILIKE', "%$search%");
                })->orWhereHas ('currency', function($query) use ($search) {
                    $query->where ('name_en', 'ILIKE', "%$search%");
                });
                $query->orwhere ('code', 'ILIKE', "%$search%");
            });
        }
        $query->whereRaw ('(service_type_id != ? and service_type_id != ? and service_model_id != ?)', [375650, 375649, 375448]);
        if (isset($request->start_date)) {
            $query->whereDate ('created_at', '>=', $request->start_date);
        }
        if (isset($request->end_date)) {
            $query->whereDate ('created_at', '<=', $request->end_date);
        }
        if (isset($request->max_total)) {
            $query->where ('total_currency', '<=', $request->max_total);
        }
        if (isset($request->min_total)) {
            $query->where ('total_currency', '>=', $request->min_total);
        }
        $query->where ('total_currency', '>=', 1);

        $totalCount = $query->count ();
        $query->offset ($offset)
            ->limit ($per_page)
            ->orderBy ($sortField, $sortOrder);
        $data = $query->get ();
        $request->offsetSet ('pages', ceil ($totalCount / $per_page));
        $request->offsetSet ('total', $totalCount);
        return $this->resources (new ServiceOfficeCollection($data));
    }


    /**
     * @param Store $request
     * @return JsonResponse|null
     */
    public function store (Store $request): ?JsonResponse
    {
        try {
            $service = $request->service;
            $service['stored_by'] = Auth::user ()->full_name;
            $service['requester'] = Auth::id ();
            if (!isset($service['payment_type_id'])) {
                $service['payment_type_id'] = 3304;
            }
            $service['status_id'] = 174;
            if ($service['service_method_id'] == 66894 && $service['payment_type_id'] == 310675) {
                $service['implementing_partner_account_id'] = $service['bank_account'];
            }
            if ($service['service_method_id'] == 137368 && $service['payment_type_id'] == 310675) {
                $service['service_provider_account_id'] = $service['bank_account'];
            }
            if ($service['service_method_id'] == 311432 && $service['payment_type_id'] == 310675) {
                $service['supplier_account_id'] = $service['bank_account'];
            }
            $requester = Auth::id ();
            $item = [];
            $total_currency = 0;
            $total_usd = 0;
            $item_2 = [];
            $manager = false;
            if ($service['service_model_id'] == 375449) {
                if ($service['service_type_id'] == 375446) {
                    $dt = Carbon::now ();
                    $count = Service::where ('service_type_id', $service['service_type_id'])->whereYear ('created_at', '=', $dt->year)->count ();
                    $code = str_pad ($count + 1, 4, '0', STR_PAD_LEFT);
                    $service['code'] = 'MR ' . $code . '-' . $dt->year;
                    unset($service['service_receiver_id']);
                    $service['service_method_id'] = 66893;
                    if (isset($request->service_item)) {
                        foreach ($request->service_item as $key => $value) {
                            $total_currency += $value['quantity'] * $value['unit_cost'];
                            unset($value['total']);
                            $value['stored_by'] = Auth::user ()->full_name;
//                            $value['requester'] = Auth::id ();
                            $value['currency_id'] = $request->input ('service.currency_id');
                            $value['exchange_rate'] = $request->input ('service.user_exchange_rate');
                            $value['project_id'] = $request->input ('service.project_id');
                            $item[] =
                                new ServiceItem($value);
                        }
                    }
                    if (isset($service['user_exchange_rate'])) {
                        $service['total_currency'] = $total_currency;
                        $service['total_usd'] = $total_currency / $service['user_exchange_rate'];
                    } else {
                        $service['total_currency'] = $total_currency;
                        $service['total_usd'] = $total_currency;

                    }

                    $new_service = Service::create ($service);
                    $new_service->service_items ()->saveMany ($item);
                    $procurement_id = Mission::find (Auth::user ()->mission_id)->procurement_responsibility;
                    $this->new_notification_project ("$new_service->id", false, 'service.logistic', 375547, '174', "$requester", "$procurement_id");
                } elseif ($service['service_type_id'] == 375447 && $service['service_method_id'] == 66893) {
                    $dt = Carbon::now ();
                    $count = Service::where ('service_type_id', $service['service_type_id'])->whereYear ('created_at', '=', $dt->year)->count ();
                    $code = str_pad ($count + 1, 4, '0', STR_PAD_LEFT);
                    $service['code'] = 'PYR ' . $code . '-' . $dt->year;
                    unset($service['service_receiver_id']);
                    $service['service_method_id'] = 66893;
                    if (isset($request->service_item)) {
                        foreach ($request->service_item as $key => $value) {
                            unset($value['total']);
                            $total_currency += $value['quantity'] * $value['unit_cost'];
                            $value['stored_by'] = Auth::user ()->full_name;
//                            $value['requester'] = Auth::id ();
                            $value['currency_id'] = $request->input ('service.currency_id');
                            $value['exchange_rate'] = $request->input ('service.user_exchange_rate');
                            $value['project_id'] = $request->input ('service.project_id');
                            $item[] =
                                new ServiceItem($value);
                        }
                    }
                    if (isset($service['user_exchange_rate'])) {
                        $service['total_currency'] = $total_currency;
                        $service['total_usd'] = $total_currency / $service['user_exchange_rate'];
                    } else {
                        $service['total_currency'] = $total_currency;
                        $service['total_usd'] = $total_currency;
                    }
                    $new_service = Service::create ($service);
                    $new_service->service_items ()->saveMany ($item);
                    $procurement_id = Mission::find (Auth::user ()->mission_id)->procurement_responsibility;
                    $this->new_notification_project ("$new_service->id", false, 'service.logistic', 375547, '174', "$requester", "$procurement_id");
                } elseif ($service['service_type_id'] == 375447 && $service['service_method_id'] != 66893) {
                    $url = 'service.show';
                    $dt = Carbon::now ();
                    $count = Service::where ('service_type_id', $service['service_type_id'])->whereYear ('created_at', '=', $dt->year)->count ();
                    $code = str_pad ($count + 1, 4, '0', STR_PAD_LEFT);
                    $service['code'] = 'PYR ' . $code . '-' . $dt->year;
                    if ($service['service_method_id'] == 66892) {
                        $service['recipient'] = $service['service_receiver_id'];
                    }
                    if ($service['service_method_id'] == 66894) {
                        $service['implementing_partner_id'] = $service['service_receiver_id'];
                    }
                    if ($service['service_method_id'] == 137368) {
                        $service['service_provider_id'] = $service['service_receiver_id'];
                    }
                    if ($service['service_method_id'] == 311432) {
                        $service['supplier_id'] = $service['service_receiver_id'];
                    }
                    unset($service['service_receiver_id']);
                    if ($request->hasFile ('receipt_file')) {
                        $file = $request->file ('receipt_file');
                        $filename = time () . '.pdf';
                        $file->move ('file/invoice', $filename);
                        $service['receipt_file'] = $filename;
                    }
                    if ($service['payment_method_id'] == 3297) {
                        if (isset($request->service_item)) {

                            foreach ($request->service_item as $key => $value) {
                                $total_currency += $value['quantity'] * $value['unit_cost'];
                                unset($value['total']);
                                $value['stored_by'] = Auth::user ()->full_name;
//                                $value['requester'] = Auth::id ();
                                $value['currency_id'] = $service['currency_id'];
                                $value['exchange_rate'] = $service['user_exchange_rate'];
                                $value['project_id'] = $service['project_id'];
                                $item[] =
                                    new ServiceItem($value);
                            }

                        }
                        if (isset($service['user_exchange_rate'])) {
                            $service['total_currency'] = $total_currency;
                            $service['total_usd'] = $total_currency / $service['user_exchange_rate'];
                        } else {
                            $service['total_currency'] = $total_currency;
                            $service['total_usd'] = $total_currency;
                        }
                        $new_service = Service::create ($service);

                        $new_service->service_items ()->saveMany ($item);
                        $this->notification_Office ("$new_service->project_id", "$new_service->id", 'mission_pyr_advance_service', "$url", $count = 0, '375547', "$manager", false, false);
                    } elseif ($service['payment_method_id'] == 3296) {
                        $dt = Carbon::now ();
                        $count = Service::where ('service_type_id', 375649)->whereYear ('created_at', '=', $dt->year)->count ();
                        $code = str_pad ($count + 1, 4, '0', STR_PAD_LEFT);
                        if (isset($request->service_item_direct)) {
                            foreach ($request->service_item_direct as $key => $value) {
                                $total_currency += $value['quantity'] * $value['unit_cost'];
                                $total_usd += ($value['quantity'] * $value['unit_cost']) / $value['exchange_rate'];
                                unset($value['total']);
                                $value['stored_by'] = Auth::user ()->full_name;
//                                $value['requester'] = Auth::id ();
                                $value['project_id'] = $service['project_id'];
                                $item[] = new ServiceItem($value);
                                $item_2[] = new ServiceInvoice($value);
                            }
                            if (isset($service['user_exchange_rate'])) {
                                $service['total_currency'] = $total_currency;
                                $service['total_usd'] = $total_currency / $service['user_exchange_rate'];
                            } else {
                                $service['total_currency'] = $total_currency;
                                $service['total_usd'] = $total_usd;
                            }
                            $new_service = Service::create ($service);
                            $new_service->service_items ()->saveMany ($item);
                            $service['code'] = 'PYO ' . $code . '-' . $dt->year;
                            $service['parent_id'] = $new_service->id;
                            $service['service_type_id'] = 375649;
                            $new_service_pyo = Service::create ($service);
                            $new_service_pyo->service_invoices ()->saveMany ($item_2);
                        }

                        $this->notification_Office ("$new_service->project_id", "$new_service->id", 'mission_pyr_direct_service', "$url", $count = 0, '375547', "$manager", false, false);
                    }


                }
            } else {
                if ($service['service_type_id'] == 375446) {
                    $dt = Carbon::now ();
                    $count = Service::where ('service_type_id', $service['service_type_id'])->whereYear ('created_at', '=', $dt->year)->count ();
                    $code = str_pad ($count + 1, 4, '0', STR_PAD_LEFT);
                    $service['code'] = 'MR ' . $code . '-' . $dt->year;
                    unset($service['service_receiver_id']);
                    $service['service_method_id'] = 66893;
                    if (isset($request->service_item)) {
                        foreach ($request->service_item as $key => $value) {
                            $total_currency += $value['quantity'] * $value['unit_cost'];
                            unset($value['total']);
                            $value['stored_by'] = Auth::user ()->full_name;
//                            $value['requester'] = Auth::id ();
                            $value['currency_id'] = $request->input ('service.currency_id');
                            $value['exchange_rate'] = $request->input ('service.user_exchange_rate');
                            $value['project_id'] = $request->input ('service.project_id');
                            $item[] =
                                new ServiceItem($value);
                        }
                    }
                    if (isset($service['user_exchange_rate'])) {
                        $service['total_currency'] = $total_currency;
                        $service['total_usd'] = $total_currency / $service['user_exchange_rate'];
                    } else {
                        $service['total_currency'] = $total_currency;
                        $service['total_usd'] = $total_currency;

                    }

                    $new_service = Service::create ($service);
                    $new_service->service_items ()->saveMany ($item);
                    $procurement_id = ProjectNotificationStructure::where ('project_id', $request->input ('service.project_id'))->first ()->procurement_responsibility;
                    $this->new_notification_project ("$new_service->id", false, 'service.logistic', 375547, '174', "$requester", "$procurement_id");
                } elseif ($service['service_type_id'] == 375447 && $service['service_method_id'] == 66893) {
                    $dt = Carbon::now ();
                    $count = Service::where ('service_type_id', $service['service_type_id'])->whereYear ('created_at', '=', $dt->year)->count ();
                    $code = str_pad ($count + 1, 4, '0', STR_PAD_LEFT);
                    $service['code'] = 'PYR ' . $code . '-' . $dt->year;
                    unset($service['service_receiver_id']);
                    $service['service_method_id'] = 66893;
                    if (isset($request->service_item)) {
                        foreach ($request->service_item as $key => $value) {
                            unset($value['total']);
                            $total_currency += $value['quantity'] * $value['unit_cost'];
                            $value['stored_by'] = Auth::user ()->full_name;
//                            $value['requester'] = Auth::id ();
                            $value['currency_id'] = $request->input ('service.currency_id');
                            $value['exchange_rate'] = $request->input ('service.user_exchange_rate');
                            $value['project_id'] = $request->input ('service.project_id');
                            $item[] =
                                new ServiceItem($value);
                        }
                    }
                    if (isset($service['user_exchange_rate'])) {
                        $service['total_currency'] = $total_currency;
                        $service['total_usd'] = $total_currency / $service['user_exchange_rate'];
                    } else {
                        $service['total_currency'] = $total_currency;
                        $service['total_usd'] = $total_currency;
                    }
                    $new_service = Service::create ($service);
                    $new_service->service_items ()->saveMany ($item);
                    $procurement_id = ProjectNotificationStructure::where ('project_id', $request->input ('service.project_id'))->first ()->procurement_responsibility;
                    $this->new_notification_project ("$new_service->id", false, 'service.logistic', 375547, '174', "$requester", "$procurement_id");
                } elseif ($service['service_type_id'] == 375447 && $service['service_method_id'] != 66893) {
                    $url = 'service.show';
                    $dt = Carbon::now ();
                    $count = Service::where ('service_type_id', $service['service_type_id'])->whereYear ('created_at', '=', $dt->year)->count ();
                    $code = str_pad ($count + 1, 4, '0', STR_PAD_LEFT);
                    $service['code'] = 'PYR ' . $code . '-' . $dt->year;
                    if ($service['service_method_id'] == 66892) {
                        $service['recipient'] = $service['service_receiver_id'];
                    }
                    if ($service['service_method_id'] == 66894) {
                        $service['implementing_partner_id'] = $service['service_receiver_id'];
                    }
                    if ($service['service_method_id'] == 137368) {
                        $service['service_provider_id'] = $service['service_receiver_id'];
                    }
                    if ($service['service_method_id'] == 311432) {
                        $service['supplier_id'] = $service['service_receiver_id'];
                    }
                    unset($service['service_receiver_id']);
                    if ($request->hasFile ('receipt_file')) {
                        $file = $request->file ('receipt_file');
                        $filename = time () . '.pdf';
                        $file->move ('file/invoice', $filename);
                        $service['receipt_file'] = $filename;
                    }
                    if ($service['payment_method_id'] == 3297) {
                        if (isset($request->service_item)) {

                            foreach ($request->service_item as $key => $value) {
                                $total_currency += $value['quantity'] * $value['unit_cost'];
                                unset($value['total']);
                                $value['stored_by'] = Auth::user ()->full_name;
//                                $value['requester'] = Auth::id ();
                                $value['currency_id'] = $service['currency_id'];
                                $value['exchange_rate'] = $service['user_exchange_rate'];
                                $value['project_id'] = $service['project_id'];
                                $item[] =
                                    new ServiceItem($value);
                            }

                        }
                        if (isset($service['user_exchange_rate'])) {
                            $service['total_currency'] = $total_currency;
                            $service['total_usd'] = $total_currency / $service['user_exchange_rate'];
                        } else {
                            $service['total_currency'] = $total_currency;
                            $service['total_usd'] = $total_currency;
                        }
                        $new_service = Service::create ($service);

                        $new_service->service_items ()->saveMany ($item);
                        $this->notification ("$new_service->project_id", "$new_service->id", 'pyr_advance_service', "$url", $count = 0, '375547', "$manager", false, false);
                    } elseif ($service['payment_method_id'] == 3296) {


                        if (isset($request->service_item_direct)) {
                            foreach ($request->service_item_direct as $key => $value) {
                                $total_currency += $value['quantity'] * $value['unit_cost'] / $value['exchange_rate'];
                                unset($value['total']);
                                $value['stored_by'] = Auth::user ()->full_name;
//                                $value['requester'] = Auth::id ();
                                $value['project_id'] = $service['project_id'];
                                $item[] = new ServiceItem($value);
                                $item_2[] = new ServiceInvoice($value);
                            }
                            if (isset($service['user_exchange_rate'])) {
                                $service['total_currency'] = $total_currency;
                                $service['total_usd'] = $total_currency / $service['user_exchange_rate'];
                                $service['currency_id'] = 87034;

                            } else {
                                $service['total_currency'] = $total_currency;
                                $service['total_usd'] = $total_currency;
                                $service['currency_id'] = 87034;
                                $service['user_exchange_rate'] = 1;
                            }
                            $new_service = Service::create ($service);
                            $new_service->service_items ()->saveMany ($item);
                            $service['parent_id'] = $new_service->id;
                            $service['service_type_id'] = 375649;
                            $dt = Carbon::now ();
                            $count = Service::where ('service_type_id', 375649)->whereYear ('created_at', '=', $dt->year)->count ();
                            $code = str_pad ($count + 1, 4, '0', STR_PAD_LEFT);
                            $service['code'] = 'PYO ' . $code . '-' . $dt->year;
                            $new_service_pyo = Service::create ($service);
                            $new_service_pyo->service_invoices ()->saveMany ($item_2);
                        }
                        $this->notification ("$new_service->project_id", "$new_service->id", 'pyr_direct_service', "$url", $count = 0, '375547', "$manager", false, false);
                    }
                }
            }


            return $this->setStatusCode (200)->respond (['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => ['Something is error']]);
        }
    }

    /**
     * @param $id
     * @return Factory|View
     */
    public function logistic ($id)
    {
        $this->data['service'] = Service::where ('id', $id)->first ();
        $this->data['service_items'] = ServiceItem::where ('service_id', $id)->get ();
        $this->data['total_currencies'] = ServiceItem::select (DB::raw ('sum(quantity * unit_cost)'))->where ('service_id', $id)->get ();
        $this->data['total_usd'] = ServiceItem::select (DB::raw ('sum(quantity * unit_cost / exchange_rate)'))->where ('service_id', $id)->get ();
//      $this->data['project']   = Project::orderBy('name_en')->get();
        $this->data['service_models'] = ServiceModel::orderBy ('name_en')->get ();
        $this->data['service_methods'] = ServiceMethod::orderBy ('name_en')->get ();
        $this->data['payment_methods'] = PaymentMethod::orderBy ('name_en')->get ();
        $this->data['payment_types'] = PaymentType::orderBy ('name_en')->get ();
        $this->data['currencies'] = Currency::orderBy ('name_en')->get ();
        $this->data['service_receivers'] = DB::table ('users')->select ('users.id', 'users.first_name_en', 'users.last_name_en')
            ->join ('departments_missions as dm1', 'dm1.id', '=', 'users.department_id')
            ->join ('missions', 'missions.id', '=', 'dm1.mission_id')
            ->join ('departments_missions as dm2', 'dm2.mission_id', '=', 'missions.id')
            ->join ('users as procurement_officer', 'procurement_officer.department_id', '=', 'dm2.id')
            ->where ('users.logistic_service_receiver', true)->where ('procurement_officer.id', Auth::user ()->id)
            ->distinct ()->get ();
        $this->data['budget_lines'] = DetailedProposalBudget::orderBy ('budget_line')->get ();
        $this->data['suppliers'] = Supplier::orderBy ('name_en')->get ();
        $this->data['items'] = Item::orderBy ('name_en')->get ();
        $this->data['units'] = Unit::orderBy ('name_en')->get ();
        return view ('layouts.services.logistic', $this->data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update (Request $request): JsonResponse
    {
        try {
            $service_data = $request->service;
            $service = Service::find ($request->id);
            $total_currency = 0;
            $ids = [];
            $manager = false;
            if (!isset($service->service_items[0]->detailed_proposal_budget_id)) {
                $manager = true;
            }
            if (isset($request->service_item, $service->service_items[0]->detailed_proposal_budget_id)) {
                foreach ($request->service_item as $key => $value) {
                    $value['modified_by'] = Auth::user ()->full_name;
                    $total_currency += $value['quantity'] * $value['unit_cost'];
                    if (isset($value['id'])) {
                        $id = $value['id'];
                        unset($value['id'], $value['total']);
                        $value['exchange_rate'] = $service->user_exchange_rate;
                        ServiceItem::whereId ($id)->update ($value);
                        $ids[] = $id;
                    }
                }
                $service_data['total_currency'] = $total_currency;
                $service_data['total_usd'] = $total_currency / $service->user_exchange_rate;
                $service->service_items ()->whereNotIn ('id', $ids)->delete ();
                $service_data['modified_by'] = Auth::user ()->full_name;
                $service->update ($service_data);
            } elseif (isset($request->service_item) && !isset($service->service_items[0]->detailed_proposal_budget_id)) {
                foreach ($request->service_item as $key => $value) {
                    ServiceItem::whereId ($value['id'])->update (['modified_by' => Auth::user ()->full_name, 'detailed_proposal_budget_id' => $value['detailed_proposal_budget_id']]);
                }
                $service_data['modified_by'] = Auth::user ()->full_name;
                $service->update ($service_data);
            }
            $url = 'service.show';
            if ($service->service_model_id == 375449) {
                if ($service->payment_method_id == 3297 && $service->service_method_id != 66893) {
                    $this->notification_office ("$service->project_id", "$service->id", 'mission_pyr_advance_service', "$url", $count = 0, '375547', "$manager", false, false);
                }
                if ($service->payment_method_id == 3296 && $service->service_method_id != 66893) {
                    $this->notification_office ("$service->project_id", "$service->id", 'mission_pyr_direct_service', "$url", $count = 0, '375547', "$manager", false, false);
                }
                if ($service->payment_method_id == 3297 && $service->service_method_id == 66893) {
                    $this->notification ("$service->project_id", "$service->id", 'mission_pyr_logistic_advance_service', "$url", $count = 0, '375547', "$manager", false, false);
                }
                if ($service->payment_method_id == 3296 && $service->service_method_id == 66893) {
                    $this->notification ("$service->project_id", "$service->id", 'mission_pyr_logistic_direct_service', "$url", $count = 0, '375547', "$manager", false, false);
                }
            } else {
                if ($service->payment_method_id == 3297 && $service->service_method_id != 66893) {
                    $this->notification ("$service->project_id", "$service->id", 'pyr_advance_service', "$url", $count = 0, '375547', "$manager", false, false);
                }
                if ($service->payment_method_id == 3296 && $service->service_method_id != 66893) {
                    $this->notification ("$service->project_id", "$service->id", 'pyr_direct_service', "$url", $count = 0, '375547', "$manager", false, false);
                }
                if ($service->payment_method_id == 3297 && $service->service_method_id == 66893) {
                    $this->notification ("$service->project_id", "$service->id", 'pyr_logistic_advance_service', "$url", $count = 0, '375547', "$manager", false, false);
                }
                if ($service->payment_method_id == 3296 && $service->service_method_id == 66893) {
                    $this->notification ("$service->project_id", "$service->id", 'pyr_logistic_direct_service', "$url", $count = 0, '375547', "$manager", false, false);
                }
            }
            return $this->setStatusCode (200)->respond (['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => ['Something is error']]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logistic_update (Request $request): JsonResponse
    {
        try {
            $service_data = $request->service;
            $service = Service::find ($request->id);
            $total_currency = 0;
            $ids = [];
            $item = [];
            $manager = false;

            if (!isset($service->service_items[0]->detailed_proposal_budget_id)) {
                $manager = true;
            }

            if (isset($service_data['recipient']) && $service_data['payment_type_id'] == 310675) {
                $service['recipient_account_id'] = $service['bank_account'];
            }
            if (isset($service_data['supplier_id']) && $service_data['payment_type_id'] == 310675) {
                $service['supplier_account_id'] = $service['bank_account'];
            }
            $filename=false;
            if ($request->hasFile ('receipt_file')) {
                $file = $request->file ('receipt_file');
                $filename = time () . '.pdf';
                $file->move ('file/invoice', $filename);
            }
            if (!is_null ($service_data)) {
                if ($service->service_type_id == 375446) {
                    if (isset($request->service_item, $service->service_items[0]->detailed_proposal_budget_id)) {
                        foreach ($request->service_item as $key => $value) {
                            $value['modified_by'] = Auth::user ()->full_name;
                            $total_currency += $value['quantity'] * $value['unit_cost'];
                            if (isset($value['id'])) {
                                $id = $value['id'];
                                unset($value['id'], $value['total']);
                                $value['exchange_rate'] = $service->user_exchange_rate;
                                ServiceItem::whereId ($id)->update ($value);
                                $ids[] = $id;
                            }
                        }
                        $service_data['total_currency'] = $total_currency;
                        $service_data['total_usd'] = $total_currency / $service->user_exchange_rate;
                        $service->service_items ()->whereNotIn ('id', $ids)->delete ();
                        $service_data['modified_by'] = Auth::user ()->full_name;
                        $service->update ($service_data);
                    } elseif (isset($request->service_item) && !isset($service->service_items[0]->detailed_proposal_budget_id)) {
                        $total_currency = $service->service_items ()->groupBy ('service_id')->selectRaw ('sum(quantity * unit_cost)')->first ()->sum;
                        foreach ($request->service_item as $key => $value) {
//                        $total_currency += $value['quantity'] * $value['unit_cost'];
                            $value['modified_by'] = Auth::user ()->full_name;
                            if (isset($value['id'])) {
                                $id = $value['id'];
                                unset($value['id'], $value['availability'], $value['availability_old'], $value['total']);
                                $value['exchange_rate'] = $service->user_exchange_rate;
                                ServiceItem::whereId ($id)->update ($value);
                                $ids[] = $id;
                            }
                        }
                        $service_data['total_currency'] = $total_currency;
                        $service_data['total_usd'] = $total_currency / $service->user_exchange_rate;
                        $service_data['modified_by'] = Auth::user ()->full_name;
                        $service->update ($service_data);
                    }
                }
                else {
                    if ($service_data['payment_method_id'] == 3297) {
                        if (isset($request->service_item, $service->service_items[0]->detailed_proposal_budget_id)) {
                            foreach ($request->service_item as $key => $value) {
                                $value['modified_by'] = Auth::user ()->full_name;
                                $total_currency += $value['quantity'] * $value['unit_cost'];
                                if (isset($value['id'])) {
                                    $id = $value['id'];
                                    unset($value['id'], $value['total']);
                                    $value['exchange_rate'] = $service->user_exchange_rate;
                                    ServiceItem::whereId ($id)->update ($value);
                                    $ids[] = $id;
                                }
                            }
                            $service_data['total_currency'] = $total_currency;
                            $service_data['total_usd'] = $total_currency / $service->user_exchange_rate;
                            $service->service_items ()->whereNotIn ('id', $ids)->delete ();
                            $service_data['modified_by'] = Auth::user ()->full_name;
                            $service->update ($service_data);
                        } elseif (isset($request->service_item) && !isset($service->service_items[0]->detailed_proposal_budget_id)) {
                            $total_currency = $service->service_items ()->groupBy ('service_id')->selectRaw ('sum(quantity * unit_cost)')->first ()->sum;
                            foreach ($request->service_item as $key => $value) {
                                $value['modified_by'] = Auth::user ()->full_name;
                                if (isset($value['id'])) {
                                    $id = $value['id'];
                                    unset($value['id'], $value['availability'], $value['availability_old'], $value['total']);
                                    $value['exchange_rate'] = $service->user_exchange_rate;
                                    ServiceItem::whereId ($id)->update ($value);
                                    $ids[] = $id;
                                }
                            }
                            $service_data['total_currency'] = $total_currency;
                            $service_data['total_usd'] = $total_currency / $service->user_exchange_rate;
                            $service_data['modified_by'] = Auth::user ()->full_name;
                            $service->update ($service_data);
                        }
                    }
                    else {
                        $dt = Carbon::now ();
                        $count = Service::where ('service_type_id', 375649)->whereYear ('created_at', '=', $dt->year)->count ();
                        $code = str_pad ($count + 1, 4, '0', STR_PAD_LEFT);
                        $new_code = 'PYO ' . $code . '-' . $dt->year;
                        if (isset($request->service_item_direct, $service->service_items[0]->detailed_proposal_budget_id)) {
                            foreach ($request->service_item_direct as $key => $value) {
                                $value['modified_by'] = Auth::user ()->full_name;
                                $total_currency += ($value['quantity'] * $value['unit_cost']) / $value['exchange_rate'];
                                if (isset($value['id'])) {
                                    $id = $value['id'];
                                    unset($value['id'], $value['total']);
                                    $item[] = new ServiceInvoice($value);
                                    ServiceItem::whereId ($id)->update ($value);
                                    $ids[] = $id;
                                }
                            }
                            echo 'test ';
                            $service_data['total_usd'] = $total_currency;
                            $service->service_items ()->whereNotIn ('id', $ids)->delete ();
                            $service_data['modified_by'] = Auth::user ()->full_name;
                            $service_data['receipt_file'] = $filename;
                            $service_data['completed'] = true;
                            $service->update ($service_data);
                            $pyo_service = $service->replicate ();
                            $pyo_service['parent_id'] = $service->id;
                            $pyo_service['code'] = $new_code;
                            $pyo_service['service_type_id'] = 375649;
                            $pyo_service['stored_by'] = Auth::user ()->full_name;
                            $pyo_service['requester'] = Auth::id ();
                            $pyo_service['receipt_file'] = $filename;

                            $pyo_service->save ();
                            $pyo_service->service_invoices ()->saveMany ($item);
                        } elseif (isset($request->service_item) && !isset($service->service_items[0]->detailed_proposal_budget_id)) {
                            foreach ($request->service_item as $key => $value) {
                                $value['modified_by'] = Auth::user ()->full_name;
                                $total_currency += $value['quantity'] * $value['unit_cost'];
                                if (isset($value['id'])) {
                                    $id = $value['id'];
                                    unset($value['id'], $value['total']);
                                    $item[] = new ServiceInvoice($value);
                                    ServiceItem::whereId ($id)->update ($value);
                                    $ids[] = $id;
                                }
                            }
                            $service_data['total_currency'] = $total_currency;
                            $service_data['total_usd'] = $total_currency / $service->user_exchange_rate;
                            $service_data['modified_by'] = Auth::user ()->full_name;
//                            $service_data['receipt_file'] = $filename;
                            $service->update ($service_data);
//                            $pyo_service = $service->replicate ();
//                            $pyo_service['code'] = $new_code;
//                            $pyo_service['service_type_id'] = 375649;
//                            $pyo_service['stored_by'] = Auth::user ()->full_name;
//                            $pyo_service['requester'] = Auth::id ();
//                            $pyo_service['receipt_file'] = $filename;
//
//                            $pyo_service->save ();
//                            $pyo_service->service_invoice ()->saveMany ($item);
                        }

                    }
                }


            } else {
                if (isset($request->service_item)) {
                    foreach ($request->service_item as $key => $value) {
                        ServiceItem::whereId ($value['id'])->update (['modified_by' => Auth::user ()->full_name, 'detailed_proposal_budget_id' => $value['detailed_proposal_budget_id']]);
                    }
                }

            }
            $url = 'service.logistic_show';
            if ($service->service_model_id == 375449) {
                if ($service->payment_method_id == 3297 && $service->service_type_id != 375447) {
                    $this->notification_office ("$service->project_id", "$service->id", 'mission_mr_advance_service', "$url", $count = 0, '375547', "$manager", false, false);
                }
                if ($service->payment_method_id == 3297 && $service->service_type_id == 375447) {
                    $this->notification_office ("$service->project_id", "$service->id", 'mission_pyr_logistic_advance_service', "$url", $count = 0, '375547', "$manager", false, false);

                }
                if ($service->payment_method_id == 3296 && $service->service_type_id != 375447) {
                    $this->notification_office ("$service->project_id", "$service->id", 'mission_mr_direct_service', "$url", $count = 0, '375547', "$manager", false, false);
                }
                if ($service->payment_method_id == 3296 && $service->service_type_id == 375447) {
                    $this->notification_office ("$service->project_id", "$service->id", 'mission_pyr_logistic_direct_service', "$url", $count = 0, '375547', "$manager", false, false);

                }
            } else {
                if ($service->payment_method_id == 3297 && $service->service_type_id != 375447) {
                    $this->notification ("$service->project_id", "$service->id", 'mr_advance_service', "$url", $count = 0, '375547', "$manager", false, false);
                }
                if ($service->payment_method_id == 3297 && $service->service_type_id == 375447) {
                    $this->notification ("$service->project_id", "$service->id", 'pyr_logistic_advance_service', "$url", $count = 0, '375547', "$manager", false, false);

                }
                if ($service->payment_method_id == 3296 && $service->service_type_id != 375447) {
                    $this->notification ("$service->project_id", "$service->id", 'mr_direct_service', "$url", $count = 0, '375547', "$manager", false, false);
                }
                if ($service->payment_method_id == 3296 && $service->service_type_id == 375447) {
                    $this->notification ("$service->project_id", "$service->id", 'pyr_logistic_direct_service', "$url", $count = 0, '375547', "$manager", false, false);

                }
            }
//        return $this->setStatusCode (422)->respond (['error' => ['Something is error']]);
            return $this->setStatusCode (200)->respond (['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => ['Something is error']]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function mission_holder_update (Request $request): JsonResponse
    {
        try {
            $service_data = $request->service;
            $service = Service::find ($request->id);
            $total_currency = 0;
            $ids = [];
            $item = [];
            $manager = false;
//      if(!is_null ($service_data))  {
            if ($service->service_type_id == 375446) {
                if (isset($request->service_item, $service->service_items[0]->detailed_proposal_budget_id)) {
                    foreach ($request->service_item as $key => $value) {
                        $value['modified_by'] = Auth::user ()->full_name;
                        $total_currency += $value['quantity'] * $value['unit_cost'];
                        if (isset($value['id'])) {
                            $id = $value['id'];
                            unset($value['id'], $value['total']);
                            $value['exchange_rate'] = $service->user_exchange_rate;
                            ServiceItem::whereId ($id)->update ($value);
                            $ids[] = $id;
                        }
                    }
                    $service_data['total_currency'] = $total_currency;
                    $service_data['total_usd'] = $total_currency / $service->user_exchange_rate;
                    $service->service_items ()->whereNotIn ('id', $ids)->delete ();
                    $service_data['modified_by'] = Auth::user ()->full_name;
                    $service->update ($service_data);
                } elseif (isset($request->service_item) && !isset($service->service_items[0]->detailed_proposal_budget_id)) {
//                   $total_currency = $service->service_items ()->groupBy ('service_id')->selectRaw ('sum(quantity * unit_cost)')->first ()->sum;
                    foreach ($request->service_item as $key => $value) {
                        $total_currency += $value['quantity'] * $value['unit_cost'];
                        $value['modified_by'] = Auth::user ()->full_name;
                        if (isset($value['id'])) {
                            $id = $value['id'];
                            unset($value['id'], $value['availability'], $value['availability_old'], $value['total']);
                            $value['exchange_rate'] = $service->user_exchange_rate;
                            ServiceItem::whereId ($id)->update ($value);
                            $ids[] = $id;
                        }
                    }

                    $service_data['total_currency'] = $total_currency;
                    $service_data['total_usd'] = $total_currency / $service->user_exchange_rate;
                    $service_data['modified_by'] = Auth::user ()->full_name;
                    $service->update ($service_data);
                }
            } else {
                if ($service->payment_method_id == 3297) {
                    if (isset($request->service_item, $service->service_items[0]->detailed_proposal_budget_id)) {
                        foreach ($request->service_item as $key => $value) {
                            $value['modified_by'] = Auth::user ()->full_name;
                            $total_currency += $value['quantity'] * $value['unit_cost'];
                            if (isset($value['id'])) {
                                $id = $value['id'];
                                unset($value['id'], $value['total']);
                                $value['exchange_rate'] = $service->user_exchange_rate;
                                ServiceItem::whereId ($id)->update ($value);
                                $ids[] = $id;
                            }
                        }
                        $service_data['total_currency'] = $total_currency;
                        $service_data['total_usd'] = $total_currency / $service->user_exchange_rate;
                        $service->service_items ()->whereNotIn ('id', $ids)->delete ();
                        $service_data['modified_by'] = Auth::user ()->full_name;
                        $service->update ($service_data);
                    } elseif (isset($request->service_item) && !isset($service->service_items[0]->detailed_proposal_budget_id)) {
                        $total_currency = $service->service_items ()->groupBy ('service_id')->selectRaw ('sum(quantity * unit_cost)')->first ()->sum;
                        foreach ($request->service_item as $key => $value) {
                            $value['modified_by'] = Auth::user ()->full_name;
                            if (isset($value['id'])) {
                                $id = $value['id'];
                                unset($value['id'], $value['availability'], $value['availability_old'], $value['total']);
                                $value['exchange_rate'] = $service->user_exchange_rate;
                                ServiceItem::whereId ($id)->update ($value);
                                $ids[] = $id;
                            }
                        }

                        $service_data['total_currency'] = $total_currency;
                        $service_data['total_usd'] = $total_currency / $service->user_exchange_rate;
                        $service_data['modified_by'] = Auth::user ()->full_name;
                        $service->update ($service_data);
                    }

                } else {
                    if (isset($request->service_item)) {
                        foreach ($request->service_item as $key => $value) {
                            $value['modified_by'] = Auth::user ()->full_name;
                            $total_currency += ($value['quantity'] * $value['unit_cost']) / $value['exchange_rate'];
                            if (isset($value['id'])) {
                                $id = $value['id'];
                                unset($value['id'], $value['total']);
                                $item[] = new ServiceInvoice($value);
                                ServiceItem::whereId ($id)->update ($value);
                                ServiceInvoice::whereId ($id)->update ($value);
                                $ids[] = $id;
                            }
                        }
                        $service_data['total_usd'] = $total_currency;
                        $service_data['total_currency'] = $total_currency;
                        $service->service_items ()->whereNotIn ('id', $ids)->delete ();
                        $service->service_invoices ()->whereNotIn ('id', $ids)->delete ();
                        $service_data['modified_by'] = Auth::user ()->full_name;

                        $pyo_service = Service::where ('parent_id', $service->parent_id);
                        $pyo_service->update ($service_data);
                        $service->update ($service_data);
                    }
                }
            }
            $url = 'service.show';
            if ($service->payment_method_id == 3297 && $service->service_type_id != 375447) {
                if ($service->service_method_id == 66893) {
                    $this->notification_office ("$service->project_id", "$service->id", 'mission_mr_advance_service', "$url", $count = 0, '375547', "$manager", false, false);
                } else {
                    $this->notification_office ("$service->project_id", "$service->id", 'mission_mr_advance_service', "$url", $count = 0, '375547', "$manager", false, false);

                }
            }
            if ($service->payment_method_id == 3297 && $service->service_type_id == 375447) {
                if ($service->service_method_id == 66893) {
                    $this->notification_office ("$service->project_id", "$service->id", 'mission_pyr_logistic_advance_service', "$url", $count = 0, '375547', "$manager", false, false);
                } else {
                    $this->notification_office ("$service->project_id", "$service->id", 'mission_pyr_advance_service', "$url", $count = 0, '375547', "$manager", false, false);

                }
            }
            if ($service->payment_method_id == 3296 && $service->service_type_id != 375447) {
                if ($service->service_method_id == 66893) {
                    $this->notification_office ("$service->project_id", "$service->id", 'mission_mr_direct_service', "$url", $count = 0, '375547', "$manager", false, false);
                } else {
                    $this->notification_office ("$service->project_id", "$service->id", 'mission_mr_direct_service', "$url", $count = 0, '375547', "$manager", false, false);

                }
            }
            if ($service->payment_method_id == 3296 && $service->service_type_id == 375447) {
                if ($service->service_method_id == 66893) {
                    $this->notification_office ("$service->project_id", "$service->id", 'mission_pyr_logistic_direct_service', "$url", $count = 0, '375547', "$manager", false, false);

                } else {
                    $this->notification_office ("$service->project_id", "$service->id", 'mission_pyr_direct_service', "$url", $count = 0, '375547', "$manager", false, false);

                }

            }
//        return $this->setStatusCode (422)->respond (['error' => ['Something is error']]);
            return $this->setStatusCode (200)->respond (['status' => true]);
        } catch (\Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => ['Something is error']]);
        }
    }
    /**
     * @param $id
     * @return Redirector|View
     */
    public function show ($id)
    {
        $this->data['check_notification'] = ProjectNotification::where ('url_id', $id)->where ('receiver', Auth::id ())->where ('status_id', $this->in_progress)->first ();
        if (is_null ($this->data['check_notification'])) {
            return redirect ('home');
        }
        $this->data['service'] = Service::with ('service_items.item', 'service_items.unit', 'project', 'currency')->find ($id);

        return view ('layouts.services.show', $this->data);
    }
    /**
     * @param $id
     * @return Redirector|View
     */
    public function ajax_view ($id)
    {
        $this->data['service'] = Service::with ('service_items.item', 'service_items.unit', 'project', 'currency')->find ($id);
        return view ('layouts.ajax_view.service.project.view', $this->data);
    }
    /**
     * @param $id
     * @return Redirector|View
     */
    public function ajax_office_view ($id)
    {

        $service = Service::find ($id);
        $service_items = ServiceItem::where ('service_id', $id)->get ();
        $total_currencies = ServiceItem::select (DB::raw ('sum(quantity * unit_cost)'))->where ('service_id', $id)->get ();
        $total_usd = ServiceItem::select (DB::raw ('sum(quantity * unit_cost / exchange_rate)'))->where ('service_id', $id)->get ();
        return view ('layouts.ajax_view.service.office.view', compact ('service', 'service_items', 'total_currencies', 'total_usd'));
    }
    /**
     * @param $id
     * @return Redirector|View
     */
    public function cycle ($id)
    {
        $this->data['notifications'] = ProjectNotification::where ('url_id', $id)->orderBy ('id')->with ('user_receiver')->get ();


        return view ('layouts.services.cycle', $this->data);
    }
    /**
     * @param $id
     * @return Redirector|View
     */
    public function logistic_show ($id)
    {
        $service = Service::find ($id);
        $check_notification = ProjectNotification::where ('url_id', $id)->where ('receiver', Auth::id ())->where ('status_id', $this->in_progress)->first ();
        if (is_null ($check_notification)) {
            return redirect ('home');
        }
        $service_items = ServiceItem::where ('service_id', $id)->get ();
        $total_currencies = ServiceItem::select (DB::raw ('sum(quantity * unit_cost)'))->where ('service_id', $id)->get ();
        $total_usd = ServiceItem::select (DB::raw ('sum(quantity * unit_cost / exchange_rate)'))->where ('service_id', $id)->get ();
        return view ('layouts.services.logistic_show', compact ('service', 'check_notification', 'service_items', 'total_currencies', 'total_usd'));
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
    public function notification ($project_id = '', $url_id = '', $type = 0, $url = '', $count = 0, $message_id = '0', $manager = false, $last = false, $my = false): ?bool
    {
        $structure = ProjectNotificationStructure::where ('project_id', $project_id)->first ();
        $notification = ProjectNotification::where ('url_id', $url_id)->where ('status_id', $this->in_progress)->latest ('id')->first ();
        if ($my) {
            $notification = ProjectNotification::where ('url_id', $url_id)->latest ('id')->first ();
        }
        if (is_null ($notification)) {
            if ($count == 0) {
                $requester = Auth::id ();
            } else {
                $notification_2 = ProjectNotification::where ('url_id', $url_id)->latest ('id')->first ();
                if (!is_null ($notification)) {
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
        if ($type_id == '') {
            $type_id = NotificationType::where ('module_name', $type)->latest ('id')->first ()->id;

        }
        if (!isset($requester) || is_null ($requester)) {
            $requester = Auth::id ();
        }
//        echo $type_id;
        $cycles = NotificationCycle::where ('notification_type_id', $type_id)->orderBy ('orderby')->get ();
        $count_notification = count (ProjectNotification::where ('url_id', $url_id)->where ('notification_type_id', $type_id)->groupBy ('step')->select ('step')->get ());
        if ($count_notification == 1) {
            --$count_notification;
        }
        if (isset($cycles[$count_notification + $count]) && $cycles[$count_notification + $count]->notification_receiver_id == 375431) {
            $count_notification_step = ProjectNotification::where ('url_id', $url_id)->where ('notification_type_id', $type_id)->where ('step', '375431')->select ('step')->count ();
            if ($cycles[$count_notification + $count]->number_of_superiors == 0) {
                if ($delegated_user_id != null) {
                    $parent_user = User::find ($notification->delegated_user_id)->parent_id;
                } elseif ($count_notification_step == 0) {
                    $parent_user = User::find ($requester)->parent_id;
                } else {
                    $parent_user = Auth::user ()->parent_id;
                }
                $next_user = User::where ('position_id', '!=', 32)->find ($parent_user);
                if (is_null ($next_user)) {
                    $this->notification ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                    return true;
                }
                $user_id = $this->delegation_or_disabled ($next_user->id, 0);
                if ($this->check_notification ($user_id, $url_id) || $this->check_notification ($next_user->id, $url_id)) {
                    $this->notification ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                    return true;
                }
                if ($user_id == $next_user->id) {
                    $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, true);
                } else {
                    $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, true, $next_user->id);
                }

            } else {
                $count_notification_step = ProjectNotification::where ('url_id', $url_id)->where ('step', 375431)->count ();
                if ($count_notification_step == $cycles[$count_notification + $count]->number_of_superiors) {
//                    $this->notification_project ($url_id, $type_id, $url, $count++);
                } else {
//                    echo 'insert user 2';
                }
            }
        } else {
            if (isset($cycles[$count_notification + $count])) {
                if ($cycles[$count_notification + $count]->notification_receiver_id == 375483) {
                    $recipient = Service::find ($url_id)->recipient;
                    if (is_null ($recipient)) {
                        $this->notification ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                        return true;
                    }
                    $user_id = $this->delegation_or_disabled ($recipient);
                    if ($this->check_notification ($recipient, $url_id) || $this->check_notification ($user_id, $url_id)) {
                        $this->notification ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                        return true;
                    }
                    if ($user_id == $recipient) {
                        $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $cycles[$count_notification + $count]->authorized);
                    } else {
                        $delegated_user_id = $requester;
                        $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $cycles[$count_notification + $count]->authorized, $delegated_user_id);
                    }
                } elseif ($cycles[$count_notification + $count]->notification_receiver_id == 375467 && $manager) {
                    $receiver_name = NotificationReceiver::where ('id', $cycles[$count_notification + $count]->notification_receiver_id)->first ();
                    $receiver_id = $structure[$receiver_name->name_en];
                    $user_id = $this->delegation_or_disabled ($receiver_id);
                    if ($this->check_notification ($receiver_id, $url_id) || $this->check_notification ($user_id, $url_id)) {
                        $this->notification ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                        return true;
                    }
                    if ($user_id == $receiver_id) {
                        $this->new_notification_project_authorized ($url_id, $type_id, 'service.project_manager', $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $cycles[$count_notification + $count]->authorized);
                    } else {
                        $delegated_user_id = $receiver_id;
                        $this->new_notification_project_authorized ($url_id, $type_id, 'service.project_manager', $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $cycles[$count_notification + $count]->authorized, $delegated_user_id);
                    }
                } elseif ($cycles[$count_notification + $count]->notification_receiver_id == 375467 && !$manager) {
                    $receiver_name = NotificationReceiver::where ('id', $cycles[$count_notification + $count]->notification_receiver_id)->first ();
                    $receiver_id = $structure[$receiver_name->name_en];
                    $user_id = $this->delegation_or_disabled ($receiver_id);
                    $service = Service::find ($url_id);

//                    if ($service->service_method_id != 66893) {
                    if ($this->check_notification ($receiver_id, $url_id)) {
                        $this->notification ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                        return true;
                    }
//                    }
                    echo $count_notification;
                    if ($user_id == $receiver_id) {
                        $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $cycles[$count_notification +
                        $count]->authorized);
                    } else {
                        $delegated_user_id = $receiver_id;
                        $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $cycles[$count_notification +
                        $count]->authorized, $delegated_user_id);
                    }
                } else {

                    $receiver_name = NotificationReceiver::where ('id', $cycles[$count_notification + $count]->notification_receiver_id)->first ();
                    $receiver_id = $structure[$receiver_name->name_en];
                    if (is_null ($receiver_id)) {
                        $this->notification ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                    } else {
                        $user_id = $this->delegation_or_disabled ($receiver_id);
                        if (is_null ($user_id)) {
                            $this->notification ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                            return true;
                        }
                        if ($cycles[$count_notification + $count]->authorized) {
                            if ($this->check_notification ($receiver_id, $url_id) || $this->check_notification ($user_id, $url_id)) {
                                $this->notification ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                                return true;
                            }
                            if ($user_id == $receiver_id) {
                                $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $cycles[$count_notification + $count]->authorized);
                            } else {
                                $delegated_user_id = $receiver_id;
                                $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $cycles[$count_notification + $count]->authorized, $delegated_user_id);
                            }
                        } elseif (!$cycles[$count_notification + $count]->authorized) {

                            if ($user_id == $receiver_id) {
                                $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $cycles[$count_notification + $count]->authorized);
                                $user_id = $this->delegation_or_disabled ($requester);
                                if (!is_null ($user_id) && $user_id == $requester) {
                                    $this->new_notification_project_authorized ($url_id, $type_id, $url, '457086', $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, false);
                                } else {
                                    $this->new_notification_project_authorized ($url_id, $type_id, $url, '457086', $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, false, $delegated_user_id);
                                }
                            } else {
                                $delegated_user_id = $receiver_id;
                                $user_id = $this->delegation_or_disabled ($requester);
                                if (!is_null ($user_id) && $user_id == $requester) {
                                    $this->new_notification_project_authorized ($url_id, $type_id, $url, '457086', $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, false);
                                } else {
                                    $this->new_notification_project_authorized ($url_id, $type_id, $url, '457086', $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, false, $requester);
                                }
                                $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $cycles[$count_notification + $count]->authorized, $delegated_user_id);
                            }
                            $service = Service::where ('id', $url_id)->orWhere ('parent_id', $url_id)->update (['status_id' => 170]);

                        }
                    }
                }
            } else {
                $user_id = $this->delegation_or_disabled ($requester);
                if (!is_null ($user_id) && $user_id == $requester) {
                    $this->new_notification_project_authorized ($url_id, $type_id, $url, '457086', $this->in_progress, $requester, $user_id, 0, false);
                } else {
                    $this->new_notification_project_authorized ($url_id, $type_id, $url, '457086', $this->in_progress, $requester, $user_id, 0, false, $requester);
                }
                $service = Service::where ('id', $url_id)->orWhere ('parent_id', $url_id)->update (['status_id' => 170]);
                return true;
            }

        }
        return true;
    }
    /**
     * @param string $office_id
     * @param string $url_id
     * @param int $type
     * @param string $url
     * @param int $count
     * @param string $message_id
     * @param bool $manager
     * @param bool $last
     * @param bool $my
     * @return bool
     */
    public function notification_office ($office_id = '', $url_id = '', $type = 0, $url = '', $count = 0, $message_id = '0', $manager = false, $last = false, $my = false): bool
    {
        $type_id = NotificationType::where ('module_name', $type)->latest ('id')->first ()->id;
        $notification = ProjectNotification::where ('url_id', $url_id)->where ('status_id', $this->in_progress)->latest ('id')->first ();
        if ($my) {
            $notification = ProjectNotification::where ('url_id', $url_id)->latest ('id')->first ();
        }
        if (is_null ($notification)) {

            if ($count == 0) {
                $requester = Auth::id ();
            } else {
                $notification_2 = ProjectNotification::where ('url_id', $url_id)->latest ('id')->first ();
                if (!is_null ($notification)) {
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
        if (!isset($requester) || is_null ($requester)) {
            $requester = Auth::id ();
        }
        $mission_id = User::find ($requester)->mission_id;
        $structure = Mission::where ('id', $mission_id)->first ();

        if ($type_id == '') {
            $type_id = NotificationType::where ('module_name', $type)->latest ('id')->first ()->id;
        }

        $cycles = NotificationCycle::where ('notification_type_id', $type_id)->orderBy ('orderby')->get ();

        $count_notification = count (ProjectNotification::where ('url_id', $url_id)->where ('notification_type_id', $type_id)->groupBy ('step')->select ('step')->get ());
        if ($count_notification == 1) {
            $count_notification = $count_notification - 1;
        }
        $count_notification_step = ProjectNotification::where ('url_id', $url_id)->where ('step', 375431)->count ();
        $count_cycle_step = NotificationCycle::where ('notification_type_id', $type_id)->where ('notification_receiver_id', 375431)->count ();
        $parent_user = User::find ($requester)->parent_id;
        $next_user = User::where ('position_id', '!=', 32)->find ($parent_user);
        if (is_null ($next_user)) {
            $notification_23 = ProjectNotification::where ('url_id', $url_id)->latest ('id')->first ();
            if (is_null ($notification_23)) {
                $count_notification = 0;
            } else {
                if ($notification_23->step == 0) {
                    $count_notification = 0;
                } else {
                    $count_notification = NotificationCycle::where ('notification_type_id', $type_id)->where ('notification_receiver_id', $notification_23->step)->first ()->orderby;

                    $count_notification++;
                }
            }
        }
        if (isset($cycles[$count_notification + $count]) && $cycles[$count_notification + $count]->notification_receiver_id == 375431) {
            $count_notification_step = ProjectNotification::where ('url_id', $url_id)->where ('notification_type_id', $type_id)->where ('step', '375431')->select ('step')->count ();
            if ($cycles[$count_notification + $count]->number_of_superiors == 0) {
                if ($delegated_user_id != null) {
                    $parent_user = User::find ($notification->delegated_user_id)->parent_id;
                } elseif ($count_notification_step == 0) {
                    $parent_user = User::find ($requester)->parent_id;
                } else {
                    $parent_user = Auth::user ()->parent_id;
                }
                $next_user = User::where ('position_id', '!=', 32)->find ($parent_user);
                if (is_null ($next_user)) {
                    $this->notification_office ($office_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                    return true;
                }
                $user_id = $this->delegation_or_disabled ($next_user->id, 0);
                if ($this->check_notification ($user_id, $url_id) || $this->check_notification ($next_user->id, $url_id)) {
                    $this->notification_office ($office_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                    return true;
                }
                if ($user_id == $next_user->id) {
                    $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, true);
                } else {
                    $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, true, $next_user->id);
                }

            } else {

                $count_notification_step = ProjectNotification::where ('url_id', $url_id)->where ('step', 375431)->count ();
                if ($count_notification_step == $cycles[$count_notification + $count]->number_of_superiors) {
                    $this->notification_office ($office_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                } else {

                    if ($count_notification_step == 0) {
                        $parent_user = User::find ($requester)->parent_id;
                    } else {
                        $parent_user = Auth::user ()->parent_id;
                    }
                    $next_user = User::where ('position_id', '!=', 32)->find ($parent_user);
                    if (is_null ($next_user)) {
                        $this->notification_office ($office_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                        return true;
                    }
                    $user_id = $this->delegation_or_disabled ($next_user->id, 0);
                    if ($this->check_notification ($user_id, $url_id) || $this->check_notification ($next_user->id, $url_id)) {
                        $this->notification_office ($office_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                        return true;
                    }
                    if ($user_id == $next_user->id) {
                        $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, true);
                    } else {
                        $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, true, $next_user->id);
                    }
                }
            }
        } else {
            if (isset($cycles[$count_notification + $count])) {
                $count_notification_step = ProjectNotification::where ('url_id', $url_id)->where ('step', $cycles[$count_notification + $count]->notification_receiver_id)->count ();

                if ($cycles[$count_notification + $count]->notification_receiver_id == 375483 && $count_notification_step == 0) {
                    $recipient = Service::find ($url_id)->recipient;
                    if (is_null ($recipient)) {
                        $this->notification_office ($office_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                        return true;
                    }
                    $user_id = $this->delegation_or_disabled ($recipient);
                    if ($this->check_notification ($recipient, $url_id) || $this->check_notification ($user_id, $url_id)) {
                        $this->notification_office ($office_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                        return true;
                    }
                    if ($user_id == $recipient) {

                        $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $cycles[$count_notification + $count]->authorized);
                    } else {
                        $delegated_user_id = $requester;
                        $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $cycles[$count_notification + $count]->authorized, $delegated_user_id);
                    }
                } elseif ($cycles[$count_notification + $count]->notification_receiver_id == 375472 && $count_notification_step == 0) {
                    $receiver_name = NotificationReceiver::where ('id', $cycles[$count_notification + $count]->notification_receiver_id)->first ();
                    $receiver_id = $structure[$receiver_name->name_en];
                    $user_id = $this->delegation_or_disabled ($receiver_id);
                    if ($user_id == $receiver_id) {
                        $this->new_notification_project_authorized ($url_id, $type_id, 'service.mission_budget_holder', $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $cycles[$count_notification + $count]->authorized);
                    } else {
                        $delegated_user_id = $receiver_id;
                        $this->new_notification_project_authorized ($url_id, $type_id, 'service.mission_budget_holder', $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $cycles[$count_notification + $count]->authorized, $delegated_user_id);
                    }
                } elseif ($cycles[$count_notification + $count]->notification_receiver_id == 375467) {
                    $step_count = ProjectNotification::where ('url_id', $url_id)->where ('step', 375467)->count ();
                    if ($step_count != 0) {
                        $this->notification_office ($office_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                        return true;
                    }
                    $projects = Service::find ($url_id)->service_items ()->groupBy ('project_id')->select ('project_id')->get ();
                    foreach ($projects as $project) {
                        $project_notification_structure = ProjectNotificationStructure::where ('project_id', $project->project_id)->first ();
//                       $receiver_name = NotificationReceiver::where ('id', $cycles[$count_notification + $count]->notification_receiver_id)->first ();
                        $receiver_id = $project_notification_structure->project_manager;
                        $user_id = $this->delegation_or_disabled ($receiver_id);
                        if ($user_id == $receiver_id) {
                            $this->new_notification_project_authorized ($url_id, $type_id, 'service.manager_accountant_show', $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $cycles[$count_notification + $count]->authorized);
                        } else {
                            $delegated_user_id = $receiver_id;
                            $this->new_notification_project_authorized ($url_id, $type_id, 'service.manager_accountant_show', $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $cycles[$count_notification + $count]->authorized, $delegated_user_id);
                        }
                    }
                } elseif ($cycles[$count_notification + $count]->notification_receiver_id == 375471 && $count_notification_step == 0) {
                    $step_count = ProjectNotification::where ('url_id', $url_id)->where ('step', 375471)->count ();
                    if ($step_count != 0) {
                        $this->notification_office ($office_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                        return true;
                    }
                    $projects = Service::find ($url_id)->service_items ()->groupBy ('project_id')->select ('project_id')->get ();
                    foreach ($projects as $project) {
                        $project_notification_structure = ProjectNotificationStructure::where ('project_id', $project->project_id)->first ();
//                       $receiver_name = NotificationReceiver::where ('id', $cycles[$count_notification + $count]->notification_receiver_id)->first ();
                        $receiver_id = $project_notification_structure->project_accountant;
                        $user_id = $this->delegation_or_disabled ($receiver_id);
                        if ($user_id == $receiver_id) {
                            $this->new_notification_project_authorized ($url_id, $type_id, 'service.manager_accountant_show', $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $cycles[$count_notification + $count]->authorized);
                        } else {
                            $delegated_user_id = $receiver_id;
                            $this->new_notification_project_authorized ($url_id, $type_id, 'service.manager_accountant_show', $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $cycles[$count_notification + $count]->authorized, $delegated_user_id);
                        }
                    }
                } else {
                    $receiver_name = NotificationReceiver::where ('id', $cycles[$count_notification + $count]->notification_receiver_id)->first ();
                    $receiver_id = $structure[$receiver_name->name_en];
                    if (is_null ($receiver_id)) {
                        $this->notification_office ($office_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                    } else {
                        $user_id = $this->delegation_or_disabled ($receiver_id);
                        if (is_null ($user_id)) {
                            $this->notification_office ($office_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                            return true;
                        }
                        if ($cycles[$count_notification + $count]->authorized) {
                            if ($this->check_notification ($receiver_id, $url_id) || $this->check_notification ($user_id, $url_id)) {
                                $this->notification_office ($office_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                                return true;
                            }
                            if ($user_id == $receiver_id) {
                                $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $cycles[$count_notification + $count]->authorized);
                            } else {
                                $delegated_user_id = $receiver_id;
                                $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $cycles[$count_notification + $count]->authorized, $delegated_user_id);
                            }
                        } elseif (!$cycles[$count_notification + $count]->authorized) {
                            if ($user_id == $receiver_id) {
                                $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $cycles[$count_notification + $count]->authorized);
                                $user_id = $this->delegation_or_disabled ($requester);
                                if (!is_null ($user_id) && $user_id == $requester) {
                                    $this->new_notification_project_authorized ($url_id, $type_id, $url, '457086', $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, false);
                                } else {
                                    $this->new_notification_project_authorized ($url_id, $type_id, $url, '457086', $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, false, $delegated_user_id);
                                }
                            } else {
                                $delegated_user_id = $receiver_id;
                                $user_id = $this->delegation_or_disabled ($requester);
                                if (!is_null ($user_id) && $user_id == $requester) {
                                    $this->new_notification_project_authorized ($url_id, $type_id, $url, '457086', $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, false);
                                } else {
                                    $this->new_notification_project_authorized ($url_id, $type_id, $url, '457086', $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, false, $requester);
                                }
                                $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $cycles[$count_notification + $count]->authorized, $delegated_user_id);
                            }
                            $service = Service::where ('id', $url_id)->orWhere ('parent_id', $url_id)->update (['status_id' => 170]);

                        }
                    }
                }
            } else {
                $user_id = $this->delegation_or_disabled ($requester);
                if (!is_null ($user_id) && $user_id == $requester) {
                    $this->new_notification_project_authorized ($url_id, $type_id, $url, '457086', $this->in_progress, $requester, $user_id, 0, false);
                } else {
                    $this->new_notification_project_authorized ($url_id, $type_id, $url, '457086', $this->in_progress, $requester, $user_id, 0, false, $requester);
                }
                $service = Service::where ('id', $url_id)->orWhere ('parent_id', $url_id)->update (['status_id' => 170]);
                return true;
            }

        }
        return true;
    }
    /**
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function logistic_action (Request $request)
    {
        $check_notification = ProjectNotification::where ('url_id', $request->id)->where ('receiver', Auth::id ())->where ('status_id', $this->in_progress)->first ();
        if (is_null ($check_notification)) {
            return redirect ('home');
        }
        if ($request->action == 'reject') {
            $this->new_notification_project_authorized ($request->id, $check_notification->notification_type_id, 'service.logistic_show', 457087, $this->in_progress, $check_notification->requester, $check_notification->requester, 0, false);
            $check_notification->status_id = 171;
            $check_notification->update ();
            $service = Service::find ($request->id);
            $service->status_id = 171;
            $service->update ();
        } elseif ($request->action == 'confirm') {
            $check_notification->status_id = 170;
            $check_notification->modified_by = Auth::user ()->full_name;
            $check_notification->update ();
        }
        return redirect ('home');
    }
    /**
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function manager_action (Request $request)
    {
        $check_notification = ProjectNotification::where ('url_id', $request->id)->where ('receiver', Auth::id ())->where ('status_id', $this->in_progress)->first ();
        if (is_null ($check_notification)) {
            return redirect ('home');
        }
        $url = 'service.mission_budget_show';

        if ($request->action == 'accept') {
            $count = ProjectNotification::where ('url_id', $request->id)->where ('receiver', Auth::id ())->where ('status_id', $this->in_progress)->count ();
            if ($count == 1) {
                $service = Service::find ($request->id);
                if ($service->payment_method_id == 3297 && $service->service_type_id != 375447) {
                    if ($service->service_method_id == 66893) {
                        $this->notification_office ("$service->project_id", "$service->id", 'mission_mr_advance_service', "$url", $count = 0, '375547', false, false, false);
                    } else {
                        $this->notification_office ("$service->project_id", "$service->id", 'mission_mr_advance_service', "$url", $count = 0, '375547', false, false, false);
                    }
                }
                if ($service->payment_method_id == 3297 && $service->service_type_id == 375447) {
                    if ($service->service_method_id == 66893) {
                        $this->notification_office ("$service->project_id", "$service->id", 'mission_pyr_logistic_advance_service', "$url", $count = 0, '375547', false, false, false);
                    } else {
                        $this->notification_office ("$service->project_id", "$service->id", 'mission_pyr_advance_service', "$url", $count = 0, '375547', false, false, false);

                    }
                }
                if ($service->payment_method_id == 3296 && $service->service_type_id != 375447) {
                    if ($service->service_method_id == 66893) {
                        $this->notification_office ("$service->project_id", "$service->id", 'mission_mr_direct_service', "$url", $count = 0, '375547', false, false, false);
                    } else {
                        $this->notification_office ("$service->project_id", "$service->id", 'mission_mr_direct_service', "$url", $count = 0, '375547', false, false, false);

                    }
                }
                if ($service->payment_method_id == 3296 && $service->service_type_id == 375447) {
                    if ($service->service_method_id == 66893) {
                        $this->notification_office ("$service->project_id", "$service->id", 'mission_pyr_logistic_direct_service', "$url", $count = 0, '375547', false, false, false);

                    } else {
                        $this->notification_office ("$service->project_id", "$service->id", 'mission_pyr_direct_service', "$url", $count = 0, '375547', false, false, false);

                    }

                }
            }
        }
        if ($request->action == 'reject') {
            $find_notification = ProjectNotification::where ('url_id', $request->id)->where ('step', 375472)->first ();
            if (isset($request->reallocate)) {
                ProjectNotification::where ('url_id', $request->id)->where ('id', '>', $find_notification->id)->delete ();
                $find_notification->status_id = 174;
                $find_notification->message_id = 375807;
                $find_notification->rejected_by = Auth::id ();
                $find_notification->update ();
            } else {
                $this->new_notification_project_authorized ($request->id, $check_notification->notification_type_id, 'service.logistic_show', 457087, $this->in_progress, $check_notification->requester, $check_notification->requester, 0, false);
                $check_notification->status_id = 171;
                $check_notification->update ();
                $service = Service::find ($request->id);
                $service->status_id = 171;
                $service->update ();
            }


        } elseif ($request->action == 'confirm') {
            $check_notification->status_id = 170;
            $check_notification->modified_by = Auth::user ()->full_name;

            $check_notification->update ();
        }
        return redirect ('home');
    }
    /**
     * @param $id
     * @return Factory|RedirectResponse|Redirector|View
     */
    public function projectManager ($id)
    {
        $services = Service::find ($id);
        $check_notification = ProjectNotification::where ('url_id', $id)->where ('receiver', Auth::id ())->where ('status_id', $this->in_progress)->first ();
        if (is_null ($check_notification)) {
            return redirect ('home');
        }
        if ($services->service_type_id == 375447) {
            $route = route ('service.update');
        } else {
            $route = route ('service.logistic_update');
        }
        $service_items = ServiceItem::where ('service_id', $id)->get ();
        $budget_lines = DB::table ('detailed_proposal_budgets')->join ('services', 'services.project_id', '=', 'detailed_proposal_budgets.project_id')
            ->join ('category_options', 'category_options.id', '=', 'detailed_proposal_budgets.category_option_id')
            ->where ('services.id', $id)->select ('detailed_proposal_budgets.id', 'detailed_proposal_budgets.budget_line', 'category_options.name_en')->get ();
        $total_currency = ServiceItem::select (DB::raw ('sum(quantity * unit_cost)'))->where ('service_id', $id)->first ();
        $total_usd = ServiceItem::select (DB::raw ('sum(quantity * unit_cost / exchange_rate)'))->where ('service_id', $id)->first ();
        return view ('layouts.services.project_manager', compact ('services', 'service_items', 'route', 'budget_lines', 'total_currency', 'total_usd'));
    }
    /**
     * @param $id
     * @return Factory|RedirectResponse|Redirector|View
     */
    public function manager_accountant_show ($id)
    {
        $check_notification = ProjectNotification::where ('url_id', $id)->where ('receiver', Auth::id ())->where ('status_id', $this->in_progress)->first ();
        if (is_null ($check_notification)) {
            return redirect ('home');
        }
        $services = Service::find ($id);

        $service_items = ServiceItem::where ('service_id', $id)->get ();
        $total_currencies = ServiceItem::select (DB::raw ('sum(quantity * unit_cost)'))->where ('service_id', $id)->get ();
        $total_usd = ServiceItem::select (DB::raw ('sum(quantity * unit_cost / exchange_rate)'))->where ('service_id', $id)->get ();
        return view ('layouts.services.manager_accountant_show', compact ('services', 'check_notification', 'service_items', 'total_currencies', 'total_usd'));
    }
    /**
     * @param $id
     * @return Factory|View
     */
    public function mission_budget_holder ($id)
    {
        $services = Service::find ($id);
        $items = Item::orderBy ('name_en')->get ();
        $units = Unit::orderBy ('name_en')->get ();
        $mission_budgets = DB::table ('mission_budgets')->join ('missions', 'missions.id', '=', 'mission_budgets.mission_id')
            ->select ('missions.name_en as mission', 'mission_budgets.id', 'mission_budgets.name_en as mission_budget')->get ();
        $service_items = ServiceItem::where ('service_id', $id)->get ();
        $total_currency = ServiceItem::select (DB::raw ('sum(quantity * unit_cost)'))->where ('service_id', $id)->get ();
        $total_usd = ServiceItem::select (DB::raw ('sum(quantity * unit_cost / exchange_rate)'))->where ('service_id', $id)->get ();
        $currencies = Currency::orderBy ('name_en')->get ();

        return view ('layouts.services.mission_budget_holder', compact ('services', 'units', 'currencies', 'items', 'mission_budgets', 'service_items', 'total_currency', 'total_usd'));
    }
    /**
     * @param $id
     * @return Factory|RedirectResponse|Redirector|View
     */
    public function mission_budget_show ($id)
    {
        $check_notification = ProjectNotification::where ('url_id', $id)->where ('receiver', Auth::id ())->where ('status_id', $this->in_progress)->first ();
        if (is_null ($check_notification)) {
            return redirect ('home');
        }
        $services = Service::find ($id);
        $service_items = ServiceItem::where ('service_id', $id)->get ();
        $total_currencies = ServiceItem::select (DB::raw ('sum(quantity * unit_cost)'))->where ('service_id', $id)->get ();
        $total_usd = ServiceItem::select (DB::raw ('sum(quantity * unit_cost / exchange_rate)'))->where ('service_id', $id)->get ();
        return view ('layouts.services.mission_budget_show', compact ('services', 'check_notification', 'service_items', 'total_currencies', 'total_usd'));
    }
    /**
     * @param $id
     * @return float|int
     */
    public function availability ($id)
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

}
