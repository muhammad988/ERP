<div class="form-group form-group-last row import">
    <div data-repeater-list="service_item_direct" class="col-lg-12">
        @foreach( $data_row as $key=>$value)
            @if( !is_null($value[1]) )
                <div data-repeater-item="" class="form-group row">
                    <div class="row col-md-12">

                            <div @if(! $user_count ) hidden @endif  class="col-md-5 budget_line_dev form-group">
                                <div class="kt-form__group--inline">
                                    <div class="kt-form__label">
                                        <label class="kt-label m-label--single">Budget Line<span class="required"> *</span></label>
                                    </div>
                                    <div class="kt-form__control">
                                        <select class="form-control select2-multiple budget_line detailed_proposal_budget_id" name="detailed_proposal_budget_id" required>
                                            <option value="">Please Select</option>
                                            @if( $user_count )
                                            @foreach ($budget_lines as $budget_line)
                                                <option @if($budget_line->budget_line == $value[0]) selected @endif value="{{$budget_line->id}}">{{$budget_line->budget_line .' - '.$budget_line->name_en}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        <span class="form-text text-muted"></span>
                                        <input name="budget_id"  @if( $user_count ) value="{{get_budget_id ($value[0],$project_id)}}" @endif type="text" class="form-control" hidden disabled>
                                    </div>
                                </div>
                            </div>
                            <div  @if( !$user_count ) hidden @endif  class="col-md-2 availability_dev form-group">
                                <div class="kt-form__group--inline">
                                    <div class="kt-form__label">
                                        <label>Remaining</label>
                                    </div>
                                    <div class="kt-form__control">
                                        <input  name="availability"   @if( $user_count ) value="{{availability_with_project_id ($value[0],$project_id)}}"   @endif  type="text" class="form-control money-2  @if( $user_count )   availability_{{get_budget_id ($value[0],$project_id)}} {{get_budget_id ($value[0],$project_id)}} @endif" placeholder="Remaining" disabled>
                                        <input hidden  name="availability_old"   @if( $user_count ) value="{{availability_with_project_id ($value[0],$project_id)}}"  @endif  type="text" class="form-control money   @if( $user_count )  availability_old_{{get_budget_id ($value[0],$project_id)}} @endif "  placeholder="Remaining" disabled>
                                    </div>
                                </div>
                            </div>
                        <div class="col-md-2 form-group">
                            <div class="kt-form__group--inline">
                                <div class="kt-form__label">
                                    <label>Invoice Number<span class="required"> *</span></label>
                                </div>
                                <div class="kt-form__control">
                                    <input id="invoice_number" name="invoice_number"  value="{{$value[1]}}" type="text" class="form-control " placeholder="Invoice Number" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 form-group">
                            <div class="kt-form__label">
                                <label>Invoice Date<span class="required"> *</span></label>
                            </div>
                            <div class="input-group date">
                                <input type="text" name="invoice_date" value="{{$value[2]}}" class="form-control kt_datepicker_3 " readonly required>
                                <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <i class="la la-calendar"></i>
                                                                </span>
                                </div>
                            </div>
                            <span class="form-text text-muted"></span>

                        </div>
                        <div class="d-flex  @if( $user_count ) col-md-1 @else col-md-8 @endif align-self-end flex-row-reverse ">
                            <button type="button" data-repeater-delete="" class="btn btn-danger btn-sm btn-icon btn-circle "><i class="la la-trash-o"></i></button>
                        </div>
                    </div>
                    <div class="col-md-12 kt-separator kt-separator--border-dashed kt-separator--space-sm"></div>
                    <div class="row col-md-12 ">
                        <div class="col-md-2 form-group">
                            <div class="kt-form__group--inline">
                                <div class="kt-form__label">
                                    <label>Item<span class="required"> *</span></label>
                                </div>
                                <div class="kt-form__control">
                                    <select class="form-control select2-multiple" name="item_id" required>
                                        <option value="">Please Select</option>
                                        @foreach ($items as $item)
                                            <option @if($item->id == $value[3]) selected @endif  value="{{$item->id}}">{{$item->name_en}}</option>
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
                                    <select class="form-control select2-multiple" name="unit_id" required>
                                        <option value="" selected>Please Select</option>
                                        @foreach ($units as $unit)
                                            <option  @if($unit->id == $value[4]) selected @endif value="{{$unit->id}}">{{$unit->name_en}}</option>
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
                                    <input id="quantity" name="quantity"  onblur="getTotal(this)"  value="{{$value[5]}}"  type="text" class="form-control money-2" placeholder="Quantity" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 form-group">
                            <div class="kt-form__group--inline">
                                <div class="kt-form__label">
                                    <label>Unit Cost<span class="required"> *</span></label>
                                </div>
                                <div class="kt-form__control">
                                    <input id="unit_cost" name="unit_cost"  onblur="getTotal(this)" value="{{$value[6]}}"  type="text" class="form-control money-2" placeholder="Unit Cost" required>
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
                                            <option @if($currency->id == $value[7]) selected @endif value="{{$currency->id}}">{{$currency->name_en}}</option>
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
                                    <input  name="exchange_rate"  onblur="getTotal(this)" type="text" value="{{$value[8]}}" class="form-control money-2 exchange_rate_val @if( $user_count ) exchange_rate_val_{{get_budget_id ($value[0],$project_id)}} @endif " placeholder="X-Rate" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 form-group">
                            <div class="kt-form__group--inline">
                                <div class="kt-form__label">
                                    <label>Total Cost</label>
                                </div>
                                <div class="kt-form__control">
                                    <input name="total" type="text"  value="{{$value[5]*$value[6]}}" @if( $user_count ) id="{{get_budget_id ($value[0],$project_id)}}" @endif  class="form-control total-2 money-2 total  @if( $user_count ) total_{{get_budget_id ($value[0],$project_id)}}@endif "  placeholder="Total Cost" readonly>
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
                                    {{-- <input name="note" type="text" class="form-control" placeholder="note"> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
                </div>
            @endif
        @endforeach
    </div>
</div>


<div class="form-group form-group-last row">
    <div class="col-lg-4">
        <a href="javascript:;" data-repeater-create="" class="btn btn-bold btn-sm btn-label-brand">
            <i class="la la-plus"></i> Add
        </a>
    </div>
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
