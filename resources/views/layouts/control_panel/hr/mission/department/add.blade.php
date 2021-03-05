<div class="modal fade" id="add"  role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('common.department')</h5>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('mission.management_department_store')}}" id="kt_add_form" class="kt-form">
                    @csrf
                    <input type="hidden" id="mission_id" value="{{$mission->id}}" name="mission_id">
                    <div class="kt-portlet__body">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label>@lang('common.department') <span class="required" aria-required="true"> *</span></label>
                                {!! Form::select('department_id', $departments,null,['class' => 'form-control kt_select2_modal','id'=>'add_department_id']) !!}
                                <span class="form-text text-muted"></span>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>@lang('common.parent') <span class="required" aria-required="true"> *</span></label>
                                {!! Form::select('parent_id', $departments,null,['class' => 'form-control kt_select2_modal','id'=>'add_parent_id']) !!}
                                <span class="form-text text-muted"></span>
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-xl-6">
                                <label>@lang('common.start')  @lang('common.date')  <span class="required" aria-required="true"> *</span></label>
                                <input type="text" class="form-control kt_datepicker_1_validate" id="add_start_date" autocomplete="off" name="start_date" placeholder="@lang('common.start')  @lang('common.date')">
                            </div>
                            <div class="form-group col-xl-6">
                                <label>@lang('common.end') @lang('common.date')</label>
                                <input type="text" class="form-control kt_datepicker_1_validate" id="add_end_date" name="end_date" autocomplete="off" placeholder="@lang('common.end') @lang('common.date')">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label>@lang('common.active')  <span class="required" aria-required="true"> *</span></label>
                                <span class=" col-xl-12 kt-switch kt-switch--icon">
															<label>
																<input type="checkbox" checked id="add_status" name="status">
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
