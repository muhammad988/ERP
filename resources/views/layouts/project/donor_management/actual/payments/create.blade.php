@extends('layouts.app')
@section('style')
    @include('layouts.include.style.style_form')
@stop
@section('content')
    <!-- begin:: Portlet -->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Portlet-->
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            First Payment
                        </h3>
                    </div>
                </div>
                <form method="POST" action="{{route('project.donor_payment_actual_store')}}" class="kt-form" id="kt_form_1" name="donorForm" enctype="multipart/form-data">
                    @csrf
                    <input value="{{$project->id}}" name="project_id" hidden>
                    <!--begin::Form-->
                    <div class="kt-portlet__body">
                        @foreach($project->prject_payment as $payment)
                            <input hidden value="{{$payment->id}}" name="id[]">
                            <div class="row">
                                <div class="form-group col-2">
                                    <div class="kt-form__group--inline"></div>
                                    <div class="kt-form__label">
                                        <label>Agreed Amount Of Money</label>
                                    </div>
                                    <input class="form-control agreedAmountOfMoney money"
                                           type="text" readonly
                                           value="{{$payment->agreed_amount}}"
                                           name="agreedAmountOfMoney">
                                </div>
                                <div class="form-group col-2">
                                    <div class="kt-form__group--inline">
                                        <div class="kt-form__label">
                                            <label>Payment Due Date</label>
                                        </div>
                                        <input class="form-control paymentDueDate"
                                               value="{{$payment->due_date}}"
                                               type="text" readonly
                                               name="paymentDueDate">
                                    </div>
                                </div>
                                <div class="form-group col-1">
                                    <div class="kt-form__group--inline">
                                        <div class="kt-form__label">
                                            <label>---</label>
                                        </div>
                                        <a href="javascript:showRecievedPaymentElements({{$payment->id}});"
                                           class="btn-sm btn btn-label-brand btn-bold showRecievedPaymentElements">
                                            <i class="la la-arrow-right"></i><i class="la la-dollar	"></i>
                                        </a>
                                    </div>
                                </div>

                                <div id="receivedPaymentElement_{{$payment->id}}" class="col-7"   @if($payment->received_payment!='' ) style="display: block" @else style="display: none"  @endif >
                                    <div class="row">
                                        <div class="form-group col-3">
                                            <div class="kt-form__group--inline">
                                                <div class="kt-form__label">
                                                    <label>Received Amount</label>
                                                </div>
                                                <input class="form-control  PaymentReceivedAmount "
                                                       type="text"
                                                       value="{{$payment->received_payment}}"
                                                       @if($payment->received_payment!='' && !$project->edit_actual_donor_management) readonly @endif

                                                       name="received_payment_{{$payment->id}}" id="PaymentReceivedAmount">
                                            </div>
                                        </div>
                                        <div class="form-group col-3">
                                            <div class="kt-form__group--inline">
                                                <div class="kt-form__label">
                                                    <label>Received Date</label>
                                                </div>
                                                <input class="form-control paymentReceivedDate"
                                                       type="date"
                                                       required
                                                       @if($payment->receiving_date!='' && !$project->edit_actual_donor_management) readonly @endif

                                                       value="{{$payment->receiving_date}}"
                                                       name="receiving_date_{{$payment->id}}">
                                            </div>
                                        </div>

                                        @if($payment->payment_file=='' || $project->edit_actual_donor_management)
                                            <div @if($payment->payment_file) class="col-4" @else class="col-5" @endif >
                                                <label>Received Payment Receipt</label>
                                                <div></div>
                                                <div class="custom-file">
                                                    <input type="file"
                                                           @if(!$payment->payment_file) required @endif
                                                           class="custom-file-input"
                                                           id="payment_file_{{$payment->id}}"
                                                           name="payment_file_{{$payment->id}}">
                                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                                </div>
                                            </div>
                                        @endif


                                        @if($payment->payment_file)
                                            <div class="col-lg-1 ">
                                                <label>File</label>
                                                <a target="_blank" href="/file/donor/{{$payment->payment_file}}" class="btn btn-bold btn-primary">View </a>
                                            </div>
                                        @endif
                                        @if($payment->payment_file=='' || $project->edit_actual_donor_management)
                                            <div class="form-group col-1">
                                                <div class="kt-form__group--inline">
                                                    <div class="kt-form__label">
                                                        <label>---</label>
                                                    </div>
                                                    <a href="javascript:hideRecievedPaymentElements({{$payment->id}});"
                                                       class="btn-sm btn btn-label-danger btn-bold">
                                                        <i class="la la-trash-o"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="row col-12 repeater">
                                            <div class="row col-sm-12">
                                                <div class="col-sm-8"></div>
                                                <div class="form-group col-4 kt-align-right">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label></label>
                                                        </div>
                                                        <a href="javascript:;"
                                                           data-repeater-create
                                                           class="btn-sm btn btn-label-brand btn-bold">
                                                            <i class="la la-plus"></i> Add Usable Amount Of money
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="dataRepeaterList" data-repeater-list="usable_{{$payment->id}}" class="row col-12">
                                                <div hidden >
                                                    <div class="row col-12" id="usableAmountForm" data-repeater-item>
                                                        <input hidden value="" name="id">
                                                        <div class="form-group col-3">
                                                            <div class="kt-form__group--inline"></div>
                                                            <div class="kt-form__label">
                                                                <label>Usable Amount Of Money</label>
                                                            </div>
                                                            <input class="form-control usableAmountOfMoney currency"
                                                                   type="number"
                                                                   required
                                                                   value=""
                                                                   name="amount" id="usableAmountOfMoney">
                                                        </div>
                                                        <div class="form-group col-3">
                                                            <div class="kt-form__group--inline"></div>
                                                            <div class="kt-form__label">
                                                                <label>Date</label>
                                                            </div>
                                                            <input class="form-control agreedAmountOfMoney currency"
                                                                   type="date"
                                                                   required
                                                                   value=""
                                                                   name="payment_date">
                                                        </div>
                                                        <div class="form-group col-1">
                                                            <div class="kt-form__group--inline">
                                                                <div class="kt-form__label">
                                                                    <label>---</label>
                                                                </div>
                                                                <a href="javascript:;"
                                                                   data-repeater-delete=""
                                                                   class="btn-sm btn btn-label-danger btn-bold">
                                                                    <i class="la la-close"></i>
                                                                </a>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                                @foreach($payment->project_account as $project_account)
                                                    <div class="row col-12" id="usableAmountForm" data-repeater-item>
                                                        <input hidden value="{{$project_account->id}}" name="id">
                                                        <div class="form-group col-3">
                                                            <div class="kt-form__group--inline"></div>
                                                            <div class="kt-form__label">
                                                                <label>Usable Amount Of Money</label>
                                                            </div>
                                                            <input class="form-control usableAmountOfMoney currency"
                                                                   type="number"
                                                                   required
                                                                   @if($project_account->amount!='' && !$project->edit_actual_donor_management) readonly @endif
                                                                   value="{{$project_account->amount}}"
                                                                   name="amount" id="usableAmountOfMoney">
                                                        </div>
                                                        <div class="form-group col-3">
                                                            <div class="kt-form__group--inline"></div>
                                                            <div class="kt-form__label">
                                                                <label>Date</label>
                                                            </div>
                                                            <input class="form-control agreedAmountOfMoney currency"
                                                                   type="date"
                                                                   required
                                                                   @if($project_account->amount!='' && !$project->edit_actual_donor_management) readonly @endif
                                                                   value="{{$project_account->payment_date}}"
                                                                   name="payment_date">
                                                        </div>
                                                        @if($project_account->amount=='' || $project->edit_actual_donor_management)
                                                            <div class="form-group col-1">
                                                                <div class="kt-form__group--inline">
                                                                    <div class="kt-form__label">
                                                                        <label>---</label>
                                                                    </div>
                                                                    <a href="javascript:;"
                                                                       data-repeater-delete=""
                                                                       class="btn-sm btn btn-label-danger btn-bold">
                                                                        <i class="la la-close"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endif

                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-xl"></div>
                        @endforeach
                        <div class="row col-12">
                            <div class="col-4 ">
                                <a href="#" id="submitForm" type="submit"
                                   class="btn btn-sm btn-label-success btn-bold">
                                    <i class="la la-save"></i>@lang('common.submit')
                                </a>
                                <a type="reset" onClick="window.location.reload();" class="btn btn-sm btn-bold btn-label-warning">
                                    <i class="la la-rotate-right"></i> Reset
                                </a>
                                <a type="reset" href="/" class="btn btn-bold btn-sm btn-label-danger">
                                    <i class="la la-close"></i>@lang('common.cancel')
                                </a>
                            </div>
                        </div>
                    </div>
                    <!--end::Form-->
                </form>
            </div>
            <!--end::Portlet-->
        </div>
    </div>
    <!-- end:: Portlet -->
