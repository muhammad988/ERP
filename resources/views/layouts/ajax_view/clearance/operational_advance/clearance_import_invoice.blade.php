<div data-repeater-list="clearance_item" class="col-lg-12">

    @foreach( $data_row as $key=>$value)
        @if( !is_null($value[1]) )
            <div data-repeater-item="" class="form-group row">
                <div class="row col-md-12">
                    <div class="col-md-2">
                        <div class="kt-form__group--inline">
                            <div class="kt-form__label">
                                <label>Invoice Number<span class="required"> *</span></label>
                            </div>
                            <div class="kt-form__control form-group-sub">
                                <input  name="invoice_number" value="{{$value[1]}}" type="text" class="form-control " placeholder="Invoice Number" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="kt-form__label">
                            <label>Invoice Date<span class="required"> *</span></label>
                        </div>
                        <div class="input-group date form-group-sub">
                            <input type="text" name="invoice_date" value="{{ \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value[2]))->format ('Y-m-d') }}" class="form-control kt_datepicker_3" readonly required>
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
                            <div class="kt-form__control form-group-sub">
                                <select class="form-control  select2-multiple " name="item_id" required>
                                    <option value="">Please Select</option>
                                    @foreach ($items as $item)
                                        <option @if($item->id == (int)explode('-', $value[3])[0]) selected @endif  value="{{$item->id}}">{{$item->name_en}}</option>
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
                                <select class="form-control  select2-multiple" name="unit_id" required>
                                    <option value="" selected>Please Select</option>
                                    @foreach ($units as $unit)
                                        <option  @if($unit->id == (int)explode('-', $value[4])[0]) selected @endif  value="{{$unit->id}}">{{$unit->name_en}}</option>
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
                                <input  name="quantity" onblur="getTotal(this)" value="{{$value[5]}}" type="text" class="form-control kt_inputmask_6" placeholder="Quantity" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="kt-form__group--inline">
                            <div class="kt-form__label">
                                <label>Unit Cost<span class="required"> *</span></label>
                            </div>
                            <div class="kt-form__control form-group-sub">
                                <input  onchange="getTotal(this)" name="unit_cost" value="{{$value[6]}}"  type="text" class="form-control money" placeholder="Unit Cost" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="kt-form__group--inline">
                            <div class="kt-form__label">
                                <label class="kt-label m-label--single">Currency<span class="required"> *</span></label>
                            </div>
                            <div class="kt-form__control form-group-sub">
                                <select class="form-control currency currency_val_1" onchange="getTotal(this)" name="currency_id" required>
                                    <option value="" selected>Select</option>
                                    @foreach ($currencies as $currency)
                                        <option  @if($currency->id == (int)explode('-', $value[7])[0]) selected @endif  value="{{$currency->id}}">{{$currency->name_en}}</option>
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
                                <input name="exchange_rate" onchange="getTotal(this)" value="{{$value[8]}}"  type="text" class="form-control money exchange_rate_val exchange_rate_val_1" placeholder="X-Rate" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="kt-form__group--inline">
                            <div class="kt-form__label">
                                <label>Total Cost</label>
                            </div>
                            <div class="kt-form__control form-group-sub">
                                <input name="total" type="text" class="form-control total money " value="{{$value[5]*$value[6]}}" placeholder="Total Cost" required readonly>
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
    <button type="button" data-repeater-create=""  class="btn btn-bold btn-sm btn-label-brand add">
        <i class="la la-plus"></i> Add
    </button>
</div>
<script>

    jQuery(document).ready(function () {
        KTFormRepeater.init()
    });
</script>
