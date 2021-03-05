@extends('layouts.worksheet.worksheet')
@section('create')
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('common.add')  @lang('url.worksheet')</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('worksheet.store')}}" id="kt_add_form" class="kt-form">
                        @csrf
                        <div class="kt-portlet__body">

                            <div class="row">
                                <div class="form-group col-xl-4">
                                    <label>@lang('common.start')  @lang('common.date')</label>
                                    <input type="text" class="form-control kt_datepicker_1_validate" id="add_start_date" required autocomplete="off" name="start_date" placeholder="@lang('common.start')  @lang('common.date')">
                                </div>
                                <div class="form-group col-xl-4">
                                    <label>@lang('common.end') @lang('common.date')</label>
                                    <input type="text" class="form-control kt_datepicker_1_validate" id="add_end_date" required name="end_date" autocomplete="off" placeholder="@lang('common.end') @lang('common.date')">
                                </div>
                                <div class="form-group col-xl-4">
                                    <label>@lang('user') <span class="required" aria-required="true"> *</span></label>
                                    {!! Form::select('user_id[]', $users,null,['class' => 'form-control  kt-selectpicker-3','id'=>'add_user','data-live-search'=>'true','data-actions-box'=>'true','multiple','required']) !!}
                                </div>
                            </div>
                            <div class="col-lg-12 kt-separator kt-separator--border-dashed kt-separator--space-sm"></div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <h6>Saturday</h6>
                                    <div class="form-group">
                                        <label>Work Status</label>
                                        {!! Form::select('saturday_work_status_id', $work_statuses,null,['class' => 'form-control','required']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('common.start') @lang('common.time') </label>
                                        <input class="form-control kt_timepicker_2"  value="" name="saturday_start_time" placeholder="Select time" type="text"/>
                                    </div>
                                    <div class="form-group">
                                    <label class="row col-lg-12">Add Day</label>
                                    <span class=" kt-switch kt-switch--icon">
                                    <label>
                                        <input  type="checkbox" value="true"   name="saturday_add_day">
                                         <span></span>
                                     </label>
                                                </span>
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('common.end') @lang('common.time') </label>
                                        <input class="form-control kt_timepicker_2"   name="saturday_end_time" placeholder="Select time" type="text"/>
                                    </div>
                                </div><div class="col-lg-3">
                                    <h6>Sunday</h6>
                                    <div class="form-group">
                                        <label>Work Status</label>
                                        {!! Form::select('sunday_work_status_id', $work_statuses,null,['class' => 'form-control','required']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('common.start') @lang('common.time') </label>
                                        <input class="form-control kt_timepicker_2"  value="" name="sunday_start_time" placeholder="Select time" type="text"/>
                                    </div>
                                    <div class="form-group">
                                    <label class="row col-lg-12">Add Day</label>
                                    <span class=" kt-switch kt-switch--icon">
                                    <label>
                                        <input  type="checkbox" value="true"   name="sunday_add_day">
                                         <span></span>
                                     </label>
                                                </span>
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('common.end') @lang('common.time') </label>
                                        <input class="form-control kt_timepicker_2"   name="sunday_end_time" placeholder="Select time" type="text"/>
                                    </div>
                                </div><div class="col-lg-3">
                                    <h6>Monday</h6>
                                    <div class="form-group">
                                        <label>Work Status</label>
                                        {!! Form::select('monday_work_status_id', $work_statuses,null,['class' => 'form-control','required']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('common.start') @lang('common.time') </label>
                                        <input class="form-control kt_timepicker_2"  value="" name="monday_start_time" placeholder="Select time" type="text"/>
                                    </div>
                                    <div class="form-group">
                                    <label class="row col-lg-12">Add Day</label>
                                    <span class=" kt-switch kt-switch--icon">
                                    <label>
                                        <input  type="checkbox" value="true"   name="monday_add_day">
                                         <span></span>
                                     </label>
                                                </span>
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('common.end') @lang('common.time') </label>
                                        <input class="form-control kt_timepicker_2"   name="monday_end_time" placeholder="Select time" type="text"/>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <h6>Tuesday</h6>
                                    <div class="form-group">
                                        <label>Work Status</label>
                                        {!! Form::select('tuesday_work_status_id', $work_statuses,null,['class' => 'form-control','required']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('common.start') @lang('common.time') </label>
                                        <input class="form-control kt_timepicker_2"  value="" name="tuesday_start_time" placeholder="Select time" type="text"/>
                                    </div>
                                    <div class="form-group">
                                    <label class="row col-lg-12">Add Day</label>
                                    <span class=" kt-switch kt-switch--icon">
                                    <label>
                                        <input  type="checkbox" value="true"   name="tuesday_add_day">
                                         <span></span>
                                     </label>
                                                </span>
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('common.end') @lang('common.time') </label>
                                        <input class="form-control kt_timepicker_2"   name="tuesday_end_time" placeholder="Select time" type="text"/>
                                    </div>
                                </div>
                                <div class="col-lg-12 kt-separator kt-separator--border-dashed  kt-separator--space-sm"></div>
                                <div class="col-lg-3">
                                    <h6>Wednesday</h6>
                                    <div class="form-group">
                                        <label>Work Status</label>
                                        {!! Form::select('wednesday_work_status_id', $work_statuses,null,['class' => 'form-control','required']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('common.start') @lang('common.time') </label>
                                        <input class="form-control kt_timepicker_2"  value="" name="wednesday_start_time" placeholder="Select time" type="text"/>
                                    </div>
                                    <div class="form-group">
                                    <label class="row col-lg-12">Add Day</label>
                                    <span class=" kt-switch kt-switch--icon">
                                    <label>
                                        <input  type="checkbox" value="true"   name="wednesday_add_day">
                                         <span></span>
                                     </label>
                                                </span>
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('common.end') @lang('common.time') </label>
                                        <input class="form-control kt_timepicker_2"   name="wednesday_end_time" placeholder="Select time" type="text"/>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <h6>Thursday</h6>
                                    <div class="form-group">
                                        <label>Work Status</label>
                                        {!! Form::select('thursday_work_status_id', $work_statuses,null,['class' => 'form-control','required']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('common.start') @lang('common.time') </label>
                                        <input class="form-control kt_timepicker_2"  value="" name="thursday_start_time" placeholder="Select time" type="text"/>
                                    </div>
                                    <div class="form-group">
                                    <label class="row col-lg-12">Add Day</label>
                                    <span class=" kt-switch kt-switch--icon">
                                    <label>
                                        <input  type="checkbox" value="true"   name="thursday_add_day">
                                         <span></span>
                                     </label>
                                                </span>
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('common.end') @lang('common.time') </label>
                                        <input class="form-control kt_timepicker_2"   name="thursday_end_time" placeholder="Select time" type="text"/>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <h6>Friday</h6>
                                    <div class="form-group">
                                        <label>Work Status</label>
                                        {!! Form::select('friday_work_status_id', $work_statuses,null,['class' => 'form-control','required']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('common.start') @lang('common.time') </label>
                                        <input class="form-control kt_timepicker_2"  value="" name="friday_start_time" placeholder="Select time" type="text"/>
                                    </div>
                                    <div class="form-group">
                                    <label class="row col-lg-12">Add Day</label>
                                    <span class=" kt-switch kt-switch--icon">
                                    <label>
                                        <input  type="checkbox" value="true"   name="friday_add_day">
                                         <span></span>
                                     </label>
                                       </span>
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('common.end') @lang('common.time') </label>
                                        <input class="form-control kt_timepicker_2"   name="friday_end_time" placeholder="Select time" type="text"/>
                                    </div>
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
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('common.edit')  @lang('url.worksheet')</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('worksheet.update',0)}}" id="kt_edit_form" class="kt-form">
                        @method('PUT')
                        @csrf
                        <input type="hidden" id="edit_id" value="" name="id">
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="form-group col-xl-4">
                                    <label>@lang('common.date')</label>
                                    <input type="text" class="form-control" disabled  autocomplete="off" id="edit_day" value="">
                                </div>
                                <div class="form-group col-xl-4">
                                    <label>@lang('user')</label>
                                    {!! Form::select('user_id', $users,null,['class' => 'form-control','id'=>'edit_user','disabled']) !!}
                                </div>
                            </div>
                            <div class="col-lg-12 kt-separator kt-separator--border-dashed kt-separator--space-sm"></div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <h6 id="edit_name_day"></h6>
                                    <div class="form-group">
                                        <label>@lang('common.start') @lang('common.time') </label>
                                        <input class="form-control kt_timepicker_2_1_modal"  value="" id="edit_start_time" name="start_time" placeholder="Select time" type="text"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="row col-lg-12">Add Day</label>
                                        <span class=" kt-switch kt-switch--icon">
                                    <label>
                                        <input  type="checkbox" value="true"  id="edit_add_day"  name="add_day">
                                         <span></span>
                                     </label>
                                     </span>
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('common.end') @lang('common.time') </label>
                                        <input class="form-control kt_timepicker_2_1_modal" id="edit_end_time"  name="end_time" placeholder="Select time" type="text"/>
                                    </div>
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
