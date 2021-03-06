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
                            Clearance For Service Request (Advance)
                        </h1>
                    </div>
                </div>
                <!--begin::Form-->
                <form method="POST" action="{{route('clearance.store')}} " class="kt-form kt-form--label-right" id="kt_form_2" novalidate="novalidate">
                    @csrf
                    <div class="kt-portlet__body">
                        <div class="kt-section">
                            <h3 class="kt-section__title">
                                Service Request Information:
                            </h3>
                            <div class="kt-section__content">
                                <div class="form-group form-group-last">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td style="width: 50%"><b>Project Name:</b>&nbsp;&nbsp;{{$service->project->name_en}}</td>
                                            <td style="width: 50%"><b>Service Type:</b>&nbsp;&nbsp;{{$service->service_type_id == 375446? 'Material and Service Request': 'Payment Request'}}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%"><b>Project Code:</b>&nbsp;&nbsp;{{$service->project->code}}</td>
                                            <td style="width: 50%"><b>Service Code:</b>&nbsp;&nbsp;{{$service->code}}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%">
                                                @if ($service->implementing_partner_id)
                                                    <b>Implementing Partner:</b>&nbsp;&nbsp;{{$service->implementing_partner->name_en}}
                                                @elseif ($service->supplier_id)
                                                    <b>Supplier:</b>&nbsp;&nbsp;{{$service->supplier->name_en}}
                                                @elseif ($service->service_provider_id)
                                                    <b>Service Provider:</b>&nbsp;&nbsp;{{$service->service_provider->name_en}}
                                                @else
                                                    <b>Recipient:</b>&nbsp;&nbsp;{{$service->service_recipient->first_name_en . ' ' . $service->service_recipient->last_name_en}}
                                                @endif
                                            </td>
                                            <td style="width: 50%"><b>Service Date:</b>&nbsp;&nbsp;{{$service->created_at}}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%"><b>Payment Type:</b>&nbsp;&nbsp;{{$service->payment_type->name_en}}</td>
                                            <td style="width: 50%">
                                                @if ($service->implementing_partner_account_id)
                                                    <b>Bank Account:</b>&nbsp;&nbsp;{{$service->implementing_partner_account->bank_name .' - '. $service->implementing_partner_account->iban}}
                                                @elseif ($service->supplier_account_id)
                                                    <b>Bank Account:</b>&nbsp;&nbsp;{{$service->supplier_account->bank_name .' - '. $service->supplier_account->iban}}
                                                @elseif ($service->service_provider_account_id)
                                                    <b>Bank Account:</b>&nbsp;&nbsp;{{$service->service_provider_account->bank_name .' - '. $service->service_provider_account->iban}}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%"><b>Currency:</b>&nbsp;&nbsp;{{$service->currency->name_en}}</td>
                                            <td style="width: 50%"><b>Exchange Rate:</b>&nbsp;&nbsp;{{$service->user_exchange_rate}}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%"><b>Total USD:</b>&nbsp;&nbsp;<span class="money">{{$total_usd}}</span></td>
                                            <td>{!! $service->currency->id != 87034? '<b>Total '.$service->currency->name_en .':</b>&nbsp;&nbsp;<span class="money">' . $total_currency .'</span>' : ''!!}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                                    <div class="row">
                                        <div class="col-lg-2 form-group-sub">
                                            <label class="form-control-label">Final clearance for this service?<span class="required"> *</span></label>
                                            <select class="form-control" name="clearance[completed]" id="completed" required>
                                                <option value="">Please Select</option>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                        @if ($service->service_method_id == 66893 || $service->service_method_id == 66892)
                                            <div class="col-lg-3 form-group-sub">
                                                <label class="form-control-label">Supplier Name</label>
                                                <select class="form-control  select2-multiple " name="clearance[supplier_id]" id="supplier_id">
                                                    <option value="">Please Select</option>
                                                    @foreach ($suppliers as $supplier)
                                                        <option value="{{$supplier->id}}">{{$supplier->name_en}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                        <div class="col-lg-2 form-group-sub">
                                            <label class="form-control-label">Upload Receipts<span class="required"> *</span></label>
                                            <input id="receipt_file" name="clearance[receipt_file]" type="file" class="form-control kt_inputmask_6" placeholder="receipt_file" required>
                                        </div>
                                        <div class="col-lg-2">
                                            <label class="form-control-label">Import Financial Clearance Items</label>
                                            <input id="items_file" name="items_file" type="file" class="form-control kt_inputmask_6" placeholder="items_file">
                                        </div>
                                        <div class="col-lg-3 align-self-end">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">View Service Items</button>
                                        </div>
                                    </div>
                                    <div class="form-text text-muted"><!--must use this helper element to display error message for the options--></div>
                                </div>
                            </div>
                        </div>
                        <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                        <div class="kt-section">
                            <h3 class="kt-section__title">
                                Financial Clearance Items
                                <i data-toggle="kt-tooltip" data-width="auto" class="kt-section__help" title="" data-original-title="If different than the corresponding address"></i>
                            </h3>
                            <div class="kt-section__content">
                                    <div class="form-group form-group-last row kt_repeater_clearance" >
                                        <div data-repeater-list="clearance_item" class="col-lg-12">
                                            <div data-repeater-item="" class="form-group row">
                                                <div class="row col-md-12">
                                                    <div class="col-md-5" id="service_item_dev">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label class="kt-label m-label--single">Service Item<span class="required"> *</span></label>
                                                            </div>
                                                            <div class="kt-form__control form-group-sub">
                                                                <select class="form-control  select2-multiple  service_item" name="service_item_id" required>
                                                                    <option value="">Please Select</option>
                                                                    @foreach ($service->service_items as $service_item)
                                                                        <option value="{{$service_item->id}}">{{$service_item->detailed_proposal_budget->budget_line .' - '. $service_item->detailed_proposal_budget->category_option->name_en .' - '. $service_item->item->name_en  .' - '. $service_item->quantity*$service_item->unit_cost}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="form-text text-muted"></span>

                                                                <input name="budget_id" type="text" class="form-control" hidden disabled>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2" id="availability_dev">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Availability</label>
                                                            </div>
                                                            <div class="kt-form__control form-group-sub">
                                                                <input id="availability" name="availability" required type="text" class="form-control money-2 availability" placeholder="availability" disabled>
                                                                <input name="availability_old" type="text" class="form-control availability" hidden disabled></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2" id="availability_dev">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Invoice Number<span class="required"> *</span></label>
                                                            </div>
                                                            <div class="kt-form__control form-group-sub">
                                                                <input id="invoice_number" name="invoice_number" type="text" class="form-control kt_inputmask_6" placeholder="Invoice Number" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="kt-form__label">
                                                            <label>Invoice Date<span class="required"> *</span></label>
                                                        </div>
                                                        <div class="input-group date form-group-sub">
                                                            <input type="text" name="invoice_date" class="form-control" readonly="" id="kt_datepicker_3" required>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <i class="la la-calendar"></i>
                                                                </span>
                                                            </div>
                                                            <span class="form-text text-muted"></span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex col-md-1 align-self-end flex-row-reverse">
                                                        <a href="javascript:;" data-repeater-delete="" class="btn-sm btn btn-danger btn-icon btn-circle">
                                                            <i class="la la-trash-o"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 kt-separator kt-separator--border-dashed kt-separator--space-sm"></div>
                                                <div class="row col-md-12">
                                                    <div class="col-md-2">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Item<span class="required"> *</span></label>
                                                            </div>
                                                            <div class="kt-form__control form-group-sub">
                                                                <select class="form-control  select2-multiple " name="item_id" required>
                                                                    <option value="">Please Select</option>
                                                                    @foreach ($items as $item)
                                                                        <option value="{{$item->id}}">{{$item->name_en}}</option>
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
                                                                <label class="kt-label m-label--single">Unit<span class="required"> *</span></label>
                                                            </div>
                                                            <div class="kt-form__control form-group-sub">
                                                                <select class="form-control  select2-multiple  " name="unit_id" required>
                                                                    <option value="" selected>Please Select</option>
                                                                    @foreach ($units as $unit)
                                                                        <option value="{{$unit->id}}">{{$unit->name_en}}</option>
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
                                                                <label>Quantity<span class="required"> *</span></label>
                                                            </div>
                                                            <div class="kt-form__control form-group-sub">
                                                                <input id="quantity" name="quantity" onblur="getTotal(this)" type="text" class="form-control kt_inputmask_6" placeholder="Quantity" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Unit Cost<span class="required"> *</span></label>
                                                            </div>
                                                            <div class="kt-form__control form-group-sub">
                                                                <input id="unit_cost" onblur="getTotal(this)" name="unit_cost" type="text" class="form-control money" placeholder="Unit Cost" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label class="kt-label m-label--single">Currency<span class="required"> *</span></label>
                                                            </div>
                                                            <div class="kt-form__control form-group-sub">
                                                                <select class="form-control currency" onchange="getTotal(this)" name="currency_id"  required>
                                                                    <option value="" selected>Select</option>
                                                                    @foreach ($currencies as $currency)
                                                                        <option value="{{$currency->id}}">{{$currency->name_en}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="d-md-none kt-margin-b-10"></div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Exchange rate<span class="required">*</span></label>
                                                            </div>
                                                            <div class="kt-form__control form-group-sub">
                                                                <input name="exchange_rate" onblur="getTotal(this)" type="text" class="form-control money exchange_rate_val" placeholder="X-Rate" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Total Cost</label>
                                                            </div>
                                                            <div class="kt-form__control form-group-sub">
                                                                <input name="total" type="text" class="form-control total total-2 money" placeholder="Total Cost" required readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Note</label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <textarea class="form-control" name="note" id="note" cols="30" rows="2"></textarea>
                                                                {{-- <input name="note" type="text" class="form-control" placeholder="note"> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
                                            </div>
                                        </div>
                                            <div class="col-lg-12 form-group form-group-last">
                                                <button type="button" data-repeater-create="" disabled class="btn btn-bold btn-sm btn-label-brand add">
                                                    <i class="la la-plus"></i> Add
                                                </button>
                                            </div>

                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="submit" disabled id="submit" data-ktwizard-type="action-submit" class="btn  btn-sm  btn-label-primary btn-bold "><i class="la la-check"></i> @lang('common.submit')</button>
                                    <button onClick="window.location.reload();" type="reset" class="btn btn-sm btn-bold btn-label-warning"><i class="la la-rotate-right"></i>Reset</button>
                                    <a href="/" class="btn btn-bold btn-sm btn-label-danger"> <i class="la la-close"></i>@lang('common.cancel') </a>
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

    <!-- Button trigger modal -->

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Service Items</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Budget Line</th>
                            <th>Item</th>
                            <th>Unit</th>
                            <th>Quantity</th>
                            <th>Unit Cost</th>
                            <th>Total Cost</th>
                            <th>Note</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($service->service_items as $key=>$service_item)
                            <tr>
                                <th>{{++$key}}</th>
                                <td>{{$service_item->detailed_proposal_budget->budget_line . ' - ' . $service_item->detailed_proposal_budget->category_option->name_en}}</td>
                                <td>{{$service_item->item->name_en}}</td>
                                <td>{{$service_item->unit->name_en}}</td>
                                <td>{{$service_item->quantity}}</td>
                                <td>{{$service_item->unit_cost}}</td>
                                <td>{{$service_item->unit_cost*$service_item->quantity}}</td>
                                <td>{{$service_item->note}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    @include('layouts.include.script.script_jquery_form')
    {!! Html::script('assets/js/demo2/pages/crud/forms/validation/form-controls-clearance.js') !!}

    <script>
        $(document).ready(function () {
            $('#submit').prop('disabled',false);
            $(document).on('change', `.service_item`, function () {
                if ($(this).val() == '') {
                    return false;
                }
                let currency = {'87035': 1, '87036': 2, '87034': 3};
                let name = $(this)["0"].name;
                let name_str = name.split("]");
                let category = name_str[0].split("[");
                let categoryName = category[0];
                let num = category[1];
                let sum = 0;
                let sum_2 = 0;
                let total = 0;
                let val = 0;
                let id = $(this).val();
                $(`.total_${$(this).val()}`).each(function (i) {
                    if ($(this).val() != '') {
                        val= $(`.exchange_rate_val_${id}:eq(${i})`).val();
                       if(val!=''){
                           if (currency[$(`.currency:eq(${i})`).val()] <= currency['{{$service->currency_id}}']) {
                               sum += Number($(this).val()) / Number(val);
                           } else {
                               sum += Number($(this).val()) * Number(val);
                           }
                       }
                    }
                });
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
                    document.getElementsByName('' + categoryName + '[' + num + '][exchange_rate]')[0].classList.remove("exchange_rate_val_" + old_id);
                    $(`.total_${old_id}`).each(function (i) {
                        if ($(this).val() != '') {
                            val= $(`.exchange_rate_val_${old_id}:eq(${i})`).val();
                            if(val!=''){
                                if (currency[$(`.currency:eq(${i})`).val()] <= currency['{{$service->currency_id}}']) {
                                    sum += Number($(this).val()) / Number(val);
                                } else {
                                    sum += Number($(this).val()) * Number(val);
                                }
                            }
                        }
                    });
                    $(`.${old_id}`).val(Number(availability_old) - (Number(sum_2)));
                }
                document.getElementsByName('' + categoryName + '[' + num + '][exchange_rate]')[0].classList.add("exchange_rate_val_" + $(this).val());
                document.getElementsByName('' + categoryName + '[' + num + '][total]')[0].classList.add("total_" + $(this).val());
                document.getElementsByName('' + categoryName + '[' + num + '][total]')[0].setAttribute('id', $(this).val());
                document.getElementsByName('' + categoryName + '[' + num + '][availability]')[0].classList.add($(this).val());
                document.getElementsByName('' + categoryName + '[' + num + '][availability_old]')[0].classList.add(`availability_old_${$(this).val()}`);
                document.getElementsByName('' + categoryName + '[' + num + '][budget_id]')[0].value = $(this).val();
                $.get('/service/get-availability-service-item/' + $(this).val(), function (data) {
                    let exchange_rate = document.getElementsByName('' + categoryName + '[' + num + '][exchange_rate]')[0];
                        console.log(sum);
                        console.log(data);
                        total = Number(data) - Number(sum);
                        document.getElementsByName('' + categoryName + '[' + num + '][availability]')[0].value = Number(total);
                        document.getElementsByName('' + categoryName + '[' + num + '][availability_old]')[0].value = Number(data);
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
        });
        function getTotal(e) {
            let currency = {'87035': 1, '87036': 2, '87034': 3};
            let name = e.getAttribute("name");
            let name_str = name.split("]");
            let category = name_str[0].split("[");
            let categoryName = category[0];
            let num = category[1];
            let val = '';
            let cost = document.getElementsByName('' + categoryName + '[' + num + '][unit_cost]')[0].value;
            let quantity = document.getElementsByName('' + categoryName + '[' + num + '][quantity]')[0].value;
            let availability_old = document.getElementsByName('' + categoryName + '[' + num + '][availability_old]')[0].value;
            let availability = document.getElementsByName('' + categoryName + '[' + num + '][availability]')[0].value;
            let exchange_rate = document.getElementsByName('' + categoryName + '[' + num + '][exchange_rate]')[0].value;
            let currency_id = $("[name='" + categoryName + "[" + num + "][currency_id]']").val();
            console.log();
            let total;
            let sum = 0;
            if (quantity == '') {
                quantity = 0;
            }
            if (availability == '') {
                document.getElementsByName('' + categoryName + '[' + num + '][availability]')[0].classList.add("is-invalid");
                return false
            }else{
                document.getElementsByName('' + categoryName + '[' + num + '][availability]')[0].classList.remove("is-invalid");

            }
            if (currency_id == '') {
                document.getElementsByName('' + categoryName + '[' + num + '][currency_id]')[0].classList.add("is-invalid");
                return false
            }else{
                document.getElementsByName('' + categoryName + '[' + num + '][currency_id]')[0].classList.remove("is-invalid");

            }
            if (exchange_rate == '') {
                document.getElementsByName('' + categoryName + '[' + num + '][exchange_rate]')[0].classList.add("is-invalid");
                return false
            }else{
                document.getElementsByName('' + categoryName + '[' + num + '][exchange_rate]')[0].classList.remove("is-invalid");

            }

            if (cost == '') {
                cost = '0';
            }
            total = ((Number(cost) * Number(quantity)));
            if (total > 0) {
                document.getElementsByName('' + categoryName + '[' + num + '][total]')[0].value = total;
                document.getElementsByName('' + categoryName + '[' + num + '][total]')[0].classList.remove("is-invalid");
                document.getElementsByName('' + categoryName + '[' + num + '][availability]')[0].classList.remove("is-invalid");
                $('.add').prop('disabled',false);
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

            $(`.total_${id}`).each(function (i) {
                if ($(this).val() != '') {
                    val= $(`.exchange_rate_val_${id}:eq(${i})`).val();
                    if(val!=''){
                        if (currency[$(`.currency:eq(${i})`).val()] <= currency['{{$service->currency_id}}']) {
                            console.log('/');

                            sum += Number($(this).val()) / Number(val);
                        }else{
                            console.log('*');
                            sum += Number($(this).val()) * Number(val);
                        }
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
                        val= $(`.exchange_rate_val_${id}:eq(${i})`).val();
                        if(val!=''){
                            if (currency[$(`.currency:eq(${i})`).val()] <= currency['{{$service->currency_id}}']) {
                                sum += Number($(this).val()) / Number(val);
                            } else {
                                sum += Number($(this).val()) * Number(val);
                            }
                        }
                    }
                });
                $(`.${id}`).val(Number(availability_old) - (Number(sum)));
                document.getElementsByName('' + categoryName + '[' + num + '][total]')[0].classList.add("is-invalid");
                document.getElementsByName('' + categoryName + '[' + num + '][availability]')[0].classList.add("is-invalid");
                $('.add').prop('disabled',true);
                let el = document.getElementsByName('' + categoryName + '[' + num + '][total]')[0];
                let ev = document.createEvent('Event');
                ev.initEvent('change', true, false);
                el.dispatchEvent(ev);
            }
        }
    </script>
@endsection
