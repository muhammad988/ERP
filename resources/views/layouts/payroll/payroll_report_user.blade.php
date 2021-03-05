@extends('layouts.app')
@section('style')
    @include('layouts.include.style.style_form')
    {!! Html::style('assets/plugins/global/plugins.bundle.css') !!}
    {!! Html::style('assets/app/custom/wizard/wizard-v2.demo2.css') !!}
    <link href="/css/dual-listbox.css" rel="stylesheet">
@stop
@section('content')
    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="col-lg-12">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h1 class="kt-portlet__head-title">
                            Payroll Report
                        </h1>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="kt-section">
                        <h3 class="kt-section__title kt-margin-b-20">
                            Payroll Report Information<span class="required"> *</span>
                        </h3>
                        <div class="kt-section__content">
                            <div class="form-group form-group-last">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td width="50%"><b>Report Name:</b>&nbsp;&nbsp;{{$payroll_report->name_en}}</td>
                                        <td><b>Description:</b>&nbsp;&nbsp;{{$payroll_report->description}}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Year:</b>&nbsp;&nbsp;{{\Carbon\Carbon::parse($payroll_report->month)->format('Y')}}
                                        </td>
                                        <td>
                                            <b>Month:</b>&nbsp;&nbsp;{{\Carbon\Carbon::parse($payroll_report->month)->format('M')}}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="form-text text-muted">
                                    <!--must use this helper element to display error message for the options--></div>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                        <div class="kt-portlet">
                            <div class="kt-portlet__body kt-portlet__body--fit">
                                <div class="kt-grid  kt-wizard-v2 kt-wizard-v2--white" id="kt_wizard_v2"
                                     data-ktwizard-state="step-first">
                                    <div class="kt-grid__item kt-wizard-v2__aside">
                                        <!--begin: Form Wizard Nav -->
                                        <div class="kt-wizard-v2__nav">
                                            <div class="kt-wizard-v2__nav-items">

                                                <!--doc: Replace A tag with SPAN tag to disable the step link click -->
                                                <div class="kt-wizard-v2__nav-item" data-ktwizard-type="step"
                                                     data-ktwizard-state="current">
                                                    <div class="kt-wizard-v2__nav-body">
                                                        <div class="kt-wizard-v2__nav-icon">
                                                            <i class="la la-money"></i>
                                                        </div>
                                                        <div class="kt-wizard-v2__nav-label">
                                                            <div class="kt-wizard-v2__nav-label-title">
                                                                Salary
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kt-wizard-v2__nav-item" data-ktwizard-type="step">
                                                    <div class="kt-wizard-v2__nav-body">
                                                        <div class="kt-wizard-v2__nav-icon">
                                                            <i class="la la-suitcase"></i>
                                                        </div>
                                                        <div class="kt-wizard-v2__nav-label">
                                                            <div class="kt-wizard-v2__nav-label-title">
                                                                Management Allowance
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kt-wizard-v2__nav-item" href="#" data-ktwizard-type="step">
                                                    <div class="kt-wizard-v2__nav-body">
                                                        <div class="kt-wizard-v2__nav-icon">
                                                            <i class="la la-bus"></i>
                                                        </div>
                                                        <div class="kt-wizard-v2__nav-label">
                                                            <div class="kt-wizard-v2__nav-label-title">
                                                                Transportation Allowance
                                                            </div>
                                                            {{-- <div class="kt-wizard-v2__nav-label-desc">
                                                                Add Your Support Agents
                                                            </div> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kt-wizard-v2__nav-item" data-ktwizard-type="step">
                                                    <div class="kt-wizard-v2__nav-body">
                                                        <div class="kt-wizard-v2__nav-icon">
                                                            <i class="la la-home"></i>
                                                        </div>
                                                        <div class="kt-wizard-v2__nav-label">
                                                            <div class="kt-wizard-v2__nav-label-title">
                                                                House Allowance
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kt-wizard-v2__nav-item" data-ktwizard-type="step">
                                                    <div class="kt-wizard-v2__nav-body">
                                                        <div class="kt-wizard-v2__nav-icon">
                                                            <i class="la la-mobile-phone"></i>
                                                        </div>
                                                        <div class="kt-wizard-v2__nav-label">
                                                            <div class="kt-wizard-v2__nav-label-title">
                                                                Cell Phone Allowance
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kt-wizard-v2__nav-item" data-ktwizard-type="step">
                                                    <div class="kt-wizard-v2__nav-body">
                                                        <div class="kt-wizard-v2__nav-icon">
                                                            <i class="la la-dollar"></i>
                                                        </div>
                                                        <div class="kt-wizard-v2__nav-label">
                                                            <div class="kt-wizard-v2__nav-label-title">
                                                                Cost of Living Allowance
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kt-wizard-v2__nav-item" data-ktwizard-type="step">
                                                    <div class="kt-wizard-v2__nav-body">
                                                        <div class="kt-wizard-v2__nav-icon">
                                                            <i class="fa fa-gas-pump"></i>
                                                        </div>
                                                        <div class="kt-wizard-v2__nav-label">
                                                            <div class="kt-wizard-v2__nav-label-title">
                                                                Fuel Allowance
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kt-wizard-v2__nav-item" data-ktwizard-type="step">
                                                    <div class="kt-wizard-v2__nav-body">
                                                        <div class="kt-wizard-v2__nav-icon">
                                                            <i class="la la-black-tie"></i>
                                                        </div>
                                                        <div class="kt-wizard-v2__nav-label">
                                                            <div class="kt-wizard-v2__nav-label-title">
                                                                Appearance Allowance
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kt-wizard-v2__nav-item" data-ktwizard-type="step">
                                                    <div class="kt-wizard-v2__nav-body">
                                                        <div class="kt-wizard-v2__nav-icon">
                                                            <i class="fa fa-business-time"></i>
                                                        </div>
                                                        <div class="kt-wizard-v2__nav-label">
                                                            <div class="kt-wizard-v2__nav-label-title">
                                                                Work Nature Allowance
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kt-wizard-v2__nav-item" data-ktwizard-type="step">
                                                    <div class="kt-wizard-v2__nav-body">
                                                        <div class="kt-wizard-v2__nav-icon">
                                                            <i class="fab fa-creative-commons-nc"></i>
                                                        </div>
                                                        <div class="kt-wizard-v2__nav-label">
                                                            <div class="kt-wizard-v2__nav-label-title">
                                                                Deduction
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--end: Form Wizard Nav -->
                                    </div>
                                    <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v2__wrapper">

                                        <!--begin: Form Wizard Form-->
                                        <form  method="POST" action="{{route('payroll.store_report_user')}}" class="kt-form" id="kt_form">
                                        @csrf
                                            <input name="month" value="{{$payroll_report->month}}" hidden>
                                            <input name="report_id" value="{{$payroll_report->id}}" hidden>
                                            <!--begin: Form Wizard Step 1-->
                                            <div class="kt-wizard-v2__content" data-ktwizard-type="step-content"
                                                 data-ktwizard-state="current">
                                                <div class="kt-heading kt-heading--md">Employee List</div>
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                    <th>Employee</th>
                                                    <th>Position</th>
                                                    <th>Salary</th>
                                                    <th>Allocated</th>
                                                    <th>Project</th>
                                                    <th>Budget Line</th>
                                                    <th>Allocation</th>
                                                    <th>Allocated Salary</th>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($payroll_report_users as $payroll_report_user)
                                                        <input name="payroll_report_user_id[]" value="{{$payroll_report_user->payroll_report_user_id}}" hidden >
                                                        <input name="month[]" value="{{$payroll_report->month}}" hidden >
                                                        <input name="detailed_proposal_budget_id[]" value="{{$payroll_report_user->id}}" hidden >
                                                        <input name="user_id[]" value="{{$payroll_report_user->user_id}}" hidden >

                                                        <tr>
                                                            <td>{{$payroll_report_user->first_name_en .' '. $payroll_report_user->last_name_en}}</td>
                                                            <td>{{$payroll_report_user->position}}</td>
                                                            <td><input type="text" class="form-control money"
                                                                       id="basic_salary_{{$payroll_report_user->id}}"

                                                                       value="{{$payroll_report_user->basic_salary}}"
                                                                       disabled></td>
                                                            <td><input type="text" class="form-control money allocated_salary_{{ $payroll_report_user->user_id}}"  disabled></td>
                                                            <td>{{$payroll_report_user->project}}</td>
                                                            <td>{{$payroll_report_user->budget_line .' - '. $payroll_report_user->category_option}}</td>
                                                            <td>
                                                                <input  onblur="total_salary(`{{$payroll_report_user->id}}`,`{{ $payroll_report_user->user_id}}`,`{{ $payroll_report_user->payroll_report_user_id}}`,'salary')" class="form-control money value-salary-{{ $payroll_report_user->user_id}}" id="salary_percentage_{{$payroll_report_user->id}}" name="salary_percentage[]" type="text" value="@foreach($payroll_records as $payroll_record)  @if($payroll_report_user->id==$payroll_record->detailed_proposal_budget_id and $payroll_report_user->user_id==$payroll_record->user_id){{$payroll_record->salary_percentage}}@else {{0}} @endif @endforeach">
                                                                <span id="error-salary-percentage-{{$payroll_report_user->id}}" class="form-text text-danger error-salary-value-{{$payroll_report_user->user_id}}"></span>
                                                            </td>
                                                            <td>
                                                                <input  type="text" class="form-control money" id="salary_{{$payroll_report_user->id}}"
                                                                       value="@foreach($payroll_records as $payroll_record) @if($payroll_report_user->id==$payroll_record->detailed_proposal_budget_id and $payroll_report_user->user_id==$payroll_record->user_id){{$payroll_record->salary_percentage * $payroll_report_user->basic_salary /100}} @else {{0}} @endif @endforeach"
                                                                       name="user_salary[]" readonly>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!--end: Form Wizard Step 1-->

                                            <!--begin: Form Wizard Step 2-->
                                            <div class="kt-wizard-v2__content" data-ktwizard-type="step-content">
                                                <div class="kt-heading kt-heading--md">Employee List</div>
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                    <th>Employee</th>
                                                    <th>Position</th>
                                                    <th>Management Allowance</th>
                                                    <th>Allocated</th>
                                                    <th>Project</th>
                                                    <th>Budget Line</th>
                                                    <th>Allocation</th>
                                                    <th>Allocated Salary</th>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($management_payroll_report_users as $payroll_report_user)
                                                        @if ($management_budget_lines->count())
                                                            @foreach ($management_budget_lines as $budget_line)
                                                                <input name="management_payroll_report_user_id[]" value="{{$payroll_report_user->payroll_report_user_id}}" hidden >
                                                                <input name="management_month[]" value="{{$payroll_report->month}}" hidden >
                                                                <input name="management_detailed_proposal_budget_id[]" value="{{$budget_line->id}}" hidden >
                                                                <tr>
                                                                    <td>{{$payroll_report_user->first_name_en .' '. $payroll_report_user->last_name_en}}</td>
                                                                    <td>{{$payroll_report_user->position}}</td>
                                                                    <td><input type="text" class="form-control money"
                                                                               id="basic_management_allowance_{{$budget_line->id}}"
                                                                               value="{{$payroll_report_user->management_allowance}}"
                                                                               disabled></td>
                                                                    <td><input type="text" class="form-control money allocated_management_allowance_{{ $payroll_report_user->user_id}}" disabled>
                                                                    </td>
                                                                    <td>{{$budget_line->project}}</td>
                                                                    <td>{{$budget_line->budget_line .' - '. $budget_line->category_option}}</td>
                                                                    <td>

                                                                        <input  class="form-control money value-management_allowance-{{ $payroll_report_user->user_id}}"
                                                                                onblur="total_salary(`{{$budget_line->id}}`,`{{ $payroll_report_user->user_id}}`,`{{ $payroll_report_user->payroll_report_user_id}}`,'management_allowance')"
                                                                                id="management_allowance_percentage_{{$budget_line->id}}"
                                                                                name="management_allowance_percentage[]"
                                                                               type="text"
                                                                               value="@foreach($management_payroll_records as $payroll_record)@if($budget_line->id==$payroll_record->detailed_proposal_budget_id and $payroll_report_user->user_id == $payroll_record->user_id){{$payroll_record->management_allowance_percentage}}@endif
                                                                               @endforeach">
                                                                        <span id="error-management_allowance-percentage-{{$budget_line->id}}" class="form-text text-danger error-management_allowance-value-{{$payroll_report_user->user_id}}"></span>

                                                                    </td>
                                                                    <td><input type="text" class="form-control money"
                                                                               id="management_allowance_{{$budget_line->id}}"
                                                                               name="management_allowance[]" readonly>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td>{{$payroll_report_user->first_name_en .' '. $payroll_report_user->last_name_en}}</td>
                                                                <td>{{$payroll_report_user->position}}</td>
                                                                <td><input type="text" class="form-control"
                                                                           id="user_management_allowance"
                                                                           value="{{$payroll_report_user->management_allowance}}"
                                                                           disabled></td>
                                                                <td><input type="text" class="form-control"
                                                                           id="user_allocated_management" disabled></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!--end: Form Wizard Step 2-->

                                            <!--begin: Form Wizard Step 3-->
                                            <div class="kt-wizard-v2__content" data-ktwizard-type="step-content">
                                                <div class="kt-heading kt-heading--md">Employee List</div>
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                    <th>Employee</th>
                                                    <th>Position</th>
                                                    <th>Transportation Allowance</th>
                                                    <th>Allocated</th>
                                                    <th>Project</th>
                                                    <th>Budget Line</th>
                                                    <th>Allocation</th>
                                                    <th>Allocated Salary</th>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($transportation_payroll_report_users as $payroll_report_user)
                                                        @if ($transportation_budget_lines->count())
                                                            @foreach ($transportation_budget_lines as $budget_line)
                                                                <input name="transportation_payroll_report_user_id[]" value="{{$payroll_report_user->payroll_report_user_id}}" hidden >
                                                                <input name="transportation_month[]" value="{{$payroll_report->month}}" hidden >
                                                                <input name="transportation_detailed_proposal_budget_id[]" value="{{$budget_line->id}}" hidden >
                                                                <tr>
                                                                    <td>{{$payroll_report_user->first_name_en .' '. $payroll_report_user->last_name_en}}</td>
                                                                    <td>{{$payroll_report_user->position}}</td>
                                                                    <td><input type="text" class="form-control money"
                                                                               id="basic_transportation_allowance_{{$budget_line->id}}"
                                                                               value="{{$payroll_report_user->transportation_allowance}}"
                                                                               disabled>
                                                                    </td>
                                                                    <td><input type="text" class="form-control money allocated_transportation_allowance_{{ $payroll_report_user->user_id}}" disabled>
                                                                    <td>{{$budget_line->project}}</td>
                                                                    <td>{{$budget_line->budget_line .' - '. $budget_line->category_option}}</td>
                                                                    <td>
                                                                        <input  class="form-control money value-transportation_allowance-{{ $payroll_report_user->user_id}}"
                                                                                onblur="total_salary(`{{$budget_line->id}}`,`{{ $payroll_report_user->user_id}}`,`{{ $payroll_report_user->payroll_report_user_id}}`,'transportation_allowance')"
                                                                                id="transportation_allowance_percentage_{{$budget_line->id}}"
                                                                                name="transportation_allowance_percentage[]"
                                                                                type="text"
                                                                                value="@foreach($transportation_payroll_records as $payroll_record)@if($budget_line->id==$payroll_record->detailed_proposal_budget_id and $payroll_report_user->user_id == $payroll_record->user_id){{$payroll_record->transportation_allowance_percentage}}@endif
                                                                                @endforeach">
                                                                        <span id="error-transportation_allowance-percentage-{{$budget_line->id}}" class="form-text text-danger error-transportation_allowance-value-{{$payroll_report_user->user_id}}"></span>
                                                                    </td>
                                                                    <td><input type="text" class="form-control money"
                                                                               id="transportation_allowance_{{$budget_line->id}}"
                                                                               name="transportation_allowance[]" readonly>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td>{{$payroll_report_user->first_name_en .' '. $payroll_report_user->last_name_en}}</td>
                                                                <td>{{$payroll_report_user->position}}</td>
                                                                <td><input type="text" class="form-control"
                                                                           id="user_transportation_allowance"
                                                                           value="{{$payroll_report_user->transportation_allowance}}"
                                                                           disabled></td>
                                                                <td><input type="text" class="form-control"
                                                                           id="user_allocated_transportation" disabled>
                                                                </td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!--end: Form Wizard Step 3-->

                                            <!--begin: Form Wizard Step 4-->
                                            <div class="kt-wizard-v2__content" data-ktwizard-type="step-content">
                                                <div class="kt-heading kt-heading--md">Employee List</div>
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                    <th>Employee</th>
                                                    <th>Position</th>
                                                    <th>House Allowance</th>
                                                    <th>Allocated</th>
                                                    <th>Project</th>
                                                    <th>Budget Line</th>
                                                    <th>Allocation</th>
                                                    <th>Allocated Salary</th>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($house_payroll_report_users as $payroll_report_user)
                                                        @if ($house_budget_lines->count())
                                                            @foreach ($house_budget_lines as $budget_line)
                                                                <input name="house_payroll_report_user_id[]" value="{{$payroll_report_user->payroll_report_user_id}}" hidden >
                                                                <input name="house_month[]" value="{{$payroll_report->month}}" hidden >
                                                                <input name="house_detailed_proposal_budget_id[]" value="{{$budget_line->id}}" hidden >
                                                                <tr>
                                                                    <td>{{$payroll_report_user->first_name_en .' '. $payroll_report_user->last_name_en}}</td>
                                                                    <td>{{$payroll_report_user->position}}</td>
                                                                    <td><input type="text" class="form-control money"
                                                                               id="basic_house_allowance_{{$budget_line->id}}"
                                                                               value="{{$payroll_report_user->house_allowance}}"
                                                                               disabled></td>
                                                                    <td><input type="text" class="form-control money allocated_house_allowance_{{ $payroll_report_user->user_id}}" disabled>
                                                                    <td>{{$budget_line->project}}</td>
                                                                    <td>{{$budget_line->budget_line .' - '. $budget_line->category_option}}</td>
                                                                    <td>

                                                                        <input  class="form-control money value-house_allowance-{{ $payroll_report_user->user_id}}"
                                                                                onblur="total_salary(`{{$budget_line->id}}`,`{{ $payroll_report_user->user_id}}`,`{{ $payroll_report_user->payroll_report_user_id}}`,'house_allowance')"
                                                                                id="house_allowance_percentage_{{$budget_line->id}}"
                                                                                name="house_allowance_percentage[]"
                                                                                type="text"
                                                                                value="@foreach($house_payroll_records as $payroll_record)@if($budget_line->id==$payroll_record->detailed_proposal_budget_id and $payroll_report_user->user_id == $payroll_record->user_id){{$payroll_record->house_allowance_percentage}}@endif
                                                                                @endforeach">
                                                                        <span id="error-house_allowance-percentage-{{$budget_line->id}}" class="form-text text-danger error-house_allowance-value-{{$payroll_report_user->user_id}}"></span>

                                                                    </td>
                                                                    <td><input type="text" class="form-control money"
                                                                               id="house_allowance_{{$budget_line->id}}"
                                                                               name="house_allowance[]" readonly>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td>{{$payroll_report_user->first_name_en .' '. $payroll_report_user->last_name_en}}</td>
                                                                <td>{{$payroll_report_user->position}}</td>
                                                                <td><input type="text" class="form-control"
                                                                           id="user_house_allowance"
                                                                           value="{{$payroll_report_user->house_allowance}}"
                                                                           disabled></td>
                                                                <td><input type="text" class="form-control"
                                                                           id="user_allocated_house" disabled></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!--end: Form Wizard Step 4-->

                                            <!--begin: Form Wizard Step 5 Cell Phone Allowance-->
                                            <div class="kt-wizard-v2__content" data-ktwizard-type="step-content">
                                                <div class="kt-heading kt-heading--md">Employee List</div>
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                    <th>Employee</th>
                                                    <th>Position</th>
                                                    <th>Cell Phone Allowance</th>
                                                    <th>Allocated</th>
                                                    <th>Project</th>
                                                    <th>Budget Line</th>
                                                    <th>Allocation</th>
                                                    <th>Allocated Salary</th>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($cell_phone_payroll_report_users as $payroll_report_user)
                                                        @if ($cell_phone_budget_lines->count())
                                                            @foreach ($cell_phone_budget_lines as $budget_line)
                                                                <input name="cell_phone_payroll_report_user_id[]" value="{{$payroll_report_user->payroll_report_user_id}}" hidden >
                                                                <input name="cell_phone_month[]" value="{{$payroll_report->month}}" hidden >
                                                                <input name="cell_phone_detailed_proposal_budget_id[]" value="{{$budget_line->id}}" hidden >
                                                                <tr>
                                                                    <td>{{$payroll_report_user->first_name_en .' '. $payroll_report_user->last_name_en}}</td>
                                                                    <td>{{$payroll_report_user->position}}</td>
                                                                    <td><input type="text" class="form-control money"
                                                                               id="basic_cell_phone_allowance_{{$budget_line->id}}"
                                                                               value="{{$payroll_report_user->cell_phone_allowance}}"
                                                                               disabled></td>
                                                                    <td><input type="text" class="form-control money allocated_cell_phone_allowance_{{ $payroll_report_user->user_id}}" disabled>
                                                                    <td>{{$budget_line->project}}</td>
                                                                    <td>{{$budget_line->budget_line .' - '. $budget_line->category_option}}</td>
                                                                    <td>

                                                                        <input  class="form-control money value-cell_phone_allowance-{{ $payroll_report_user->user_id}}"
                                                                                onblur="total_salary(`{{$budget_line->id}}`,`{{ $payroll_report_user->user_id}}`,`{{ $payroll_report_user->payroll_report_user_id}}`,'cell_phone_allowance')"
                                                                                id="cell_phone_allowance_percentage_{{$budget_line->id}}"
                                                                                name="cell_phone_allowance_percentage[]"
                                                                                type="text"
                                                                                value="@foreach($cell_phone_payroll_records as $payroll_record)@if($budget_line->id==$payroll_record->detailed_proposal_budget_id and $payroll_report_user->user_id == $payroll_record->user_id){{$payroll_record->cell_phone_allowance_percentage}}@endif
                                                                                @endforeach">
                                                                        <span id="error-cell_phone_allowance-percentage-{{$budget_line->id}}" class="form-text text-danger error-cell_phone_allowance-value-{{$payroll_report_user->user_id}}"></span>

                                                                    </td>
                                                                    <td><input type="text" class="form-control money"
                                                                               id="cell_phone_allowance_{{$budget_line->id}}"
                                                                               name="cell_phone_allowance[]" readonly>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td>{{$payroll_report_user->first_name_en .' '. $payroll_report_user->last_name_en}}</td>
                                                                <td>{{$payroll_report_user->position}}</td>
                                                                <td><input type="text" class="form-control"
                                                                           id="user_cell_phone_allowance"
                                                                           value="{{$payroll_report_user->cell_phone_allowance}}"
                                                                           disabled></td>
                                                                <td><input type="text" class="form-control"
                                                                           id="user_allocated_cell_phone" disabled></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!--end: Form Wizard Step 5-->

                                            <!--begin: Form Wizard Step 6 Cost Of Living Allowance -->
                                            <div class="kt-wizard-v2__content" data-ktwizard-type="step-content">
                                                <div class="kt-heading kt-heading--md">Employee List</div>
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                    <th>Employee</th>
                                                    <th>Position</th>
                                                    <th>Cost of Living Allowance</th>
                                                    <th>Allocated</th>
                                                    <th>Project</th>
                                                    <th>Budget Line</th>
                                                    <th>Allocation</th>
                                                    <th>Allocated Salary</th>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($cost_of_living_payroll_report_users as $payroll_report_user)
                                                        @if ($cost_of_living_budget_lines->count())
                                                            @foreach ($cost_of_living_budget_lines as $budget_line)
                                                                <input name="cost_of_living_payroll_report_user_id[]" value="{{$payroll_report_user->payroll_report_user_id}}" hidden >
                                                                <input name="cost_of_living_month[]" value="{{$payroll_report->month}}" hidden >
                                                                <input name="cost_of_living_detailed_proposal_budget_id[]" value="{{$budget_line->id}}" hidden >
                                                                <tr>
                                                                    <td>{{$payroll_report_user->first_name_en .' '. $payroll_report_user->last_name_en}}</td>
                                                                    <td>{{$payroll_report_user->position}}</td>
                                                                    <td><input type="text" class="form-control money"
                                                                               id="basic_cost_of_living_allowance_{{$budget_line->id}}"
                                                                               value="{{$payroll_report_user->cost_of_living_allowance}}"
                                                                               disabled>
                                                                    </td>
                                                                    <td><input type="text" class="form-control money allocated_cost_of_living_allowance_{{ $payroll_report_user->user_id}}" disabled>
                                                                    <td>{{$budget_line->project}}</td>
                                                                    <td>{{$budget_line->budget_line .' - '. $budget_line->category_option}}</td>
                                                                    <td>
                                                                        <input  class="form-control money value-cost_of_living_allowance-{{ $payroll_report_user->user_id}}"
                                                                                onblur="total_salary(`{{$budget_line->id}}`,`{{ $payroll_report_user->user_id}}`,`{{ $payroll_report_user->payroll_report_user_id}}`,'cost_of_living_allowance')"
                                                                                id="cost_of_living_allowance_percentage_{{$budget_line->id}}"
                                                                                name="cost_of_living_allowance_percentage[]"
                                                                                type="text"
                                                                                value="@foreach($cost_of_living_payroll_records as $payroll_record)@if($budget_line->id==$payroll_record->detailed_proposal_budget_id and $payroll_report_user->user_id == $payroll_record->user_id){{$payroll_record->cost_of_living_allowance_percentage}}@endif
                                                                                @endforeach">
                                                                        <span id="error-cost_of_living_allowance-percentage-{{$budget_line->id}}" class="form-text text-danger error-cost_of_living_allowance-value-{{$payroll_report_user->user_id}}"></span>
                                                                    </td>
                                                                    <td><input type="text" class="form-control money"
                                                                               id="cost_of_living_allowance_{{$budget_line->id}}"
                                                                               name="cost_of_living_allowance[]" readonly>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td>{{$payroll_report_user->first_name_en .' '. $payroll_report_user->last_name_en}}</td>
                                                                <td>{{$payroll_report_user->position}}</td>
                                                                <td><input type="text" class="form-control"
                                                                           id="user_cost_of_living_allowance"
                                                                           value="{{$payroll_report_user->cost_of_living_allowance}}"
                                                                           disabled></td>
                                                                <td><input type="text" class="form-control"
                                                                           id="user_allocated_cost_of_living" disabled>
                                                                </td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!--end: Form Wizard Step 6-->

                                            <!--begin: Form Wizard Step 7 Fuel Allowance -->
                                            <div class="kt-wizard-v2__content" data-ktwizard-type="step-content">
                                                <div class="kt-heading kt-heading--md">Employee List</div>
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                    <th>Employee</th>
                                                    <th>Position</th>
                                                    <th>Fuel Allowance</th>
                                                    <th>Allocated</th>
                                                    <th>Project</th>
                                                    <th>Budget Line</th>
                                                    <th>Allocation</th>
                                                    <th>Allocated Salary</th>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($fuel_payroll_report_users as $payroll_report_user)
                                                        @if ($fuel_budget_lines->count())
                                                            @foreach ($fuel_budget_lines as $budget_line)
                                                                <input name="fuel_payroll_report_user_id[]" value="{{$payroll_report_user->payroll_report_user_id}}" hidden >
                                                                <input name="fuel_month[]" value="{{$payroll_report->month}}" hidden >
                                                                <input name="fuel_detailed_proposal_budget_id[]" value="{{$budget_line->id}}" hidden >
                                                                <tr>
                                                                    <td>{{$payroll_report_user->first_name_en .' '. $payroll_report_user->last_name_en}}</td>
                                                                    <td>{{$payroll_report_user->position}}</td>
                                                                    <td><input type="text" class="form-control money"
                                                                               id="basic_fuel_allowance_{{$budget_line->id}}"
                                                                               value="{{$payroll_report_user->fuel_allowance}}"
                                                                               disabled>
                                                                    </td>
                                                                    <td><input type="text" class="form-control money allocated_fuel_allowance_{{ $payroll_report_user->user_id}}" disabled>
                                                                    <td>{{$budget_line->project}}</td>
                                                                    <td>{{$budget_line->budget_line .' - '. $budget_line->category_option}}</td>
                                                                    <td>
                                                                        <input  class="form-control money value-fuel_allowance-{{ $payroll_report_user->user_id}}"
                                                                                onblur="total_salary(`{{$budget_line->id}}`,`{{ $payroll_report_user->user_id}}`,`{{ $payroll_report_user->payroll_report_user_id}}`,'fuel_allowance')"
                                                                                id="fuel_allowance_percentage_{{$budget_line->id}}"
                                                                                name="fuel_allowance_percentage[]"
                                                                                type="text"
                                                                                value="@foreach($fuel_payroll_records as $payroll_record)@if($budget_line->id==$payroll_record->detailed_proposal_budget_id and $payroll_report_user->user_id == $payroll_record->user_id){{$payroll_record->fuel_allowance_percentage}}@endif
                                                                                @endforeach">
                                                                        <span id="error-fuel_allowance-percentage-{{$budget_line->id}}" class="form-text text-danger error-fuel_allowance-value-{{$payroll_report_user->user_id}}"></span>
                                                                    </td>
                                                                    <td><input type="text" class="form-control money"
                                                                               id="fuel_allowance_{{$budget_line->id}}"
                                                                               name="fuel_allowance[]" readonly>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td>{{$payroll_report_user->first_name_en .' '. $payroll_report_user->last_name_en}}</td>
                                                                <td>{{$payroll_report_user->position}}</td>
                                                                <td><input type="text" class="form-control"
                                                                           id="user_fuel_allowance"
                                                                           value="{{$payroll_report_user->fuel_allowance}}"
                                                                           disabled></td>
                                                                <td><input type="text" class="form-control"
                                                                           id="user_allocated_fuel" disabled></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!--end: Form Wizard Step 7-->

                                            <!--begin: Form Wizard Step 8 Appearance Allowance -->
                                            <div class="kt-wizard-v2__content" data-ktwizard-type="step-content">
                                                <div class="kt-heading kt-heading--md">Employee List</div>
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                    <th>Employee</th>
                                                    <th>Position</th>
                                                    <th>Appearance Allowance</th>
                                                    <th>Allocated</th>
                                                    <th>Project</th>
                                                    <th>Budget Line</th>
                                                    <th>Allocation</th>
                                                    <th>Allocated Salary</th>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($appearance_payroll_report_users as $payroll_report_user)
                                                        @if ($appearance_budget_lines->count())
                                                            @foreach ($appearance_budget_lines as $budget_line)
                                                                <input name="appearance_payroll_report_user_id[]" value="{{$payroll_report_user->payroll_report_user_id}}" hidden >
                                                                <input name="appearance_month[]" value="{{$payroll_report->month}}" hidden >
                                                                <input name="appearance_detailed_proposal_budget_id[]" value="{{$budget_line->id}}" hidden >
                                                                <tr>
                                                                    <td>{{$payroll_report_user->first_name_en .' '. $payroll_report_user->last_name_en}}</td>
                                                                    <td>{{$payroll_report_user->position}}</td>
                                                                    <td><input type="text" class="form-control money"
                                                                               id="basic_appearance_allowance_{{$budget_line->id}}"
                                                                               value="{{$payroll_report_user->appearance_allowance}}"
                                                                               disabled>
                                                                    </td>
                                                                    <td><input type="text" class="form-control money allocated_appearance_allowance_{{ $payroll_report_user->user_id}}" disabled>
                                                                    <td>{{$budget_line->project}}</td>
                                                                    <td>{{$budget_line->budget_line .' - '. $budget_line->category_option}}</td>
                                                                    <td>
                                                                        <input  class="form-control money value-appearance_allowance-{{ $payroll_report_user->user_id}}"
                                                                                onblur="total_salary(`{{$budget_line->id}}`,`{{ $payroll_report_user->user_id}}`,`{{ $payroll_report_user->payroll_report_user_id}}`,'appearance_allowance')"
                                                                                id="appearance_allowance_percentage_{{$budget_line->id}}"
                                                                                name="appearance_allowance_percentage[]"
                                                                                type="text"
                                                                                value="@foreach($appearance_payroll_records as $payroll_record)@if($budget_line->id==$payroll_record->detailed_proposal_budget_id and $payroll_report_user->user_id == $payroll_record->user_id){{$payroll_record->appearance_allowance_percentage}}@endif
                                                                                @endforeach">
                                                                        <span id="error-appearance_allowance-percentage-{{$budget_line->id}}" class="form-text text-danger error-appearance_allowance-value-{{$payroll_report_user->user_id}}"></span>
                                                                    </td>
                                                                    <td><input type="text" class="form-control money"
                                                                               id="appearance_allowance_{{$budget_line->id}}"
                                                                               name="appearance_allowance[]" readonly>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td>{{$payroll_report_user->first_name_en .' '. $payroll_report_user->last_name_en}}</td>
                                                                <td>{{$payroll_report_user->position}}</td>
                                                                <td><input type="text" class="form-control"
                                                                           id="user_appearance_allowance"
                                                                           value="{{$payroll_report_user->appearance_allowance}}"
                                                                           disabled></td>
                                                                <td><input type="text" class="form-control"
                                                                           id="user_allocated_appearance" disabled></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!--end: Form Wizard Step 8-->

                                            <!--begin: Form Wizard Step 9 Work Nature Allowance -->
                                            <div class="kt-wizard-v2__content" data-ktwizard-type="step-content">
                                                <div class="kt-heading kt-heading--md">Employee List</div>
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                    <th>Employee</th>
                                                    <th>Position</th>
                                                    <th>Work Nature Allowance</th>
                                                    <th>Allocated</th>
                                                    <th>Project</th>
                                                    <th>Budget Line</th>
                                                    <th>Allocation</th>
                                                    <th>Allocated Salary</th>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($work_nature_payroll_report_users as $payroll_report_user)
                                                        @if ($work_nature_budget_lines->count())
                                                            @foreach ($work_nature_budget_lines as $budget_line)
                                                                <input name="work_nature_payroll_report_user_id[]" value="{{$payroll_report_user->payroll_report_user_id}}" hidden >
                                                                <input name="work_nature_month[]" value="{{$payroll_report->month}}" hidden >
                                                                <input name="work_nature_detailed_proposal_budget_id[]" value="{{$budget_line->id}}" hidden >
                                                                <tr>
                                                                    <td>{{$payroll_report_user->first_name_en .' '. $payroll_report_user->last_name_en}}</td>
                                                                    <td>{{$payroll_report_user->position}}</td>
                                                                    <td><input type="text" class="form-control money"
                                                                               id="basic_work_nature_allowance_{{$budget_line->id}}"
                                                                               value="{{$payroll_report_user->work_nature_allowance}}"
                                                                               disabled>
                                                                    </td>
                                                                    <td><input type="text" class="form-control money allocated_work_nature_allowance_{{ $payroll_report_user->user_id}}" disabled>
                                                                    <td>{{$budget_line->project}}</td>
                                                                    <td>{{$budget_line->budget_line .' - '. $budget_line->category_option}}</td>
                                                                    <td>
                                                                        <input  class="form-control money value-work_nature_allowance-{{ $payroll_report_user->user_id}}"
                                                                                onblur="total_salary(`{{$budget_line->id}}`,`{{ $payroll_report_user->user_id}}`,`{{ $payroll_report_user->payroll_report_user_id}}`,'work_nature_allowance')"
                                                                                id="work_nature_allowance_percentage_{{$budget_line->id}}"
                                                                                name="work_nature_allowance_percentage[]"
                                                                                type="text"
                                                                                value="@foreach($work_nature_payroll_records as $payroll_record)@if($budget_line->id==$payroll_record->detailed_proposal_budget_id and $payroll_report_user->user_id == $payroll_record->user_id){{$payroll_record->work_nature_allowance_percentage}}@endif
                                                                                @endforeach">
                                                                        <span id="error-work_nature_allowance-percentage-{{$budget_line->id}}" class="form-text text-danger error-work_nature_allowance-value-{{$payroll_report_user->user_id}}"></span>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control money"
                                                                               id="work_nature_allowance_{{$budget_line->id}}"
                                                                               name="work_nature_allowance[]" readonly>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td>{{$payroll_report_user->first_name_en .' '. $payroll_report_user->last_name_en}}</td>
                                                                <td>{{$payroll_report_user->position}}</td>
                                                                <td><input type="text" class="form-control"
                                                                           id="user_work_nature_allowance"
                                                                           value="{{$payroll_report_user->work_nature_allowance}}"
                                                                           disabled></td>
                                                                <td><input type="text" class="form-control"
                                                                           id="user_allocated_work_nature" disabled>
                                                                </td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!--end: Form Wizard Step 9-->

                                            <!--begin: Form Wizard Step 10-->
                                            <div class="kt-wizard-v2__content" data-ktwizard-type="step-content"
                                                 data-ktwizard-state="current">
                                                <div class="kt-heading kt-heading--md">Employee List</div>
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                    <th>Employee</th>
                                                    <th>Position</th>
                                                    <th>Salary</th>
                                                    <th>Deducted</th>
                                                    <th>Unpaid Leave Days</th>
                                                    <th>Unpaid Leave Deduction</th>
                                                    <th>Deduction</th>
                                                    <th>Deduction Salary</th>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($payroll_users as $payroll_user)
                                                        <tr>
                                                            <td>{{$payroll_user->first_name_en .' '. $payroll_user->last_name_en}}</td>
                                                            <td>{{$payroll_user->position}}</td>
                                                            <td><input type="text" class="form-control money deduction-basic-salary-{{$payroll_user->id}}"
                                                                       name="salary[{{$payroll_user->id}}]"
                                                                       value="{{$payroll_user->basic_salary}}" readonly>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control money deducted-{{$payroll_user->id}}" readonly></td>
                                                            <td>
                                                                <input type="text" name="unpaid_leave_days[{{$payroll_user->id}}]" class="form-control money unpaid-leave-days-{{$payroll_user->id}}"
                                                                       value="{{$payroll_user->days}}" readonly></td>
                                                            <td>
                                                                <input type="text" class="form-control money unpaid-leave-deduction-{{$payroll_user->id}}"
                                                                       onblur="unpaid_leave_deduction(`{{$payroll_user->id}}`)"
                                                                       name="unpaid_leave_deduction[{{$payroll_user->id}}]"
                                                                       value="{{$payroll_user->days*$payroll_user->basic_salary/30}}">
                                                                <span id="error-unpaid-leave-deduction-{{$payroll_user->id}}" class="form-text text-danger"></span>
                                                            </td>
                                                            <td><input type="text" class="form-control money deduction-percentage-{{$payroll_user->id}}"
                                                                       onblur="deduction_percentage(`{{$payroll_user->id}}`)"
                                                                       name="deduction_percentage[{{$payroll_user->id}}]">
                                                                <span id="error-deduction-percentage-{{$payroll_user->id}}" class="form-text text-danger"></span>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control money deduction-{{$payroll_user->id}}"
                                                                       name="deduction[{{$payroll_user->id}}]" readonly>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!--end: Form Wizard Step 10-->

                                            <!--begin: Form Actions -->
                                            <div class="kt-form__actions">
                                                <button
                                                    class="btn btn-secondary btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
                                                    data-ktwizard-type="action-prev">
                                                    Previous
                                                </button>
                                                <button id="submit"
                                                    class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
                                                    data-ktwizard-type="action-submit">
                                                    Submit
                                                </button>
                                                <button id="next"
                                                    class="btn btn-brand btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
                                                    data-ktwizard-type="action-next">
                                                    Next Step
                                                </button>
                                            </div>

                                            <!--end: Form Actions -->
                                        </form>

                                        <!--end: Form Wizard Form-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Form-->
                </div>
            </div>
            <!--end::Portlet-->
        </div>
    </div>
    <!-- end:: Content -->
@stop
@section('script')
    @include('layouts.include.script.script_jquery_form')
    {!! Html::script('assets/app/custom/wizard/wizard-v2.js') !!}
    <script>
        function total_salary(budget_line_id,user_id,payroll_report_user_id,type){
            let salary =$(`#basic_${type}_${budget_line_id}`).val();
            let error = $(`.error-${type}-value-${user_id}`);
            let sum = 0;
            let percentage= $(`#${type}_percentage_${budget_line_id}`).val();
            let value= $(`.value-${type}-${user_id}`);
            value.each(function(){
                if($(this).val()!=''){
                    sum += parseFloat($(this).val());
                }
            });
            if(sum > 100){
                value.addClass('is-invalid');
                error.html('test');
                return false
            }else{
                value.removeClass('is-invalid');
                error.html(null);
                $(`#${type}_${budget_line_id}`).val(percentage * salary / 100);
                $(`.allocated_${type}_${user_id}`).val(sum * salary / 100);
            $.ajax({
                    url: `{{route ('payroll.check_report_salary')}}`,
                    method: 'POST',
                    data: {
                        id: user_id,
                        salary: salary,
                        value: percentage,
                        sum: sum,
                        type: type,
                        payroll_report_user_id: payroll_report_user_id,
                        month: `{{$payroll_report->month}}`,
                        budget_line_id: budget_line_id
                    },
                    success: function () {
                        $(`#${type}_percentage_${budget_line_id}`).removeClass('is-invalid');
                        $(`#error-${type}-percentage-${budget_line_id}`).html(null);
                        // submit.attr('disabled', false);
                        // submit.removeClass('disabled');
                    },
                    error: function (data) {
                          $(`#${type}_percentage_${budget_line_id}`).addClass('is-invalid');
                        $(`#error-${type}-percentage-${budget_line_id}`).html(data.responseJSON.error);
                        // submit.attr('disabled', true);
                        // submit.addClass('disabled');
                        // toastr.error(data.responseJSON.error);
                    }
                });
            }

        }

        function unpaid_leave_deduction(user_id){
            let unpaid_leave_deduction	 =$(`.unpaid-leave-deduction-${user_id}`);
            let salary	 =$(`.deduction-basic-salary-${user_id}`).val();
            let deducted_salary	 =$(`.deducted-${user_id}`);
            let error = $(`#error-unpaid-leave-deduction-${user_id}`);
            let submit = $(`#submit`);
            let next = $(`#next`);
            let unpaid_leave_days= $(`.unpaid-leave-days-${user_id}`);
            if(Number(unpaid_leave_deduction.val()) > Number(salary) ){
                unpaid_leave_deduction.addClass('is-invalid');
                error.html('error salary');
                submit.attr('disabled', true);
                next.attr('disabled', true);
                return false;
            }
            unpaid_leave_deduction.removeClass('is-invalid');
            error.html(null);
            submit.attr('disabled', false);
            next.attr('disabled', false);
            unpaid_leave_days.val(unpaid_leave_deduction.val() * 30 / salary);
            let deduction= $(`.deduction-${user_id}`);
            deducted_salary.val(Number(unpaid_leave_deduction.val())+Number(deduction.val()));
        }
        function deduction_percentage(user_id){
            let deduction_percentage	 =$(`.deduction-percentage-${user_id}`);
            let salary	 =$(`.deduction-basic-salary-${user_id}`).val();
            let deducted	 =$(`.deducted-${user_id}`);
            let unpaid_leave_deduction	 =$(`.unpaid-leave-deduction-${user_id}`).val();
            let error = $(`#error-deduction-percentage-${user_id}`);
            let submit = $(`#submit`);
            let next = $(`#next`);
            let deduction= $(`.deduction-${user_id}`);
            if(Number(deduction_percentage.val()) >100 ){
                deduction_percentage.addClass('is-invalid');
                error.html('error Deduction');
                submit.attr('disabled', true);
                next.attr('disabled', true);
                return false;
            }
            deduction_percentage.removeClass('is-invalid');
            error.html(null);
            submit.attr('disabled', false);
            next.attr('disabled', false);
            deduction.val(deduction_percentage.val() * salary / 100);
            deducted.val(Number(unpaid_leave_deduction)+Number(deduction.val()));

        }
        // $(document).ready(function () {
        //
        //     $("#salary").val($("#salary_percentage").val() * $("#basic_salary").val() / 100);
        //
        //     $("#salary_percentage").keyup(function () {
        //         $("#salary").val($("#salary_percentage").val() * $("#basic_salary").val() / 100);
        //     });
        //
        //     $("#management_allowance").val($("#management_allowance_percentage").val() * $("#user_management_allowance").val() / 100);
        //
        //     $("#management_allowance_percentage").keyup(function () {
        //         $("#management_allowance").val($("#management_allowance_percentage").val() * $("#user_management_allowance").val() / 100);
        //     });
        //
        //     $("#transportation_allowance").val($("#transportation_allowance_percentage").val() * $("#user_transportation_allowance").val() / 100);
        //
        //     $("#transportation_allowance_percentage").keyup(function () {
        //         $("#transportation_allowance").val($("#transportation_allowance_percentage").val() * $("#user_transportation_allowance").val() / 100);
        //     });
        //
        //     $("#house_allowance").val($("#house_allowance_percentage").val() * $("#user_house_allowance").val() / 100);
        //
        //     $("#house_allowance_percentage").keyup(function () {
        //         $("#house_allowance").val($("#house_allowance_percentage").val() * $("#user_house_allowance").val() / 100);
        //     });
        //
        //     $("#cell_phone_allowance").val($("#cell_phone_allowance_percentage").val() * $("#user_cell_phone_allowance").val() / 100);
        //
        //     $("#cell_phone_allowance_percentage").keyup(function () {
        //         $("#cell_phone_allowance").val($("#cell_phone_allowance_percentage").val() * $("#user_cell_phone_allowance").val() / 100);
        //     });
        //
        //     $("#cost_of_living_allowance").val($("#cost_of_living_allowance_percentage").val() * $("#user_cost_of_living_allowance").val() / 100);
        //
        //     $("#cost_of_living_allowance_percentage").keyup(function () {
        //         $("#cost_of_living_allowance").val($("#cost_of_living_allowance_percentage").val() * $("#user_cost_of_living_allowance").val() / 100);
        //     });
        //
        //     $("#fuel_allowance").val($("#fuel_allowance_percentage").val() * $("#user_fuel_allowance").val() / 100);
        //
        //     $("#fuel_allowance_percentage").keyup(function () {
        //         $("#fuel_allowance").val($("#fuel_allowance_percentage").val() * $("#user_fuel_allowance").val() / 100);
        //     });
        //
        //     $("#appearance_allowance").val($("#appearance_allowance_percentage").val() * $("#user_appearance_allowance").val() / 100);
        //
        //     $("#appearance_allowance_percentage").keyup(function () {
        //         $("#appearance_allowance").val($("#appearance_allowance_percentage").val() * $("#user_appearance_allowance").val() / 100);
        //     });
        //
        //     $("#work_nature_allowance").val($("#work_nature_allowance_percentage").val() * $("#user_work_nature_allowance").val() / 100);
        //
        //     $("#work_nature_allowance_percentage").keyup(function () {
        //         $("#work_nature_allowance").val($("#work_nature_allowance_percentage").val() * $("#user_work_nature_allowance").val() / 100);
        //     });
        //
        //     $("#deduction").val($("#deduction_percentage").val() * $("#deduction_basic_salary").val() / 100);
        //
        //     $("#deduction_percentage").keyup(function () {
        //         $("#deduction").val($("#deduction_percentage").val() * $("#deduction_basic_salary").val() / 100);
        //
        //         $("#deducted_salary").val(parseInt($("#deduction_percentage").val() * $("#deduction_basic_salary").val() / 100) + parseInt($("#unpaid_leave_deduction").val()));
        //     });
        // });
    </script>

@stop
