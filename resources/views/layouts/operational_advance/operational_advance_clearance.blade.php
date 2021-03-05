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
                            Clearance For Operational Advance
                        </h1>
                    </div>
                </div>
                <!--begin::Form-->
                <form method="POST" action="{{route('clearance.store_operational_advance')}} " class="kt-form kt-form--label-right" id="kt_form_2" novalidate="novalidate">
                    @csrf
                    <input hidden name="id" value="{{$service->id}}">
                    <div class="kt-portlet__body">
                        <div class="kt-section">
                            <h3 class="kt-section__title">
                                Operational Advance Information:
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
                                            <td style="width: 50%"><b>Recipient:</b>&nbsp;&nbsp;{{$service->user_recipient->first_name_en . ' ' . $service->user_recipient->last_name_en}}</td>
                                            <td style="width: 50%"><b>Service Date:</b>&nbsp;&nbsp;{{$service->created_at}}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%"><b>Currency:</b>&nbsp;&nbsp;{{$service->currency->name_en}}</td>
                                            <td style="width: 50%"><b>Exchange Rate:</b>&nbsp;&nbsp;<span id="user_exchange_rate" class="money">{{$service->user_exchange_rate}}</span></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%"><b>Total USD:</b>&nbsp;&nbsp;<span id="availability_service" class="money">{{$service->total_dollar}}</span></td>
                                            <td>{!! $service->currency->id != 87034? '<b>Total '.$service->currency->name_en .':</b>&nbsp;&nbsp;<span class="money">'. $service->total_currency.'</span>' : ''!!}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class="kt-separator kt-separator--border-dashed kt-separator--space-sm"></div>
                                    <div class="row">
                                        <div hidden class="col-lg-2  form-group-sub">
                                            <label class="form-control-label">Final clearance for this service?<span class="required"> *</span></label>
                                            <select class="form-control" name="clearance[completed]" id="completed" required>
                                                <option value="">Please Select</option>
                                                <option selected value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4 form-group-sub">
                                            <label class="form-control-label">Supplier Name</label>
                                            <select class="form-control select2" name="clearance[supplier_id]" id="supplier_id">
                                                <option value="">Please Select</option>
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{$supplier->id}}">{{$supplier->name_en}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-2 form-group-sub">
                                            <label class="form-control-label">Upload Receipts<span class="required"> *</span></label>
                                            <input id="receipt_file" name="receipt_file" type="file" class="form-control kt_inputmask_6" placeholder="receipt_file" required>
                                        </div>
                                        <div class="col-lg-2">
                                            <label class="form-control-label">Download Clearance Template</label>
                                            <a href="{{route ('clearance.export_operational_advance_invoice_template',$service->id)}}" class="btn btn-bold btn-primary">Download</a>
                                            {{--                                            <input id="items_file" name="items_file" type="file" class="form-control kt_inputmask_6" placeholder="items_file">--}}
                                        </div>
                                        <div class="col-lg-2">
                                            <label class="form-control-label">Import Financial Clearance Items</label>
                                            <input id="items_file" name="items_file" type="file" class="form-control kt_inputmask_6" placeholder="items_file">
                                        </div>

                                    </div>
                                    <div class="form-text text-muted"><!--must use this helper element to display error message for the options--></div>
                                </div>
                            </div>
                        </div>
                        <div class="kt-separator kt-separator--border-dashed kt-separator--space-sm"></div>
                        <div class="kt-section">
                            <h3 class="kt-section__title">
                                Financial Clearance Items
                                <i data-toggle="kt-tooltip" data-width="auto" class="kt-section__help" title="" data-original-title="If different than the corresponding address"></i>
                            </h3>
                            <div class="kt-section__content">
                                <div class="form-group form-group-last row kt_repeater_clearance" id="div_data">
                                    <div data-repeater-list="clearance_item" class="col-lg-12">
                                        <div data-repeater-item="" class="form-group row">
                                            <div class="row col-md-12">
                                                <div class="col-md-2" id="availability_dev">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Invoice Number<span class="required"> *</span></label>
                                                        </div>
                                                        <div class="kt-form__control form-group-sub">
                                                            <input id="invoice_number" name="invoice_number" type="text" class="form-control " placeholder="Invoice Number" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="kt-form__label">
                                                        <label>Invoice Date<span class="required"> *</span></label>
                                                    </div>
                                                    <div class="input-group date  form-group-sub">
                                                        <input type="text" name="invoice_date" class="form-control kt_datepicker_3" readonly="" required>
                                                        <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <i class="la la-calendar"></i>
                                                                </span>
                                                        </div>
                                                        <span class="form-text text-muted"></span>

                                                    </div>
                                                </div>
                                                <div class="d-flex col-md-8 align-self-end flex-row-reverse">
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
                                                        <div class="kt-form__control   form-group-sub">
                                                            <select class="form-control select2" name="item_id" required>
                                                                <option value="">Please Select</option>
                                                                @foreach ($items as $item)
                                                                    <option value="{{$item->id}}">{{$item->name_en}}</option>
                                                                @endforeach
                                                            </select>
                                                            <span class="form-text text-muted"></span>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="kt-form__group--inline ">
                                                        <div class="kt-form__label ">
                                                            <label class="kt-label m-label--single">Unit<span class="required"> *</span></label>
                                                        </div>
                                                        <div class="kt-form__control  form-group-sub">
                                                            <select class="form-control select2" name="unit_id" required>
                                                                <option value="" selected>Please Select</option>
                                                                @foreach ($units as $unit)
                                                                    <option value="{{$unit->id}}">{{$unit->name_en}}</option>
                                                                @endforeach
                                                            </select>
                                                            <span class="form-text text-muted"></span>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 form-group-sub">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Quantity<span class="required"> *</span></label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <input  name="quantity" onchange="getTotal(this)" type="text" class="form-control kt_inputmask_6" placeholder="Quantity" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 form-group-sub">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Unit Cost<span class="required"> *</span></label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <input  name="unit_cost"  onchange="getTotal(this)"  type="text" class="form-control money" placeholder="Unit Cost" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 form-group-sub">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label class="kt-label m-label--single">Currency<span class="required"> *</span></label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <select  onchange="check_total()"  class="form-control currency" name="currency_id"  required>
                                                                <option value="" selected>Select</option>
                                                                @foreach ($currencies as $currency)
                                                                    <option value="{{$currency->id}}">{{$currency->name_en}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="d-md-none kt-margin-b-10"></div>
                                                </div>
                                                <div class="col-md-1 form-group-sub">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Exchange rate<span class="required">*</span></label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <input  name="exchange_rate" onchange="check_total()"  type="text" class="form-control money exchange_rate_val" placeholder="X-Rate" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 form-group-sub">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Total Cost<span class="required">*</span></label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <input  name="total" type="text" class="form-control money total" placeholder="Total Cost" required readonly>
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
                                            <div class="col-md-12 kt-separator kt-separator--border-dashed kt-separator--space-sm"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group form-group-last">
                                            <a href="javascript:;" data-repeater-create="" class="btn btn-bold btn-sm btn-label-brand">
                                                <i class="la la-plus"></i> Add
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="kt-separator kt-separator--border-dashed kt-separator--space-xl"></div>
                        <div class="row">
                            <div class="col-lg-2">
                                <h5 id="title_service_total">Service Total {{$service->currency->name_en}}:</h5>
                                <input id="service_total" value="" name="total" readonly class="form-control money">
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

@stop
@section('script')
    @include('layouts.include.script.script_jquery_form')
    {!! Html::script('assets/js/demo2/pages/crud/forms/validation/form-controls-clearance.js') !!}
    <script>
        $(document).ready(function () {
            $('#submit').prop('disabled', false);
            $('#items_file').on('change', function () {
                let file_data = $('#items_file').prop('files')[0];
                let form_data = new FormData();
                let div_data = $('#div_data');
                form_data.append('file', file_data);
                let url = `/clearance/operational-advance/import-file-invoice`;
                $.ajax({
                    url: `${url}`, // point to server-side PHP script
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    success: function ($data) {
                        div_data.html('');
                        div_data.html($data);
                        toastr.success("Operation", "Success", {
                            closeButton: true, "positionClass": "toast-bottom-right",
                            "onclick": null,
                            "showDuration": "1000",
                            "hideDuration": "1000",
                            "timeOut": "3000",
                            "extendedTimeOut": "10000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        });
                        setTimeout(function () {
                            $('.select2-multiple').select2();
                            $('.kt_datepicker_3').datepicker({
                                rtl: KTUtil.isRTL(),
                                todayBtn: "linked",
                                clearBtn: true,
                                todayHighlight: true,
                            });
                        }, 500);
                        check_total()
                    },
                    error: function () {
                        toastr.error("Operation", "Error", {
                            closeButton: true, "positionClass": "toast-bottom-right",
                            "onclick": null,
                            "showDuration": "1000",
                            "hideDuration": "1000",
                            "timeOut": "3000",
                            "extendedTimeOut": "10000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        })
                    }
                });
            });


            // $('.select2-multiple').select2();
        });

        function getTotal(e) {
            let name = e.getAttribute("name");
            let name_str = name.split("]");
            let category = name_str[0].split("[");
            let categoryName = category[0];
            let num = category[1];
            let val = '';
            let cost = document.getElementsByName('' + categoryName + '[' + num + '][unit_cost]')[0].value;
            let quantity = document.getElementsByName('' + categoryName + '[' + num + '][quantity]')[0].value;
            let total;
            let sum = 0;
            if (quantity == '') {
                quantity = 0;
            }
            if (cost == '') {
                cost = '0';
            }
            total = ((Number(cost) * Number(quantity)));
            document.getElementsByName('' + categoryName + '[' + num + '][total]')[0].value = total;
            check_total();
        }
        function check_total() {
            let currency = {'87035': 1, '87036': 2, '87034': 3};
            let sum = 0;
            let total=$(`.total`);
            total.each(function (i) {
                if ($(this).val() != '') {
                    val = $(`.exchange_rate_val:eq(${i})`).val();
                    if (val != '') {
                        if (currency[$(`.currency:eq(${i})`).val()] <= currency['{{$service->currency_id}}']) {
                            sum += Number($(this).val()) / Number(val);
                        } else {
                            sum += Number($(this).val()) * Number(val);
                        }
                    }
                }
            });
            if ((Number($(`#availability_service`).val()) * Number($(`#user_exchange_rate`).val())) - (Number(sum)) < 0) {
                swal.fire({
                    "title": "",
                    "text": "You do not have enough money in service !",
                    "type": "error",
                    "confirmButtonClass": "btn btn-secondary"
                });
                total.val(null);
                total.addClass('is-invalid');
                $('#submit').prop('disabled', true);
                $(`#service_total`).val(0);
            } else {
                total.removeClass('is-invalid');
                $('#submit').prop('disabled', false);
                $(`#service_total`).val(sum);
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
            }

        }

        $(document).on('change', `.total`, function () {
            let total = 0;
            setTimeout(function () {
                check_total()
            }, 500);
        });
    </script>
@endsection
