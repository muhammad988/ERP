@extends('layouts.control_panel.hr.type_of_contract.type_of_contract')

@section('create_type_of_contract')
    <div class="modal fade" id="add" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('common.type_of_contract')</h5>
                </div>
                <div class="modal-body">
                    <form  method="POST" action="{{route('type-of-contract.store')}}"   id="kt_add_form" class="kt-form">
                        @csrf
                        <div class="kt-portlet__body">
                            <div class="row">
                                    <div class="form-group col-xl-6">
                                        <label>@lang('common.name') EN<span class="required" aria-required="true"> *</span></label>
                                        <input type="text" class="form-control test"  id="add_name_en" name="name_en" placeholder="@lang('common.name') EN">
                                    </div>
                                    <div class="form-group col-xl-6">
                                        <label>@lang('common.name') AR<span class="required" aria-required="true"> *</span></label>
                                        <input type="text" class="form-control" id="add_name_ar" name="name_ar" placeholder="@lang('common.name') AR">
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

@section('edit_type_of_contract')
    <div class="modal fade" id="edit" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('common.edit')  @lang('common.type_of_contract')</h5>
                </div>
                <div class="modal-body">
                    <form  method="POST" action="{{route('type-of-contract.update',0)}}"   id="kt_edit_form" class="kt-form">
                        @method('PUT')
                        @csrf
                        <input type="hidden" id="edit_id" value=""  name="id">
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
