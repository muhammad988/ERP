<div data-repeater-list="clearance_item" class="col-lg-12">

    @foreach( $data_row as $key=>$value)

        @if( !is_null($value[1]) )
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
                                        <option @if($service_item->id == (int)explode('-', $value[1])[0]) selected @endif  value="{{$service_item->id}}">{{$service_item->detailed_proposal_budget->budget_line .' - '. $service_item->detailed_proposal_budget->category_option->name_en .' - '. $service_item->item->name_en  .' - '. $service_item->quantity*$service_item->unit_cost}}</option>
                                    @endforeach
                                </select>
                                <span class="form-text text-muted"></span>

                                <input name="budget_id" type="text" class="form-control" value="{{ (int) explode('-', $value[1])[0]}}" hidden disabled>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-2" id="availability_dev">
                        <div class="kt-form__group--inline">
                            <div class="kt-form__label">
                                <label>Remaining</label>
                            </div>
                            <div class="kt-form__control form-group-sub">
                                <input id="availability" name="availability" value="{{availability_with_service_id ((int)explode('-', $value[1])[0])}}" required type="text" class="form-control money-2 availability {{explode('-', $value[1])[0]}}" placeholder="remaining" disabled>
                                <input name="availability_old" type="text" class="form-control availability_old availability_old_{{(int)explode('-', $value[1])[0]}}" hidden disabled></div>
                        </div>
                    </div>
                    <div class="col-md-2" id="availability_dev">
                        <div class="kt-form__group--inline">
                            <div class="kt-form__label">
                                <label>Invoice Number<span class="required"> *</span></label>
                            </div>
                            <div class="kt-form__control form-group-sub">
                                <input id="invoice_number" name="invoice_number" value="{{$value[2]}}" type="text" class="form-control " placeholder="Invoice Number" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="kt-form__label">
                            <label>Invoice Date<span class="required"> *</span></label>
                        </div>
                        <div class="input-group date form-group-sub">
                            <input type="text" name="invoice_date" value="{{ \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value[3]))->format ('Y-m-d') }}" class="form-control kt_datepicker_3" readonly="" required>
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
                                        <option @if($item->id == (int)explode('-', $value[4])[0]) selected @endif  value="{{$item->id}}">{{$item->name_en}}</option>
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
                                        <option  @if($unit->id == (int)explode('-', $value[5])[0]) selected @endif  value="{{$unit->id}}">{{$unit->name_en}}</option>
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
                                <input id="quantity" name="quantity" onblur="getTotal(this)" value="{{$value[6]}}" type="text" class="form-control kt_inputmask_6" placeholder="Quantity" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="kt-form__group--inline">
                            <div class="kt-form__label">
                                <label>Unit Cost<span class="required"> *</span></label>
                            </div>
                            <div class="kt-form__control form-group-sub">
                                <input id="unit_cost" onblur="getTotal(this)" name="unit_cost" value="{{$value[7]}}"  type="text" class="form-control money" placeholder="Unit Cost" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="kt-form__group--inline">
                            <div class="kt-form__label">
                                <label class="kt-label m-label--single">Currency<span class="required"> *</span></label>
                            </div>
                            <div class="kt-form__control form-group-sub">
                                <select class="form-control currency currency_val_{{(int)explode('-', $value[1])[0]}}" onchange="getTotal(this)" name="currency_id" required>
                                    <option value="" selected>Select</option>
                                    @foreach ($currencies as $currency)
                                        <option  @if($currency->id == (int)explode('-', $value[8])[0]) selected @endif  value="{{$currency->id}}">{{$currency->name_en}}</option>
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
                                <input name="exchange_rate" onblur="getTotal(this)" value="{{$value[9]}}"  type="text" class="form-control money exchange_rate_val exchange_rate_val_{{(int)explode('-', $value[1])[0]}}" placeholder="X-Rate" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="kt-form__group--inline">
                            <div class="kt-form__label">
                                <label>Total Cost</label>
                            </div>
                            <div class="kt-form__control form-group-sub">
                                <input name="total" id="{{(int)explode('-', $value[1])[0]}}" type="text" class="form-control total total-2 money total_{{(int)explode('-', $value[1])[0]}}" value="{{$value[6]*$value[7]}}" placeholder="Total Cost" required readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="kt-form__group--inline">
                            <div class="kt-form__label">
                                <label>Note</label>
                            </div>
                            <div class="kt-form__control">
                                <textarea class="form-control" name="note" id="note" cols="30" rows="2">{{$value[10]}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
            </div>
        @endif
    @endforeach
</div>
<div class="col-lg-12 form-group form-group-last">
    <button type="button" data-repeater-create="" disabled class="btn btn-bold btn-sm btn-label-brand add">
        <i class="la la-plus"></i> Add
    </button>
</div>
<script>

    jQuery(document).ready(function () {
        KTFormRepeater.init()
    });
    $(".money-2").inputmask({
        "alias": "decimal",
        "digits": 4,
        "autoGroup": true,
        "allowMinus": true,
        "rightAlign": false,
        autoUnmask: true,
        "groupSeparator": ",",
        "radixPoint": ".",

    });

</script>
