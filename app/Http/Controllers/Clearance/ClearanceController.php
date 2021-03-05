<?php


namespace App\Http\Controllers\Clearance;


use DB;
use Auth;
use Excel;
use Exception;
use Carbon\Carbon;
use App\Model\Hr\User;
use App\Model\Currency;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Model\Service\Service;
use App\Model\NotificationType;
use App\Model\ControlPanel\Item;
use App\Model\NotificationCycle;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Redirector;
use App\Model\ProjectNotification;
use App\Model\Service\ServiceItem;
use App\Model\NotificationReceiver;
use App\Http\Controllers\Controller;
use App\Model\ControlPanel\Supplier;
use Illuminate\Http\RedirectResponse;
use App\Model\Service\ServiceInvoice;
use Illuminate\Contracts\View\Factory;
use App\Model\ControlPanel\Hr\Mission;
use App\Model\ControlPanel\Project\Unit;
use App\Model\Service\OperationalAdvance;
use App\Imports\Clearance\ClearanceImport;
use App\Model\ProjectNotificationStructure;
use App\Exports\Clearance\InvoiceTemplateExport;
use App\Model\Service\OperationalAdvanceInvoice;
use App\Exports\Clearance\InvoiceFinancialExport;
use App\Http\Resources\Clearance\ClearanceCollection;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Model\ControlPanel\Project\ProjectResponsibility;
use App\Http\Resources\Clearance\ClearanceOperationalAdvanceCollection;
use App\Exports\Clearance\OperationalAdvance\OperationalAdvanceInvoiceTemplateExport;

/**
 * Class ClearanceController
 * @package App\Http\Controllers\Clearance
 */
class ClearanceController extends Controller
{
    /**
     * @param $id
     * @return Factory|View
     */
    public function index ($id)
    {
        $this->data['service'] = Service::find ($id);
        return view ('layouts.services.clearance_index', $this->data);
    }

    /**
     * @param $id
     * @return Factory|View
     */
    public function index_operational_advance ($id)
    {
        $this->data['service'] = OperationalAdvance::find ($id);
        return view ('layouts.operational_advance.index_operational_advance', $this->data);
    }

    /**
     * @param $id
     * @return Factory|View
     */
    public function create ($id)
    {
        $this->data['service'] = Service::with ('service_items.unit', 'service_items.item', 'service_items.detailed_proposal_budget')->where ('id', $id)->first ();
        $this->data['total_currency'] = $this->data['service']->service_items ()->sum (DB::raw ('quantity * unit_cost'));
        $this->data['total_usd'] = $this->data['service']->service_items ()->sum (DB::raw ('(quantity * unit_cost / exchange_rate)'));
        $this->data['items'] = Item::orderBy ('name_en')->get ();
        $this->data['units'] = Unit::orderBy ('name_en')->get ();
        $this->data['currencies'] = Currency::orderBy ('name_en')->get ();
        $this->data['suppliers'] = Supplier::orderBy ('name_en')->get ();
        return view ('layouts.services.clearance', $this->data);

    }

    /**
     * @param $id
     * @return Factory|View
     */
    public function create_operational_advance ($id)
    {
        $this->data['service'] = OperationalAdvance::find ($id);
//        $this->data['total_currency'] = $this->data['service']->service_items ()->sum (DB::raw ('quantity * unit_cost'));
//        $this->data['total_usd'] = $this->data['service']->service_items ()->sum (DB::raw ('(quantity * unit_cost / exchange_rate)'));
        $this->data['items'] = Item::orderBy ('name_en')->get ();
        $this->data['units'] = Unit::orderBy ('name_en')->get ();
        $this->data['currencies'] = Currency::orderBy ('name_en')->get ();
        $this->data['suppliers'] = Supplier::orderBy ('name_en')->get ();
        return view ('layouts.operational_advance.operational_advance_clearance', $this->data);

    }

    /**
     * @param $id
     * @return Factory|View
     */
    public function create_office ($id)
    {
        $this->data['service'] = Service::where ('id', $id)->first ();
        $this->data['items'] = Item::orderBy ('name_en')->get ();
        $this->data['units'] = Unit::orderBy ('name_en')->get ();
        $this->data['currencies'] = Currency::orderBy ('name_en')->get ();
        $this->data['suppliers'] = Supplier::orderBy ('name_en')->get ();
        return view ('layouts.services.mission_clearance', $this->data);
    }

