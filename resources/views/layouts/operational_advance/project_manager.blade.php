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
                            Operational Advance Clearance
                        </h1>
                    </div>
                </div>
                <!--begin::Form-->
                <form method="POST" action="{{route ('clearance.update_operational_advance')}} " class="kt-form kt-form--label-right" id="kt_form_2" novalidate="novalidate">
                    @csrf
                    @method('PUT')
                    <input hidden name="id" value="{{$services->id}}">

                    <div class="kt-portlet__body">
                        <div class="kt-separator kt-separator--border-dashed kt-separator--space-xs"></div>
                        <div class="kt-section">
                            <h3 class="kt-section__title">
                                Operational Advance Clearance Information:
                            </h3>
                            <div class="kt-section__content">
                                <div class="form-group row">
                                    <div class="col-lg-2">
                                        <label class="form-control-label">Operational Advance Clearance Code</label>
                                        <input type="text" class="form-control" placeholder="service_method" value="{{$services->code}}" disabled>
                                    </div>
                                    <div class="col-lg-2">
                                        <label class="form-control-label">Operational Advance Code</label>
                                        <input type="text" class="form-control" placeholder="service_method" value="{{$services->parent->code}}" disabled>
                                    </div>

                                    <div class="col-lg-2 form-group-sub" id="service_receiver_dev">
                                        <label class="form-control-label">Recipient Name</label>
                                            <input type="text" name="service_receiver" id="service_receiver" class="form-control" placeholder="service_receiver" value="{{$services->user_recipient->first_name_en .' '. $services->user_recipient->last_name_en}}" disabled>

                                    </div>
                                    <div class="col-lg-4 form-group-sub" id="project_name_dev">
                                        <label class="form-control-label">Project Name</label>
                                        <input type="text" name="project_id" id="project_name" class="form-control" placeholder="project name" value="{{$services->project->name_en}}" disabled>
                                    </div>
                                    <div class="col-lg-1 form-group-sub">
                                        <label class="form-control-label">Currency</label>
                                        <input type="text" name="currency_id" id="currency" class="form-control" placeholder="currency" value="{{$services->currency->name_en}}" disabled>
                                    </div>
                                    <div class="col-lg-1 form-group-sub">
                                        <label class="form-control-label">Exchange Rate<span class="required"> *</span></label>
                                        <input type="text" name="user_exchange_rate" id="exchange_rate" class="form-control money" readonly placeholder="exchange rate" value="{{$services->user_exchange_rate}}" required {{$services->currency->id == 87034?'readonly':''}}>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="kt-separator kt-separator--border-dashed kt-separator--space-xs"></div>

                        <div class="kt-section">
                            <h3 class="kt-section__title">
                                Operational Advance Clearance  Items
                                <i data-toggle="kt-tooltip" data-width="auto" class="kt-section__help" title="" data-original-title="If different than the corresponding address"></i>
                            </h3>
                            <div class="kt-section__content">
                                <div class="kt_repeater_service">
                                    <div data-repeater-list="service_item">
                                        <div data-repeater-item="">
                                            @foreach ($service_items as $service_item)
                                                <div data-repeater-item="" class="form-group row">
                                                    <input type="text" name="id" value="{{$service_item->id}}" hidden>
                                                    <div class="col-md-4 form-group-sub" id="budget_line_dev">
                                                        <label class="kt-label m-label--single">Budget Line</label>
                                                        <select class="form-control detailed_proposal_budget_id select2" name="service_items[detailed_proposal_budget_id]"  required>
                                                            <option value="" selected>Please Select</option>
                                                            @foreach ($budget_lines as $budget_line)
                                                                <option value="{{$budget_line->id}}">{{$budget_line->budget_line .' - '. $budget_line->name_en}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="form-text text-muted"></span>
                                                        <input name="budget_id" type="text" class="form-control" hidden disabled>
                                                    </div>
                                                    <div class="col-md-2 availability_dev" >
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Usable</label>
                                                            </div>
                                                            <div class="kt-form__control form-group">
                                                                <input id="availability" name="availability" type="text" class="form-control money-2 availability" required placeholder="remaining" disabled readonly>
                                                                <input name="availability_old" type="text" class="form-control availability" hidden disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- TODO: --}}
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
                                                    <div class="col-md-2">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Item</label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <input id="item_id" name="item_id" type="text" class="form-control " value="{{$service_item->item->name_en}}" placeholder="item" disabled>
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
                                                                <input id="unit_id" name="unit_id" type="text" class="form-control " value="{{$service_item->unit->name_en}}" placeholder="item" disabled>
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
                                                                <input id="unit_cost" name="unit_cost" type="text" class="form-control money" placeholder="unit cost" value="{{$service_item->unit_cost}}" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- TODO: --}}
                                                        <div class="col-md-1">
                                                            <div class="kt-form__group--inline">
                                                                <div class="kt-form__label">
                                                                    <label class="kt-label m-label--single">Currency<span class="required"> *</span></label>
                                                                </div>
                                                                <div class="kt-form__control">
                                                                    <input name="currency" type="text" class="form-control " placeholder="currency" value="{{$service_item->currency->name_en}}" disabled>
                                                                    <input name="currency_id" hidden type="text" class="form-control currency_val" placeholder="currency" value="{{$service_item->currency_id}}" disabled>
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
                                                                    <input  name="exchange_rate" type="text" class="form-control money" placeholder="X-Rate" value="{{$service_item->exchange_rate}}" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <div class="col-md-1">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Total Cost</label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <input name="total" type="text" class="form-control money total_cost total" placeholder="total cost" value="{{$service_item->unit_cost*$service_item->quantity}}" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Note</label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <textarea name="note" id="note" cols="30" class="form-control" rows="2" disabled>{{$service_item->note}}</textarea>
                                                                {{-- <input name="note" type="text" class="form-control" placeholder="note"> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 kt-separator kt-separator--border-dashed kt-separator--space-xs"></div>

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
                                    @if($services->currency_id != 87034 && !is_null ($services->currency_id ))
                                        <div class="col-lg-2 form-group-sub">
                                            <label class="form-control-label">Total Currency {{$services->currency->name_en}}</label>
                                            <input type="text" name="total_currency" id="total_currency" class="form-control money" placeholder="total currency" value="{{$services->total_currency}}" disabled>
                                        </div>
                                    @endif
                                    <div class="col-lg-2 form-group-sub">
                                        <label class="form-control-label">Total USD</label>
                                        <input type="text" name="total_usd" id="total_usd" class="form-control money" placeholder="total USD" value="{{$services->total_dollar}}" disabled>
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
    <!-- end:: Content -->
    <form id="reject-form" action="{{route ('clearance.action_operational_advance')}}" method="POST" hidden>
        @csrf
        <input hidden name="action" value="reject">
        <input hidden name="id" value="{{$services->id}}">
    </form>
@stop
@section('script')
    @include('layouts.include.script.script_jquery_form')
    {!! Html::script('assets/js/demo2/pages/crud/forms/validation/form-controls-service-logistic.js') !!}
    <script>
            submit_form('reject', 'reject-form');
        $(document).on('change', `.detailed_proposal_budget_id`, function () {
            let currency = {'87035': 1, '87036': 2, '87034': 3};
            let name = $(this)["0"].name;
            let name_str = name.split("]");
            let category = name_str[0].split("[");
            let categoryName = category[0];
            let num = category[1];
            let sum = 0;
            let usable = 0;
            let sum_2 = 0;
            let total = 0;
            let val = 0;
            let id = $(this).val();

            let old_id = document.getElementsByName('' + categoryName + '[' + num + '][budget_id]')[0].value;
            let exchange_rate = document.getElementsByName('' + categoryName + '[' + num + '][exchange_rate]')[0];
            let availability_old = $(`.availability_old_${old_id}`).val();
            if (old_id != '') {
                document.getElementsByName('' + categoryName + '[' + num + '][availability]')[0].classList.remove(old_id);
                document.getElementsByName('' + categoryName + '[' + num + '][total]')[0].classList.remove("total_" + old_id);
                document.getElementsByName('' + categoryName + '[' + num + '][availability_old]')[0].classList.remove("availability_old_" + old_id);
                document.getElementsByName('' + categoryName + '[' + num + '][currency_id]')[0].classList.remove("currency_val_" + old_id);
                document.getElementsByName('' + categoryName + '[' + num + '][budget_id]')[0].value = $(this).val();
                document.getElementsByName('' + categoryName + '[' + num + '][exchange_rate]')[0].classList.remove("exchange_rate_val_" + old_id);
                $(`.total_${old_id}`).each(function (i) {
                    if ($(this).val() != '') {
                        val= $(`.exchange_rate_val_${old_id}:eq(${i})`).val();
                        if(val!=''){

                            if (currency[$(`.currency_val_${old_id}:eq(${i})`).val()] <= currency['{{$services->currency_id}}']) {
                                sum_2 += Number($(this).val()) / Number(val);
                            } else {
                                sum_2 += Number($(this).val()) * Number(val);
                            }
                        }
                    }
                });
                $(`.${old_id}`).val(Number(availability_old) - (Number(sum_2)));
            }
            if ($(this).val() == '') {
                return false;
            }
            document.getElementsByName('' + categoryName + '[' + num + '][exchange_rate]')[0].classList.add("exchange_rate_val_" + $(this).val());
            document.getElementsByName('' + categoryName + '[' + num + '][total]')[0].classList.add("total_" + $(this).val());
            document.getElementsByName('' + categoryName + '[' + num + '][total]')[0].setAttribute('id', $(this).val());
            document.getElementsByName('' + categoryName + '[' + num + '][availability]')[0].classList.add($(this).val());
            document.getElementsByName('' + categoryName + '[' + num + '][currency_id]')[0].classList.add("currency_val_" + id);
            document.getElementsByName('' + categoryName + '[' + num + '][availability_old]')[0].classList.add(`availability_old_${$(this).val()}`);
            document.getElementsByName('' + categoryName + '[' + num + '][budget_id]')[0].value = $(this).val();
            $.get('/project/get-availability-budget-line/' + $(this).val(), function (data) {

                usable=Number(Number(data)* Number(`{{$services->user_exchange_rate}}`));
                document.getElementsByName('' + categoryName + '[' + num + '][availability_old]')[0].value = usable;
                $(`.total_${id}`).each(function (i) {
                    if ($(this).val() != '') {
                        val= $(`.exchange_rate_val_${id}:eq(${i})`).val();
                        if(val!=''){
                            if (currency[$(`.currency_val_${id}:eq(${i})`).val()] <= currency['{{$services->currency_id}}']) {
                                sum += Number($(this).val()) / Number(val);
                            } else {
                                sum += Number($(this).val()) * Number(val);
                            }
                        }
                    }
                });

                total = Number(data) - Number(sum);
                if (Number(data) - (Number(sum)) < 0) {
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
                            val= $(`.exchange_rate_val_${id}:eq(${i})`).val();
                            if(val!=''){
                                if (currency[$(`.currency_val_${id}:eq(${i})`).val()] <= currency['{{$services->currency_id}}']) {
                                    sum += Number($(this).val()) / Number(val);
                                } else {
                                    sum += Number($(this).val()) * Number(val);
                                }
                            }
                        }
                    });
                    $(`.${id}`).val(Number(usable) - (Number(sum)));
                    document.getElementsByName('' + categoryName + '[' + num + '][total]')[0].classList.add("is-invalid");
                    document.getElementsByName('' + categoryName + '[' + num + '][availability]')[0].classList.add("is-invalid");
                    document.getElementsByName('' + categoryName + '[' + num + '][availability]')[0].classList.add("error");
                    $('#submit').prop('disabled', true);
                }  else{
                    $(`.${id}`).val(Number(usable) - (Number(sum)));
                    document.getElementsByName('' + categoryName + '[' + num + '][total]')[0].classList.remove("is-invalid");
                    document.getElementsByName('' + categoryName + '[' + num + '][availability]')[0].classList.remove("is-invalid");
                    document.getElementsByName('' + categoryName + '[' + num + '][availability]')[0].classList.remove("error");
                    if($(".error").length==0){
                        $('#submit').prop('disabled', false);
                    }
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
    </script>
@endsection
