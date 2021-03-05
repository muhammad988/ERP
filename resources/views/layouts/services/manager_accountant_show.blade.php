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
                <form class="kt-form kt-form--label-right" id="kt_form_2" novalidate="novalidate">
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
                                            <input type="radio" name="service_type" id="mr_service" ivalue="375446" checked disabled>
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
                                            <input type="radio" name="service_type" id="pyr_service" value="375447" @if($services->service_type_id == 375447) checked @endif disabled>
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
                                    <div class="col-lg-3 form-group-sub" id="service_method_dev">
                                        <label class="form-control-label">Service Method</label>
                                        <input type="text" name="service_method" id="service_method" class="form-control" placeholder="service_method" value="{{$services->service_method->name_en}}" disabled>
                                    </div>
                                    <div class="col-lg-2 form-group-sub" id="payment_method_dev">
                                        <label class="form-control-label">Payment Method</label>
                                        <input type="text" name="payment_method" id="payment_method" class="form-control" placeholder="payment_method" value="{{$services->payment_method->name_en}}" disabled>
                                    </div>
                                    <div class="col-lg-2 form-group-sub" id="service_receiver_dev">
                                        <label class="form-control-label">Service Receiver</label>
                                        @if ($services->recipient )
                                            <input type="text" name="service_receiver" id="service_receiver" class="form-control" placeholder="service_receiver" value="{{$services->service_recipient->first_name_en .' '. $services->service_recipient->last_name_en}}" disabled>
                                        @endif

                                        @if ($services->implementing_partner_id)
                                            <input type="text" name="service_receiver" id="service_receiver" class="form-control" placeholder="service_receiver" value="{{$services->implementing_partner->name_en}}" disabled>
                                        @endif
                                        @if ($services->supplier_id)
                                            <input type="text" name="service_receiver" id="service_receiver" class="form-control" placeholder="service_receiver" value="{{$services->supplier->name_en}}" disabled>
                                        @endif
                                        {{-- TODO: --}}
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
                                        @else
                                            @if ($services->supplier_account_id)
                                                <label class="form-control-label">Bank Account</label>
                                                <input type="text" name="bank_account" id="bank_account" class="form-control" placeholder="bank_account" value="{{$services->supplier_account->bank_name .' - '. $services->supplier_account->iban}}" disabled>
                                            @else
                                                @if ($services->service_provider_account_id)
                                                    <label class="form-control-label">Bank Account</label>
                                                    <input type="text" name="bank_account" id="bank_account" class="form-control" placeholder="bank_account" value="{{$services->service_provider_account->bank_name .' - '. $services->service_provider_account->iban}}" disabled>
                                                @endif
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6 form-group-sub">
                                        <label class="form-control-label">Office/ Project</label>
                                        <input type="text" name="service_model" id="service_model" class="form-control" placeholder="service_model" value="{{$services->service_model->name_en}}" disabled>
                                    </div>
                                    {{--                                 @if ($services->project_id)--}}
                                    <div class="col-lg-6 form-group-sub" id="project_name_dev">
                                        <label class="form-control-label">Project Name</label>
                                        <input type="text" name="project_name" id="project_name" class="form-control" placeholder="project_name" value="{{$service_items[0]->detailed_proposal_budget? $service_items[0]->project->name_en:''}}" disabled>
                                    </div>
                                    {{--                                 @endif--}}
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6 form-group-sub">
                                        <label class="form-control-label">Office Budget</label>
                                        <input type="text" name="mission_budget_id" id="mission_budget_id" class="form-control" placeholder="mission budget" value="{{$services->mission_budget->name_en}}" disabled>
                                    </div>
                                    <div class="col-lg-6 form-group-sub">
                                        <label class="form-control-label">Office Budget Line</label>
                                        <input type="text" name="mission_budget_line_id" id="mission_budget_line_id" class="form-control" placeholder="mission budget line" value="{{$services->mission_budget_line->budget_line .' - '. $services->mission_budget_line->category_option->name_en}}" disabled>
                                    </div>
                                </div>
                                {{-- TODO: --}}
                                @if ($services->service_type_id != 375447 or $services->payment_method_id != 3296)
                                    <div class="form-group row">
                                        <div class="col-lg-6 form-group-sub">
                                            <label class="form-control-label">Currency</label>
                                            <input type="text" name="currency" id="currency" class="form-control" placeholder="currency" value="{{$services->currency->name_en}}" disabled>
                                        </div>
                                        <div class="col-lg-6 form-group-sub">
                                            <label class="form-control-label">Exchange Rate<span class="required"> *</span></label>
                                            <input type="text" name="accountant_exchange_rate" readonly id="exchange_rate" class="form-control money" placeholder="exchange rate" value="{{$services->user_exchange_rate}}" required {{$services->currency->id == 87034?'readonly':''}}>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="kt-separator kt-separator--border-dashed kt-separator--space-xl"></div>

                        <div class="kt-section">
                            <h3 class="kt-section__title">
                                Service Items
                                <i data-toggle="kt-tooltip" data-width="auto" class="kt-section__help" title="" data-original-title="If different than the corresponding address"></i>
                            </h3>
                            <div class="kt-section__content">
                                <div id="kt_repeater_1">
                                    <div class="form-group form-group-last row" id="kt_repeater_3">
                                        <div data-repeater-list="service_item" class="col-lg-12">
                                            @foreach ($service_items as $service_item)
                                                <div data-repeater-item="" class="form-group row">
                                                    <div class="col-md-{{$services->service_type_id==375447&&$services->payment_method_id == 3296?'4':'3'}}" id="budget_line_dev">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label class="kt-label m-label--single">Budget Line</label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <input type="text" name="budget_line" id="budget_line" class="form-control" placeholder="budget_line" value="{{$service_item->detailed_proposal_budget? $service_item->detailed_proposal_budget->budget_line . ' - ' . $service_item->detailed_proposal_budget->category_option->name_en:''}}" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="d-md-none kt-margin-b-10"></div>
                                                    </div>
                                                    <div class="col-md-{{$services->service_type_id==375447&&$services->payment_method_id == 3296?'2':'1'}}" id="availability_dev">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Remaining</label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <input id="availability" name="availability" value="{{availability ($service_item->detailed_proposal_budget_id)}}" type="text" class="form-control money" placeholder="remaining" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- TODO: --}}
                                                    @if ($services->service_type_id == 375447 and $services->payment_method_id == 3296)
                                                        <div class="col-md-3">
                                                            <div class="kt-form__group--inline">
                                                                <div class="kt-form__label">
                                                                    <label>Invoice Number<span class="required"> *</span></label>
                                                                </div>
                                                                <div class="kt-form__control">
                                                                    <input id="invoice_number" name="invoice_number" type="text" class="form-control " placeholder="Invoice Number" value="{{$service_item->invoice_number}}" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- TODO: --}}
                                                        <div class="col-md-3">
                                                            <div class="kt-form__label">
                                                                <label>Invoice Date<span class="required"> *</span></label>
                                                            </div>
                                                            <div class="input-group date">
                                                                <input type="text" name="invoice_date" class="form-control" readonly="" id="kt_datepicker_3" value="{{$service_item->invoice_date}}" disabled>
                                                                <div class="input-group-append">
                                                            <span class="input-group-text">
                                                                <i class="la la-calendar"></i>
                                                            </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="form-group row">
                                                    @endif
                                                    <div class="col-md-2">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Item</label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <input id="availability" name="item" type="text" class="form-control " value="{{$service_item->item->name_en}}" placeholder="item" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="d-md-none kt-margin-b-10"></div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label class="kt-label m-label--single">Unit</label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <input id="availability" name="item" type="text" class="form-control " value="{{$service_item->unit->name_en}}" placeholder="item" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="d-md-none kt-margin-b-10"></div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Quantity</label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <input id="quantity" name="quantity" type="text" class="form-control kt_inputmask_6" placeholder="quantity" value="{{$service_item->quantity}}" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Unit Cost</label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <input id="unit_cost" name="unit_cost" type="text" class="form-control money" placeholder="unit_cost" value="{{$service_item->unit_cost}}" disabled>
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
                                                                <div class="kt-form__control">
                                                                    <input id="currency_id" name="currency_id" type="text" class="form-control " placeholder="currency" value="{{$service_item->currency->name_en}}" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="d-md-none kt-margin-b-10"></div>
                                                        </div>
                                                        {{-- TODO: --}}
                                                        <div class="col-md-2">
                                                            <div class="kt-form__group--inline">
                                                                <div class="kt-form__label">
                                                                    <label>Exchange rate<span class="required">*</span></label>
                                                                </div>
                                                                <div class="kt-form__control">
                                                                    <input id="exchange_rate" name="exchange_rate" type="text" class="form-control money" placeholder="X-Rate" value="{{$service_item->exchange_rate}}" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="col-md-1">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Total Cost</label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <input id="total_cost" name="total_cost" type="text" class="form-control money total_cost" placeholder="total cost" value="{{$service_item->unit_cost*$service_item->quantity}}" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- TODO: --}}
                                                    <div class="col-md-{{$services->service_type_id==375447&&$services->payment_method_id == 3296?'3':'2'}}">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Note</label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <textarea class="form-control" name="note" id="note" cols="30" rows="2" disabled>{{$service_item->note}}</textarea>
                                                                {{-- <input name="note" type="text" class="form-control" placeholder="note"> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- TODO: --}}
                                                <div class="kt-separator kt-separator--border-dashed kt-separator--space-xl"></div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="kt-section">
                            <h3 class="kt-section__title">
                                Service Total:
                            </h3>
                            <div class="kt-section__content">
                                <div class="form-group row">
                                    {{-- TODO: --}}
                                    @if($services->currency_id != 87034 and $services->currency_id != "")
                                        <div class="col-lg-6 form-group-sub">
                                            <label class="form-control-label">Total Currency {{$services->currency->name_en}}</label>
                                            <input type="text" name="total_currency" id="total_currency" class="form-control money" placeholder="total_currency" value="{{$services->total_currency}}" disabled>
                                        </div>
                                    @endif
                                    <div class="col-lg-6 form-group-sub">
                                        <label class="form-control-label">Total USD</label>
                                        <input type="text" name="total_usd" id="total_usd" class="form-control money" placeholder="total_usd" value="{{$services->total_usd}}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-12">
                                    @if($check_notification->authorized)
                                        <a href="javascript:;" id="accept" class="btn btn-sm btn-label-primary btn-bold"><i class="la la-check"></i> @lang('common.accept')</a>
                                        <a href="javascript:;" id="reject" class="btn btn-sm  btn-label-danger btn-bold"><i class="la la-ban"></i> @lang('common.reject')</a>
                                    @else
                                        <a href="javascript:;" id="confirm" class="btn  btn-sm  btn-label-primary btn-bold"><i class="la la-check"></i> Confirm</a>
                                    @endif
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
    <form id="reject-form" action="{{route ('service.manager_action')}}" method="POST" hidden>
        @csrf
        <input hidden name="action" value="reject">
        <input hidden name="reallocate" value="1">
        <input hidden name="id" value="{{$services->id}}">
    </form>
    <form id="confirm-form" action="{{route ('service.manager_action')}}" method="POST" hidden>
        @csrf
        <input hidden name="action" value="confirm">
        <input hidden name="id" value="{{$services->id}}">
    </form>
    <form id="accept-form" action="{{route ('service.manager_action')}}" method="POST" hidden>
        @csrf
        <input hidden name="action" value="accept">
        <input hidden name="id" value="{{$services->id}}">
    </form>
    <!-- end:: Content -->
@stop
@section('script')
    @include('layouts.include.script.script_jquery_form')

    <script>
        submit_form('accept', 'accept-form');
        submit_form('reject', 'reject-form');
        submit_form('confirm', 'confirm-form');
        // $("#exchange_rate").keyup(function () {
        //         total_currency();
        //     });
        // function total_currency(){
        //         $sum_usd = 0;
        //         $total = $('.total_cost').each(function () {
        //             $sum_usd += +$(this).val()/$('#exchange_rate').val();
        //         });
        //         $('#total_usd').val($sum_usd);
        //     }
    </script>
@endsection
