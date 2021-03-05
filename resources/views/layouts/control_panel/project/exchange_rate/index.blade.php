@extends('layouts.control_panel.project.exchange_rate.list')
@section('create')
    <div class="modal fade" id="add" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('url.exchange-rate')</h5>
                </div>
                <div class="modal-body">
                    <form  method="POST" action="{{route('exchange-rate.store')}}"   id="kt_add_form" class="kt-form">
                        @csrf
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label>Mission <span class="required" aria-required="true"> *</span></label>
                                    {!! Form::select('mission_id', $missions,null,['class' => 'form-control kt_select2_modal','required','id'=>'add_mission_id']) !!}
                                    <span class="form-text text-muted"></span>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Currency<span class="required" aria-required="true"> *</span></label>
                                    {!! Form::select('currency_id', $currencies,null,['class' => 'form-control  kt_select2_modal','required','id'=>'add_currency_id']) !!}
                                    <span class="form-text text-muted"></span>
                                </div>
                            </div>
                            <div class="row">
                                    <div class="form-group col-xl-6">
                                        <label>Due Date<span class="required" aria-required="true"> *</span></label>
                                        <input type="text" required class="form-control kt_datepicker_1_validate" id="add_due_date" name="due_date" placeholder="Due Date">
                                    </div>
                                    <div class="form-group col-xl-6">
                                        <label>Exchange Rate<span class="required" aria-required="true"> *</span></label>
                                        <input type="text" required class="form-control number_mask" name="exchange_rate"  id="add_exchange_rate" placeholder="Exchange Rate">
                                    </div>
                            </div>
                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <div class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-submit">
                                    @lang('common.submit')
                                </div>
                                <div class="btn btn-danger  btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-dismiss="modal">@lang('common.cancel')</div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('edit')
    <div class="modal fade" id="edit" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('common.edit') @lang('url.exchange-rate')</h5>
                </div>
                <div class="modal-body">
                    <form  method="POST" action="{{route('exchange-rate.update',0)}}"   id="kt_edit_form" class="kt-form">
                        @method('PUT')
                        @csrf
                        <input type="hidden" id="edit_id" value=""  name="id">
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label>Mission <span class="required" aria-required="true"> *</span></label>
                                    {!! Form::select('mission_id', $missions,null,['class' => 'form-control kt_select2_modal','required','id'=>'edit_mission_id']) !!}
                                    <span class="form-text text-muted"></span>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Currency<span class="required" aria-required="true"> *</span></label>
                                    {!! Form::select('currency_id', $currencies,null,['class' => 'form-control  kt_select2_modal','required','id'=>'edit_currency_id']) !!}
                                    <span class="form-text text-muted"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xl-6">
                                    <label>Due Date<span class="required" aria-required="true"> *</span></label>
                                    <input type="text" required class="form-control kt_datepicker_1_validate" id="edit_due_date" name="due_date" placeholder="Due Date">
                                </div>
                                <div class="form-group col-xl-6">
                                    <label>Exchange Rate<span class="required" aria-required="true"> *</span></label>
                                    <input type="text" required class="form-control number_mask" name="exchange_rate"  id="edit_exchange_rate" placeholder="Exchange Rate">
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <button class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"  data-ktwizard-type="action-submit">@lang('common.submit')</button>
                                <button class="btn btn-danger  btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-dismiss="modal">@lang('common.cancel')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
