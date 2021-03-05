<div class="modal fade" id="edit"  role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('common.department')</h5>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('mission.management_department_update',0)}}" id="kt_edit_form" class="kt-form">
                    @method('PUT')
                    @csrf
                    <input type="hidden" id="id" value="" name="id">
                    <input type="hidden" id="mission_id" value="{{$mission->id}}" name="mission_id">
                    <div class="kt-portlet__body">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label>@lang('common.department') <span class="required" aria-required="true"> *</span></label>
                                {!! Form::select('department_id', $departments,null,['class' => 'form-control  kt_select2_modal','id'=>'edit_department_id']) !!}
                                <span class="form-text text-muted"></span>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>@lang('common.parent') <span class="required" aria-required="true"> *</span></label>
                                {!! Form::select('parent_id', $departments,null,['class' => 'form-control kt_select2_modal','id'=>'edit_parent_id']) !!}
                                <span class="form-text text-muted"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xl-6">
                                <label>@lang('common.start')  @lang('common.date')<span class="required" aria-required="true"> *</span></label>
                                <input type="text" class="form-control kt_datepicker_1_validate" id="edit_start_date" autocomplete="off" name="start_date" placeholder="@lang('common.start')  @lang('common.date')">
                            </div>
                            <div class="form-group col-xl-6">
                                <label>@lang('common.end') @lang('common.date')</label>
                                <input type="text" class="form-control kt_datepicker_1_validate" id="edit_end_date" name="end_date" autocomplete="off" placeholder="@lang('common.end') @lang('common.date')">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label>@lang('common.active')  <span class="required" aria-required="true"> *</span></label>
                                <span class=" col-xl-12 kt-switch kt-switch--icon">
															<label>
																<input type="checkbox" checked id="edit_status" name="status">
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



