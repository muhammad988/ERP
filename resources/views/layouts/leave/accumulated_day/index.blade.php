@extends('layouts.leave.accumulated_day.accumulated_day')
@section('create')
    <div class="modal fade" id="add" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('url.accumulated-day')</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('accumulated-day.store')}}" id="kt_add_form" class="kt-form">
                        @csrf
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="form-group col-xl-4">
                                    <label>Employee Name<span class="required" aria-required="true"> *</span></label>
                                    {!! Form::select('user_id', $users,null,['class' => 'form-control kt_select2_modal','id'=>'add-user-id']) !!}
                                    <span class="form-text text-muted"></span>
                                </div>
                                <div class="form-group col-xl-4">
                                    <label>Year<span class="required" aria-required="true"> *</span></label>
                                    {{ Form::selectYear('year', \Carbon\Carbon::now()->subYear(1)->year, \Carbon\Carbon::now()->addYear(1)->year, null, ['placeholder' => 'Please select ...',"class"=>"form-control",'required']) }}
                                </div>
                                <div class="form-group col-xl-4">
                                    <label>Number Of Days<span class="required" aria-required="true"> *</span></label>
                                    <input type="text" class="form-control " name="number_of_days" id="add-number-of-days" required  placeholder="0">
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
    <div class="modal fade" id="edit" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('common.edit') @lang('url.accumulated-day')</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('accumulated-day.update',0)}}" id="kt_edit_form" class="kt-form">
                        @method('PUT')
                        @csrf
                        <input type="hidden" id="edit-id" value="" name="id">
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="form-group col-xl-4">
                                    <label>Employee Name<span class="required" aria-required="true"> *</span></label>
                                    {!! Form::select('user_id', $users,null,['class' => 'form-control kt_select2_modal','id'=>'edit-user-id']) !!}
                                    <span class="form-text text-muted"></span>
                                </div>
                                <div class="form-group col-xl-4">
                                    <label>Year<span class="required" aria-required="true"> *</span></label>
                                    {{ Form::selectYear('year', \Carbon\Carbon::now()->subYear(1)->year, \Carbon\Carbon::now()->addYear(1)->year, null, ['placeholder' => 'Please select ...',"class"=>"form-control","id"=>"edit-year",'required']) }}
                                </div>
                                <div class="form-group col-xl-4">
                                    <label>Number Of Days<span class="required" aria-required="true"> *</span></label>
                                    <input type="text" class="form-control " name="number_of_days" id="edit-number-of-days" required  placeholder="0">
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <button class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-submit">@lang('common.submit')</button>
                                <button class="btn btn-danger  btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-dismiss="modal">@lang('common.cancel')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
