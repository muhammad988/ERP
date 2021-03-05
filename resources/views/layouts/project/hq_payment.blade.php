@extends('layouts.app')
@section('style')
    @include('layouts.include.style.style_form')
@stop
@section('content')
    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h1 class="kt-portlet__head-title">
                        HQ payments
                    </h1>
                </div>
            </div>
            <!--begin::Form-->
            <form method="POST" action="{{route('project.hq_payment_store_or_update')}}"
                  class="kt-form kt-form--label-right" id="kt_form_2">
                @csrf
                <input value="{{$project->id}}" hidden name="project_id">
                <div class="kt-portlet__body">
                    <div class="kt-section">
                        <h3 class="kt-section__title">
                            Project Information:
                        </h3>
                        <div class="kt-section__content">
                            <div class="form-group form-group-last">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td style="width: 50%"><b>Project Name
                                                EN:</b>&nbsp;&nbsp;{{$project->name_en}}</td>
                                        <td><b>Project Name AR:</b>&nbsp;&nbsp;{{$project->name_ar}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Project Code:</b>&nbsp;&nbsp;{{$project->code}}</td>
                                        <td><b>Project Budget:</b>&nbsp;&nbsp;<span
                                                class="money">{{$project->project_budget}}</span></td>
                                    </tr>
                                    <tr>
                                        <td><b>Total HQ Payments:</b>&nbsp;&nbsp;<span
                                                class="money">{{$project->project_accounts_payments->sum('amount')}}</span>
                                        </td>
                                        <td><b>Total Refunds:</b>&nbsp;&nbsp;<span
                                                class="money">{{$project->project_accounts_refunds->sum('refund')}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Remaining of HQ payments:</b>&nbsp;&nbsp;<span
                                                class="money">{{$project->project_accounts_payments->sum('amount') - $project->project_accounts_refunds->sum('refund')}}</span>
                                        </td>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

                                <div class="form-text text-muted"></div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                    <div class="kt-section">
                        <div class="row">
                            <div class="col-lg-6">
                                <h3 class="kt-section__title">
                                    HQ Payments
                                </h3>
                            </div>
                            <div class=" col-lg-6">
                                <h3 class="kt-section__title">
                                    HQ Refunds
                                </h3>
                            </div>
                        </div>
                        <div class="kt-section__content">
                            <div class="row">
                                <div class="form-group form-group-last  col-lg-6 kt_repeater_hq_payment">
                                    <div data-repeater-list="payments">
                                        <div data-repeater-item=""  class="form-group row empty-div">
                                            <div class="col-md-5" id="availability_dev">
                                                <div class="kt-form__group--inline">
                                                    <div class="kt-form__label">
                                                        <label>Payment Amount</label>
                                                    </div>
                                                    <div class="kt-form__control form-group-sub">
                                                        <input name="amount" onchange="" type="text"
                                                               required
                                                               class="form-control money refund"
                                                               placeholder="Payment Amount">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="kt-form__label">
                                                    <label>Payment Date</label>
                                                </div>
                                                <div class="input-group date form-group-sub">
                                                    <input type="text" name="payment_date"
                                                           class="form-control kt_datepicker_3"
                                                           required
                                                           readonly>
                                                    <div class="input-group-append">
                                                            <span class="input-group-text">
                                                                <i class="la la-calendar"></i>
                                                            </span>
                                                    </div>
                                                    <span class="form-text text-muted"></span>

                                                </div>
                                            </div>
                                            <div class="col-md-1 align-self-end">
                                                <a href="javascript:;" data-repeater-delete=""
                                                   class="btn-sm btn btn-label-danger btn-bold">
                                                    <i class="la la-trash-o"></i>
                                                </a>
                                            </div>
                                            <div class="col-md-11" id="availability_dev">
                                                <div class="kt-form__group--inline">
                                                    <div class="kt-form__label">
                                                        <label>Note</label>
                                                    </div>
                                                    <div class="kt-form__control">
                                                            <textarea class="form-control" name="note" cols="30"
                                                                      rows="1"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="col-md-12 kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
                                        </div>
                                            @foreach ($project->project_accounts_payments as $project_account)

                                                <div data-repeater-item="" class="form-group row">
                                                    <input type="text" name="id"
                                                           value="{{$project_account->id}}" hidden>
                                                    <div class="col-md-5" id="availability_dev">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Payment Amount<span
                                                                        class="required"> *</span></label>
                                                            </div>
                                                            <div class="kt-form__control form-group-sub">
                                                                <input name="amount" type="text"
                                                                       readonly
                                                                       disabled
                                                                       class="form-control money amount"
                                                                       placeholder="Payment Amount"
                                                                       value="{{$project_account->amount}}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="kt-form__label">
                                                            <label>Payment Date<span class="required"> *</span></label>
                                                        </div>
                                                        <div class="input-group date form-group-sub">
                                                            <input type="text" name="payment_date"
                                                                   class="form-control kt_datepicker_3"
                                                                   readonly
                                                                   disabled
                                                                   value="{{$project_account->payment_date}}" required>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <i class="la la-calendar"></i>
                                                                </span>
                                                            </div>
                                                            <span class="form-text text-muted"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 align-self-end">
                                                        <a href="javascript:;" data-repeater-delete=""
                                                           class="btn-sm btn btn-label-danger btn-bold">
                                                            <i class="la la-trash-o"></i>

                                                        </a>
                                                    </div>
                                                    <div class="col-md-11" id="availability_dev">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Note</label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <textarea class="form-control" name="note" disabled cols="30"
                                                                          rows="1">{{$project_account->note}}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="col-md-12 kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
                                                </div>
                                            @endforeach


                                    </div>
                                    <div class="form-group form-group-last ">
                                        <div class="col-lg-12">
                                            <a href="javascript:;" data-repeater-create=""
                                               class="btn btn-bold btn-sm btn-label-brand">
                                                <i class="la la-plus"></i> Add
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-group-last  col-lg-6 kt_repeater_hq_payment">
                                    <div data-repeater-list="refunds">
                                        <div data-repeater-item="" class="form-group row  empty-div">
                                            <div class="col-md-5" id="availability_dev">
                                                <div class="kt-form__group--inline">
                                                    <div class="kt-form__label">
                                                        <label>Refund Amount<span
                                                                class="required"> *</span></label>
                                                    </div>
                                                    <div class="kt-form__control form-group-sub">
                                                        <input name="refund" type="text"

                                                               class="form-control money amount"
                                                               placeholder="Refund Amount"
                                                               value="" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="kt-form__label">
                                                    <label>Refund Date<span class="required"> *</span></label>
                                                </div>
                                                <div class="input-group date form-group-sub">
                                                    <input type="text" name="refund_date"
                                                           class="form-control kt_datepicker_3"
                                                           readonly
                                                           value="" required>
                                                    <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <i class="la la-calendar"></i>
                                                                </span>
                                                    </div>
                                                    <span class="form-text text-muted"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-2 align-self-end">
                                                <a href="javascript:;" data-repeater-delete=""
                                                   class="btn-sm btn btn-label-danger btn-bold">
                                                    <i class="la la-trash-o"></i>
                                                </a>
                                            </div>
                                            <div class="col-md-11" id="availability_dev">
                                                <div class="kt-form__group--inline">
                                                    <div class="kt-form__label">
                                                        <label>Note</label>
                                                    </div>
                                                    <div class="kt-form__control">
                                                            <textarea class="form-control" name="note" cols="30"
                                                                      rows="1"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="col-md-12 kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
                                        </div>

                                    @foreach ($project->project_accounts_refunds as $project_account)

                                                <div data-repeater-item="" class="form-group row">
                                                    <input type="text" name="id"
                                                           value="{{$project_account->id}}" hidden>
                                                    <div class="col-md-5" id="availability_dev">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Refund Amount</label>
                                                            </div>
                                                            <div class="kt-form__control form-group-sub">
                                                                <input id="refund" name="refund" type="text"
                                                                       class="form-control money refund"
                                                                       disabled readonly
                                                                       placeholder="Refund Amount"
                                                                       value="{{$project_account->refund}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="kt-form__label">
                                                            <label>Refund Date</label>
                                                        </div>
                                                        <div class="input-group date form-group-sub">
                                                            <input type="text" name="refund_date"
                                                                   class="form-control kt_datepicker_3"
                                                                   disabled readonly
                                                                   value="{{$project_account->refund_date}}">
                                                            <div class="input-group-append">
                                                            <span class="input-group-text">
                                                                <i class="la la-calendar"></i>
                                                            </span>
                                                            </div>
                                                            <span class="form-text text-muted"></span>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 align-self-end">
                                                        <a href="javascript:;" data-repeater-delete=""
                                                           class="btn-sm btn btn-label-danger btn-bold">
                                                            <i class="la la-trash-o"></i>

                                                        </a>
                                                    </div>
                                                    <div class="col-md-11" id="availability_dev">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Note</label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <textarea class="form-control" disabled name="note" cols="30"
                                                                          rows="1">{{$project_account->note}}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="col-md-12 kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
                                                </div>
                                            @endforeach
                                    </div>
                                    <div class="form-group form-group-last ">
                                        <div class="col-lg-12">
                                            <a href="javascript:;" data-repeater-create=""
                                               class="btn btn-bold btn-sm btn-label-brand">
                                                <i class="la la-plus"></i> Add
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" data-ktwizard-type="action-submit"
                                        class="btn btn-sm btn-label-success btn-bold"><i
                                        class="la la-save"></i> @lang('common.save')</button>
                                <button onClick="window.location.reload();" type="reset"
                                        class="btn btn-sm btn-bold btn-label-warning"><i class="la la-rotate-right"></i>Reset
                                </button>
                                <a href="/" class="btn btn-bold btn-sm btn-label-danger"> <i
                                        class="la la-close"></i>@lang('common.cancel') </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Portlet-->
    </div>
    <!-- end:: Content -->
@stop
@section('script')
    @include('layouts.include.script.script_jquery_form')
    {!! Html::script('assets/js/demo2/pages/crud/forms/validation/form-controls-hq-payment.js') !!}
    <script>
        // $(document).on('keyup', '.amount,.refund', function () {
        //     $('.amount').each(function (i) {
        //         let total_input = $('.remaining_amount:eq(' + i + ')');
        //         let refund = $('.refund:eq(' + i + ')').val();
        //         if (Number(refund) > Number($(this).val())) {
        //             toastr.error('The Refund Amount must be equal or lower from payment amount');
        //             total_input.addClass("is-invalid");
        //             total_input.val(null);
        //             return false;
        //         }
        //         total_input.removeClass("is-invalid");
        //         total_input.val(Number($(this).val()) - Number(refund));
        //     });
        // });
        $(document).ready(function () {
            $('.empty-div').html('');
        })
    </script>
@endsection
