<div class="modal fade" id="add" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('common.sector')</h5>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('mission.management_department_sector_store')}}" id="kt_add_form"
                      class="kt-form">
                    @csrf
                    <input type="hidden" id="department_id" value="{{$id}}" name="department_id">
                    <div class="kt-portlet__body">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label>@lang('common.sector') <span class="required"  aria-required="true"> *</span></label>
                                {!! Form::select('sector_id', $sectors,0,['class' => 'form-control kt_select2_modal','id'=>'add_sector']) !!}
                                <span class="form-text text-muted"></span>
                            </div>
                        </div>

                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
                                 data-ktwizard-type="action-submit">
                                @lang('common.submit')
                            </div>
                            <div class="btn btn-danger  btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
                                 data-dismiss="modal">@lang('common.cancel')</div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
