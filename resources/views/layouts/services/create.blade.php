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
                <form method="POST" action="{{route('service.store')}} " class="kt-form kt-form--label-right" id="kt_form_2">
                    @csrf
                    <div class="kt-portlet__body">
                        <div class="kt-section">
                            <h3 class="kt-section__title kt-margin-b-20">
                                Service Type<span class="required"> *</span>
                            </h3>
                            <div class="kt-section__content">
                                <div class="form-group form-group-last">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label class="kt-option">
                                            <span class="kt-option__control">
                                            <span class="kt-radio kt-radio--state-brand">
                                            <input type="radio" name="service[service_type_id]" id="mr_service" required value="375446">
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
                                        <div class="col-lg-6">
                                            <label class="kt-option">
                                            <span class="kt-option__control">
                                            <span class="kt-radio kt-radio--state-brand">
                                            <input type="radio" name="service[service_type_id]" id="pyr_service" required value="375447">
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
                                        <label class="form-control-label">Service Method<span class="required"> *</span></label>
                                        <select class="form-control" name="service[service_method_id]" id="service_method" required>
                                            <option value="" selected>Please Select</option>
                                            @foreach ($serviceMethods as $serviceMethod)
                                                <option value="{{$serviceMethod->id}}">{{$serviceMethod->name_en}}</option>
                                            @endforeach
                                        </select>
                                        <span class="form-text text-muted"></span>
                                    </div>
                                    <div class="col-lg-2 form-group-sub" id="payment_method_dev">
                                        <label class="form-control-label">Payment Method<span class="required"> *</span></label>
                                        <select class="form-control" name="service[payment_method_id]" id="payment_method" required>
                                            <option value="" selected>Please Select</option>
                                            @foreach ($paymentMethods as $paymentMethod)
                                                <option value="{{$paymentMethod->id}}">{{$paymentMethod->name_en}}</option>
                                            @endforeach
                                        </select>
                                        <span class="form-text text-muted"></span>
                                    </div>
                                    <div class="col-lg-3 form-group-sub" id="service_receiver_dev">
                                        <label class="form-control-label">Service Receiver<span class="required"> *</span></label>
                                        <select class="form-control select2-multiple" name="service[service_receiver_id]" id="service_receiver" required>
                                            <option value="" selected>Please Select</option>
                                        </select>
                                        <span class="form-text text-muted"></span>
                                    </div>

                                    <div class="col-lg-2 form-group-sub" id="payment_type_dev">
                                        <label class="form-control-label">Payment Type<span class="required"> *</span></label>
                                        <select class="form-control" name="service[payment_type_id]" id="payment_type" required>
                                            <option value="" selected>Please Select</option>
                                            @foreach ($paymentTypes as $payment_type)
                                                <option value="{{$payment_type->id}}">{{$payment_type->name_en}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3 form-group-sub" id="bank_account_dev">
                                        <label class="form-control-label">Bank Account</label>
                                        <select class="form-control" name="service[bank_account]" id="bank_account">
                                            <option value="" selected>Please Select</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6 form-group-sub">
                                        <label class="form-control-label">Office/ Project<span class="required"> *</span></label>
                                        <select class="form-control" name="service[service_model_id]" id="service_model" required>
                                            <option value="" selected>Please Select</option>
                                            @foreach ($serviceModels as $serviceModel)
                                                <option value="{{$serviceModel->id}}">{{$serviceModel->name_en}}</option>
                                            @endforeach
                                        </select>
                                        <span class="form-text text-muted"></span>
                                        <select hidden disabled class="form-control detailed_proposal_budget_id_hidden" name="detailed_proposal_budget_id_hidden">
                                            <option value="">Please Select</option>
                                        </select>
                                        <input hidden value="" id="budget_line_hidden">
                                    </div>
                                    <div class="col-lg-6 form-group-sub" id="project_id_dev">
                                        <label class="form-control-label">Project Name<span class="required"> *</span></label>
                                        <select class="form-control select2-multiple" name="service[project_id]" id="project_id" required>
                                            <option value="" selected>Please Select</option>
                                            @foreach ($projects as $project)
                                                <option value="{{$project->id}}">{{$project->name_en}}</option>
                                            @endforeach
                                        </select>
                                        <span class="form-text text-muted"></span>
                                    </div>
                                </div>
                                <br/>
                                <div class="form-group row exchange_rate">
                                    <div class="col-lg-6 form-group-sub">
                                        <label class="form-control-label">Currency<span class="required"> *</span></label>
                                        <select class="form-control" name="service[currency_id]" id="currency" required>
                                            <option value="" selected>Please Select</option>
                                            @foreach ($currencies as $currency)
                                                <option value="{{$currency->id}}">{{$currency->name_en}}</option>
                                            @endforeach
                                        </select>
                                        <span class="form-text text-muted"></span>
                                    </div>
                                    <div class="col-lg-6 form-group-sub">
                                        <label class="form-control-label">Exchange Rate<span class="required"> *</span></label>
                                        <input type="text" name="service[user_exchange_rate]" required id="exchange_rate" class="form-control money" placeholder="0" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- TODO: --}}
                        <div class="kt-section" id="import_file" style="display:none">
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-xl"></div>
                            <h3 class="kt-section__title">
                                Service Files:
                            </h3>
                            <div class="kt-section__content">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <label class="form-control-label">Upload Receipts<span class="required"> *</span></label>
                                        <input id="receipt_file" name="receipt_file" type="file" class="form-control kt_inputmask_6" placeholder="receipt_file" required>
                                    </div>
                                    {{--                                    <div class="col-lg-2">--}}
                                    {{--                                        <label class="form-control-label">Import Payment Order Items</label>--}}
                                    {{--                                        <input id="upload_file" type="file" class="form-control kt_inputmask_6" placeholder="items_file">--}}
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
                                <div class="kt_repeater_service  first_repeater">
                                    <div data-repeater-list="service_item">
                                        <div data-repeater-item="">
                                            <div class="row">
                                                <div class="col-md-2 form-group detailed_proposal_budget_id_dev">
                                                    <label>Budget Line<span class="required"> *</span>  </label><a style="cursor: pointer;float: right;" class="budget" data-toggle="modal" data-target="#exampleModal" name="info">Info</a>
                                                    <select class="form-control select2-multiple detailed_proposal_budget_id" name="detailed_proposal_budget_id" required>
                                                        <option value="">Please Select</option>
                                                    </select>
                                                    <input name="budget_id" type="text" class="form-control" hidden disabled>
                                                    <span class="form-text text-muted"></span>
                                                </div>
                                                <div class="col-md-1 form-group availability_dev">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Usable</label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <input id="availability" name="availability" type="text" class="form-control money-2 availability" placeholder="remaining" disabled>
                                                            <input name="availability_old" type="text" class="form-control availability" hidden disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 form-group">
                                                    <label>Item<span class="required"> *</span></label>
                                                    <select class="form-control select2-multiple" name="item_id" required>
                                                        <option value="">Please Select</option>
                                                        @foreach ($items as $item)
                                                            <option value="{{$item->id}}">{{$item->name_en}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="form-text text-muted"></span>
                                                </div>
                                                <div class="col-md-1 form-group">
                                                    <label class="kt-label m-label--single">Unit<span class="required"> *</span></label>
                                                    <select class="form-control select2-multiple" name="unit_id" required>
                                                        <option value="" selected>Please Select</option>
                                                        @foreach ($units as $unit)
                                                            <option value="{{$unit->id}}">{{$unit->name_en}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="form-text text-muted"></span>
                                                </div>
                                                <div class="col-md-1 form-group">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Quantity<span class="required"> *</span></label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <input id="quantity" name="quantity" type="text" class="form-control kt_inputmask_6 " onblur="getTotal(this)" placeholder="quantity" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 form-group">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Unit Cost<span class="required"> *</span></label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <input id="unit_cost" name="unit_cost" type="text" class="form-control money money-1" onblur="getTotal(this)" placeholder="unit_cost" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 form-group">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Total Cost</label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <input name="total" type="text" class="form-control money-1 total-1 total" placeholder="total cost" required readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="row">
                                                        <div class="col-md-10 form-group">
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
                                                        <div class="col-md-2 form-group pt-2 text-center">
                                                            <button type="button" data-repeater-delete="" class="btn btn-danger btn-sm btn-icon btn-circle mt-4 "><i class="la la-trash-o"></i></button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row kt-separator kt-separator--border-dashed kt-separator--space-md">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-last row">
                                        <div class="col-lg-4">
                                            <a href="javascript:;" data-repeater-create="" class="btn btn-bold btn-sm btn-label-brand disabled add">
                                                <i class="la la-plus"></i> Add
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="kt_repeater_clearance second_repeater" id="div_data" style="display: none">
                                    <div class="form-group form-group-last row">
                                        <div data-repeater-list="service_item_direct" class="col-lg-12">
                                            <div data-repeater-item="" class=" row">
                                                <div class="row col-md-12">
                                                    <div class="col-md-5 budget_line_dev detailed_proposal_budget_id_dev form-group">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label class="kt-label m-label--single">Budget Line<span class="required"> *</span></label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <select class="form-control select2-multiple budget_line detailed_proposal_budget_id" name="detailed_proposal_budget_id" required>
                                                                    <option value="" selected>Please Select</option>
                                                                </select>
                                                                <span class="form-text text-muted"></span>
                                                                <input name="budget_id" type="text" class="form-control" hidden disabled>
                                                            </div>
                                                        </div>
                                                        <div class="d-md-none kt-margin-b-10"></div>
                                                    </div>
                                                    <div class="col-md-2 availability_dev form-group">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Usable</label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <input id="availability" name="availability" value="" type="text" class="form-control money-2 availability" placeholder="remaining" disabled>
                                                                <input name="availability_old" type="text" class="form-control availability" hidden disabled>
                                                            </div>
                                                        </div>
                                                    </div>
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
                                                        <div class="input-group date">
                                                            <input type="text" name="invoice_date" class="form-control kt_datepicker_3" readonly required>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <i class="la la-calendar"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <span class="form-text text-muted"></span>

                                                    </div>
                                                    <div class="d-flex col-md-1 align-self-end flex-row-reverse ">
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
                                                                        <option value="{{$item->id}}">{{$item->name_en}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="form-text text-muted"></span>
                                                            </div>
                                                        </div>
                                                        <div class="d-md-none kt-margin-b-10"></div>
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
                                                                        <option value="{{$unit->id}}">{{$unit->name_en}}</option>
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
                                                                <input id="quantity" onblur="getTotal(this)" name="quantity" type="text" class="form-control money" placeholder="Quantity" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 form-group">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Unit Cost<span class="required"> *</span></label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <input id="unit_cost" onblur="getTotal(this)" name="unit_cost" type="text" class="form-control money" placeholder="Unit Cost" required>
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
                                                                <input name="exchange_rate" onblur="getTotal(this)" type="text" class="form-control money exchange_rate_val" placeholder="X-Rate" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 form-group">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Total Cost</label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <input name="total" type="text" class="form-control total total-2 money" placeholder="Total Cost" required readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Note</label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <textarea class="form-control" name="note" id="note" cols="30" rows="2"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-last row">
                                        <div class="col-lg-4">
                                            <a href="javascript:;" data-repeater-create="" class="btn btn-bold btn-sm btn-label-brand disabled add">
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
                                <h5 id="title_service_total">Service Total :</h5>
                                <h5 id="title_service_total_usd" style="display: none;">Service Total USD:</h5>
                                <input id="service_total" value="" name="total" readonly class="form-control money-2">
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="submit" data-ktwizard-type="action-submit" class="btn btn-sm btn-label-success btn-bold"><i class="la la-save"></i> @lang('common.save')</button>
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
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Budget Line</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead class="thead-light">
                        <tr>
                            <th>Budget</th>
                            <th>Reserve</th>
                            <th>Expense</th>
                            <th>Usable</th>
                            <th>Remaining</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr id="tr-row">

                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- end:: Content -->
@stop
@section('script')
    @include('layouts.include.script.script_jquery_form')
    {!! Html::script('assets/js/demo2/pages/crud/forms/validation/form-controls-service.js') !!}
    <script>
        $(document).on('click', `.budget`, function () {
            let tr = $('#tr-row');
            $.ajax({
                url: `/project/budget/info/${$(this).attr('id')}`,
                type: 'get',
                success: function ($data) {
                    console.log($data);
                    tr.empty();
                    tr.append(`<td class="money">${$data.total}</td><td class="money">${$data.reserve}</td><td class="money">${$data.expense}</td><td class="money">${$data.usable}</td><td class="money">${$data.remaining}</td>`);
                    $(".money").inputmask({
                        "alias": "decimal",
                        "digits": 2,
                        "autoGroup": true,
                        "allowMinus": true,
                        "rightAlign": false,
                        "groupSeparator": ",",
                        "radixPoint": ".",
                    });
                }
            });
        });
        $('#upload_file').on('change', function () {
            let file_data = $('#upload_file').prop('files')[0];
            let form_data = new FormData();
            let div_data = $('#div_data');
            let project_id = $('#project_id').val();
            let service_model = $('#service_model').val();
            form_data.append('file', file_data);
            let url;
            if (service_model == 375449) {
                url = `/clearance/mission/import-file`
            } else {
                url = `/clearance/import-file/${project_id}`
            }
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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

        function check_total() {
            let sum_2 = 0;
            let sum_budget_line_2 = 0;
            let id = '';
            let total = 0;
            $(`.import .total`).each(function () {
                id = $(this).attr('id');
                sum_budget_line_2 = 0;
                $(`.total_${id}`).each(function () {

                    if ($(this).val() != '') {
                        sum_2 += Number($(this).val());
                        sum_budget_line_2 += Number($(this).val());
                    }

                });
                if (Number($(`.availability_old_${id}`).val()) - (Number(sum_budget_line_2)) < 0) {
                    swal.fire({
                        "title": "",
                        "text": "You do not have enough money in budget Line!",
                        "type": "error",
                        "confirmButtonClass": "btn btn-secondary"
                    });
                    $(`.${id}`).val(Number($(`.availability_old_${id}`).val()));
                    $(`.total_${id}`).val(null);
                    $(`.${id}`).addClass('is-invalid');
                    $(`.total_${id}`).addClass('is-invalid');
                } else {
                    $(`.${$(this).attr('id')}`).val(Number($(`.availability_old_${id}`).val()) - Number(sum_budget_line_2));

                }
            });
            // $(`.${$(this).attr('id')}`).val(Number($(`.availability_old_${id}`).val()) - Number(sum_budget_line_2));
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
        }

        $(document).ready(function () {
            // Project or mission budget
            $("#service_model").change(function () {
                let optionValue = $(this).val();
                // if the selected was mission budget, then hide the project and budgetlines
                if (optionValue == "375449") {
                    $("#project_id_dev").hide();
                    $("#project_id").removeAttr('required');
                    $(".detailed_proposal_budget_id_dev").hide();
                    $(".availability_dev").hide();
                    $("#budget_line_hidden").val(1);
                    $(".detailed_proposal_budget_id").removeAttr('required');
                } else {
                    $("#project_id_dev").show();
                    $("#project_id").attr('required', true);
                    $(".detailed_proposal_budget_id_dev").show();
                    $("#budget_line_hidden").val(0);
                    $(".detailed_proposal_budget_id").attr('required', true);
                    $(".availability_dev").show();
                }

            });
            $("#project_id").change(function () {
                $('.detailed_proposal_budget_id').html('<option value="" selected>Please Select</option>');

                // Bringing budget lines based on the selected project
                $.get('get-budget-line/' + $('#project_id').val(), function (data) {
                    // If the current user is the project manager or one of the project officers, then show budget line
                    if (data) {
                        $(".detailed_proposal_budget_id_dev").show();
                        $("#budget_line_hidden").val(0);
                        $(".detailed_proposal_budget_id").attr('required', true);
                        $(".availability_dev").show();
                        for (let i = 0; i < data.length; i++) {
                            $('.detailed_proposal_budget_id').append('<option value="' + data[i].id + '">' + data[i].budget_line + ' - ' + data[i].name_en + '</option>');
                            $('.detailed_proposal_budget_id_hidden').append('<option value="' + data[i].id + '">' + data[i].budget_line + ' - ' + data[i].name_en + '</option>');
                        }
                        // if thr current user does not have authority on the selected project, then hide budget line
                    } else {
                        $(".detailed_proposal_budget_id_dev").hide();
                        $(".availability_dev").hide();
                        $("#budget_line_hidden").val(1);
                        $(".detailed_proposal_budget_id").removeAttr('required');
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
                // let exchange_rate = $('#exchange_rate').val();

                $(`.total_${$(this).val()}`).each(function (i) {
                    if ($(this).val() != '') {
                        console.log($(`.exchange_rate_val_${$(this).val()}:eq(${i})`).val());
                        if ($(`.exchange_rate_val_${$(this).val()}:eq(${i})`).val() == undefined) {
                            sum += Number($(this).val());
                        } else {
                            sum += Number($(this).val()) / Number($(`.exchange_rate_val_${$(this).val()}:eq(${i})`).val());
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
                document.getElementsByName('' + categoryName + '[' + num + '][info]')[0].setAttribute('id', $(this).val());
                document.getElementsByName('' + categoryName + '[' + num + '][availability]')[0].classList.add($(this).val());
                document.getElementsByName('' + categoryName + '[' + num + '][availability_old]')[0].classList.add(`availability_old_${$(this).val()}`);
                document.getElementsByName('' + categoryName + '[' + num + '][budget_id]')[0].value = $(this).val();
                $.get('/project/get-availability-budget-line/' + $(this).val(), function (data) {
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
            // If Service Type is MR, then hide service method, service receive and payment method
            $("#mr_service").change(function () {
                $("#service_method_dev").hide();
                $("#service_method").removeAttr('required');
                $("#payment_method_dev").hide();
                $("#payment_method").removeAttr('required');
                $("#service_receiver_dev").hide();
                $("#service_receiver").removeAttr('required');
                $("#payment_type_dev").hide();
                $("#payment_type_id").removeAttr('required');
                $("#bank_account_dev").hide();

                // Hide payment order element
                payment_type();
            });
            // If Service Type is PYR, then show service method, service receive and payment method
            $("#pyr_service").change(function () {
                $("#service_method_dev").show();
                $("#service_method").attr('required', true);
                $("#payment_method_dev").show();
                $("#payment_method").attr('required', true);
                $("#service_receiver_dev").show();
                $("#service_receiver").attr('required', true);
                $("#payment_type_dev").show();
                $("#payment_type_id").attr('required', true);
                $("#bank_account_dev").show();
                // See whether the paymen type is direct or not and do action based on that
                payment_type();
            });
            // If service method is logistic, then disable payment method
            $("#service_method").change(function () {
                if ($("#service_method").val() == "66893") {
                    $("#payment_method").prop("disabled", true);
                    $("#payment_method").removeAttr('required');
                    $("#service_receiver").prop("disabled", true);
                    $("#service_receiver").removeAttr('required');
                    $("#payment_type").prop("disabled", true);
                    $("#payment_type").removeAttr('required');
                    $("#bank_account").prop("disabled", true);
                } else if ($("#service_method").val() == "66892") {
                    $("#payment_method").prop("disabled", false);
                    $("#payment_method").attr('required', true);
                    $("#service_receiver").prop("disabled", false);
                    $("#service_receiver").attr('required', true);
                    $("#payment_type").prop("disabled", true);
                    $("#payment_type").removeAttr('required');
                    $("#bank_account").prop("disabled", true);
                } else {
                    $("#payment_method").prop("disabled", false);
                    $("#payment_method").attr('required', true);
                    $("#service_receiver").prop("disabled", false);
                    $("#service_receiver").attr('required', true);
                    $("#payment_type").prop("disabled", false);
                    $("#payment_type").attr('required', true);
                    $("#bank_account").prop("disabled", false);
                }
                // Bringing the receiver based on the service method
                if ($("#service_method").val()) {
                    $('#service_receiver').html('<option value="" selected>Please Select</option>');
                    $.get("getservicereceiver/" + $("#service_method").val(), function (data) {
                        for (i = 0; i < data.length; i++) {
                            $optionValue = $("#service_method").val();
                            if ($optionValue == 66894 || $optionValue == 137368 || $optionValue == 311432) {
                                $("#service_receiver").append('<option value="' + data[i].id + '">' + data[i].name_en + '</option>');
                            } else if ($optionValue == 66892) {
                                $("#service_receiver").append('<option value="' + data[i].id + '">' + data[i].first_name_en + ' ' + data[i].last_name_en + '</option>');
                            }
                        }
                    });
                }
            });
            $("#payment_method").change(function () {
                payment_type();
            });
            $("#service_receiver,#payment_type").change(function () {
                bank_account();
            });

            function bank_account() {
                $("#bank_account").html('<option value="">Please Select</option>')
                if ($("#payment_type").val() == 310675 && $("#service_receiver").val()) {
                    $("#bank_account").prop("disabled", false);
                    $("#bank_account").attr('required', true);
                    $.get("get_bank_account/" + $("#service_method").val() + "/" + $("#service_receiver").val(), function (data) {
                        if (data) {
                            for (let i = 0; i < data.length; i++) {
                                $("#bank_account").append('<option value="' + data[i].id + '">' + data[i].bank_name + ' - ' + data[i].iban + '</option>');
                            }
                        }
                    });
                } else {
                    $("#bank_account").prop("disabled", true);
                    $("#bank_account").removeAttr('required');
                }
            }

            function payment_type() {
                // if the current service is payment request
                if ($("#pyr_service").is(':checked')) {
                    // if the current payment request is direct, then show payment order details
                    if ($("#payment_method").val() == 3296) {
                        $(".first_repeater").hide();
                        $(".second_repeater").show();
                        $("#import_file").show();
                        $("#title_service_total").hide();
                        $("#title_service_total_usd").show();
                        $(".exchange_rate").hide();
                        $("#exchange_rate").val('');
                    }
                    // if the current payment request is advance, then hide payment order details
                    else {
                        $(".first_repeater").show();
                        $(".second_repeater").hide();
                        $("#import_file").hide();
                        $("#title_service_total").show();
                        $("#title_service_total_usd").hide();

                        $(".exchange_rate").show();

                        $("#exchange_rate").val('');
                    }
                }
                // if the current service is material, then hide payment order details
                else {
                    $(".first_repeater").show();
                    $(".second_repeater").hide();
                    $("#import_file").hide();
                    $("#title_service_total").show();
                    $("#title_service_total_usd").hide();

                    $(".exchange_rate").show();
                    $("#exchange_rate").val('');
                }
                $(`.total`).each(function () {

                    $(this).val(null);

                });
            }

            // If currency is USD, then make exchange rate = 1
            $("#currency").change(function () {
                $('.total').val(null);
                $('.availability').val(null);
                if ($("#currency").val() == "87034") {
                    $("#exchange_rate").val("1").prop("readonly", true);
                } else if ($("#currency").val()) {
                    $.get('getexchangerate/' + $("#currency").val(), function (data) {
                        $("#exchange_rate").val(data).prop("readonly", false);
                    });
                } else {
                    // if there is no currency selected, then reset the exchange rate value
                    $("#exchange_rate").val("").prop("readonly", false);
                }
            });
            $('.select2-multiple').select2();
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
            console.log(sum);
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
    </script>
@stop
