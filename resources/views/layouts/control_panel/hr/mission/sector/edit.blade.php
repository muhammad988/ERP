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
                    <input type="hidden" id="department_id" value="{{$id}}" name="department_id">
                    <div class="kt-portlet__body">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label>@lang('common.mission') <span class="required" aria-required="true"> *</span></label>
                                {!! Form::select('sector_id', $sectors,null,['class' => 'form-control kt_select2_modal','id'=>'edit_sector','multiple']) !!}
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



