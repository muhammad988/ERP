@extends('layouts.authority.authority')
@section('create')
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('common.add')  @lang('authority.authority')</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('authority.store')}}" id="kt_add_form" class="kt-form">
                        @csrf
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="form-group col-xl-4">
                                    <label>@lang('authority.role')<span class="required" aria-required="true"> *</span></label>
                                    {!! Form::select('role_id', $roles,null,['class' => 'form-control kt-selectpicker','data-live-search'=>'true']) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xl-4">
                                    <label>@lang('common.mission')</label>
                                    {!! Form::select('mission_id', $missions,null,['class' => 'form-control kt-selectpicker','id'=>'add_mission','data-live-search'=>'true','data-actions-box'=>'true','multiple']) !!}
                                </div>
                                <div class="form-group col-xl-4">
                                    <label>@lang('common.department')</label>
                                    {!! Form::select('department_id', $departments,null,['class' => 'form-control  kt-selectpicker','id'=>'add_department','data-live-search'=>'true','data-actions-box'=>'true','multiple']) !!}
                                </div>
                                <div class="form-group col-xl-4">
                                    <label>@lang('project.project')</label>
                                    {!! Form::select('project_id', $projects,null,['class' => 'form-control  kt-selectpicker','id'=>'add_project','data-live-search'=>'true','data-actions-box'=>'true','multiple']) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xl-4">
                                    <label>@lang('common.mission')</label>
                                    {!! Form::select('mission_id', $missions,null,['class' => 'form-control kt-selectpicker','id'=>'add_mission_for_user','data-live-search'=>'true']) !!}
                                </div>
                                <div class="form-group col-xl-4">
                                    <label>@lang('common.department')</label>
                                    {!! Form::select('department_id', $departments,null,['class' => 'form-control  kt-selectpicker','id'=>'add_department_for_user','data-live-search'=>'true']) !!}
                                </div>
                                <div class="form-group col-xl-4">
                                    <label>@lang('user') <span class="required" aria-required="true"> *</span></label>
                                    {!! Form::select('user_id[]', $users,null,['class' => 'form-control  kt-selectpicker','id'=>'add_user','data-live-search'=>'true','data-actions-box'=>'true','multiple']) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-2">
                                    <label>@lang('common.view')</label>
                                    <span class=" col-xl-12 kt-switch kt-switch--icon">
                                            															<label>
                                            																<input type="checkbox" value="true" id="add_view" checked="checked" name="view">
                                            																<span></span>
                                            															</label>
                                            														</span>
                                </div>
                                <div class="form-group col-lg-2">
                                    <label>@lang('common.add')</label>
                                    <span class=" col-xl-12 kt-switch kt-switch--icon">
                                            															<label>
                                            																<input type="checkbox" value="true" id="add_add" checked="checked" name="add">
                                            																<span></span>
                                            															</label>
                                            														</span>
                                </div>
                                <div class="form-group col-lg-2">
                                    <label>@lang('common.update')</label>
                                    <span class=" col-xl-12 kt-switch kt-switch--icon">
                                            															<label>
                                            																<input type="checkbox" value="true" id="add_update" checked="checked" name="update">
                                            																<span></span>
                                            															</label>
                                            														</span>
                                </div>
                                <div class="form-group col-lg-2">
                                    <label>@lang('common.disable')</label>
                                    <span class=" col-xl-12 kt-switch kt-switch--icon">
                                            															<label>
                                            																<input type="checkbox" value="true" id="add_disable" checked="checked" name="disable">
                                            																<span></span>
                                            															</label>
                                            														</span>
                                </div>

                                <div class="form-group col-lg-2">
                                    <label>@lang('common.delete')</label>
                                    <span class=" col-xl-12 kt-switch kt-switch--icon">
                                            															<label>
                                            																<input type="checkbox" value="true" id="add_delete" checked="checked" name="delete">
                                            																<span></span>
                                            															</label>
                                            														</span>
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
                    <h5 class="modal-title" id="exampleModalLabel">@lang('common.edit')  @lang('authority.authority')</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('authority.update',0)}}" id="kt_edit_form" class="kt-form">
                        @method('PUT')
                        @csrf
                        <input type="hidden" id="edit_id" value="" name="id">
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="form-group col-xl-4">
                                    <label>@lang('authority.role')<span class="required" aria-required="true"> *</span></label>
                                    {!! Form::select('role_id', $roles,null,['class' => 'form-control kt_select2_modal','id'=>'edit_role']) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xl-4">
                                    <label>@lang('common.mission')</label>
                                    {!! Form::select('mission_id', $missions,null,['class' => 'form-control kt_select2_modal','id'=>'edit_mission']) !!}
                                </div>
                                <div class="form-group col-xl-4">
                                    <label>@lang('common.department')</label>
                                    {!! Form::select('department_id', $departments,null,['class' => 'form-control  kt_select2_modal','id'=>'edit_department']) !!}
                                </div>
                                <div class="form-group col-xl-4">
                                    <label>@lang('project.project')</label>
                                    {!! Form::select('project_id', $projects,null,['class' => 'form-control  kt_select2_modal','id'=>'edit_project']) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xl-4">
                                    <label>@lang('common.mission')</label>
                                    {!! Form::select('mission_id', $missions,null,['class' => 'form-control kt_select2_modal','id'=>'edit_mission_for_user']) !!}
                                </div>
                                <div class="form-group col-xl-4">
                                    <label>@lang('common.department')</label>
                                    {!! Form::select('department_id', $departments,null,['class' => 'form-control  kt_select2_modal','id'=>'edit_department_for_user']) !!}
                                </div>
                                <div class="form-group col-xl-4">
                                    <label>@lang('user') <span class="required" aria-required="true"> *</span></label>
                                    {!! Form::select('user_id', $users,null,['class' => 'form-control  kt_select2_modal','id'=>'edit_user']) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-2">
                                    <label>@lang('common.view')</label>
                                    <span class=" col-xl-12 kt-switch kt-switch--icon">
                                            															<label>
                                            																<input type="checkbox" value="true" id="edit_view" checked="checked" name="view">
                                            																<span></span>
                                            															</label>
                                            														</span>
                                </div>
                                <div class="form-group col-lg-2">
                                    <label>@lang('common.add')</label>
                                    <span class=" col-xl-12 kt-switch kt-switch--icon">
                                            															<label>
                                            																<input type="checkbox" value="true" id="edit_add" checked="checked" name="add">
                                            																<span></span>
                                            															</label>
                                            														</span>
                                </div>
                                <div class="form-group col-lg-2">
                                    <label>@lang('common.update')</label>
                                    <span class=" col-xl-12 kt-switch kt-switch--icon">
                                            															<label>
                                            																<input type="checkbox" value="true" id="edit_update" checked="checked" name="update">
                                            																<span></span>
                                            															</label>
                                            														</span>
                                </div>
                                <div class="form-group col-lg-2">
                                    <label>@lang('common.disable')</label>
                                    <span class=" col-xl-12 kt-switch kt-switch--icon">
                                            															<label>
                                            																<input type="checkbox" value="true" id="edit_disable" checked="checked" name="disable">
                                            																<span></span>
                                            															</label>
                                            														</span>
                                </div>

                                <div class="form-group col-lg-2">
                                    <label>@lang('common.delete')</label>
                                    <span class=" col-xl-12 kt-switch kt-switch--icon">
                                            															<label>
                                            																<input type="checkbox" value="true" id="edit_delete" checked="checked" name="delete">
                                            																<span></span>
                                            															</label>
                                            														</span>
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
