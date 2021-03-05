@extends('layouts.hr.fingerprint.fingerprint_user.fingerprint')
@section('create')
    <div class="modal fade" id="add" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('url.fingerprint')</h5>
                </div>
                <div class="modal-body">
                    <form  method="POST" action="{{route('fingerprint.store')}}"   id="kt_add_form" class="kt-form">
                        @csrf
                        <input hidden name="id" value="{{$id}}">
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="form-group col-xl-3">
                                    <label>@lang('common.start')  @lang('common.date')</label>
                                    <input type="text" class="form-control kt_datepicker_1_validate" name="day" required  autocomplete="off" id="add_day" value="">
                                </div>
                                <div class="form-group  col-xl-3">
                                    <label>@lang('common.start') @lang('common.time') </label>
                                    <input class="form-control kt_timepicker_2" required  value="" id="add_time" name="time" placeholder="Select time" type="text"/>
                                </div>
                                <div class="form-group  col-xl-3">
                                    <label>Status  </label>
                                    {!! Form::select('state', [''=>'Please Select','Check in'=>'Check in','Check out'=>'Check out'],null,[ 'id'=>"add_state",'class' => 'form-control','required']) !!}
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
                    <h5 class="modal-title" id="exampleModalLabel">@lang('common.edit')  @lang('url.fingerprint')</h5>
                </div>
                <div class="modal-body">
                    <form  method="POST" action="{{route('fingerprint.update',0)}}"   id="kt_edit_form" class="kt-form">
                        @method('PUT')
                        @csrf
                        <input type="hidden" id="edit_id" value=""  name="id">
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="form-group col-xl-3">
                                    <label>@lang('common.start')  @lang('common.date')</label>
                                    <input type="text" class="form-control kt_datepicker_1_validate" name="day" required  autocomplete="off" id="edit_day" value="">
                                </div>
                                <div class="form-group  col-xl-3">
                                    <label>@lang('common.start') @lang('common.time') </label>
                                    <input class="form-control kt_timepicker_2_1_modal" required  value="" id="edit_time" name="time" autocomplete="off" placeholder="Select time" type="text"/>
                                </div>
                                <div class="form-group  col-xl-3">
                                    <label>Status  </label>
                                    {!! Form::select('state', [''=>'Please Select','Check in'=>'Check in','Check out'=>'Check out'],null,[ 'id'=>"edit_state",'class' => 'form-control','required']) !!}
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
