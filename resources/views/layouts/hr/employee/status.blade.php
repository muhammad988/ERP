<div class="modal fade" id="active" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('common.status')</h5>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('employee.status_update')}}" id="kt_active_form" class="kt-form">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="active_id" value="" name="id">

                    <div class="kt-portlet__body">

                        <div class="row">

                            <div class="form-group col-lg-3">
                                <label>@lang('common.status') <span class="required" aria-required="true"> *</span></label>
                                <span class=" col-xl-12 kt-switch kt-switch--icon">
															<label>
																<input type="checkbox" disabled checked value="0" name="status">
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
<div class="modal fade" id="inactive" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('common.status')</h5>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('employee.status_update')}}" id="kt_inactive_form" class="kt-form">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="inactive_id" value="" name="id">
                    <div class="alert alert-warning alert-bold collapse  kt-margin-t-20 kt-margin-b-40" role="alert">
                        <div class="alert-icon"><i class="fa fa-exclamation-triangle"></i></div>
                        <div class="alert-text">There are <span id="count"></span> candidates for this user ..!!<br>Choose someone else to take them</div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="la la-close"></i></span>
                            </button>
                        </div>
                    </div>
                    <div class="kt-portlet__body">

                        <div class="row" id="div-superior">
                            <div class="form-group col-lg-4">
                                <label>@lang('common.mission') <span class="required" aria-required="true"> *</span></label>
                                {!! Form::select('mission_id', [''=>trans('common.please_select')]+$missions,null,['class' => 'form-control select2 ','id'=>'mission_status']) !!}
                                <span class="form-text text-muted"></span>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>@lang('hr.department') <span class="required" aria-required="true"> *</span></label>
                                {!! Form::select('department_id', [''=>trans('common.please_select')],null,['class' => 'form-control select2 ','id'=>'department_status']) !!}
                                <span class="form-text text-muted"></span>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>@lang('hr.superior') <span class="required" aria-required="true"> *</span></label>
                                {!! Form::select('parent_id', [''=>trans('common.please_select')]+$superior ,null,['class' => 'form-control select2 superior','id'=>'superior_status']) !!}
                                <span class="form-text text-muted"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-2">
                                <label>@lang('common.status') <span class="required" aria-required="true"> *</span></label>
                                <span class=" col-xl-12 kt-switch kt-switch--icon">
								    <label>
								        <input type="checkbox" disabled name="status">
								        <span></span>
								    </label>
								</span>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>@lang('common.date') <span class="required" aria-required="true"> *</span></label>
                                    <input type="text" class="form-control kt_datepicker_1_validate" name="disable_date" id="disable_date" placeholder="@lang('common.date') " value="">
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
