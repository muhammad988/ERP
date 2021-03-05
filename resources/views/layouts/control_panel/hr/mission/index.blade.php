@extends('layouts.control_panel.hr.mission.mission')
@section('create_mission')
    <div class="modal fade" id="add_mission"  role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('common.mission')</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('mission.store')}}" id="kt_add_form" class="kt-form">
                        @csrf
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="form-group col-xl-6">
                                    <label>@lang('common.name') <span class="required" aria-required="true"> *</span></label>
                                    <input type="text" class="form-control test" id="add_name_en" name="name_en" placeholder="@lang('common.name') EN">
                                </div>
                                <div class="form-group col-xl-6">
                                    <label>@lang('common.name') <span class="required" aria-required="true"> *</span></label>
                                    <input type="text" class="form-control" id="add_name_ar" name="name_ar" placeholder="@lang('common.name') AR">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xl-6">
                                    <label>@lang('common.start')  @lang('common.date')</label>
                                    <input type="text" class="form-control kt_datepicker_1_validate" id="add_start_date" autocomplete="off" name="start_date" placeholder="@lang('common.start')  @lang('common.date')">
                                </div>
                                <div class="form-group col-xl-6">
                                    <label>@lang('common.end') @lang('common.date')</label>
                                    <input type="text" class="form-control kt_datepicker_1_validate" id="add_end_date" name="end_date" autocomplete="off" placeholder="@lang('common.end') @lang('common.date')">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label>@lang('common.mission') <span class="required" aria-required="true"> *</span></label>
                                    {!! Form::select('parent_id', $missions,null,['class' => 'form-control select2','id'=>'add_parent_id']) !!}
                                    <span class="form-text text-muted"></span>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>@lang('common.organisation_unit') </label>
                                    {!! Form::select('organisation_unit_id', $organisation_unit,null,['class' => 'form-control kt_select2_modal','id'=>'add_organisation_unit_id']) !!}
                                    <span class="form-text text-muted"></span>
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

@section('edit_mission')
    <div class="modal fade" id="edit_mission"  role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('common.edit') @lang('common.new') @lang('common.mission')</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('mission.update',0)}}" id="kt_edit_form" class="kt-form">
                        @method('PUT')
                        @csrf
                        <input type="hidden" id="edit_id" value="" name="id">
                        <div class="kt-portlet__body">
                            <div class="row">
                                    <div class="form-group col-xl-6">
                                        <label>@lang('common.name') <span class="required" aria-required="true"> *</span></label>
                                        <input type="text" id="edit_name_en" class="form-control" name="name_en" placeholder="@lang('common.name') EN">
                                    </div>
                                    <div class="form-group col-xl-6">
                                        <label>@lang('common.name') <span class="required" aria-required="true"> *</span></label>
                                        <input type="text" id="edit_name_ar" class="form-control" name="name_ar" placeholder="@lang('common.name') AR">
                                    </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xl-6">
                                    <label>@lang('common.start')  @lang('common.date')</label>
                                    <input type="text" class="form-control kt_datepicker_1_validate" id="edit_start_date" autocomplete="off" name="start_date" placeholder="@lang('common.start')  @lang('common.date')">
                                </div>
                                <div class="form-group col-xl-6">
                                    <label>@lang('common.end') @lang('common.date')</label>
                                    <input type="text" class="form-control kt_datepicker_1_validate" id="edit_end_date" name="end_date" autocomplete="off" placeholder="@lang('common.end') @lang('common.date')">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label>@lang('common.mission') <span class="required" aria-required="true"> *</span></label>
                                    {!! Form::select('parent_id', $missions,null,['class' => 'form-control kt_select2_modal','id'=>'edit_parent_id']) !!}
                                    <span class="form-text text-muted"></span>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>@lang('common.organisation_unit') </label>
                                    {!! Form::select('organisation_unit_id', $organisation_unit,null,['class' => 'form-control kt_select2_modal','id'=>'edit_organisation_unit_id']) !!}
                                    <span class="form-text text-muted"></span>
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
