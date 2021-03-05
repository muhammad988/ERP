<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Request;
use App\Model\ControlPanel\Project\ProjectResponsibility;
use function App\Model\Project\category_options;

Auth::routes ();
Route::get ('/home', 'HomeController@index')->name ('home.index');
Route::get ('/', 'HomeController@index')->name ('home.index');
Route::get ('/organisation-unit/tree_view', 'OrganisationUnitController@tree_view');
Route::post ('/nested/organisation-unit-mission/multiple', 'OrganisationUnitController@nested_organisation_unit_mission_multiple')->name ('nested_organisation_unit_mission_multiple');
Route::post ('/duration', 'Controller@duration')->name ('duration');
Route::get ('authority', 'AuthorityController@index')->name ('authority.index');
Route::get ('authority/{user_role}/edit', 'AuthorityController@edit')->name ('authority.edit');
Route::post ('authority', 'AuthorityController@store')->name ('authority.store');
Route::put ('authority/{id}', 'AuthorityController@update')->name ('authority.update');
Route::delete ('authority/{id}', 'AuthorityController@destroy')->name ('authority.destroy');
Route::post ('authority/all', 'AuthorityController@get_all');
Route::group (['prefix' => '/hr', 'namespace' => 'Hr'], function() {
    Route::get ('/employee/org-chart', 'UserController@org_chart')->name ('employee.org_chart');
    Route::resource ('/employee', 'UserController');
    Route::post ('/employee/all', 'UserController@get_all');
    Route::post ('/employee/status', 'UserController@status')->name ('employee.status');
    Route::put ('/employee/status/update', 'UserController@status_update')->name ('employee.status_update');
    Route::post ('/nested/superior_department', 'UserController@nested_select_superior')->name ('nested_superior_department');

    Route::get ('/fingerprint', 'FingerprintController@index')->name ('fingerprint.index');
    Route::get ('/fingerprint/{fingerprint}/edit', 'FingerprintController@edit')->name ('fingerprint.edit');
    Route::put ('/fingerprint/{id}', 'FingerprintController@update')->name ('fingerprint.update');
    Route::delete ('/fingerprint/{id}', 'FingerprintController@destroy');
    Route::post ('/fingerprint', 'FingerprintController@store')->name ('fingerprint.store');
    Route::get ('employee/fingerprint/{user_id}', 'FingerprintController@index_user')->name ('fingerprint.index_user');
    Route::post ('fingerprint/all', 'FingerprintController@get_all');
    Route::post ('/fingerprint-user/day/{worksheet}', 'FingerprintController@get_fingerprint_user');
    Route::post ('/fingerprint/import', 'FingerprintController@import')->name ('fingerprint.import');

    Route::get ('/fingerprint/report', 'FingerprintController@index_report')->name ('fingerprint.index_report');
    Route::post ('/fingerprint/export', 'FingerprintController@export_report')->name ('fingerprint.export_report');

    Route::post ('fingerprint/get-report', 'FingerprintController@get_report');
});
Route::group (['prefix' => '/'], function() {
    Route::resource ('worksheet', 'WorksheetController');
    Route::post ('worksheet/all', 'WorksheetController@get_all');
//    Route::get ('/', 'WorksheetController@index')->name ('worksheet.index');
});
Route::group (['prefix' => '/leave', 'namespace' => 'Leave'], function() {

    Route::resource ('accumulated-day', 'AccumulatedDayController');
    Route::post ('accumulated-day/all', 'AccumulatedDayController@get_all');

    Route::resource ('extra-day', 'ExtraDayController');
    Route::post ('extra-day/all', 'ExtraDayController@get_all');

    Route::get ('', 'LeaveController@index')->name ('leave.index');
    Route::post ('/all', 'LeaveController@get_all');
    Route::post ('/export', 'LeaveController@export')->name ('leave.export');
    Route::get ('/daily/create', 'LeaveController@daily_create')->name ('leave.daily_create');
    Route::post ('/daily', 'LeaveController@daily_store')->name ('leave.daily_store');
    Route::get ('/daily/show/{leave}', 'LeaveController@daily_show')->name ('leave.daily_show');

    Route::get ('/hourly/create', 'LeaveController@hourly_create')->name ('leave.hourly_create');
    Route::post ('/hourly', 'LeaveController@hourly_store')->name ('leave.hourly_store');
    Route::get ('/hourly/show/{leave}', 'LeaveController@hourly_show')->name ('leave.hourly_show');
    Route::get ('/report/{user_id}', 'LeaveController@report')->name ('leave.report');
    Route::post ('/available-days', 'LeaveController@available_days')->name ('leave.available_days');
});
Route::group (['prefix' => '/project', 'namespace' => 'Project'], function() {
    Route::get ('index-budget-line/{project_id}', 'ProjectController@index_budget_line')->name ('project.index_budget_line');
    Route::post ('/all', 'ProjectController@get_all');
    Route::post ('/get-budget-line/{project}', 'ProjectController@get_budget_line');
    Route::get ('', 'ProjectController@index')->name ('project.index');
    Route::get ('/submission/create/{project}', 'ProjectController@create')->name ('project.create');
    Route::post ('/submission', 'ProjectController@store')->name ('project.store');
    Route::put ('/submission', 'ProjectController@update')->name ('project.update');
    Route::get ('/submission/{project}', 'ProjectController@show')->name ('project.show');
    Route::post ('/submission/action', 'ProjectController@action')->name ('project.action');
    Route::get ('/submission/{project}/edit', 'ProjectController@edit')->name ('project.edit');
    Route::post ('/save-and-continue-submission', 'ProjectController@saveAndContinue')->name ('project.save_And_continue');
    Route::get ('/concept/create', 'ProposalController@create')->name ('proposal.create');
    Route::post ('/concept', 'ProposalController@store')->name ('proposal.store');
    Route::put ('/concept/{project}', 'ProposalController@update')->name ('proposal.update');
    Route::get ('/concept/{project}', 'ProposalController@show')->name ('proposal.show');
    Route::get ('/concept/{project}/edit', 'ProposalController@edit')->name ('proposal.edit');
    Route::post ('/concept/action', 'ProposalController@action')->name ('proposal.action');
    Route::get ('/get-availability-budget-line/{budget}', 'BudgetController@availability');
    Route::get ('/budget/info/{budget}', 'BudgetController@info');
    Route::get ('/info/{project}', 'ProjectController@project_info');
    Route::get ('cycle/{id}', 'ProjectController@cycle')->name ('service.cycle');
    Route::get ('/responsibility/{project}', 'ProjectController@responsibility')->name ('project.responsibility');
    Route::post ('/responsibility/update', 'ProjectController@responsibility_update')->name ('project.responsibility_update');
    //Nami
    Route::get ('donor-management/{project}', 'ProjectController@donor_management')->name ('project.donor_management');
    Route::get ('/donor-management-ongoing-actual-payments/{project}', 'ProjectController@saveDonorManagementOngoingActualPayments')->name ('project.save_donor_management_ongoin_actual_payments');
    Route::get ('/donor-payment-request/{project}', 'ProjectController@donorPaymentRequest')->name ('project.donor_payment_request');
    Route::post ('/donor-payment-request-store', 'ProjectController@donorPaymentRequestStore')->name ('project.donor_payment_request_store');
    Route::post ('/donor-payment-actual-request-store', 'ProjectController@donorPaymentActualRequestStore')->name ('project.donor_payment_actual_store');
    Route::post ('/get-donor-budget', 'BudgetController@get_donor_budget')->name ('project.get_donor_budget');
    Route::get ('/donor-management', 'ProjectController@saveDonorManagement')->name ('project.save_donor_management');
    Route::get ('/donor-management-ongoing-actual-payments', 'ProjectController@saveDonorManagementOngoingActualPayments')->name ('project.save_donor_management_ongoin_actual_payments');
    Route::get ('/donor-payment-request/{project}', 'ProjectController@donorPaymentRequest')->name ('project.donor_payment_request');
    Route::get ('/print/{project}', 'ProjectController@submission_pdf')->name ('project.print');
    Route::get ('/hq-payment/{id}', 'ProjectController@hq_payment')->name ('project.hq_payment');
    Route::post ('/hq-payment', 'ProjectController@hq_payment_store_or_update')->name ('project.hq_payment_store_or_update');
    Route::post ('/nested/sector-project/multiple', 'ProjectController@nested_select_multiple')->name ('nested_sector_project_multiple');
    //Nami
});
Route::group (['prefix' => '/report', 'namespace' => 'Report'], function() {
    Route::get ('budget/{project_id}/{budget_category_id}', 'ReportController@budget_index')->name ('report.budget_index');
    Route::get ('budget-category/{project_id}', 'ReportController@budget_category_index')->name ('report.budget_category_index');
    Route::get ('project', 'ReportController@project_index')->name ('report.project_index');
    Route::get ('create-budget', 'ReportController@create_report_budget')->name ('report.create_budget');
    Route::post ('budget-data/{project_id}/{budget_category_id}', 'ReportController@budget_data')->name ('report.budget_data');
    Route::post ('project-data', 'ReportController@project_data')->name ('report.project_data');
    Route::post ('budget-category-data/{project_id}', 'ReportController@budget_category_data')->name ('report.budget_category_data');
});
Route::group (['prefix' => '/transfer', 'namespace' => 'Project'], function() {
    Route::get ('/create', 'TransferController@create')->name ('transfer.create');
    Route::post ('/store', 'TransferController@store')->name ('transfer.store');
    Route::get ('/show/{id}', 'TransferController@show')->name ('transfer.show');
    Route::post ('action', 'TransferController@action')->name ('transfer.action');
    Route::get ('/pdf', 'TransferController@transfer_pdf')->name ('transfer.pdf');
});
Route::group (['prefix' => '/clearance', 'namespace' => 'Clearance'], function() {
    Route::get ('{id}', 'ClearanceController@index')->name ('clearance.index');
    Route::get ('operational-advance/{id}', 'ClearanceController@index_operational_advance')->name ('clearance.index_operational_advance');
    Route::post ('/list-clearance/{id}', 'ClearanceController@list')->name ('clearance.list');
    Route::post ('/operational-advance/list/{id}', 'ClearanceController@list_clearance_operational_advance')->name ('clearance.list_clearance_operational_advance');
    Route::get ('/create/{id}', 'ClearanceController@create')->name ('clearance.create');
    Route::get ('operational-advance/create/{id}', 'ClearanceController@create_operational_advance')->name ('clearance.create_operational_advance');
    Route::get ('office/create/{id}', 'ClearanceController@create_office')->name ('clearance.create_office');
    Route::post ('/store', 'ClearanceController@store')->name ('clearance.store');
    Route::post ('operational-advance/store', 'ClearanceController@store_operational_advance')->name ('clearance.store_operational_advance');
    Route::put ('operational-advance/update', 'ClearanceController@update_operational_advance')->name ('clearance.update_operational_advance');
    Route::post ('office/store', 'ClearanceController@store_office')->name ('clearance.store_office');
//    Route::get ('/mission/{id}', 'ClearanceController@create_mission')->name ('clearance.create_mission');
    Route::post ('import-file/{id}', 'ClearanceController@import_file')->name ('clearance.import_file');
    Route::post ('import-file-invoice/{project_id}/{service_id}', 'ClearanceController@import_file_invoice')->name ('clearance.import_file_invoice');
    Route::post ('operational-advance/import-file-invoice', 'ClearanceController@import_operational_advance_file_invoice')->name ('clearance.import_operational_advance_file_invoice');
    Route::get ('export-invoice-template/{service_id}', 'ClearanceController@export_invoice_template')->name ('clearance.export_invoice_template');
    Route::get ('export-invoice-template/operational-advance/{id}', 'ClearanceController@export_operational_advance_invoice_template')->name ('clearance.export_operational_advance_invoice_template');
    Route::get ('export-financial-file/{id}', 'ClearanceController@export_financial_file')->name ('clearance.export_financial_file');
    Route::post ('/office/import-file/{id}', 'ClearanceController@import_mission_file')->name ('clearance.import_mission_file');
//    Route::post ('show/{id}', 'ClearanceController@show')->name ('clearance.show');
    Route::get ('office/show/{id}', 'ClearanceController@show_office')->name ('clearance.show_office');
    Route::get ('', 'ClearanceController@index')->name ('clearance.index');
    Route::get ('/show/{id}', 'ClearanceController@show')->name ('clearance.show');
    Route::get ('operational-advance/show/{id}', 'ClearanceController@show_operational_advance')->name ('clearance.show_operational_advance');
    Route::post ('action', 'ClearanceController@action')->name ('clearance.action');
    Route::post ('operational-advance/action', 'ClearanceController@action_operational_advance')->name ('clearance.action_operational_advance');
    Route::post ('office/action', 'ClearanceController@action_office')->name ('clearance.action_office');
    Route::get ('view/{id}', 'ClearanceController@ajax_view')->name ('clearance.ajax_view');

});
Route::group (['prefix' => '/operational-advance', 'namespace' => 'OperationalAdvance'], function() {
    Route::get ('/', 'OperationalAdvanceController@index')->name ('operational_advance.index');
    Route::get ('/create', 'OperationalAdvanceController@create')->name ('operational_advance.create');
    Route::post ('/store', 'OperationalAdvanceController@store')->name ('operational_advance.store');
    Route::get ('/show/{id}', 'OperationalAdvanceController@show')->name ('operational_advance.show');
    Route::post ('/all', 'OperationalAdvanceController@get_all')->name ('operational_advance.get_all');
    Route::post ('action', 'OperationalAdvanceController@action')->name ('operational_advance.action');
    Route::get ('project_manager/{id}', 'OperationalAdvanceController@project_manager')->name ('operational_advance.project_manager');
});
Route::group (['prefix' => '/payment-order', 'namespace' => 'PaymentOrder'], function() {
    Route::get ('{id}', 'PaymentOrderController@index')->name ('payment_order.index');
    Route::post ('/list/{id}', 'PaymentOrderController@list')->name ('payment_order.list');
    Route::get ('/create/{id}', 'PaymentOrderController@create')->name ('payment_order.create');
    Route::get ('/office/create/{id}', 'PaymentOrderController@create_office')->name ('payment_order.create_office');
    Route::post ('/store', 'PaymentOrderController@store')->name ('payment_order.store');
    Route::post ('office/store', 'PaymentOrderController@store_office')->name ('payment_order.store_office');
    Route::get ('/office/{id}', 'PaymentOrderController@create_mission')->name ('payment_order.create_mission');
    Route::post ('import-file/{id}', 'PaymentOrderController@import_file')->name ('payment_order.import_file');
    Route::post ('show/{id}', 'PaymentOrderController@show')->name ('payment_order.show');
    Route::get ('', 'PaymentOrderController@index')->name ('payment-order.index');
    Route::get ('/show/{id}', 'PaymentOrderController@show')->name ('payment_order.show');
    Route::get ('/office/show/{id}', 'PaymentOrderController@mission_show')->name ('payment_order.mission_show');
    Route::post ('action', 'PaymentOrderController@action')->name ('payment_order.action');
    Route::post ('office/action', 'PaymentOrderController@action_office')->name ('payment_order.action_office');
});
Route::group (['prefix' => '/service', 'namespace' => 'Service'], function() {
    Route::get ('', 'ServiceController@index')->name ('service.index');
    Route::get ('expense/{project_id}', 'ServiceController@expense_index')->name ('service.expense_index');
    Route::get ('reserved/{project_id}', 'ServiceController@reserved_index')->name ('service.reserved_index');
    Route::get ('office', 'ServiceController@office_index')->name ('service.office_index');
    Route::post ('/all', 'ServiceController@get_all');
    Route::post ('/dashboard', 'ServiceController@get_dashboard');
    Route::post ('/get/{type}/{project_id}', 'ServiceController@get_service_type');
    Route::post ('/office/list', 'ServiceController@office_list');
    Route::get ('create', 'ServiceController@create')->name ('service.create');
    Route::get ('cycle/{id}', 'ServiceController@cycle')->name ('service.cycle');
    Route::post ('store', 'ServiceController@store')->name ('service.store');
    Route::get ('logistic/{id}', 'ServiceController@logistic')->name ('service.logistic');
    Route::put ('logistic-update', 'ServiceController@logistic_update')->name ('service.logistic_update');
    Route::put ('update', 'ServiceController@update')->name ('service.update');
    Route::post ('logistic-action', 'ServiceController@logistic_action')->name ('service.logistic_action');
    Route::post ('manager-action', 'ServiceController@manager_action')->name ('service.manager_action');
    Route::get ('project_manager/{id}', 'ServiceController@projectManager')->name ('service.project_manager');
    Route::get ('logistic-show/{id}', 'ServiceController@logistic_show')->name ('service.logistic_show');
    Route::get ('show/{id}', 'ServiceController@show')->name ('service.show');
    Route::get ('view/{id}', 'ServiceController@ajax_view')->name ('service.ajax_view');
    Route::get ('office/view/{id}', 'ServiceController@ajax_office_view')->name ('service.ajax_office_view');
    Route::get ('office-budget-holder/{id}', 'ServiceController@mission_budget_holder')->name ('service.mission_budget_holder');
    Route::put ('office-budget-holder-update', 'ServiceController@mission_holder_update')->name ('service.mission_holder_update');
    Route::get ('office-budget-show/{id}', 'ServiceController@mission_budget_show')->name ('service.mission_budget_show');
    Route::get ('office-accountant-show/{id}', 'ServiceController@manager_accountant_show')->name ('service.manager_accountant_show');
    // Get mission budget lines based on the selected mission budget
    Route::get ('/getmissionbudgetline/{id}', function($id) {
        if (Request::ajax ()) {
            $mission_budget_lines = DB::table ('mission_budget_lines')->join ('category_options', 'category_options.id', 'mission_budget_lines.category_option_id')
                ->select ('category_options.name_en', 'mission_budget_lines.id', 'mission_budget_lines.budget_line')->where ('mission_budget_lines.mission_budget_id', $id)
                ->orderBy ('mission_budget_lines.budget_line')->get ();
            if (!$mission_budget_lines->count ()) {
                $mission_budget_lines = "";
            }
            return $mission_budget_lines;
        }
    });
    Route::get ('mission_clearance/getservicebudgetline/{project_id}/{service_id}', function($project_id, $service_id) {
        if (Request::ajax ()) {
            $project_budget_lines = DB::table ('detailed_proposal_budgets')
                ->join ('category_options', 'category_options.id', '=', 'detailed_proposal_budgets.category_option_id')
                ->join ('service_items', 'service_items.detailed_proposal_budget_id', '=', 'detailed_proposal_budgets.id')
                ->join ('items', 'items.id', '=', 'service_items.item_id')
                ->select ('category_options.name_en', 'detailed_proposal_budgets.budget_line', 'service_items.id', 'items.name_en as item', 'service_items.quantity', 'service_items.unit_cost')->distinct ()
                ->where ('detailed_proposal_budgets.project_id', $project_id)->where ('service_items.service_id', $service_id)
                ->orderBy ('detailed_proposal_budgets.budget_line')
                ->get ();
            if (!$project_budget_lines->count ()) {
                $project_budget_lines = "";
            }
            return $project_budget_lines;
        }
    });
    // Get projects that belongs to the mission based selected mission budget
    Route::get ('/getproject/{id}', function($id) {
        if (Request::ajax ()) {
            $projects = DB::table ('projects')
                ->join ('sectors_departments', 'sectors_departments.id', '=', 'projects.sector_id')
                ->join ('departments_missions', 'departments_missions.id', '=', 'sectors_departments.department_id')
                ->join ('mission_budgets', 'mission_budgets.mission_id', '=', 'departments_missions.mission_id')
                ->select ('projects.id', 'projects.name_en')->where ('mission_budgets.id', $id)
                ->orderBy ('projects.name_en')
                ->get ();
            if (!$projects->count ()) {
                $projects = "";
            }
            return $projects;
        }
    });
    // Get project budget lines based on the selected project
    Route::get ('/getprojectbudgetline/{id}', function($id) {
        if (Request::ajax ()) {
            $project_budget_lines = DB::table ('detailed_proposal_budgets')
                ->join ('category_options', 'category_options.id', '=', 'detailed_proposal_budgets.category_option_id')
                ->select ('category_options.name_en', 'detailed_proposal_budgets.id', 'detailed_proposal_budgets.budget_line')->where ('detailed_proposal_budgets.project_id', $id)
                ->orderBy ('detailed_proposal_budgets.budget_line')
                ->get ();
            if (!$project_budget_lines->count ()) {
                $project_budget_lines = "";
            }
            return $project_budget_lines;
        }
    });
    // Get Budget Lines if the requester has authority
    Route::get ('/get-budget-line/{id}', function($id) {
        if (Request::ajax ()) {
            // List of project managers and project officers
            $user = ProjectResponsibility::select ('project_manager')->where ('project_id', $id)
                ->where (function($q) {
                    $q->where ('project_manager', Auth::user ()->id)->orWhere ('project_officer', 'like', '%' . Auth::user ()->id . '%');
                })->get ();
            // If there is a result, then return list of budget lines
            if ($user->count ()) {
                $budgetLines = DB::table ('detailed_proposal_budgets')
                    ->join ('category_options', 'category_options.id', '=', 'detailed_proposal_budgets.category_option_id')
                    ->select ('detailed_proposal_budgets.id', 'detailed_proposal_budgets.budget_line', 'category_options.name_en')
                    ->where ('detailed_proposal_budgets.project_id', $id)->get ();
            }// if there is no results, then return non
            else {
                $budgetLines = "";
            }
            return $budgetLines;
        }
    });
    Route::get ('get-availability-service-item/{budget}', 'ServiceController@availability');
    // TODO:
    Route::get ('/get_bank_account/{service_method_id}/{service_receiver_id}', function($service_method_id, $service_receiver_id) {
        if (Request::ajax ()) {
            $bank_accounts = "";
            // If service request is for a partner
            if ($service_method_id == 66894) {
                $bank_accounts = DB::table ('implementing_partner_accounts')->where ('implementing_partner_id', $service_receiver_id)->select ('id', 'bank_name', 'iban')->get ();
            }

            // If service request is for a supplier
            if ($service_method_id == 311432) {
                $bank_accounts = DB::table ('supplier_accounts')->where ('supplier_id', $service_receiver_id)->select ('id', 'bank_name', 'iban')->get ();
            }

            // If service request is for a service provider
            if ($service_method_id == 137368) {
                $bank_accounts = DB::table ('service_provider_accounts')->where ('service_provider_id', $service_receiver_id)->select ('id', 'bank_name', 'iban')->get ();
            }
            if (!$bank_accounts->count ()) {
                $bank_accounts = "";
            }

            return $bank_accounts;
        }
    });
    // Get list on service receivers based on selecting the service method
    Route::get ('/getservicereceiver/{id}', function($id) {
        if (Request::ajax ()) {
            // if service is for a partner
            if ($id == 66894) {
                $serviceReceivers = DB::table ('implementing_partners')->select ('id', 'name_en')->orderBy ('name_en')->get ();
            }// if service is for an individual
            else if ($id == 66892) {
                $serviceReceivers = DB::table ('users')->select ('id', 'first_name_en', 'last_name_en')->where ('service_receiver', true)->orderBy ('first_name_en')->get ();
            }// if service is for a supplier
            else if ($id == 311432) {
                $serviceReceivers = DB::table ('suppliers')->select ('id', 'name_en')->orderBy ('name_en')->get ();
            }// if service is for a service provider
            else if ($id == 137368) {
                $serviceReceivers = DB::table ('service_providers')->select ('id', 'name_en')->orderBy ('name_en')->get ();
            }// if there is no results for the selected item, then return non
            else {
                $serviceReceivers = "";
            }
            return $serviceReceivers;
        }
    });
    // Get the last updated exchange rate, based on the selected currency for the mission of the requested project
    Route::get ('/getexchangerate/{id}', function($id) {
        if (Request::ajax ()) {
            $exchangeRates = DB::table ('exchange_rates')->select ('exchange_rate')//->join('departments_missions', 'departments_missions.mission_id',  '=', 'exchange_rates.mission_id')
            //->where('exchange_rates.mission_id', '180781')
            ->where ('exchange_rates.currency_id', $id)->orderBy ('exchange_rates.due_date', 'desc')->first ();
            // If there is no resualts, then return non.
            if (!$exchangeRates) {
                return "";
            } else {
                return $exchangeRates->exchange_rate;
            }
        }
    });
});
Route::group (['prefix' => '/project/control-panel/', 'namespace' => 'ControlPanel\Project'], function() {
    Route::resource ('donor', 'DonorController');
    Route::post ('donor/all', 'DonorController@get_all');

    Route::resource ('implementing-partner', 'ImplementingPartnerController');
    Route::post ('implementing-partner/all', 'ImplementingPartnerController@get_all');

    Route::resource ('supplier', 'SupplierController');
    Route::post ('supplier/all', 'SupplierController@get_all');

    Route::resource ('service-provider', 'ServiceProviderController');
    Route::post ('service-provider/all', 'ServiceProviderController@get_all');

    Route::resource ('category', 'CategoryController');
    Route::post ('category/all', 'CategoryController@get_all');

    Route::resource ('category-option', 'CategoryOptionController');
    Route::post ('category-option/all', 'CategoryOptionController@get_all');

    Route::resource ('item-category', 'ItemCategoryController');
    Route::post ('item-category/all', 'ItemCategoryController@get_all');

    Route::resource ('item', 'ItemController');
    Route::post ('item/all', 'ItemController@get_all');

    Route::resource ('unit', 'UnitController');
    Route::post ('unit/all', 'UnitController@get_all');

    Route::resource ('currency', 'CurrencyController');
    Route::post ('currency/all', 'CurrencyController@get_all');

    Route::resource ('exchange-rate', 'ExchangeRateController');
    Route::post ('exchange-rate/all', 'ExchangeRateController@get_all');
});
Route::group (['prefix' => '/hr/control-panel/', 'namespace' => 'ControlPanel\Hr'], function() {

    Route::resource ('mission', 'MissionController', ['roles' => ['test']]);
    Route::post ('mission/all', 'MissionController@get_all');
    Route::post ('mission/budget/all/{id}', 'MissionController@get_all_budget');
    Route::get ('mission/management/{mission}', 'MissionController@management');
    Route::get ('mission/management/department/{id}', 'MissionController@management_department_edit')->name ('mission.management_department_edit');
    Route::post ('mission/management/department', 'MissionController@management_department_store')->name ('mission.management_department_store');
    Route::put ('mission/management/department/{id}', 'MissionController@management_department_update')->name ('mission.management_department_update');
    Route::post ('mission/management/authority/update', 'MissionController@management_authority_update')->name ('mission.management_authority_update');
    Route::delete ('mission/management/department/{id}', 'MissionController@management_department_destroy')->name ('mission.management_department_destroy');
    Route::get ('/mission/budget/create/{mission}', 'MissionController@create_budget')->name ('mission.create_budget');
    Route::get ('/mission/budget/show/{mission}', 'MissionController@show_budget')->name ('mission.show_budget');
    Route::get ('mission/budget/edit/{mission}', 'MissionController@edit_budget')->name ('mission.edit_budget');
    Route::post ('/mission/budget/store', 'MissionController@store_budget')->name ('mission.store_budget');
    Route::put ('/mission/budget/update', 'MissionController@update_budget')->name ('mission.update_budget');
    Route::get ('/mission/budget/{mission}', 'MissionController@index_budget');
//    Route::get('mission/management/department/sector/{id}', 'MissionController@management_department_sector_edit')->name('mission.management_department_sector_edit');
    Route::get ('mission/management/department/sector/{id}', 'MissionController@management_department_sector_edit')->name ('mission.management_department_sector_edit');
    Route::post ('mission/management/department/sector', 'MissionController@management_department_sector_store')->name ('mission.management_department_sector_store');
    Route::delete ('mission/management/department/sector/{id}', 'MissionController@management_department_sector_destroy')->name ('mission.management_department_sector_destroy');


    Route::resource ('department', 'DepartmentController');
    Route::post ('department/all', 'DepartmentController@get_all');

    Route::post ('/nested/department-mission', 'DepartmentController@nested_select')->name ('nested_department_mission');
    Route::post ('/nested/department-mission/multiple', 'DepartmentController@nested_select_multiple')->name ('nested_department_mission_multiple');

    Route::resource ('sector', 'SectorController');
    Route::post ('sector/all', 'SectorController@get_all');
    Route::post ('/nested/sector-department', 'SectorController@nested_select')->name ('nested_sector_department');
    Route::post ('/nested/sector-department/multiple', 'SectorController@nested_select_multiple')->name ('nested_sector_department_multiple');


    Route::resource ('position', 'PositionController');
    Route::post ('position/all', 'PositionController@get_all');

    Route::resource ('position-category', 'PositionCategoryController');
    Route::post ('position-category/all', 'PositionCategoryController@get_all');

    Route::resource ('position-group', 'PositionGroupController');
    Route::post ('position-group/all', 'PositionGroupController@get_all');

    Route::post ('/nested/position-category', 'PositionController@nested_select_category')->name ('nested_position_category');
    Route::post ('/nested/position-department', 'PositionController@nested_select_department')->name ('nested_position_department');

    Route::resource ('visa-type', 'VisaTypeController');
    Route::post ('visa-type/all', 'VisaTypeController@get_all');


    Route::resource ('type-of-contract', 'TypeOfContractController');
    Route::post ('type-of-contract/all', 'TypeOfContractController@get_all');

    Route::resource ('marital-status', 'MaritalStatusController');
    Route::post ('marital-status/all', 'MaritalStatusController@get_all');

    Route::resource ('education', 'EducationController');
    Route::post ('education/all', 'EducationController@get_all');

    Route::resource ('major', 'MajorController');
    Route::post ('major/all', 'MajorController@get_all');

    Route::resource ('nationality', 'NationalityController');
    Route::post ('nationality/all', 'NationalityController@get_all');

    Route::resource ('notification-type', 'NotificationTypeController');
    Route::post ('notification-type/all', 'NotificationTypeController@get_all');

    Route::resource ('notification-receiver', 'NotificationReceiverController');
    Route::post ('notification-receiver/all', 'NotificationReceiverController@get_all');

    Route::resource ('notification-cycle', 'NotificationCycleController');
    Route::post ('notification-cycle/all', 'NotificationCycleController@get_all');

    Route::resource ('user-type', 'UserTypeController');
    Route::post ('user-type/all', 'UserTypeController@get_all');

});
Route::get ('/home', 'HomeController@index')->name ('home');
Route::get ('/profile', 'Hr\UserController@profile')->name ('user.profile');
Route::post ('/profile-update', 'Hr\UserController@profile_update')->name ('user.profile_update');
Route::get ('/change-password', 'Hr\UserController@change_password')->name ('user.change_password');
Route::post ('/change-password-update', 'Hr\UserController@change_password_update')->name ('user.change_password_update');
Route::group (['prefix' => '/payroll', 'namespace' => 'Payroll'], function() {
    Route::get ('', 'PayrollController@index')->name ('payroll.index');
    Route::post ('/all', 'PayrollController@get_all');
    Route::get ('/user_salary/{id}', 'PayrollController@user_salary')->name ('payroll.user_salary');
    Route::get ('/print/{id}', 'PayrollController@print')->name ('payroll.print');
    Route::post ('check-salary', 'PayrollController@check_salary')->name ('payroll.check_salary');
    Route::post ('check-report-salary', 'PayrollController@check_report_salary')->name ('payroll.check_report_salary');
    Route::post ('check-vacancy', 'PayrollController@check_vacancy')->name ('payroll.check_vacancy');
    Route::post ('/save-user', 'PayrollController@save_user_salary')->name ('payroll.save_user_salary');
    Route::get ('/getdepartment/{id}', function($id) {
        if (Request::ajax ()) {
            $departments = DB::table ('departments')->select ('departments.id', 'departments.name_en')->orderBy ('departments.name_en')
                ->join ('departments_missions', 'departments_missions.department_id', '=', 'departments.id')
                ->where ('departments_missions.mission_id', $id)
                ->get ();
            if (!$departments->count ()) {
                $departments = "";
            }
            return $departments;
        }
    });
    Route::get ('/getproject/{id}', function($id) {
        if (Request::ajax ()) {
            $projects = DB::table ('projects')->select ('projects.id', 'projects.name_en')->orderBy ('projects.name_en')
                ->join ('sectors_departments', 'sectors_departments.id', '=', 'projects.sector_id')
                ->join ('departments_missions', 'departments_missions.id', '=', 'sectors_departments.department_id')
                ->where ('departments_missions.department_id', $id)
                ->get ();
            if (!$projects->count ()) {
                $projects = "";
            }
            return $projects;
        }
    });
    Route::get ('/get_user_by_project/{type}/{detailed_proposal_budget_id}/{project_id}', function($type, $detailed_proposal_budget_id, $project_id) {
        if (Request::ajax ()) {
            $users = DB::table ('users')
                ->select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en as position')
                ->orderBy ('users.first_name_en')->orderBy ('users.last_name_en')
                ->join ('positions', 'positions.id', '=', 'users.position_id')
                ->join ('category_options', 'category_options.position_group_id', '=', 'positions.position_group_id')
                ->join ('detailed_proposal_budgets', 'detailed_proposal_budgets.category_option_id', '=', 'category_options.id')
                ->where ('detailed_proposal_budgets.id', $detailed_proposal_budget_id)
                ->where ('users.project_id', $project_id)
                ->where ('users.' . $type . '', '>', '0')
                ->whereNotIn ('users.id', function($query) use ($detailed_proposal_budget_id) {
                    $query->select ('user_id')->from ('payroll_records')
                        ->whereNotNull ('payroll_records.user_id')
                        ->where ('payroll_records.detailed_proposal_budget_id', $detailed_proposal_budget_id);
                })
                ->distinct ()
                ->get ();
            if (!$users->count ()) {
                $users = "";
            }
            $payroll_report_users = \App\Model\Payroll\PayrollRecord::select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en as position')
                ->join ('users', 'users.id', '=', 'payroll_records.user_id')
                ->join ('positions', 'positions.id', '=', 'users.position_id')
                ->orderBy ('users.first_name_en')->orderBy ('users.last_name_en')
                ->where ('payroll_records.detailed_proposal_budget_id', $detailed_proposal_budget_id)
                ->distinct ()
                ->get ();
            if (!$payroll_report_users->count ()) {
                $payroll_report_users = "";
            }
            $user_list = array($users, $payroll_report_users);
            return $user_list;
        }
    });
    Route::get ('/get_user_by_department/{type}/{detailed_proposal_budget_id}/{mission_id}/{department_id}', function($type, $detailed_proposal_budget_id, $mission_id, $department_id) {
        if (Request::ajax ()) {
            $users = DB::table ('users')
                ->select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en as position')
                ->orderBy ('users.first_name_en')->orderBy ('users.last_name_en')
                ->join ('positions', 'positions.id', '=', 'users.position_id')
                ->join ('departments_missions', 'departments_missions.id', '=', 'users.department_id')
                ->join ('category_options', 'category_options.position_group_id', '=', 'positions.position_group_id')
                ->join ('detailed_proposal_budgets', 'detailed_proposal_budgets.category_option_id', '=', 'category_options.id')
                ->where ('detailed_proposal_budgets.id', $detailed_proposal_budget_id)
                ->where ('departments_missions.mission_id', $mission_id)
                ->where ('departments_missions.department_id', $department_id)
                ->where ('users.' . $type . '', '>', '0')
                ->whereNotIn ('users.id', function($query) use ($detailed_proposal_budget_id) {
                    $query->select ('user_id')->from ('payroll_records')
                        ->whereNotNull ('payroll_records.user_id')
                        ->where ('payroll_records.detailed_proposal_budget_id', $detailed_proposal_budget_id);
                })
                ->distinct ()
                ->get ();
            if (!$users->count ()) {
                $users = "";
            }
            $payroll_report_users = \App\Model\Payroll\PayrollRecord::select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en as position')
                ->join ('users', 'users.id', '=', 'payroll_records.user_id')
                ->join ('positions', 'positions.id', '=', 'users.position_id')
                ->orderBy ('users.first_name_en')->orderBy ('users.last_name_en')
                ->where ('payroll_records.detailed_proposal_budget_id', $detailed_proposal_budget_id)
                ->distinct ()
                ->get ();
            if (!$payroll_report_users->count ()) {
                $payroll_report_users = "";
            }
            $user_list = array($users, $payroll_report_users);
            return $user_list;
        }
    });
    Route::get ('/get_user_by_mission/{type}/{detailed_proposal_budget_id}/{mission_id}', function($type, $detailed_proposal_budget_id, $mission_id) {
        if (Request::ajax ()) {
            $users = DB::table ('users')
                ->select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en as position')
                ->orderBy ('users.first_name_en')->orderBy ('users.last_name_en')
                ->join ('positions', 'positions.id', '=', 'users.position_id')
                ->join ('departments_missions', 'departments_missions.id', '=', 'users.department_id')
                ->join ('category_options', 'category_options.position_group_id', '=', 'positions.position_group_id')
                ->join ('detailed_proposal_budgets', 'detailed_proposal_budgets.category_option_id', '=', 'category_options.id')
                ->where ('detailed_proposal_budgets.id', $detailed_proposal_budget_id)
                ->where ('departments_missions.mission_id', $mission_id)
                ->where ('users.' . $type, '>', '0')
                // FIXME: COMPLETE THIS AND POPULATE IT TO THE OTHER FORMS TODO: FIND OUT WHAT THE OTHER 3 AJAX FUNCTIONS BELOW STANDS FOR!!!!!!!!!!!!!!!!!!!!!
                ->whereNotIn ('users.id', function($query) use ($detailed_proposal_budget_id) {
                    $query->select ('user_id')->from ('payroll_records')
                        ->whereNotNull ('payroll_records.user_id')
                        ->where ('payroll_records.detailed_proposal_budget_id', $detailed_proposal_budget_id);
                })
                ->distinct ()
                ->get ();
            if (!$users->count ()) {
                $users = "";
            }
            $payroll_report_users = \App\Model\Payroll\PayrollRecord::select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en as position')
                ->join ('users', 'users.id', '=', 'payroll_records.user_id')
                ->join ('positions', 'positions.id', '=', 'users.position_id')
                ->orderBy ('users.first_name_en')->orderBy ('users.last_name_en')
                ->where ('payroll_records.detailed_proposal_budget_id', $detailed_proposal_budget_id)
                ->where ("payroll_records." . $type . "_percentage", '>', '0')
                ->distinct ()
                ->get ();
            if (!$payroll_report_users->count ()) {
                $payroll_report_users = "";
            }
            $user_list = array($users, $payroll_report_users);
            return $user_list;
        }
    });
    Route::get ('/salary_allocation/{id}', 'PayrollController@salary_allocation')->name ('payroll.salary_allocation');
    Route::post ('store-salary-allocation', 'PayrollController@store_salary_allocation')->name ('payroll.store_salary_allocation');
    Route::get ('/management_allowance/{id}', 'PayrollController@management_allowance')->name ('payroll.management_allowance');
    Route::get ('/management_allocation/{id}', 'PayrollController@management_allocation')->name ('payroll.management_allocation');
    Route::get ('/transportation_allowance/{id}', 'PayrollController@transportation_allowance')->name ('payroll.transportation_allowance');
    Route::get ('/transportation_allocation/{id}', 'PayrollController@transportation_allocation')->name ('payroll.transportation_allocation');
    Route::get ('/house_allowance/{id}', 'PayrollController@house_allowance')->name ('payroll.house_allowance');
    Route::get ('/house_allocation/{id}', 'PayrollController@house_allocation')->name ('payroll.house_allocation');
    Route::get ('/cell_phone_allowance/{id}', 'PayrollController@cell_phone_allowance')->name ('payroll.cell_phone_allowance');
    Route::get ('/cell_phone_allocation/{id}', 'PayrollController@cell_phone_allocation')->name ('payroll.cell_phone_allocation');
    Route::get ('/cost_of_living_allowance/{id}', 'PayrollController@cost_of_living_allowance')->name ('payroll.cost_of_living_allowance');
    Route::get ('/cost_of_living_allocation/{id}', 'PayrollController@cost_of_living_allocation')->name ('payroll.cost_of_living_allocation');
    Route::get ('/fuel_allowance/{id}', 'PayrollController@fuel_allowance')->name ('payroll.fuel_allowance');
    Route::get ('/fuel_allocation/{id}', 'PayrollController@fuel_allocation')->name ('payroll.fuel_allocation');
    Route::get ('/appearance_allowance/{id}', 'PayrollController@appearance_allowance')->name ('payroll.appearance_allowance');
    Route::get ('/appearance_allocation/{id}', 'PayrollController@appearance_allocation')->name ('payroll.appearance_allocation');
    Route::get ('/work_nature_allowance/{id}', 'PayrollController@work_nature_allowance')->name ('payroll.work_nature_allowance');
    Route::get ('/work_nature_allocation/{id}', 'PayrollController@work_nature_allocation')->name ('payroll.work_nature_allocation');
    Route::get ('/payroll_report', 'PayrollController@payroll_report')->name ('payroll.payroll_report');
    Route::post ('/store-payroll-report', 'PayrollController@store_payroll_report')->name ('payroll.store_payroll_report');
    Route::get ('/get_user_list/{month}', function($month) {
        if (Request::ajax ()) {
            $users = DB::table ('users')
                ->select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en as position')
                ->orderBy ('users.first_name_en')->orderBy ("users.last_name_en")
                ->join ('positions', 'positions.id', '=', 'users.position_id')
                ->join ('departments_missions', 'departments_missions.id', '=', 'users.department_id')
                ->WhereNotIn ('users.id', function($query) use ($month) {
                    $query->select ('user_id')->from ('payroll_report_users')
                        ->join ('payroll_reports', 'payroll_reports.id', '=', 'payroll_report_users.payroll_report_id')
                        ->where ('payroll_reports.month', $month);
                })
                ->get ();
            return $users;
        }
    });
    Route::get ('/users_by_project/{project_id}/{month}', function($project_id, $month) {
        if (Request::ajax ()) {
            $users = DB::table ('users')
                ->select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en as position')
                ->orderBy ('users.first_name_en')->orderBy ("users.last_name_en")
                ->join ('positions', 'positions.id', '=', 'users.position_id')
                ->where ('users.project_id', $project_id)
                ->WhereNotIn ('users.id', function($query) use ($month) {
                    $query->select ('user_id')->from ('payroll_report_users')
                        ->join ('payroll_reports', 'payroll_reports.id', '=', 'payroll_report_users.payroll_report_id')
                        ->where ('payroll_reports.month', $month);
                })
                ->WhereNotIn ('users.id', function($query) {
                    $query->select ('user_id')->from ('payroll_report_users')
                        ->whereNull ('payroll_report_id');
                })
                ->get ();
            if (!$users->count ()) {
                $users = "";
            }
            $payroll_report_users = \App\Model\Payroll\PayrollReportUser::select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en as position')
                ->join ('users', 'users.id', '=', 'payroll_report_users.user_id')
                ->join ('positions', 'positions.id', '=', 'users.position_id')
                ->orderBy ('users.first_name_en')->orderBy ('users.last_name_en')
                ->whereNull ('payroll_report_users.payroll_report_id')
                ->get ();
            if (!$payroll_report_users->count ()) {
                $payroll_report_users = "";
            }
            $user_list = array($users, $payroll_report_users);
            return $user_list;
        }
    });
    Route::get ('/users_by_department/{mission_id}/{department_id}/{month}', function($mission_id, $department_id, $month) {
        if (Request::ajax ()) {
            $users = DB::table ('users')
                ->select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en as position')
                ->orderBy ('users.first_name_en')->orderBy ("users.last_name_en")
                ->join ('positions', 'positions.id', '=', 'users.position_id')
                ->join ('departments_missions', 'departments_missions.id', '=', 'users.department_id')
                ->where ('departments_missions.mission_id', $mission_id)
                ->where ('departments_missions.department_id', $department_id)
                ->WhereNotIn ('users.id', function($query) use ($month) {
                    $query->select ('user_id')->from ('payroll_report_users')
                        ->join ('payroll_reports', 'payroll_reports.id', '=', 'payroll_report_users.payroll_report_id')
                        ->where ('payroll_reports.month', $month);
                })
                ->WhereNotIn ('users.id', function($query) {
                    $query->select ('user_id')->from ('payroll_report_users')
                        ->whereNull ('payroll_report_id');
                })
                ->get ();
            if (!$users->count ()) {
                $users = "";
            }
            $payroll_report_users = \App\Model\Payroll\PayrollReportUser::select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en as position')
                ->join ('users', 'users.id', '=', 'payroll_report_users.user_id')
                ->join ('positions', 'positions.id', '=', 'users.position_id')
                ->orderBy ('users.first_name_en')->orderBy ('users.last_name_en')
                ->whereNull ('payroll_report_users.payroll_report_id')
                ->get ();
            if (!$payroll_report_users->count ()) {
                $payroll_report_users = "";
            }
            $user_list = array($users, $payroll_report_users);
            return $user_list;
        }
    });
    Route::get ('/users_by_mission/{mission_id}/{month}', function($mission_id, $month) {
        if (Request::ajax ()) {
            $users = DB::table ('users')
                ->select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en as position')
                ->orderBy ('users.first_name_en')->orderBy ("users.last_name_en")
                ->join ('positions', 'positions.id', '=', 'users.position_id')
                ->join ('departments_missions', 'departments_missions.id', '=', 'users.department_id')
                ->where ('departments_missions.mission_id', $mission_id)
                ->WhereNotIn ('users.id', function($query) use ($month) {
                    $query->select ('user_id')->from ('payroll_report_users')
                        ->join ('payroll_reports', 'payroll_reports.id', '=', 'payroll_report_users.payroll_report_id')
                        ->where ('payroll_reports.month', $month);
                })
                ->WhereNotIn ('users.id', function($query) {
                    $query->select ('user_id')->from ('payroll_report_users')
                        ->whereNull ('payroll_report_id');
                })
                ->get ();
            if (!$users->count ()) {
                $users = "";
            }
            $payroll_report_users = \App\Model\Payroll\PayrollReportUser::select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en as position')
                ->join ('users', 'users.id', '=', 'payroll_report_users.user_id')
                ->join ('positions', 'positions.id', '=', 'users.position_id')
                ->orderBy ('users.first_name_en')->orderBy ('users.last_name_en')
                ->whereNull ('payroll_report_users.payroll_report_id')
                ->get ();
            if (!$payroll_report_users->count ()) {
                $payroll_report_users = "";
            }
            $user_list = array($users, $payroll_report_users);
            return $user_list;
        }
    });
    Route::get ('/payroll_report_user/{id}', 'PayrollController@payroll_report_user')->name ('payroll.payroll_report_user');
    Route::post ('payroll_report_user', 'PayrollController@store_report_user')->name ('payroll.store_report_user');
    Route::get ('/project_vacancy/{id}', 'PayrollController@project_vacancy')->name ('project_vacancy');
    Route::post ('/save-project_vacancy', 'PayrollController@save_project_vacancy')->name ('save_project_vacancy');
    Route::get ('/payroll_report_edit/{id}', 'PayrollController@payroll_report_edit')->name ('payroll_report_edit');
    Route::get ('/users_project/{project_id}/{month}', function($project_id, $month) {
        if (Request::ajax ()) {
            $users = DB::table ('users')
                ->select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en as position')
                ->orderBy ('users.first_name_en')->orderBy ("users.last_name_en")
                ->join ('positions', 'positions.id', '=', 'users.position_id')
                ->where ('users.project_id', $project_id)
                ->WhereNotIn ('users.id', function($query) use ($month) {
                    $query->select ('user_id')->from ('payroll_report_users')
                        ->join ('payroll_reports', 'payroll_reports.id', '=', 'payroll_report_users.payroll_report_id')
                        ->where ('payroll_reports.month', $month);
                })
                ->get ();
            if (!$users->count ()) {
                $users = "";
            }
            $payroll_report_users = \App\Model\Payroll\PayrollReportUser::select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en as position')
                ->join ('users', 'users.id', '=', 'payroll_report_users.user_id')
                ->join ('positions', 'positions.id', '=', 'users.position_id')
                ->orderBy ('users.first_name_en')->orderBy ('users.last_name_en')
                ->where ('payroll_report_users.payroll_report_id', 375790)
                ->get ();
            if (!$payroll_report_users->count ()) {
                $payroll_report_users = "";
            }
            $user_list = array($users, $payroll_report_users);
            return $user_list;
        }
    });
    Route::get ('/users_department/{mission_id}/{department_id}/{month}', function($mission_id, $department_id, $month) {
        if (Request::ajax ()) {
            $users = DB::table ('users')
                ->select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en as position')
                ->orderBy ('users.first_name_en')->orderBy ("users.last_name_en")
                ->join ('positions', 'positions.id', '=', 'users.position_id')
                ->join ('departments_missions', 'departments_missions.id', '=', 'users.department_id')
                ->where ('departments_missions.mission_id', $mission_id)
                ->where ('departments_missions.department_id', $department_id)
                ->WhereNotIn ('users.id', function($query) use ($month) {
                    $query->select ('user_id')->from ('payroll_report_users')
                        ->join ('payroll_reports', 'payroll_reports.id', '=', 'payroll_report_users.payroll_report_id')
                        ->where ('payroll_reports.month', $month);
                })
                ->get ();
            if (!$users->count ()) {
                $users = "";
            }
            $payroll_report_users = \App\Model\Payroll\PayrollReportUser::select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en as position')
                ->join ('users', 'users.id', '=', 'payroll_report_users.user_id')
                ->join ('positions', 'positions.id', '=', 'users.position_id')
                ->orderBy ('users.first_name_en')->orderBy ('users.last_name_en')
                ->where ('payroll_report_users.payroll_report_id', 375790)
                ->get ();
            if (!$payroll_report_users->count ()) {
                $payroll_report_users = "";
            }
            $user_list = array($users, $payroll_report_users);
            return $user_list;
        }
    });
    Route::get ('/users_mission/{mission_id}/{month}', function($mission_id, $month) {
        if (Request::ajax ()) {
            $users = DB::table ('users')
                ->select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en as position')
                ->orderBy ('users.first_name_en')->orderBy ("users.last_name_en")
                ->join ('positions', 'positions.id', '=', 'users.position_id')
                ->join ('departments_missions', 'departments_missions.id', '=', 'users.department_id')
                ->where ('departments_missions.mission_id', $mission_id)
                ->WhereNotIn ('users.id', function($query) use ($month) {
                    $query->select ('user_id')->from ('payroll_report_users')
                        ->join ('payroll_reports', 'payroll_reports.id', '=', 'payroll_report_users.payroll_report_id')
                        ->where ('payroll_reports.month', $month);
                })
                ->get ();
            if (!$users->count ()) {
                $users = "";
            }
            $payroll_report_users = \App\Model\Payroll\PayrollReportUser::select ('users.id', 'users.first_name_en', 'users.last_name_en', 'users.first_name_ar', 'users.last_name_ar', 'positions.name_en as position')
                ->join ('users', 'users.id', '=', 'payroll_report_users.user_id')
                ->join ('positions', 'positions.id', '=', 'users.position_id')
                ->orderBy ('users.first_name_en')->orderBy ('users.last_name_en')
                ->where ('payroll_report_users.payroll_report_id', 375790)
                ->get ();
            if (!$payroll_report_users->count ()) {
                $payroll_report_users = "";
            }
            $user_list = array($users, $payroll_report_users);
            return $user_list;
        }
    });
    Route::post ('/save_user_list', function() {
        if (Request::ajax ()) {
            $users = Request ('user_id');
            $payroll_report_id = Request ('payroll_report_id');

            if ($users) {
                $deleted_users = DB::table ('payroll_report_users')
                    ->where ('payroll_report_users.payroll_report_id', $payroll_report_id)
                    ->whereNotIn ('user_id', $users)
                    ->delete ();
            } else {
                $deleted_users = DB::table ('payroll_report_users')
                    ->where ('payroll_report_users.payroll_report_id', $payroll_report_id)
                    ->delete ();
            }

            foreach ($users as $user_id) {
                $payroll_report_user = \App\Model\Payroll\PayrollReportUser::updateOrCreate (['user_id' => $user_id, 'payroll_report_id' => $payroll_report_id], ['payroll_report_id' => $payroll_report_id, 'user_id' => $user_id]);
                $payroll_report_user->save ();
            }
        }
    });
    Route::post ('/save_users_list', function() {
        if (Request::ajax ()) {
            $users = Request ('user_id');
            if ($users) {
                $deleted_users = DB::table ('payroll_report_users')
                    ->whereNull ('payroll_report_users.payroll_report_id')
                    ->whereNotIn ('user_id', $users)
                    ->delete ();
            } else {
                $deleted_users = DB::table ('payroll_report_users')
                    ->whereNull ('payroll_report_users.payroll_report_id')
                    ->delete ();
            }

            foreach ($users as $user_id) {
                $payroll_report_user = \App\Model\Payroll\PayrollReportUser::updateOrCreate (['user_id' => $user_id], ['user_id' => $user_id]);
                $payroll_report_user->save ();
            }
        }
    });
    Route::post ('/save_list_users/{type}', function($type_percentage) {
        if (Request::ajax ()) {
            $users = Request ('user_id');
            $detailed_proposal_budget_id = Request ('detailed_proposal_budget_id');
            if ($users) {
                $deleted_users = DB::table ('payroll_records')
                    ->where ('detailed_proposal_budget_id', $detailed_proposal_budget_id)
                    ->where ($type_percentage, '>=', 0)
                    ->whereNotIn ('user_id', $users)
                    ->whereNotNull ('user_id')
                    ->delete ();
            } else {
                $deleted_users = DB::table ('payroll_records')
                    ->where ('detailed_proposal_budget_id', $detailed_proposal_budget_id)
                    ->where ($type_percentage, '>=', 0)
                    ->whereNotNull ('user_id')
                    ->delete ();
            }
            foreach ($users as $user_id) {
                $find = \App\Model\Payroll\PayrollRecord::where ('user_id', $user_id)->where ('detailed_proposal_budget_id', $detailed_proposal_budget_id)->where ($type_percentage, '>=', 0)->first ();
                if (is_null ($find)) {
                    echo 'test';
                    \App\Model\Payroll\PayrollRecord::create (['user_id'                     => $user_id,
                                                               'detailed_proposal_budget_id' => $detailed_proposal_budget_id,
                                                               $type_percentage              => 0
                    ]);
                }
            }

            return Response::json ($users);
        }
    });
    Route::post ('/save_list_vacancies/{type_percentage}', function($type_percentage) {
        if (Request::ajax ()) {
            $project_vacancies = Request ('project_vacancies');
            $detailed_proposal_budget_id = Request ('detailed_proposal_budget_id');

            if ($project_vacancies) {
                $deleted_users = DB::table ('payroll_records')
                    ->where ('detailed_proposal_budget_id', $detailed_proposal_budget_id)
                    ->where ($type_percentage, '>=', 0)
                    ->whereNotIn ('project_vacancy_id', $project_vacancies)
                    ->whereNotNull ('project_vacancy_id')
                    ->delete ();
            } else {
                $deleted_users = DB::table ('payroll_records')
                    ->where ('detailed_proposal_budget_id', $detailed_proposal_budget_id)
                    ->where ($type_percentage, '>=', 0)
                    ->whereNotNull ('project_vacancy_id')
                    ->delete ();
            }

            foreach ($project_vacancies as $project_vacancy_id) {

                $find = \App\Model\Payroll\PayrollRecord::where ('project_vacancy_id', $project_vacancy_id)
                    ->where ('detailed_proposal_budget_id', $detailed_proposal_budget_id)
                    ->where ($type_percentage, '>=', 0)
                    ->first ();

                if (is_null ($find)) {
                    \App\Model\Payroll\PayrollRecord::create (['project_vacancy_id'          => $project_vacancy_id,
                                                               'detailed_proposal_budget_id' => $detailed_proposal_budget_id,
                                                               $type_percentage              => 0
                    ]);
                }
            }

            return Response::json ($project_vacancies);
        }
    });
    Route::get ('/payroll_report_user_edit/{id}', 'PayrollController@payroll_report_user_edit')->name ('payroll.payroll_report_user_edit');
});
Route::group (['prefix' => '/print'], function() {
    Route::get ('pyr/{id}', 'PdfController@print_pyr');
    Route::get ('po/{id}', 'PdfController@print_po');
    Route::get ('cl/{id}', 'PdfController@print_cl');
    Route::get ('pyo/{id}', 'PdfController@print_pyo');
});
