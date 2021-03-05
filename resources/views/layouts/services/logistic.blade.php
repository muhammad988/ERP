@extends('layouts.app')
@section('style')
    @include('layouts.include.style.style_form')
@stop
@section('content')
    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h1 class="kt-portlet__head-title">
                        Service Request
                    </h1>
                </div>
            </div>
            <!--begin::Form-->
            <form method="POST" action="{{route('service.logistic_update')}} " class="kt-form kt-form--label-right" id="kt_form_2" novalidate="novalidate">
                @csrf
                @method('PUT')
                <input hidden name="id" value="{{$service->id}}">
                <div class="kt-portlet__body">
                    <div class="kt-section">
                        <h3 class="kt-section__title kt-margin-b-20">
                            Service Type
                        </h3>
                        <div class="kt-section__content">
                            <div class="form-group form-group-last">
                                <div class="row">
                                    @if ($service->service_type_id == 375446)
                                        <div class="col-lg-12">
                                            <label class="kt-option">
                                            <span class="kt-option__control">
                                            <span class="kt-radio kt-radio--state-brand">
                                            <input type="radio" name="service[service_type_id]" id="mr_service" value="375446" checked disabled>
                                            <span></span>
                                            </span>
                                            </span>
                                                <span class="kt-option__label">
                                            <span class="kt-option__head">
                                            <span class="kt-option__title">
                                            Material and Service Request
                                            </span>
                                            <span class="kt-option__focus">

                                            </span>
                                            </span>
                                            <span class="kt-option__body">
                                            Request for materials and service
                                            </span>
                                            </span>
                                            </label>
                                        </div>
                                    @else
                                        <div class="col-lg-12">
                                            <label class="kt-option">
                                            <span class="kt-option__control">
                                            <span class="kt-radio kt-radio--state-brand">
                                            <input type="radio" name="service[service_type_id]" id="pyr_service" value="375447" @if($service->service_type_id == 375447) checked @endif disabled>
                                            <span></span>
                                            </span>
                                            </span>
                                                <span class="kt-option__label">
                                            <span class="kt-option__head">
                                            <span class="kt-option__title">
                                            Payment Request
                                            </span>
                                            <span class="kt-option__focus">
                                            </span>
                                            </span>
                                            <span class="kt-option__body">
                                            Request for a payment regarding certain expenses
                                            </span>
                                            </span>
                                            </label>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-text text-muted"><!--must use this helper element to display error message for the options--></div>
                            </div>
                        </div>
                    </div>

                    <div class="kt-separator kt-separator--border-dashed kt-separator--space-xl"></div>

                    <div class="kt-section">
                        <h3 class="kt-section__title">
                            Service Request Information:
                        </h3>

                        <div class="kt-section__content">
                            <div class="form-group row">
                                <div class="col-lg-2 form-group-sub" id="service_method_dev">
                                    <label class="form-control-label">Service Method</label>
                                    <input type="text" name="service_method_id" id="service_method_id" class="form-control" placeholder="service method" value="{{$service->service_method->name_en}}" disabled>
                                </div>
                                <div class="col-lg-2 form-group-sub" id="payment_method_dev">
                                    <label class="form-control-label">Payment Method<span class="required"> *</span></label>
                                    <select class="form-control" name="service[payment_method_id]" id="payment_method_id" required>
                                        <option value="" selected>Please Select</option>
                                        @foreach ($payment_methods as $payment_method)
                                            <option value="{{$payment_method->id}}">{{$payment_method->name_en}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3 form-group-sub" id="service_receiver_dev">
                                    <label class="form-control-label">Service Receiver<span class="required"> *</span></label>
                                    <div id="recipient_dev">
                                        {{-- TODO: --}}
                                        <select class="form-control select2" name="service[recipient]" id="recipient_id" required>
                                            <option value="" selected>Please Select</option>
                                            @foreach ($service_receivers as $recipient)
                                                <option value="{{$recipient->id}}">{{$recipient->first_name_en .' '. $recipient->last_name_en}}</option>
                                            @endforeach
                                        </select>
                                        <span class="form-text text-muted"></span>
                                    </div>
                                    {{-- TODO: --}}
                                    <div class="form-group-sub" id="supplier_dev" style="display:none">
                                        <select class="form-control select2" name="service[supplier_id]" id="supplier_id">
                                            <option value="" selected>Please Select</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{$supplier->id}}">{{$supplier->name_en}}</option>
                                            @endforeach
                                        </select>
                                        <span class="form-text text-muted"></span>
                                    </div>
                                </div>
                                {{-- TODO: --}}
                                <div class="col-lg-2 form-group-sub" id="payment_type_dev">
                                    <label class="form-control-label">Payment Type<span class="required"> *</span></label>
                                    <select class="form-control" name="service[payment_type_id]" id="payment_type_id" required>
                                        <option value="" selected>Please Select</option>
                                        @foreach ($payment_types as $payment_type)
                                            <option value="{{$payment_type->id}}">{{$payment_type->name_en}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- TODO: --}}
                                <div class="col-lg-3 form-group-sub" id="bank_account_dev">
                                    <label class="form-control-label">Bank Account</label>
                                    <select class="form-control" name="bank_account" id="bank_account">
                                        <option value="" selected>Please Select</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6 form-group-sub">
                                    <label class="form-control-label">Office/ Project</label>
                                    <input type="text" id="service_model" class="form-control" placeholder="service model" value="{{$service->service_model->name_en}}" disabled>
                                </div>
                                @if ($service->project_id)
                                    <div class="col-lg-6 form-group-sub" id="project_name_dev">
                                        <label class="form-control-label">Project Name</label>
                                        <input type="text" id="project_name" class="form-control" placeholder="project name" value="{{$service->project->name_en}}" disabled>
                                    </div>
                                @endif

                            </div>
                            <br/>
                            <div class="form-group row exchange_rate">
                                <div class="col-lg-6 form-group-sub">
                                    <label class="form-control-label">Currency</label>
                                    <input type="text" id="currency" class="form-control" placeholder="currency" value="{{$service->currency->name_en}}" disabled>
                                </div>
                                <div class="col-lg-6 form-group-sub">
                                    <label class="form-control-label">Exchange Rate<span class="required"> *</span></label>
                                    <input type="text" name="user_exchange_rate" id="exchange_rate" class="form-control money" readonly placeholder="exchange rate" value="{{$service->user_exchange_rate}}"
                                           required {{$service->currency->id == 87034?'readonly':''}}>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-section" id="import_file" style="display:none">
                        <div class="kt-separator kt-separator--border-dashed kt-separator--space-xl"></div>
                        <h3 class="kt-section__title">
                            Service Files:
                        </h3>
                        <div class="kt-section__content">
                            <div class="row">
                                <div class="col-lg-2">
                                    <label class="form-control-label">Upload Receipts<span class="required"> *</span></label>
                                    <input id="receipt_file" name="receipt_file" type="file" class="form-control kt_inputmask_6" placeholder="receipt_file">
                                </div>
                                {{--                                    <div class="col-lg-2">--}}
                                {{--                                        <label class="form-control-label">Import Payment Order Items</label>--}}
                                {{--                                        <input id="items_file" name="items_file" type="file" class="form-control kt_inputmask_6" placeholder="items_file">--}}
                                {{--                                    </div>--}}
                            </div>
                        </div>
                    </div>
                    <div class="kt-separator kt-separator--border-dashed kt-separator--space-xl"></div>

                    <div class="kt-section">
                        <h3 class="kt-section__title">
                            Service Items
                            <i data-toggle="kt-tooltip" data-width="auto" class="kt-section__help" title="" data-original-title="If different than the corresponding address"></i>
                        </h3>
                        <div class="kt-section__content">
                            <div class="form-group form-group-last row first_repeater kt_repeater_service">
                                <div data-repeater-list="service_item" class="col-lg-12">
                                    @foreach ($service_items as $service_item)
                                        <div data-repeater-item="" class="form-group row">
                                            <input type="text" name="id" value="{{$service_item->id}}" hidden>
                                            @if($service_item->detailed_proposal_budget_id)
                                                <div class="col-md-2" id="budget_line_dev">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label class="kt-label m-label--single">Budget Line</label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <input type="text" name="detailed_proposal_budget" id="budget_line" class="form-control" placeholder="budget line"
                                                                   value="{{$service_item->detailed_proposal_budget? $service_item->detailed_proposal_budget->budget_line . ' - ' . $service_item->detailed_proposal_budget->category_option->name_en:''}}"
                                                                   disabled>
                                                        </div>
                                                    </div>
                                                    <div class="d-md-none kt-margin-b-10"></div>
                                                </div>
                                                <div class="col-md-1" id="availability_dev">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Usable</label>
                                                        </div>
                                                        <div class="kt-form__control form-group-sub">
                                                            <input id="availability" value="{{availability($service_item->detailed_proposal_budget_id,$service->id)}}" name="availability" type="text"
                                                                   class="form-control money {{$service_item->detailed_proposal_budget_id}}" placeholder="remaining" disabled>
                                                            <input name="availability_old" value="{{availability($service_item->detailed_proposal_budget_id,$service->id)}}" type="text"
                                                                   class="form-control availability availability_old_{{$service_item->detailed_proposal_budget_id}}" hidden disabled>

                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <input id="availability" value="100000000000000000" name="availability" type="text" class="form-control money" placeholder="remaining" hidden disabled>
                                                <input name="availability_old" value="100000000000000000" type="text" class="form-control availability " hidden disabled>
                                            @endif
                                            <div class="col-md-2">
                                                <div class="kt-form__group--inline">
                                                    <div class="kt-form__label">
                                                        <label>Item<span class="required"> *</span></label>
                                                    </div>
                                                    <div class="kt-form__control form-group-sub">
                                                        <select class="form-control select2" name="item_id" required>
                                                            <option value="">Please Select</option>
                                                            @foreach ($items as $item)
                                                                <option value="{{$item->id}}" @if ($item->id == $service_item->item_id) selected @endif>{{$item->name_en}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="form-text text-muted"></span>

                                                    </div>
                                                </div>
                                                <div class="d-md-none kt-margin-b-10"></div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="kt-form__group--inline">
                                                    <div class="kt-form__label">
                                                        <label class="kt-label m-label--single">Unit<span class="required"> *</span></label>
                                                    </div>
                                                    <div class="kt-form__control form-group-sub">
                                                        <select class="form-control select2" name="unit_id" required>
                                                            <option value="" selected>Please Select</option>
                                                            @foreach ($units as $unit)
                                                                <option value="{{$unit->id}}" @if ($unit->id == $service_item->unit_id) selected @endif>{{$unit->name_en}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="form-text text-muted"></span>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="kt-form__group--inline">
                                                    <div class="kt-form__label">
                                                        <label>Quantity<span class="required"> *</span></label>
                                                    </div>
                                                    <div class="kt-form__control form-group-sub">
                                                        <input required id="quantity" name="quantity" onblur="getTotal(this)" type="text" class="form-control kt_inputmask_6" placeholder="quantity" value="{{$service_item->quantity}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="kt-form__group--inline">
                                                    <div class="kt-form__label">
                                                        <label>Unit Cost<span class="required"> *</span></label>
                                                    </div>
                                                    <div class="kt-form__control form-group-sub">
                                                        <input id="unit_cost" name="unit_cost" onblur="getTotal(this)" type="text" class="form-control money" placeholder="unit cost" value="{{$service_item->unit_cost}}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="kt-form__group--inline">
                                                    <div class="kt-form__label">
                                                        <label>Total Cost</label>
                                                    </div>
                                                    <div class="kt-form__control form-group-sub">
                                                        <input name="total" type="text" placeholder="total cost" @if($service_item->detailed_proposal_budget_id) id="{{$service_item->detailed_proposal_budget_id}}"
                                                               class="form-control total total_{{$service_item->detailed_proposal_budget_id}}  total-1   money" value="{{$service_item->unit_cost*$service_item->quantity}}"
                                                               @else  class="form-control total total-1  money" value="{{$service_item->unit_cost*$service_item->quantity}}" @endif required readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="kt-form__group--inline">
                                                    <div class="kt-form__label">
                                                        <label>Note</label>
                                                    </div>
                                                    <div class="kt-form__control">
                                                        <textarea class="form-control" name="note" id="note" cols="30" rows="2">{{$service_item->note}}</textarea>
                                                        {{-- <input name="note" type="text" class="form-control" placeholder="note"> --}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1 align-self-center">
                                                <a href="javascript:;" data-repeater-delete="" class="btn btn-danger btn-sm btn-icon btn-circle">
                                                    <i class="la la-trash-o"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        {{-- TODO: --}}
                        <!-- Second Repeater-->
                            <div class="kt_repeater_clearance second_repeater" id="div_data" style="display: none">
                                <div data-repeater-list="service_item_direct" class="col-lg-12">
                                    @foreach ($service_items as $service_item)
                                        <div data-repeater-item="" class="form-group row">
                                            <input type="text" name="id" value="{{$service_item->id}}" hidden>
                                            <div class="row col-md-12">
                                                @if($service_item->detailed_proposal_budget_id)
                                                    <div class="col-md-5 form-group" id="budget_line_dev">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label class="kt-label m-label--single">Budget Line</label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <input type="text" name="service_items[detailed_proposal_budget]" id="budget_line" class="form-control" placeholder="budget line"
                                                                       value="{{$service_item->detailed_proposal_budget? $service_item->detailed_proposal_budget->budget_line . ' - ' . $service_item->detailed_proposal_budget->category_option->name_en:''}}"
                                                                       disabled>
                                                            </div>
                                                        </div>
                                                        <div class="d-md-none kt-margin-b-10"></div>
                                                    </div>
                                                    <div class="col-md-2 form-group" id="availability_dev">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Usable</label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <input id="availability" value="{{availability($service_item->detailed_proposal_budget_id,$service->id)}}" name="availability" type="text"
                                                                       class="form-control money {{$service_item->detailed_proposal_budget_id}}" placeholder="remaining" disabled>
                                                                <input name="availability_old" value="{{availability($service_item->detailed_proposal_budget_id,$service->id)}}" type="text"
                                                                       class="form-control availability availability_old_{{$service_item->detailed_proposal_budget_id}}" hidden disabled>

                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <input id="availability" value="100000000000000000" name="availability" type="text" class="form-control money" placeholder="remaining" hidden disabled>
                                                    <input name="availability_old" value="100000000000000000" type="text" class="form-control availability " hidden disabled>
                                                @endif
                                                <div class="col-md-2 form-group">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Invoice Number<span class="required"> *</span></label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <input id="invoice_number" name="invoice_number" type="text" class="form-control " placeholder="Invoice Number" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 form-group">
                                                    <div class="kt-form__label">
                                                        <label>Invoice Date<span class="required"> *</span></label>
                                                    </div>
                                                    <div class="input-group date ">
                                                        <input type="text" name="invoice_date" class="form-control" readonly="" id="kt_datepicker_3" required>
                                                        <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <i class="la la-calendar"></i>
                                                                </span>
                                                        </div>
                                                    </div>
                                                    <span class="form-text text-muted"></span>

                                                </div>
                                                <div class="col-md-1 align-self-end form-group">
                                                    <a href="javascript:;" data-repeater-delete="" class="btn btn-danger btn-sm btn-icon btn-circle">
                                                        <i class="la la-trash-o"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-12 kt-separator kt-separator--border-dashed kt-separator--space-sm"></div>
                                            <div class="row col-md-12">
                                                <div class="col-md-2 form-group">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Item<span class="required"> *</span></label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <select class="form-control select2" name="item_id" required>
                                                                <option value="">Please Select</option>
                                                                @foreach ($items as $item)
                                                                    @if ($item->id == $service_item->item_id)
                                                                        <option value="{{$item->id}}" selected>{{$item->name_en}}</option>
                                                                    @else
                                                                        <option value="{{$item->id}}">{{$item->name_en}}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            <span class="form-text text-muted"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 form-group">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label class="kt-label m-label--single">Unit<span class="required"> *</span></label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <select class="form-control select2" name="unit_id" required>
                                                                <option value="" selected>Please Select</option>
                                                                @foreach ($units as $unit)
                                                                    @if ($unit->id == $service_item->unit_id)
                                                                        <option value="{{$unit->id}}" selected>{{$unit->name_en}}</option>
                                                                    @else
                                                                        <option value="{{$unit->id}}">{{$unit->name_en}}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            <span class="form-text text-muted"></span>

                                                        </div>
                                                    </div>
                                                    <div class="d-md-none kt-margin-b-10"></div>
                                                </div>
                                                <div class="col-md-1 form-group">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Quantity<span class="required"> *</span></label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <input name="quantity" onblur="getTotal(this)" type="text" class="form-control money" placeholder="Quantity" value="{{$service_item->quantity}}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 form-group">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Unit Cost<span class="required"> *</span></label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <input name="unit_cost" onblur="getTotal(this)" type="text" class="form-control money" placeholder="Unit Cost" value="{{$service_item->unit_cost}}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 form-group">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label class="kt-label m-label--single">Currency<span class="required"> *</span></label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <select class="form-control" name="currency_id" id="currency_id" required>
                                                                <option value="" selected>Select</option>
                                                                @foreach ($currencies as $currency)
                                                                    <option value="{{$currency->id}}">{{$currency->name_en}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="d-md-none kt-margin-b-10"></div>
                                                </div>
                                                <div class="col-md-1 form-group">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Exchange rate<span class="required">*</span></label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <input name="exchange_rate" type="text" onblur="getTotal(this)" class="form-control money" placeholder="X-Rate" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 form-group">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Total Cost</label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <input name="total" type="text" @if($service_item->detailed_proposal_budget_id) id="{{$service_item->detailed_proposal_budget_id}}"
                                                                   class="form-control total total_{{$service_item->detailed_proposal_budget_id}}  money" value="{{$service_item->unit_cost*$service_item->quantity}}" @else  class="form-control total  money"
                                                                   value="{{$service_item->unit_cost*$service_item->quantity}}" @endif placeholder="Total Cost" required readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Note</label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <textarea class="form-control" name="note" id="note" cols="30" rows="2">{{$service_item->note}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
                                        </div>

                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-separator kt-separator--border-dashed kt-separator--space-xl"></div>

                    <div class="kt-section service_total">
                        <h3 class="kt-section__title">
                            Service Total:
                        </h3>
                        <div class="kt-section__content">
                            <div class="form-group row">
                                @if($service->currency->id != 87034)
                                    <div class="col-lg-6 form-group-sub">
                                        <label class="form-control-label">Total Currency {{$service->currency->name_en}}</label>
                                        <input type="text" name="service[total_currency]" id="total_currency" class="form-control service_total money" placeholder="total  currency"
                                               value="@foreach($total_currencies as $total_currency){{$total_currency->sum}} @endforeach" disabled>
                                    </div>
                                @endif
                                <div class="col-lg-6 form-group-sub">
                                    <label class="form-control-label">Total USD</label>
                                    <input type="text" name="service[total_usd]" id="total_usd" class="form-control service_total money" placeholder="total usd" value="@foreach($total_usd as $usd) {{$usd->sum}} @endforeach" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-12">
                                    <button type="submit" data-ktwizard-type="action-submit" class="btn btn-sm btn-label-success btn-bold"><i class="la la-save"></i> @lang('common.accept')</button>
                                    <a href="javascript:;" id="reject" class="btn btn-sm  btn-label-danger btn-bold"><i class="la la-ban"></i> @lang('common.reject')</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Portlet-->
    </div>
    <!-- end:: Content -->
    <form id="reject-form" action="{{route ('service.logistic_action')}}" method="POST" hidden>
        @csrf
        <input hidden name="action" value="reject">
        <input hidden name="id" value="{{$service->id}}">
    </form>
@stop
@section('script')
    @include('layouts.include.script.script_jquery_form')
    {!! Html::script('assets/js/demo2/pages/crud/forms/validation/form-controls-service-logistic.js') !!}
    <script>
        submit_form('reject', 'reject-form');
        $("#payment_method_id").change(function () {
            console.log('test');
            if ($("#payment_method_id").val() == 3296) {
                $("#recipient_dev").hide();
                $("#recipient_id").removeAttr('required').attr('disabled', true);
                $("#supplier_dev").show();
                $("#supplier_id").attr('required', true).removeAttr('disabled');
                $("#bank_account").removeAttr('disabled');
                $("#payment_type_id").val('');

                if ($("#pyr_service").is(':checked')) {
                    $(".second_repeater").show();
                    $("#import_file").show();
                    $(".first_repeater").hide();
                    $("#title_service_total").hide();
                    $("#title_service_total_usd").show();
                    $(".exchange_rate").hide();
                    $(".service_total").hide();
                    $("#exchange_rate").val('');
                    $("#exchange_rate").attr('disabled', true);
                } else {
                    $(".second_repeater").hide();
                    $("#import_file").hide();
                    $(".first_repeater").show();
                    $(".exchange_rate").show();
                    $(".service_total").show();
                }

                // Get Bank Accounts payment type is bank transfer
                bank_account();
            } else {
                $("#supplier_dev").hide();
                $("#supplier_id").removeAttr('required').attr('disabled', true);
                $("#recipient_dev").show();
                $("#recipient_id").attr('required', true).removeAttr('disabled');
                $("#bank_account").val('').attr('disabled', true);
                $("#payment_type_id").val('3304');
                $(".second_repeater").hide();
                $("#import_file").hide();
                $(".first_repeater").show();
                $(".exchange_rate").show();
                $("#exchange_rate").removeAttr('disabled');
                $(".service_total").show();
            }

        });

        $("#payment_type_id").change(function () {
            if ($("#payment_type_id").val() == 310675) {
                $("#bank_account").removeAttr('disabled');
                //$("#bank_account").atrr('disabled');
                // Get Bank Accounts if payment method is direct
                bank_account();
            } else {
                $("#bank_account").attr('disabled', true);
            }
        });

        $("#supplier_id").change(function () {
            // Get Bank Accounts if payment type is bank transfer
            bank_account();
        });

        function bank_account() {
            $("#bank_account").html('<option value="">Please Select</option>');

            // If payment method is direct and payment type is buank transfer
            if ($("#payment_type_id").val() == 310675 && $("#payment_method_id").val() == 3296 && $("#supplier_id").val()) {
                $("#bank_account").show();
                $.get('get_bank_account/' + $("#supplier_id").val(), function (data) {
                    if (data) {
                        for (let i = 0; i < data.length; index++) {
                            $("#bank_account").append('<option value="' + data[i].id + '">' + data[i].bank_name + ' - ' + data[i].iban + '</option>');

                        }
                    }
                });
            }
        }

        function getTotal(e) {
            let class_name = '';
            if ($("#payment_method_id").val() == 3296) {
                class_name = 'second_repeater';
            } else {
                class_name = 'first_repeater';
            }
            let name = e.getAttribute("name");
            let name_str = name.split("]");
            let category = name_str[0].split("[");
            let categoryName = category[0];
            let num = category[1];
            let cost = document.getElementsByName('' + categoryName + '[' + num + '][unit_cost]')[0].value;
            let quantity = document.getElementsByName('' + categoryName + '[' + num + '][quantity]')[0].value;
            let availability_old = document.getElementsByName('' + categoryName + '[' + num + '][availability_old]')[0].value;
            let availability = document.getElementsByName('' + categoryName + '[' + num + '][availability]')[0].value;
            let exchange_rate = document.getElementsByName('' + categoryName + '[' + num + '][exchange_rate]')[0];
            console.log(availability_old);
            let total;
            let sum = 0;
            if (quantity == '') {
                quantity = 0;
            }
            if (exchange_rate == undefined) {
                exchange_rate = 1;
            } else {
                exchange_rate = document.getElementsByName('' + categoryName + '[' + num + '][exchange_rate]')[0].value;
            }
            if (cost == '') {
                cost = '0';
            }
            total = ((Number(cost) * Number(quantity)));
            console.log(total);
            if (total > 0) {
                document.getElementsByName('' + categoryName + '[' + num + '][total]')[0].value = total;
                document.getElementsByName('' + categoryName + '[' + num + '][total]')[0].classList.remove("is-invalid");
                document.getElementsByName('' + categoryName + '[' + num + '][availability]')[0].classList.remove("is-invalid");
                $('.add').removeClass('disabled');
                let el = document.getElementsByName('' + categoryName + '[' + num + '][total]')[0];
                let ev = document.createEvent('Event');
                ev.initEvent('change', true, false);
                el.dispatchEvent(ev);
                $(".money-1").inputmask({
                    "alias": "decimal",
                    "digits": 2,
                    "autoGroup": true,
                    autoUnmask: true,
                    "allowMinus": true,
                    "rightAlign": false,
                    "groupSeparator": ",",
                    "radixPoint": ".",
                });
            }
            let id = document.getElementsByName('' + categoryName + '[' + num + '][total]')[0].id;
            console.log(class_name);
            $(`.${class_name}  .total_${id}`).each(function () {
                if ($(this).val() != '') {
                    console.log($(this).val());
                    sum += (Number($(this).val()) / Number(exchange_rate));
                }
            });
            if (Number(availability_old) - (Number(sum)) < 0) {
                sum = 0;
                swal.fire({
                    "title": "",
                    "text": "You do not have enough money in budget Line!",
                    "type": "error",
                    "confirmButtonClass": "btn btn-secondary"
                });
                document.getElementsByName('' + categoryName + '[' + num + '][total]')[0].value = null;
                $(`.${class_name} .total_${id}`).each(function () {
                    if ($(this).val() != '') {
                        sum += (Number($(this).val()) / Number(exchange_rate));
                    }
                });
                $(`.${id}`).val(Number(availability_old) - (Number(sum)));
                document.getElementsByName('' + categoryName + '[' + num + '][total]')[0].classList.add("is-invalid");
                document.getElementsByName('' + categoryName + '[' + num + '][availability]')[0].classList.add("is-invalid");
                $('.add').addClass('disabled');
                let el = document.getElementsByName('' + categoryName + '[' + num + '][total]')[0];
                let ev = document.createEvent('Event');
                ev.initEvent('change', true, false);
                el.dispatchEvent(ev);
            }
            $(`.${id}`).val(Number(availability_old) - (Number(sum)));

        }

        $(document).on('change', `.total`, function () {
            setTimeout(function () {
                let total = 0;
                $(`.total-1`).each(function () {
                    if ($(this).val() != '') {
                        total += Number($(this).val());
                    }
                });
                $(`.total-2`).each(function () {
                    if ($(this).val() != '') {
                        total += Number($(this).val());
                    }
                });
                $(`#total_currency`).val(total);
                $(`#total_usd`).val(Number(total) / Number($(`#exchange_rate`).val()));
                $("#money").inputmask({
                    "alias": "decimal",
                    "digits": 2,
                    "autoGroup": true,
                    autoUnmask: true,
                    "allowMinus": true,
                    "rightAlign": false,
                    "groupSeparator": ",",
                    "radixPoint": ".",
                });
            }, 500);
        });
    </script>
@stop
