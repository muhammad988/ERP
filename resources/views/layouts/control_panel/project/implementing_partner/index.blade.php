@extends('layouts.control_panel.project.implementing_partner.implementing_partner')
@section('create')

    <div class="modal fade" id="add" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('url.implementing-partner')</h5>
                </div>
                <div class="modal-body">
                    <form  method="POST" action="{{route('implementing-partner.store')}}"   id="kt_add_form" class="kt-form">
                        @csrf
                        <div class="kt-portlet__body">
                            <div class="row">
                                    <div class="form-group col-xl-6">
                                        <label>@lang('common.name') EN<span class="required" aria-required="true"> *</span></label>
                                        <input type="text" class="form-control test" required id="add_name_en" name="name_en" placeholder = "@lang('common.name') EN">
                                    </div>
                                    <div class="form-group col-xl-6">
                                        <label>@lang('common.name') AR<span class="required" aria-required="true"> *</span></label>
                                        <input type="text" class="form-control" id="add_name_ar" required name="name_ar" placeholder="@lang('common.name') AR">
                                    </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label>@lang('hr.phone') @lang('common.number')</label>
                                    <input type="text" class="form-control phone_mask" id="add_phone_number" required name="phone_number" placeholder="@lang('hr.phone') @lang('common.number')">
                                </div>
                                    <div class="form-group col-xl-6">
                                        <label>@lang('hr.email') <span class="required" aria-required="true"> *</span></label>
                                        <input type="text" class="form-control mask_email" name="email" required id="add_email" placeholder="@lang('hr.email')" im-insert="true">
                                    </div>
                            </div>
                            <div class="row">
                                    <div  class="kt_repeater_2 col-xl-12">
                                       <div data-repeater-list="account" class="add_account">
                                                    <div data-repeater-item class=" row kt-margin-b-10 align-items-center">
                                                        <div class="form-group col-lg-3">
                                                            <label>Bank Name<span class="required" aria-required="true"> *</span></label>
                                                            <input type="text" class="form-control" required id="bank_name" name="bank_name" placeholder="Bank Name">
                                                        </div>
                                                        <div class="form-group col-lg-3">
                                                            <label>Account Name<span class="required" aria-required="true"> *</span></label>
                                                            <input type="text" class="form-control" required id="account_name" name="account_name" placeholder="Account Name">
                                                        </div>
                                                        <div class="form-group col-lg-5">
                                                            <label>IBAN<span class="required" aria-required="true"> *</span></label>
                                                            <input type="text" class="form-control" required id="iban" name="iban" placeholder="IBAN">
                                                        </div>
                                                        <div class="col-lg-1">
                                                            <button type="button" data-repeater-delete="" class="btn btn-danger btn-sm btn-icon btn-circle"><i class="la la-trash-o"></i></button>
                                                        </div>
                                                    </div>
                                            </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div data-repeater-create="" class="add btn btn btn-primary">
																	<span>
																		<i class="la la-plus"></i>
																		<span>Add</span>
																	</span>
                                                </div>
                                            </div>
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
    <div class="modal fade" id="edit" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('common.edit') @lang('url.implementing-partner')</h5>
                </div>
                <div class="modal-body">
                    <form  method="POST" action="{{route('implementing-partner.update',0)}}"   id="kt_edit_form" class="kt-form">
                        @method('PUT')
                        @csrf
                        <input type="hidden" id="edit_id" value=""  name="id">
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="form-group col-xl-6">
                                    <label>@lang('common.name') EN<span class="required" aria-required="true"> *</span></label>
                                    <input type="text" class="form-control test" required id="edit_name_en" name="name_en" placeholder = "@lang('common.name') EN">
                                </div>
                                <div class="form-group col-xl-6">
                                    <label>@lang('common.name') AR<span class="required" aria-required="true"> *</span></label>
                                    <input type="text" class="form-control" id="edit_name_ar" required name="name_ar" placeholder="@lang('common.name') AR">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label>@lang('hr.phone') @lang('common.number')</label>
                                    <input type="text" class="form-control phone_mask " required id="edit_phone_number" name="phone_number" placeholder="@lang('hr.phone') @lang('common.number')">
                                </div>
                                <div class="form-group col-xl-6">
                                    <label>@lang('hr.email') <span class="required" aria-required="true"> *</span></label>
                                    <input type="text" class="form-control  mask_email" required name="email" id="edit_email" placeholder="@lang('hr.email')" im-insert="true">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 kt_repeater_2">
                                    <div data-repeater-list="account" class="edit_account">
                                        <div data-repeater-item class=" row kt-margin-b-10 align-items-center">
                                            <div class="form-group col-lg-3">
                                                <label>Bank Name<span class="required" aria-required="true"> *</span></label>
                                                <input type="text" class="form-control" required id="bank_name" name="bank_name" placeholder="Bank Name">
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>Account Name<span class="required" aria-required="true"> *</span></label>
                                                <input type="text" class="form-control" required id="account_name" name="account_name" placeholder="Account Name">
                                            </div>
                                            <div class="form-group col-lg-5">
                                                <label>IBAN<span class="required" aria-required="true"> *</span></label>
                                                <input type="text" class="form-control" required id="iban" name="iban" placeholder="IBAN">
                                            </div>
                                            <div class="col-lg-1">
                                                <button type="button" data-repeater-delete="" class="btn btn-danger btn-sm btn-icon btn-circle"><i class="la la-trash-o"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div data-repeater-create="" class="add btn btn btn-primary">
																	<span>
																		<i class="la la-plus"></i>
																		<span>Add</span>
																	</span>
                                            </div>
                                        </div>
                                    </div>
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