@stop
@section('script')
    @include('layouts.include.script.script_jquery_form')
    <script>
        let addValidateClassToInput = function () {
            $.validator.addClassRules('required', {
                required: true
            });

            $("#kt_form_1").validate({
                focusInvalid: false,
                ignore: ":hidden",
                invalidHandler: function (form, validator) {

                    // if (!validator.numberOfInvalids())
                    //     return;
                    // $('html, body').animate({
                    //         scrollTop: $(validator.errorList[0].element).offset().top,
                    //     }, 1000, console.log($(validator.errorList[0].element).offset().top),
                    //     $(validator.errorList[0].element).closest('#collapseOne1').attr('class', 'show')
                    // );

                }
            });
        }
        // let submitUsableForm = function () {
        //     $('#usableAmountFormSubmit').click(function () {
        //         $('#usableAmountOfMoney').submit();
        //     });
        // };
        // let addValidateClassToUsablePayment = function () {
        //     $.validator.addClassRules('usableAmountOfMoney', {
        //         required: true
        //     });
        //     $("#usableAmountForm").validate({
        //         focusInvalid: false,
        //         invalidHandler: function (form, validator) {
        //
        //             if (!validator.numberOfInvalids())
        //                 return;
        //
        //             $('html, body').animate({
        //                     scrollTop: $(validator.errorList[0].element).offset().top,
        //                 }, 1000, console.log($(validator.errorList[0].element).offset().top)
        //             );
        //
        //         }
        //     });
        // };
        // let submitReceivedForm = function () {
        //     $('#ReceivedAmountFormSubmit').click(function () {
        //         $('#ReceivedAmountForm').submit();
        //     });
        // };
        // let addValidateClassToReceivedPayment = function () {
        //     $.validator.addClassRules('PaymentReceivedAmount', {
        //         required: true
        //     });
        //     $.validator.addClassRules('paymentReceivedDate', {
        //         required: true
        //     });
        //     $("#ReceivedAmountForm").validate({
        //         focusInvalid: false,
        //         invalidHandler: function (form, validator) {
        //
        //             if (!validator.numberOfInvalids())
        //                 return;
        //
        //             $('html, body').animate({
        //                     scrollTop: $(validator.errorList[0].element).offset().top,
        //                 }, 1000, console.log($(validator.errorList[0].element).offset().top)
        //             );
        //
        //         }
        //     });
        // };
        let repeterRow = function () {
            $('.repeater').repeater({
                hide: function (e) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                position: 'top-end',
                                type: 'success',
                                title: 'Deleted',
                                showConfirmButton: false,
                                timer: 1000,
                            }) && $(this).slideUp(e);
                            // result.dismiss can be 'cancel', 'overlay',
                            // 'close', and 'timer'
                        } else if (result.dismiss === 'cancel') {
                            Swal.fire({
                                position: 'top-end',
                                type: 'error',
                                title: 'Not Deleted',
                                showConfirmButton: false,
                                timer: 1000
                            })
                        }
                    })
                },
                repeaters: [{
                    selector: '.inner-repeater',
                    hide: function (e) {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then(function (result) {
                            if (result.value) {
                                Swal.fire({
                                    position: 'top-end',
                                    type: 'success',
                                    title: 'Deleted',
                                    showConfirmButton: false,
                                    timer: 500,
                                }) && $(this).slideUp(e);
                                // result.dismiss can be 'cancel', 'overlay',
                                // 'close', and 'timer'
                            } else if (result.dismiss === 'cancel') {
                                Swal.fire({
                                    position: 'top-end',
                                    type: 'error',
                                    title: 'Not Deleted',
                                    showConfirmButton: false,
                                    timer: 500
                                })
                            }
                        })
                    }
                }]
            });
        };
        let showRecievedPaymentElements = function (id) {
            $(`#receivedPaymentElement_${id}`).css('display', 'block')
        };
        let hideRecievedPaymentElements = function (id) {
            $(`#receivedPaymentElement_${id}`).css('display', 'none')
        };
        let submitForm = function () {
            $("#submitForm").click(function () {
                $("#kt_form_1").submit();
            });
        };
        // let assignIds = function () {
        //     $('.kt-portlet__body').each(function (i) {
        //         $(this).attr('id', 'kt-portlet__body[' + i + ']');
        //         $(this).children('.row').children().children().children('a').attr('id', 'showRecievedPaymentElements' + i);
        //         let showRecievedPaymentElementsClick = $(this).children('.row').children().children().children('a').attr('id')
        //         $(this).children('.row').children('.col-7').children('.row').children('#ReceivedAmountForm').attr('id', 'ReceivedAmountForm' + i);
        //         $(this).children('.row').children('.col-7').children('.row').children('#ReceivedAmountForm' + i).children('.PaymentReceivedAmount').attr('name', 'PaymentReceivedAmount' + i + i);
        //         let ReceivedAmountForm = $(this).children('.row').children('.col-7').children('.row').children('form').attr('id');
        //         console.log(showRecievedPaymentElementsClick + '  ' + ReceivedAmountForm)
        //     })
        // };
        $(document).ready(function () {
            // assignIds();
            // submitReceivedForm();
            // addValidateClassToReceivedPayment();
            // submitUsableForm();
            // addValidateClassToUsablePayment();
            repeterRow();
            addValidateClassToInput();
            submitForm();
        });
    </script>
@stop
