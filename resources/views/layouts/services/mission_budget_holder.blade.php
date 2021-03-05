@extends('layouts.app')
@section('style')
    @include('layouts.include.style.style_form')
@stop
@section('content')
    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="col-lg-12">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h1 class="kt-portlet__head-title">
                            Service Request
                        </h1>
                    </div>
                </div>
                <!--begin::Form-->
                <form  action="{{route('service.mission_holder_update')}} " method="POST"  class="kt-form kt-form--label-right" id="kt_form_2" novalidate="novalidate">
                    @csrf
                    @method('PUT')
                    <input hidden name="id" value="{{$services->id}}">

                    <div class="kt-portlet__body">
                        <div class="kt-section">
                            <h3 class="kt-section__title kt-margin-b-20">
                                Service Type
                            </h3>
                            <div class="kt-section__content">
                                <div class="form-group form-group-last">
                                    <div class="row">
                                        @if ($services->service_type_id == 375446)
                                            <div class="col-lg-12">
                                                <label class="kt-option">
                                            <span class="kt-option__control">
                                            <span class="kt-radio kt-radio--state-brand">
                                            <input type="radio" name="service[service_type_id]" id="mr_service" ivalue="375446" checked disabled>
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
                                            Request for materials and services
                                            </span>
                                            </span>
                                                </label>
                                            </div>
                                        @else
                                            <div class="col-lg-12">
                                                <label class="kt-option">
                                            <span class="kt-option__control">
                                            <span class="kt-radio kt-radio--state-brand">
                                            <input type="radio" name="service[service_type_id]" id="pyr_service" value="375447" @if($services->service_type_id == 375447) checked @endif disabled>
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

                        <div class="kt-separator kt-separator--border-dashed kt-separator--space-xs"></div>

                        <div class="kt-section">
                            <h3 class="kt-section__title">
                                Service Request Information:
                            </h3>

                            <div class="kt-section__content">
                                <div class="form-group row">
                                    <div class="col-lg-3 form-group-sub" id="service_method_id_dev">
                                        <label class="form-control-label">Service Method</label>
                                        <input type="text" name="service_method_id" id="service_method" class="form-control" placeholder="service method" value="{{$services->service_method->name_en}}" disabled>
                                    </div>
                                    <div class="col-lg-2 form-group-sub" id="payment_method_dev">
                                        <label class="form-control-label">Payment Method</label>
                                        <input type="text" name="payment_method_id" id="payment_method" class="form-control" placeholder="payment method" value="{{$services->payment_method->name_en}}" disabled>
                                    </div>
                                    <div class="col-lg-2 form-group-sub" id="service_receiver_dev">
                                        <label class="form-control-label">Service Receiver</label>
                                        @if ($services->recipient)
                                            <input type="text" name="service_receiver" id="service_receiver" class="form-control" placeholder="service_receiver" value="{{$services->service_recipient->first_name_en .' '. $services->service_recipient->last_name_en}}" disabled>
                                        @endif
                                        @if ($services->implementing_partner_id)
                                            <input type="text" name="service_receiver" id="service_receiver" class="form-control" placeholder="service_receiver" value="{{$services->implementing_partner->name_en}}" disabled>
                                        @endif
                                        @if ($services->supplier_id)
                                            <input type="text" name="service_receiver" id="service_receiver" class="form-control" placeholder="service_receiver" value="{{$services->supplier->name_en}}" disabled>
                                        @endif
                                        @if ($services->service_provider_id)
                                            <input type="text" name="service_receiver" id="service_receiver" class="form-control" placeholder="service_receiver" value="{{$services->service_provider->name_en}}" disabled>
                                        @endif
                                    </div>
                                    {{-- TODO: --}}
                                    <div class="col-lg-2 form-group-sub" id="payment_type_dev">
                                        <label class="form-control-label">Payment Type<span class="required"> *</span></label>
                                        <input type="text" name="payment_type_id" id="payment_type_id" class="form-control" placeholder="payment type" value="{{$services->payment_type->name_en}}" disabled>
                                    </div>
                                    {{-- TODO: --}}
                                    <div class="col-lg-3 form-group-sub" id="bank_account_dev">
                                        @if ($services->implementing_partner_account_id)
                                            <label class="form-control-label">Bank Account</label>
                                            <input type="text" name="bank_account" id="bank_account" class="form-control" placeholder="bank_account" value="{{$services->implementing_partner_account->bank_name .' - '. $services->implementing_partner_account->iban}}" disabled>
                                        @endif
                                        @if ($services->supplier_account_id)
                                            <label class="form-control-label">Bank Account</label>
                                            <input type="text" name="bank_account" id="bank_account" class="form-control" placeholder="bank_account" value="{{$services->supplier_account->bank_name .' - '. $services->supplier_account->iban}}" disabled>
                                        @endif
                                        @if ($services->service_provider_account_id)
                                            <label class="form-control-label">Bank Account</label>
                                            <input type="text" name="bank_account" id="bank_account" class="form-control" placeholder="bank_account" value="{{$services->service_provider_account->bank_name .' - '. $services->service_provider_account->iban}}" disabled>
                                        @endif

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-4 form-group-sub">
                                        <label class="form-control-label">Office/ Project</label>
                                        <input type="text" name="service_model_id" id="service_model" class="form-control" placeholder="service model" value="{{$services->service_model->name_en}}" disabled>
                                    </div>
                                    <div class="col-lg-4 form-group-sub">
                                        <label class="form-control-label">Office Budget<span class="required"> *</span></label>
                                        <select class="form-control select2" name="service[mission_budget_id]" id="mission_budget" required>
                                            <option value="" selected>Please Select</option>
                                            @foreach ($mission_budgets as $mission_budget)
                                                <option value="{{$mission_budget->id}}">{{$mission_budget->mission .' - '. $mission_budget->mission_budget}}</option>
                                            @endforeach
                                        </select>
                                        <span class="form-text text-muted"></span>

                                    </div>
                                    <div class="col-lg-4 form-group-sub">
                                        <label class="form-control-label">Office Budget Line<span class="required"> *</span></label>
                                        <select class="form-control select2 mission_budget_line_id" name="service[mission_budget_line_id]" required>
                                            <option value="" selected>Please Select</option>
                                        </select>
                                        <span class="form-text text-muted"></span>

                                    </div>

                                </div>
                                {{-- TODO: --}}
                                @if ($services->service_type_id != 375447 or $services->payment_method_id != 3296)
                                    <div class="form-group row">
                                        <div class="col-lg-6 form-group-sub">
                                            <label class="form-control-label">Currency</label>
                                            <input type="text" name="currency_id" id="currency" class="form-control" placeholder="currency" value="{{$services->currency->name_en}}" disabled>
                                        </div>
                                        <div class="col-lg-6 form-group-sub">
                                            <label class="form-control-label">Exchange Rate<span class="required"> *</span></label>
                                            <input type="text" name="user_exchange_rate" id="exchange_rate" class="form-control money" readonly placeholder="exchange rate" value="{{$services->user_exchange_rate}}" required>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="kt-separator kt-separator--border-dashed kt-separator--space-xs"></div>

                        <div class="kt-section">
                            <h3 class="kt-section__title">
                                Service Items
                                <i data-toggle="kt-tooltip" data-width="auto" class="kt-section__help" title="" data-original-title="If different than the corresponding address"></i>
                            </h3>
                            <div class="kt-section__content">
                                <select hidden disabled class="project_id_hidden">
                                    <option value="">Please Select</option>
                                </select>
                                <div class="form-group row kt_repeater_service_holder">
                                    <div data-repeater-list="service_item" class="col-lg-12">
                                        @foreach ($service_items as $service_item)
                                            <div data-repeater-item="" class="form-group row">
                                                <input type="text" name="service_items[id]" value="{{$service_item->id}}" hidden>
                                                <div class="col-md-{{$services->service_type_id==375447&&$services->payment_method_id == 3296?'3':'4'}}">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label class="kt-label m-label--single">Project Name<span class="required"> *</span></label>
                                                        </div>
                                                        <div class="kt-form__control form-group-sub">
                                                            <select class="form-control select2-multiple project_id" name="project_id" required>
                                                                <option value="" selected>Please Select</option>
                                                            </select>
                                                            <span class="form-text text-muted"></span>

                                                        </div>
                                                    </div>
                                                    <div class="d-md-none kt-margin-b-10"></div>
                                                </div>
                                                <div class="col-md-{{$services->service_type_id==375447&&$services->payment_method_id == 3296?'3':'4'}}" id="budget_line_dev">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label class="kt-label m-label--single">Budget Line<span class="required"> *</span></label>
                                                        </div>
                                                        <div class="kt-form__control  form-group-sub">
                                                            <select class="form-control  select2-multiple detailed_proposal_budget_id" name="detailed_proposal_budget_id" required>
                                                                <option value="" selected>Please Select</option>
                                                            </select>
                                                            <span class="form-text text-muted"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input name="budget_id" type="text" class="form-control" hidden disabled>

                                                <div class="col-md-{{$services->service_type_id==375447&&$services->payment_method_id == 3296?'1':'2'}}" id="availability_dev">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Remaining</label>
                                                        </div>
                                                        <div class="kt-form__control  form-group-sub">
                                                            <input id="availability" name="availability" type="text" class="form-control money-2 availability" placeholder="remaining" disabled>
                                                            <input name="availability_old" type="text" class="form-control availability" hidden disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- TODO: --}}
                                                @if ($services->service_type_id == 375447 and $services->payment_method_id == 3296)
                                                    <div class="col-md-2">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Invoice Number<span class="required"> *</span></label>
                                                            </div>
                                                            <div class="kt-form__control  form-group-sub">
                                                                <input id="invoice_number" name="invoice_number" type="text" class="form-control kt_inputmask_6" placeholder="Invoice Number" value="{{$service_item->invoice_number}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- TODO: --}}
                                                    <div class="col-md-2">
                                                        <div class="kt-form__label">
                                                            <label>Invoice Date<span class="required"> *</span></label>
                                                        </div>
                                                        <div class="input-group date  form-group-sub">
                                                            <input type="text" name="invoice_date" class="form-control" readonly="" id="kt_datepicker_3" value="{{$service_item->invoice_date}}">
                                                            <div class="input-group-append">
                                                            <span class="input-group-text">
                                                                <i class="la la-calendar"></i>
                                                            </span>
                                                            </div>
                                                        </div>
                                                        <span class="form-text text-muted"></span>

                                                    </div>
                                                @endif
                                                <div class="d-flex col-md-1 align-self-end flex-row-reverse">
                                                    <a href="javascript:;" data-repeater-delete="" class="btn-sm btn btn-danger btn-icon btn-circle">
                                                        <i class="la la-trash-o"></i>
                                                    </a>
                                                </div>
                                                <div class="col-md-12 kt-separator kt-separator--border-dashed kt-separator--space-sm"></div>
                                                <div class="col-md-2">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Item</label>
                                                        </div>
                                                        <div class="kt-form__control form-group-sub">
                                                            <select class="form-control select2-multiple" name="item_id" required>
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
                                                    <div class="d-md-none kt-margin-b-10"></div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label class="kt-label m-label--single">Unit</label>
                                                        </div>
                                                        <div class="kt-form__control form-group-sub">
                                                            <select class="form-control select2-multiple " name="unit_id" required>
                                                                <option value="">Please Select</option>
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
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Quantity</label>
                                                        </div>
                                                        <div class="kt-form__control form-group-sub">
                                                            <input id="quantity" required name="quantity" type="text" onblur="getTotal(this)" class="form-control kt_inputmask_6" placeholder="quantity" value="{{$service_item->quantity}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Unit Cost</label>
                                                        </div>
                                                        <div class="kt-form__control form-group-sub">
                                                            <input id="unit_cost" required  name="unit_cost" type="text" class="form-control money" onblur="getTotal(this)" placeholder="unit cost" value="{{$service_item->unit_cost}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- TODO: --}}
                                                @if ($services->service_type_id == 375447 and $services->payment_method_id == 3296)
                                                    <div class="col-md-1">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label class="kt-label m-label--single">Currency<span class="required"> *</span></label>
                                                            </div>
                                                            <div class="kt-form__control form-group-sub">
                                                                <select class="form-control " onchange="getTotal(this)" name="currency_id" required>
                                                                    <option value="">Please Select</option>
                                                                    @foreach ($currencies as $currency)
                                                                        @if ($currency->id == $service_item->currency_id)
                                                                            <option value="{{$currency->id}}" selected>{{$currency->name_en}}</option>
                                                                        @else
                                                                            <option value="{{$currency->id}}">{{$currency->name_en}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                                <span class="form-text text-muted"></span>

                                                            </div>
                                                        </div>
                                                        <div class="d-md-none kt-margin-b-10"></div>
                                                    </div>
                                                    {{-- TODO: --}}
                                                    <div class="col-md-1">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Exchange rate<span class="required">*</span></label>
                                                            </div>
                                                            <div class="kt-form__control form-group-sub">
                                                                <input required  onblur="getTotal(this)" name="exchange_rate" type="text" class="form-control exchange_rate_val money" placeholder="X-Rate" value="{{$service_item->exchange_rate}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="col-md-1">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Total Cost</label>
                                                        </div>
                                                        <div class="kt-form__control form-group-sub">
                                                            <input  name="total" type="text" class="form-control money money-1   @if ($services->service_type_id == 375447 and $services->payment_method_id == 3296)  total-2 @else total-1 @endif total" placeholder="total cost" value="{{$service_item->unit_cost*$service_item->quantity}}" required readonly>

                                                            {{--                                                                <input  name="total" type="text" class="form-control money total_cost" placeholder="total cost"  readonly>--}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-{{$services->service_type_id==375447&&$services->payment_method_id == 3296?'3':'4'}}">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Note</label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <textarea class="form-control" name="note" id="note" cols="10" rows="2">{{$service_item->note}}</textarea>
                                                            {{-- <input name="note" type="text" class="form-control" placeholder="note"> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 kt-separator kt-separator--border-dashed kt-separator--space-xs"></div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="form-group form-group-last">
                                        <div class="col-lg-12">
                                            <a href="javascript:;" data-repeater-create="" class="btn btn-bold btn-sm btn-label-brand">
                                                <i class="la la-plus"></i> Add
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-xs"></div>
                            <h3 class="kt-section__title">
                                Service Total:
                            </h3>
                            <div class="kt-section__content">
                                <div class="form-group row">
                                    {{-- TODO: --}}
                                    @if($services->currency_id != 87034 and $services->currency_id != "")
                                        <div class="col-lg-6 form-group-sub">
                                            <label class="form-control-label">Total Currency {{$services->currency->name_en}}</label>
                                            <input type="text" name="total_currency" id="total_currency" class="form-control money" placeholder="total currency" value="{{$services->total_currency}}" disabled>
                                        </div>
                                    @endif
                                    <div class="col-lg-6 form-group-sub">
                                        <label class="form-control-label">Total USD</label>
                                        <input type="text" name="total_usd" id="total_usd" class="form-control money" placeholder="total USD" value="{{$services->total_usd}}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="submit" id="submit" data-ktwizard-type="action-submit" class="btn  btn-sm  btn-label-primary btn-bold"><i class="la la-check"></i> @lang('common.accept')</button>
                                    <a href="javascript:;" id="reject" class="btn btn-sm  btn-label-danger btn-bold"><i class="la la-ban"></i> @lang('common.reject')</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!--end::Form-->
            </div>
            <!--end::Portlet-->
        </div>
    </div>
    <form id="reject-form" action="{{route ('service.logistic_action')}}" method="POST" hidden>
        @csrf
        <input hidden name="action" value="reject">
        <input hidden name="id" value="{{$services->id}}">
    </form>
    <!-- end:: Content -->
@stop
@section('script')
    @include('layouts.include.script.script_jquery_form')
    {!! Html::script('assets/js/demo2/pages/crud/forms/validation/form-controls-service-logistic.js') !!}

    <script>
        submit_form('reject', 'reject-form');

        $(document).ready(function () {
            // Bringing budget lines & projects based on the selected mission budget
            $("#mission_budget").change(function () {
                // Reset value in mission budget line, project name and budget line once the mission budget is changed
                $('.mission_budget_line_id').html('<option value="" selected>Please Select</option>');
                $('.project_id').html('<option value="" selected>Please Select</option>');
                $('.detailed_proposal_budget_id').html('<option value="" selected>Please Select</option>');

                // Get mission budget lines based on the selected mission budget
                $.get('/service/getmissionbudgetline/' + $("#mission_budget").val(), function (data) {
                    if (data) {
                        for (let i = 0; i < data.length; i++) {
                            $(".mission_budget_line_id").append('<option value="' + data[i].id + '">' + data[i].budget_line + ' - ' + data[i].name_en + '</option>')
                        }
                    }
                });

                // Get projects based on the selected mission budget (projects in specific mission)
                $.get('/service/getproject/' + $("#mission_budget").val(), function (data) {
                    if (data) {
                        for (let i = 0; i < data.length; i++) {
                            $(".project_id").append('<option value="' + data[i].id + '">' + data[i].name_en + '</option>');
                            $(".project_id_hidden").append('<option value="' + data[i].id + '">' + data[i].name_en + '</option>');
                        }
                    }
                });
            });
            // Get budget lines based on selected project
            $(document).on('change', `.project_id`, function () {
                let name = $(this)["0"].name;
                let name_str = name.split("]");
                let category = name_str[0].split("[");
                let categoryName = category[0];
                let num = category[1];
                console.log(num);
                let x = document.getElementsByName('' + categoryName + '[' + num + '][detailed_proposal_budget_id]')[0];

                // $('.detailed_proposal_budget_id').html('<option value="" selected>Please Select</option>');
                $.get('/service/getprojectbudgetline/' + $(".project_id").val(), function (data) {
                    if (data) {
                        console.log(x);
                        for (let i = 0; i < data.length; i++) {
                            let option = document.createElement("option");
                            option.text = data[i].budget_line + ' - ' + data[i].name_en;
                            option.value = data[i].id;
                            x.add(option);
                        }
                    }
                });
            });
            $(document).on('change', `.detailed_proposal_budget_id`, function () {
                let name = $(this)["0"].name;
                let name_str = name.split("]");
                let category = name_str[0].split("[");
                let categoryName = category[0];
                let num = category[1];
                let sum = 0;
                let sum_2 = 0;
                let total = 0;
                let id = $(this).val();

                let old_id = document.getElementsByName('' + categoryName + '[' + num + '][budget_id]')[0].value;
                let exchange_rate = document.getElementsByName('' + categoryName + '[' + num + '][exchange_rate]')[0];

                let availability_old = $(`.availability_old_${old_id}`).val();
                if (old_id != '') {
                    document.getElementsByName('' + categoryName + '[' + num + '][availability]')[0].classList.remove(old_id);
                    document.getElementsByName('' + categoryName + '[' + num + '][total]')[0].classList.remove("total_" + old_id);
                    document.getElementsByName('' + categoryName + '[' + num + '][availability_old]')[0].classList.remove("availability_old_" + old_id);
                    document.getElementsByName('' + categoryName + '[' + num + '][unit_cost]')[0].value = null;
                    document.getElementsByName('' + categoryName + '[' + num + '][quantity]')[0].value = null;
                    document.getElementsByName('' + categoryName + '[' + num + '][total]')[0].value = null;
                    document.getElementsByName('' + categoryName + '[' + num + '][budget_id]')[0].value = $(this).val();

                    if (exchange_rate != undefined) {
                        document.getElementsByName('' + categoryName + '[' + num + '][exchange_rate]')[0].classList.remove("exchange_rate_val_" + old_id);

                    }
                    $(`.total_${old_id}`).each(function (i) {
                        if ($(this).val() != '') {
                            if ($(`.exchange_rate_val_${old_id}:eq(${i})`).val() == undefined) {
                                sum_2 += Number($(this).val());
                            } else {
                                sum_2 += Number($(this).val()) / Number($(`.exchange_rate_val_${old_id}:eq(${i})`).val());
                            }
                        }
                    });
                    $(`.${old_id}`).val(Number(availability_old) - (Number(sum_2)));
                }
                if (exchange_rate != undefined) {
                    document.getElementsByName('' + categoryName + '[' + num + '][exchange_rate]')[0].classList.add("exchange_rate_val_" + $(this).val());
                }
                document.getElementsByName('' + categoryName + '[' + num + '][total]')[0].classList.add("total_" + $(this).val());
                document.getElementsByName('' + categoryName + '[' + num + '][total]')[0].setAttribute('id', $(this).val());
                document.getElementsByName('' + categoryName + '[' + num + '][availability]')[0].classList.add($(this).val());
                document.getElementsByName('' + categoryName + '[' + num + '][availability_old]')[0].classList.add(`availability_old_${$(this).val()}`);
                document.getElementsByName('' + categoryName + '[' + num + '][budget_id]')[0].value = $(this).val();
                $.get('/project/get-availability-budget-line/' + $(this).val(), function (data) {
                    $(`.total_${id}`).each(function (i) {
                        if ($(this).val() != '') {
                            console.log($(`.exchange_rate_val_${id}:eq(${i})`).val());
                            if ($(`.exchange_rate_val_${id}:eq(${i})`).val() == undefined) {
                                sum += Number($(this).val());
                            } else {
                                sum += Number($(this).val()) / Number($(`.exchange_rate_val_${id}:eq(${i})`).val());
                            }
                        }
                    });
                    let exchange_rate = document.getElementsByName('' + categoryName + '[' + num + '][exchange_rate]')[0];

                    if (exchange_rate == undefined) {
                        exchange_rate = $('#exchange_rate').val();
                        total = (Number(data) * Number(exchange_rate)) - Number(sum);
                        document.getElementsByName('' + categoryName + '[' + num + '][availability]')[0].value = Number(total);
                        document.getElementsByName('' + categoryName + '[' + num + '][availability_old]')[0].value = Number(data) * Number(exchange_rate);
                    } else {
                        total = Number(data) - Number(sum);
                        document.getElementsByName('' + categoryName + '[' + num + '][availability]')[0].value = Number(total);
                        document.getElementsByName('' + categoryName + '[' + num + '][availability_old]')[0].value = Number(data);
                    }

                    //
                    $(".money-2").inputmask({
                        "alias": "decimal",
                        "digits": 2,
                        "autoGroup": true,
                        autoUnmask: true,
                        "allowMinus": true,
                        "rightAlign": false,
                        "groupSeparator": ",",
                        "radixPoint": ".",
                    });
                });
            });
            $('.select2-multiple').select2();
            $(document).on('change', `.total`, function () {
                setTimeout(function () {
                    let total = 0;
                    $(`.total-1`).each(function (i) {
                        if ($(this).val() != '') {
                            total += Number($(this).val());
                        }
                    });
                    $(`.total-2`).each(function (i) {
                        if ($(this).val() != '') {
                            if ($('.exchange_rate_val:eq(' + i + ')').val() == '') {
                                total += Number($(this).val());
                            } else {
                                total += Number($(this).val()) / Number($('.exchange_rate_val:eq(' + i + ')').val());
                            }
                        }
                    });
                    $(`#service_total`).val(total);
                    $("#service_total").inputmask({
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
        });
        function getTotal(e) {
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
            if (exchange_rate == '') {
                exchange_rate = 1;
            }
            if (cost == '' || quantity ==0) {
                return false;
            }
            if (cost == '') {
                cost = '0';
            }

            total = ((Number(cost) * Number(quantity)));
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
            }else if(total <= 0){
                document.getElementsByName('' + categoryName + '[' + num + '][total]')[0].value = null;
                document.getElementsByName('' + categoryName + '[' + num + '][total]')[0].classList.add("is-invalid");
            }
            let id = document.getElementsByName('' + categoryName + '[' + num + '][total]')[0].id;
            $(`.total_${id}`).each(function (i) {
                if ($(this).val() != '') {
                    if (exchange_rate == 1) {
                        sum += Number($(this).val());
                    } else {
                        sum += Number($(this).val()) / Number($(`.exchange_rate_val_${id}:eq(${i})`).val());
                    }
                }
            });
            $(`.${id}`).val(Number(availability_old) - (Number(sum)));
            if (Number(availability_old) - (Number(sum)) < 0) {
                sum = 0;
                swal.fire({
                    "title": "",
                    "text": "You do not have enough money in budget Line!",
                    "type": "error",
                    "confirmButtonClass": "btn btn-secondary"
                });
                document.getElementsByName('' + categoryName + '[' + num + '][total]')[0].value = null;
                $(`.total_${id}`).each(function (i) {
                    if ($(this).val() != '') {
                        if (exchange_rate == 1) {
                            sum += Number($(this).val());
                        } else {
                            sum += Number($(this).val()) / Number($(`.exchange_rate_val_${id}:eq(${i})`).val());
                        }
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
        }
        $(document).on('change', `.total`, function () {
            setTimeout(function () {
                let total = 0;
                $(`.total-1`).each(function (i) {
                    if ($(this).val() != '') {
                        total += Number($(this).val());
                    }
                });
                $(`.total-2`).each(function (i) {
                    if ($(this).val() != '') {
                        if($('.exchange_rate_val:eq(' + i + ')').val()==''){
                            total += Number($(this).val());
                        }else{
                            total += Number($(this).val())/Number($('.exchange_rate_val:eq(' + i + ')').val());
                        }
                    }
                });
                console.log(total);
                $(`#total_currency`).val(total);
                if($(`#exchange_rate`).val()){
                    $(`#total_usd`).val(Number(total)/Number($(`#exchange_rate`).val()));
                }else{
                    $(`#total_usd`).val(total);
                }
                $(".money").inputmask({
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
@endsection