    /**
     * @param Request $request
     * @return JsonResponse|null
     */
    public function store (Request $request): ?JsonResponse
    {
        try {
            $clearance = $request->clearance;
            $clearance['stored_by'] = Auth::user ()->full_name;
            $requester = Auth::id ();
            $service = Service::find ($request->id);
            if ($clearance['completed']) {
                $service->completed = true;
                $service->update ();
            }
            $cl_service = $service->replicate ();
            $item = [];
            $currency = ['87035' => 1, '87036' => 2, '87034' => 3];
            $total_currency = 0;
            $dt = Carbon::now ();
            $count = Service::where ('service_type_id', 375650)->whereYear ('created_at', '=', $dt->year)->count ();
            $code = str_pad ($count + 1, 4, '0', STR_PAD_LEFT);
            if ($request->hasFile ('receipt_file')) {
                $file = $request->file ('receipt_file');
                $filename = time () . '.pdf';
                $file->move ('file/invoice', $filename);
                $cl_service['receipt_file'] = $filename;

            }
            if (isset($request->clearance_item)) {
                foreach ($request->clearance_item as $key => $value) {
                    if ($currency[$value['currency_id']] <= $currency[$service->currency_id]) {
                        $total_currency += ($value['quantity'] * $value['unit_cost']) / $value['exchange_rate'];
                    } else {
                        $total_currency += $value['quantity'] * $value['unit_cost'] * $value['exchange_rate'];
                    }
                    unset($value['total']);
                    $value['stored_by'] = Auth::user ()->full_name;
                    $value['detailed_proposal_budget_id'] = ServiceItem::find ($value['service_item_id'])->detailed_proposal_budget_id;
                    $value['project_id'] = $service['project_id'];
                    $item[] = new ServiceInvoice($value);
                }

                $cl_service['code'] = 'CL ' . $code . '-' . $dt->year;
                $cl_service['total_currency'] = $total_currency;
                $cl_service['total_usd'] = $total_currency / $service['user_exchange_rate'];
                $cl_service['parent_id'] = $request->id;
                $cl_service['service_type_id'] = 375650;
                $cl_service['stored_by'] = Auth::user ()->full_name;
                $cl_service['status_id'] = $this->in_progress;
                $cl_service->save ();
                $cl_service->service_invoices ()->saveMany ($item);
            }
            $url = 'clearance.show';
            $this->notification ("$cl_service->project_id", "$cl_service->id", 'clearance_service', "$url", $count = 0, '180357', false, false, false);

            return $this->setStatusCode (200)->respond (['status' => true]);
        } catch (Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => ['Something is error']]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse|null
     */
    public function store_operational_advance (Request $request): ?JsonResponse
    {
        try {
            $clearance = $request->clearance;
            $clearance['stored_by'] = Auth::user ()->full_name;
            $service = OperationalAdvance::find ($request->id);
            if ($clearance['completed']) {
                $service->completed = true;
                $service->update ();
            }
            $oac_service = $service->replicate ();
            $item = [];
            $currency = ['87035' => 1, '87036' => 2, '87034' => 3];
            $total_currency = 0;
            $dt = Carbon::now ();

            $count = OperationalAdvance::where ('service_type_id', 375830)->whereYear ('created_at', '=', $dt->year)->count ();
            $code = str_pad ($count + 1, 4, '0', STR_PAD_LEFT);
            if ($request->hasFile ('receipt_file')) {
                $file = $request->file ('receipt_file');
                $filename = time () . '.pdf';
                $file->move ('file/invoice', $filename);
                $oac_service['receipt_file'] = $filename;

            }
            if (isset($request->clearance_item)) {
                foreach ($request->clearance_item as $key => $value) {
                    if ($currency[$value['currency_id']] <= $currency[$service->currency_id]) {
                        $total_currency += ($value['quantity'] * $value['unit_cost']) / $value['exchange_rate'];
                    } else {
                        $total_currency += $value['quantity'] * $value['unit_cost'] * $value['exchange_rate'];
                    }
                    unset($value['total']);
                    $value['stored_by'] = Auth::user ()->full_name;
                    $value['project_id'] = $service->project_id;
                    $item[] = new OperationalAdvanceInvoice($value);
                }
                $oac_service['code'] = 'OAC ' . $code . '-' . $dt->year;
                $oac_service['total_currency'] = $total_currency;
                $oac_service['total_dollar'] = $total_currency / $service->user_exchange_rate;
                $oac_service['parent_id'] = $service->id;
                $oac_service['service_type_id'] = 375830;
                $oac_service['stored_by'] = Auth::user ()->full_name;
                $oac_service['status_id'] = $this->in_progress;
                $oac_service->save ();
                $oac_service->service_invoices ()->saveMany ($item);
            }
            $url = 'clearance.show_operational_advance';
            $this->notification_operational_advance ("$oac_service->project_id", "$oac_service->id", 'operational_advance_clearance', "$url", $count = 0, '180357', false, false, false);

            return $this->setStatusCode (200)->respond (['status' => true]);
        } catch (Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => ['Something is error']]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse|null
     */
    public function update_operational_advance (Request $request): ?JsonResponse
    {
        try {
            $data = [];
            if (isset($request->service_item)) {
                foreach ($request->service_item as $key => $value) {
                    $data['modified_by'] = Auth::user ()->full_name;
                    $data['detailed_proposal_budget_id'] = $value['detailed_proposal_budget_id'];
                    if (isset($value['id'])) {
                        OperationalAdvanceInvoice::find ($value['id'])->update ($data);
                    }

                }
                $project_id = OperationalAdvance::find ($request->id)->project_id;
                $url = 'clearance.show_operational_advance';
                $this->notification_operational_advance ($project_id, "$request->id", 'operational_advance_clearance', "$url", $count = 0, '180357', false, false, false);
            }
            return $this->setStatusCode (200)->respond (['status' => true]);
        } catch (Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => ['Something is error']]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse|null
     */
    public function store_office (Request $request): ?JsonResponse
    {
        try {
            $clearance = $request->clearance;
            $clearance['stored_by'] = Auth::user ()->full_name;
            $requester = Auth::id ();
            $service = Service::find ($request->service_id);
            if ($clearance['completed']) {
                $service->completed = true;
                $service->update ();
            }
            $cl_service = $service->replicate ();

            $item = [];
            $currency = ['87035' => 1, '87036' => 2, '87034' => 3];
            $total_currency = 0;
            $dt = Carbon::now ();
            $count = Service::where ('service_type_id', 375650)->whereYear ('created_at', '=', $dt->year)->count ();
            $code = str_pad ($count + 1, 4, '0', STR_PAD_LEFT);
            if ($request->hasFile ('receipt_file')) {
                $file = $request->file ('receipt_file');
                $filename = time () . '.pdf';
                $file->move ('file/invoice', $filename);
                $cl_service['receipt_file'] = $filename;

            }
            if (isset($request->service_item)) {
                foreach ($request->service_item as $key => $value) {
                    if ($currency[$value['currency_id']] <= $currency[$service->currency_id]) {
                        $total_currency += ($value['quantity'] * $value['unit_cost']) / $value['exchange_rate'];
                    } else {
                        $total_currency += $value['quantity'] * $value['unit_cost'] * $value['exchange_rate'];
                    }
                    unset($value['total']);
                    $value['stored_by'] = Auth::user ()->full_name;
                    $value['detailed_proposal_budget_id'] = ServiceItem::find ($value['service_item_id'])->detailed_proposal_budget_id;
                    $item[] = new ServiceInvoice($value);
                }

                $cl_service['code'] = 'CL ' . $code . '-' . $dt->year;
                $cl_service['total_currency'] = $total_currency;
                $cl_service['total_usd'] = $total_currency / $service->user_exchange_rate;
                $cl_service['parent_id'] = $request->service_id;
                $cl_service['service_type_id'] = 375650;
                $cl_service['stored_by'] = Auth::user ()->full_name;
                $cl_service['status_id'] = $this->in_progress;
                $cl_service->save ();
                $cl_service->service_invoices ()->saveMany ($item);
            }
            $url = 'clearance.show_office';
            $this->notification_office ("$cl_service->project_id", "$cl_service->id", 'mission_clearance_service', "$url", $count = 0, '180357', false, false, false);

            return $this->setStatusCode (200)->respond (['status' => true]);
        } catch (Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => ['Something is error']]);
        }
    }

    public function list (Request $request): JsonResponse
    {

        $page = $request->input ('pagination.page');
        $search = $request->input ('query.generalSearch', null);
        $per_page = $request->input ('pagination.perpage', 10);
        $sortOrder = $request->input ('sort.sort', 'asc');
        $sortField = $request->input ('sort.field', 'id');
        $offset = ($page - 1) * $per_page;
        $query = Service::where ('parent_id', $request->id)->with ('project', 'currency', 'status', 'service_type', 'payment_method', 'service_method');
        $totalCount = $query->count ();
        $query->offset ($offset)
            ->limit ($per_page)
            ->orderBy ($sortField, $sortOrder);
        $data = $query->get ();
        $request->offsetSet ('pages', ceil ($totalCount / $per_page));
        $request->offsetSet ('total', $totalCount);
        return $this->resources (new ClearanceCollection($data));

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function list_clearance_operational_advance (Request $request): JsonResponse
    {
        $page = $request->input ('pagination.page');
        $search = $request->input ('query.generalSearch', null);
        $per_page = $request->input ('pagination.perpage', 10);
        $sortOrder = $request->input ('sort.sort', 'asc');
        $sortField = $request->input ('sort.field', 'id');
        $offset = ($page - 1) * $per_page;
        $query = OperationalAdvance::where ('parent_id', $request->id)->with ('', 'currency', 'status');
        $totalCount = $query->count ();
        $query->offset ($offset)
            ->limit ($per_page)
            ->orderBy ($sortField, $sortOrder);
        $data = $query->get ();
        $request->offsetSet ('pages', ceil ($totalCount / $per_page));
        $request->offsetSet ('total', $totalCount);
        return $this->resources (new ClearanceOperationalAdvanceCollection($data));
    }

    /**
     * @param Request $request
     * @return Factory|View
     */
    public function import_file (Request $request)
    {
        $file = $request->file ('file');
        $data = Excel::toArray (new ClearanceImport, $file)[0];
        unset($data[0]);
        $this->data['data_row'] = $data;
        $user = ProjectResponsibility::select ('project_manager')->where ('project_id', $request->id)
            ->where (function($q) {
                $q->where ('project_manager', Auth::user ()->id)->orWhere ('project_officer', 'like', '%' . Auth::user ()->id . '%');
            })->get ();
        // If there is a result, then return list of budget lines
        if ($user->count ()) {
            $budgetLines = DB::table ('detailed_proposal_budgets')
                ->join ('category_options', 'category_options.id', '=', 'detailed_proposal_budgets.category_option_id')
                ->select ('detailed_proposal_budgets.id', 'detailed_proposal_budgets.budget_line', 'category_options.name_en')
                ->where ('detailed_proposal_budgets.project_id', $request->id)->get ();
        } else {
            $budgetLines = "";
        }

        $this->data['user_count'] = $user->count ();
        $this->data['project_id'] = $request->id;
        $this->data['budget_lines'] = $budgetLines;
        $this->data['items'] = Item::orderBy ('name_en')->get ();
        $this->data['units'] = Unit::orderBy ('name_en')->get ();
        $this->data['currencies'] = Currency::orderBy ('name_en')->get ();
        return view ('layouts.ajax_view.clearance.clearance_import', $this->data);

    }

    /**
     * @param Request $request
     * @return Factory|View
     */
    public function import_file_invoice (Request $request)
    {
        $file = $request->file ('file');
        $data = Excel::toArray (new ClearanceImport, $file)[0];
        unset($data[0]);
        $this->data['data_row'] = $data;
        $user = ProjectResponsibility::select ('project_manager')->where ('project_id', $request->id)
            ->where (function($q) {
                $q->where ('project_manager', Auth::user ()->id)->orWhere ('project_officer', 'like', '%' . Auth::user ()->id . '%');
            })->get ();
        // If there is a result, then return list of budget lines
        if ($user->count ()) {
            $budgetLines = DB::table ('detailed_proposal_budgets')
                ->join ('category_options', 'category_options.id', '=', 'detailed_proposal_budgets.category_option_id')
                ->select ('detailed_proposal_budgets.id', 'detailed_proposal_budgets.budget_line', 'category_options.name_en')
                ->where ('detailed_proposal_budgets.project_id', $request->id)->get ();
        } else {
            $budgetLines = "";
        }

        $this->data['user_count'] = $user->count ();
        $this->data['project_id'] = $request->project_id;
        $this->data['service'] = Service::find ($request->service_id);
        $this->data['budget_lines'] = $budgetLines;
        $this->data['items'] = Item::orderBy ('name_en')->get ();
        $this->data['units'] = Unit::orderBy ('name_en')->get ();
        $this->data['currencies'] = Currency::orderBy ('name_en')->get ();
//        foreach($data as $datum){
//
//            echo   ;
//        }

        return view ('layouts.ajax_view.clearance.clearance_import_invoice', $this->data);
    }

    /**
     * @param Request $request
     * @return Factory|View
     */
    public function import_operational_advance_file_invoice (Request $request)
    {
        $file = $request->file ('file');
        $data = Excel::toArray (new ClearanceImport, $file)[0];
        unset($data[0]);
        $this->data['data_row'] = $data;
        $this->data['items'] = Item::orderBy ('name_en')->get ();
        $this->data['units'] = Unit::orderBy ('name_en')->get ();
        $this->data['currencies'] = Currency::orderBy ('name_en')->get ();
        return view ('layouts.ajax_view.clearance.operational_advance.clearance_import_invoice', $this->data);
    }

    /**
     * @param Request $request
     * @return BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export_invoice_template (Request $request): BinaryFileResponse
    {
        $service = Service::find ($request->service_id);
        $currencies = Currency::orderBy ('name_en')->select ('name_en', 'id')->get ();
        $items = Item::orderBy ('name_en')->select ('name_en', 'id')->get ();
        $units = Unit::orderBy ('name_en')->select ('name_en', 'id')->get ();
        return Excel::download (new InvoiceTemplateExport($service->service_items, $currencies, $items, $units), 'invoice_template_' . $service->code . '.xlsx');
    }

    /**
     * @param Request $request
     * @return BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export_operational_advance_invoice_template (Request $request): BinaryFileResponse
    {
        $service = OperationalAdvance::find ($request->id);
        $currencies = Currency::orderBy ('name_en')->select ('name_en', 'id')->get ();
        $items = Item::orderBy ('name_en')->select ('name_en', 'id')->get ();
        $units = Unit::orderBy ('name_en')->select ('name_en', 'id')->get ();
        return Excel::download (new OperationalAdvanceInvoiceTemplateExport($currencies, $items, $units), 'invoice_template_' . $service->code . '.xlsx');
    }

    /**
     * @param Request $request
     * @return Factory|View
     */
    public function import_mission_file (Request $request)
    {
        $file = $request->file ('file');
        $data = Excel::toArray (new ClearanceImport, $file)[0];
        unset($data[0]);
        $this->data['data_row'] = $data;
        $this->data['service'] = Service::find ($request->id);
        $this->data['items'] = Item::orderBy ('name_en')->get ();
        $this->data['units'] = Unit::orderBy ('name_en')->get ();
        $this->data['currencies'] = Currency::orderBy ('name_en')->get ();
        return view ('layouts.ajax_view.mission.clearance_mission_import', $this->data);

    }

    /**
     * @param $id
     * @return Factory|RedirectResponse|Redirector|View
     */
    public function show ($id)
    {
        $this->data['check_notification'] = ProjectNotification::where ('url_id', $id)->where ('receiver', Auth::id ())->where ('status_id', $this->in_progress)->first ();
        if (is_null ($this->data['check_notification'])) {
            return redirect ('home');
        }
        $this->data['service'] = Service::find ($id);
        $this->data['service_items'] = ServiceItem::where ('service_id', $this->data['service']->parent_id)->orderBy ('detailed_proposal_budget_id')->get ();
        $this->data['service_invoices'] = ServiceInvoice::where ('service_id', $id)->orderBy ('id')->get ();
        return view ('layouts.services.clearance_show', $this->data);
    }

    /**
     * @param $id
     * @return Factory|RedirectResponse|Redirector|View
     */
    public function show_operational_advance ($id)
    {
        $this->data['check_notification'] = ProjectNotification::where ('url_id', $id)->where ('receiver', Auth::id ())->where ('status_id', $this->in_progress)->first ();
        if (is_null ($this->data['check_notification'])) {
            return redirect ('home');
        }
        $this->data['service'] = OperationalAdvance::find ($id);
        $this->data['service_invoices'] = OperationalAdvanceInvoice::where ('operational_advance_id', $id)->orderBy ('id')->get ();
        return view ('layouts.operational_advance.clearance_show', $this->data);
    }

    /**
     * @param $id
     * @return Factory|View
     */
    public function ajax_view ($id)
    {
        $this->data['service'] = Service::find ($id);
        $this->data['service_items'] = ServiceItem::where ('service_id', $this->data['service']->parent_id)->orderBy ('detailed_proposal_budget_id')->get ();
        $this->data['service_invoices'] = ServiceInvoice::where ('service_id', $id)->orderBy ('id')->get ();
        return view ('layouts.ajax_view.service.project.clearance.view', $this->data);
    }

    /**
     * @param $id
     * @return Factory|RedirectResponse|Redirector|View
     */
    public function show_office ($id)
    {
        $this->data['check_notification'] = ProjectNotification::where ('url_id', $id)->where ('receiver', Auth::id ())->where ('status_id', $this->in_progress)->first ();
        if (is_null ($this->data['check_notification'])) {
            return redirect ('home');
        }
        $this->data['service'] = Service::find ($id);
        $this->data['service_items'] = ServiceItem::where ('service_id', $this->data['service']->parent_id)->orderBy ('detailed_proposal_budget_id')->get ();
        $this->data['service_invoices'] = ServiceInvoice::where ('service_id', $id)->orderBy ('id')->get ();
        return view ('layouts.services.mission_clearance_show', $this->data);
    }

    /**
     * @param $id
     * @return BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export_financial_file ($id): BinaryFileResponse
    {
        $service = Service::find ($id);
        $service_parent = Service::find ($service->parent_id);
        if ($service_parent->recipient) {
            $name = $service_parent->service_recipient->first_name_en . ' ' . $service_parent->service_recipient->last_name_en;
        } elseif ($service_parent->implementing_partner_id) {
            $name = $service_parent->implementing_partner->name_en;
        } elseif ($service_parent->supplier_id) {
            $name = $service_parent->supplier->name_en;
        } elseif ($service_parent->service_provider_id) {
            $name = $service_parent->service_provider->name_en;
        }
        return Excel::download (new InvoiceFinancialExport($service, $service_parent, $name), 'invoice_financial_' . $service->code . '.xlsx');
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function action (Request $request)
    {
        $check_notification = ProjectNotification::where ('url_id', $request->id)->where ('receiver', Auth::id ())->where ('status_id', $this->in_progress)->first ();
        if (is_null ($check_notification)) {
            return redirect ('home');
        }
        if ($request->action == 'accept') {
            $this->notification ("$request->project_id", "$request->id", 'clearance_service', "$check_notification->url", $count = 0, '180357', false, false, false);
        } elseif ($request->action == 'reject') {
            $this->new_notification_project_authorized ($request->id, $check_notification->notification_type_id, 'clearance.show', 457087, $this->in_progress, $check_notification->requester, $check_notification->requester, 0, false);
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
     * @throws Exception
     */
    public function action_operational_advance (Request $request)
    {
        $check_notification = ProjectNotification::where ('url_id', $request->id)->where ('receiver', Auth::id ())->where ('status_id', $this->in_progress)->first ();
        if (is_null ($check_notification)) {
            return redirect ('home');
        }
        echo 1;
        if ($request->action == 'accept') {
            $this->notification_operational_advance ("$request->project_id", "$request->id", 'operational_advance_clearance', "$check_notification->url", $count = 0, '180357', false, false, false);
        } elseif ($request->action == 'reject') {
            $this->new_notification_project_authorized ($request->id, $check_notification->notification_type_id, 'clearance.show_operational_advance', 457087, $this->in_progress, $check_notification->requester, $check_notification->requester, 0, false);
            $check_notification->status_id = 171;
            $check_notification->update ();
            $service = OperationalAdvance::find ($request->id);
            $service->status_id = 171;
            $service->update ();
            $service2 = OperationalAdvance::find ($service->parent_id);
            $service2->completed = false;
            $service2->update ();
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
    public function action_office (Request $request)
    {
        $url = 'clearance.show_office';

        $check_notification = ProjectNotification::where ('url_id', $request->id)->where ('receiver', Auth::id ())->where ('status_id', $this->in_progress)->first ();
        if (is_null ($check_notification)) {
            return redirect ('home');
        }
        if ($request->action == 'accept') {
            $count_notification = ProjectNotification::where ('url_id', $request->id)->where ('status_id', $this->in_progress)->count ();
            if ($count_notification < 1) {
                $check_notification->status_id = 170;
                $check_notification->update ();
            } else {
                $this->notification_office ("0", "$request->id", 'mission_payment_order_service', "$url", $count = 0, '107535', false, false, false);
            }
        } elseif ($request->action == 'reject') {
            $this->new_notification_project_authorized ($request->id, $check_notification->notification_type_id, $url, 107535, $this->in_progress, $check_notification->requester, $check_notification->requester, 0, false);
            $check_notification->status_id = 171;
            $check_notification->update ();
            $service_cl = Service::find ($request->id);
            $service_cl->status_id = 171;
            $service_cl->update ();
            if ($service_cl->completed) {
                $service = Service::find ($service_cl->parent_id);
                $service->completed = false;
                $service->update ();
            }
            ProjectNotification::where ('url_id', $request->id)->where ('status_id', $this->in_progress)->delete ();
        } elseif ($request->action == 'confirm') {
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
                if (!is_null ($notification_2)) {
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
        if (!isset($requester)) {
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
                    $this->notification ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                } else {

                    if ($count_notification_step == 0) {
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
    public function notification_operational_advance ($project_id = '', $url_id = '', $type = 0, $url = '', $count = 0, $message_id = '0', $manager = false, $last = false, $my = false): ?bool
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
                if (!is_null ($notification_2)) {
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
        if (!isset($requester)) {
            $requester = Auth::id ();
        }
//        echo $type_id;
        $cycles = NotificationCycle::where ('notification_type_id', $type_id)->orderBy ('orderby')->get ();
        $count_notification = count (ProjectNotification::where ('url_id', $url_id)->where ('notification_type_id', $type_id)->groupBy ('step')->select ('step')->get ());
        if ($count_notification == 1) {
            $count_notification = $count_notification - 1;
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
                    $this->notification_operational_advance ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                    return true;
                }
                $user_id = $this->delegation_or_disabled ($next_user->id, 0);
                if ($this->check_notification ($user_id, $url_id) || $this->check_notification ($next_user->id, $url_id)) {
                    $this->notification_operational_advance ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
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
                    $this->notification_operational_advance ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                } else {

                    if ($count_notification_step == 0) {
                        $parent_user = User::find ($requester)->parent_id;
                    } else {
                        $parent_user = Auth::user ()->parent_id;
                    }
                    $next_user = User::where ('position_id', '!=', 32)->find ($parent_user);
                    if (is_null ($next_user)) {
                        $this->notification_operational_advance ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                        return true;
                    }
                    $user_id = $this->delegation_or_disabled ($next_user->id, 0);
                    if ($this->check_notification ($user_id, $url_id) || $this->check_notification ($next_user->id, $url_id)) {
                        $this->notification_operational_advance ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
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
                if ($cycles[$count_notification + $count]->notification_receiver_id == 375483) {
                    $recipient = OperationalAdvance::find ($url_id)->recipient;
                    if (is_null ($recipient)) {
                        $this->notification_operational_advance ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                        return true;
                    }
                    $user_id = $this->delegation_or_disabled ($recipient);
                    if ($this->check_notification ($recipient, $url_id) || $this->check_notification ($user_id, $url_id)) {
                        $this->notification_operational_advance ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                        return true;
                    }
                    if ($user_id == $recipient) {
                        $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $cycles[$count_notification + $count]->authorized);
                    } else {
                        $delegated_user_id = $requester;
                        $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $cycles[$count_notification + $count]->authorized, $delegated_user_id);
                    }
                } elseif ($cycles[$count_notification + $count]->notification_receiver_id == 375467) {
                    $receiver_name = NotificationReceiver::where ('id', $cycles[$count_notification + $count]->notification_receiver_id)->first ();
                    $receiver_id = $structure[$receiver_name->name_en];
                    $user_id = $this->delegation_or_disabled ($receiver_id);
                    if ($user_id == $receiver_id) {
                        $this->new_notification_project_authorized ($url_id, $type_id, 'operational_advance.project_manager', $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $cycles[$count_notification + $count]->authorized);
                    } else {
                        $delegated_user_id = $receiver_id;
                        $this->new_notification_project_authorized ($url_id, $type_id, 'operational_advance.project_manager', $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $cycles[$count_notification + $count]->authorized, $delegated_user_id);
                    }
                } else {
                    $receiver_name = NotificationReceiver::where ('id', $cycles[$count_notification + $count]->notification_receiver_id)->first ();
                    $receiver_id = $structure[$receiver_name->name_en];
                    if (is_null ($receiver_id)) {
                        $this->notification_operational_advance ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                    } else {
                        $user_id = $this->delegation_or_disabled ($receiver_id);
                        if (is_null ($user_id)) {
                            $this->notification ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                            return true;
                        }
                        if ($cycles[$count_notification + $count]->authorized) {
                            if ($this->check_notification ($receiver_id, $url_id) || $this->check_notification ($user_id, $url_id)) {
                                $this->notification_operational_advance ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
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
                            $service = OperationalAdvance::where ('id', $url_id)->update (['status_id' => 170]);

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
                $service = OperationalAdvance::where ('id', $url_id)->update (['status_id' => 170]);
                return true;
            }

        }
        return true;
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
    public function notification_office ($project_id = '', $url_id = '', $type = 0, $url = '', $count = 0, $message_id = '0', $manager = false, $last = false, $my = false): ?bool
    {
        $for_count = 0;
//        $structure = ProjectNotificationStructure::where ('project_id', $project_id)->first ();
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
        $mission_id = User::find ($requester)->mission_id;
        $structure = Mission::where ('id', $mission_id)->first ();
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
                    $this->notification_office ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                    return true;
                }
                $user_id = $this->delegation_or_disabled ($next_user->id, 0);
                if ($this->check_notification ($user_id, $url_id) || $this->check_notification ($next_user->id, $url_id)) {
                    $this->notification_office ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
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
                    $this->notification_office ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                } else {

                    if ($count_notification_step == 0) {
                        $parent_user = User::find ($requester)->parent_id;
                    } else {
                        $parent_user = Auth::user ()->parent_id;
                    }
                    $next_user = User::where ('position_id', '!=', 32)->find ($parent_user);
                    if (is_null ($next_user)) {
                        $this->notification_office ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                        return true;
                    }
                    $user_id = $this->delegation_or_disabled ($next_user->id);
                    if ($this->check_notification ($user_id, $url_id) || $this->check_notification ($next_user->id, $url_id)) {
                        $this->notification_office ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
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
                echo $cycles[$count_notification + $count]->notification_receiver_id;
                if ($cycles[$count_notification + $count]->notification_receiver_id == 375467) {
                    $receiver_name = NotificationReceiver::where ('id', $cycles[$count_notification + $count]->notification_receiver_id)->first ();
                    $projects = Service::find ($url_id)->service_invoices ()->groupBy ('project_id')->select ('project_id')->get ();
                    foreach ($projects as $project) {
                        $structure_2 = ProjectNotificationStructure::where ('project_id', $project->project_id)->first ();
                        $receiver_id = $structure_2[$receiver_name->name_en];
                        $user_id = $this->delegation_or_disabled ($receiver_id);
                        if (!$this->check_notification ($receiver_id, $url_id) || !$this->check_notification ($user_id, $url_id)) {
                            $for_count = 1;
                            if ($user_id == $receiver_id) {
                                $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id,  $cycles[$count_notification +
                                $count]->authorized);
                            } else {
                                $delegated_user_id = $receiver_id;
                                $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id,  $cycles[$count_notification +
                                $count]->authorized, $delegated_user_id);
                            }
                        }
                    }
                    if ($for_count == 0) {
                        $this->notification_office ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                        return true;
                    }
                } elseif ($cycles[$count_notification + $count]->notification_receiver_id == 375472) {
                    $receiver_name = NotificationReceiver::where ('id', $cycles[$count_notification + $count]->notification_receiver_id)->first ();
                    $receiver_id = $structure[$receiver_name->name_en];
                    $user_id = $this->delegation_or_disabled ($receiver_id);
//                    $receiver_id = $structure[$receiver_name->name_en];
//                    $user_id = $this->delegation_or_disabled ($receiver_id);
                    if ($this->check_notification ($receiver_id, $url_id) || $this->check_notification ($user_id, $url_id)) {
                        $this->notification_office ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                        return true;
                    }
                    if ($user_id == $receiver_id) {
                        $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id,  $cycles[$count_notification +
                        $count]->authorized);
                    } else {
                        $delegated_user_id = $receiver_id;
                        $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id,  $cycles[$count_notification +
                        $count]->authorized, $delegated_user_id);
                    }
                } else {
                    echo 'test';
                    $for_count = 0;
                    $receiver_name = NotificationReceiver::where ('id', $cycles[$count_notification + $count]->notification_receiver_id)->first ();
                    $projects = Service::find ($url_id)->service_invoices ()->groupBy ('project_id')->select ('project_id')->get ();
                    foreach ($projects as $project) {
                        $structure_2 = ProjectNotificationStructure::where ('project_id', $project->project_id)->first ();
                        $receiver_id = $structure_2[$receiver_name->name_en];
                        if (!is_null ($receiver_id)) {
                            $user_id = $this->delegation_or_disabled ($receiver_id);
                            if (!is_null ($user_id)) {
                                if ($cycles[$count_notification + $count]->authorized) {
                                    if (!$this->check_notification ($receiver_id, $url_id) || !$this->check_notification ($user_id, $url_id)) {
                                        if ($user_id == $receiver_id) {
                                            $for_count = 1;
                                            $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id,
                                                $cycles[$count_notification + $count]->authorized);
                                        } else {
                                            $for_count = 1;
                                            $delegated_user_id = $receiver_id;
                                            $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id,
                                                $cycles[$count_notification + $count]->authorized, $delegated_user_id);
                                        }
                                    }

                                } elseif (!$cycles[$count_notification + $count]->authorized) {

                                    if ($user_id == $receiver_id) {
                                        $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id,  $cycles[$count_notification
                                        + $count]->authorized);
                                        $for_count = 1;
                                        $user_id = $this->delegation_or_disabled ($requester);
                                        if (!is_null ($user_id) && $user_id == $requester) {
                                            $this->new_notification_project_authorized ($url_id, $type_id, $url, '457086', $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, false);
                                        } else {
                                            $this->new_notification_project_authorized ($url_id, $type_id, $url, '457086', $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, false, $delegated_user_id);
                                        }
                                    } else {
                                        $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id,  $cycles[$count_notification
                                        + $count]->authorized, $delegated_user_id);
                                        $for_count = 1;
                                        $delegated_user_id = $receiver_id;
                                        $user_id = $this->delegation_or_disabled ($requester);
                                        if (!is_null ($user_id) && $user_id == $requester) {
                                            $this->new_notification_project_authorized ($url_id, $type_id, $url, '457086', $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, false);
                                        } else {
                                            $this->new_notification_project_authorized ($url_id, $type_id, $url, '457086', $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, false, $requester);
                                        }
                                    }
//                                    $service = Service::where ('id', $url_id)->orWhere ('parent_id', $url_id)->update (['status_id' => 170]);
//                                    $service = Service::where ('id', $url_id)->orWhere ('parent_id', $url_id)->update (['status_id' => 170]);

                                }
                            }

                        }
                    }
                    if ($for_count == 0) {
                        $this->notification_office ($project_id, $url_id, $type, $url, $count + 1, $message_id, "$manager", false, true);
                        return true;
                    }
                }
            }

        }
        return true;
    }

}
