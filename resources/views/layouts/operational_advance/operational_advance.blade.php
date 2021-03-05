@extends('layouts.app')
@section('style')
    @include('layouts.include.style.style_form')
@stop
@section('content')
    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="col-lg-12">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h1 class="kt-portlet__head-title">
                            Operational Advance Request
                        </h1>
                    </div>
                </div>
                <!--begin::Form-->
                <form method="POST" action="{{route('operational_advance.store')}} " class="kt-form kt-form--label-right" id="kt_form_2">
                    @csrf
                    <div class="kt-portlet__body">
                        <div class="kt-section">
                            <h3 class="kt-section__title">
                                Operational Advance Information:
                            </h3>
                            <div class="kt-section__content">
                                <div class="form-group row">
                                    <div class="col-lg-6 form-group-sub" id="service_receiver_dev">
                                        <label class="form-control-label">Operational Advance Receiver<span class="required"> *</span></label>
                                        <select class="form-control select2" name="data[recipient]" id="recipient" required>
                                            <option value="" selected>Please Select</option>
                                            @foreach ($recipients as $recipient)
                                                <option value="{{$recipient->id}}">{{$recipient->full_name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="form-text text-muted"></span>

                                    </div>
                                    <div class="col-lg-6 form-group-sub" id="project_name_dev">
                                        <label class="form-control-label">Project Name<span class="required"> *</span></label>
                                        <select class="form-control select2" name="data[project_id]" id="project_id" required>
                                            <option value="" selected>Please Select</option>
                                            @foreach ($projects as $project)
                                                <option value="{{$project->id}}">{{$project->name_en}}</option>
                                            @endforeach
                                        </select>
                                        <span class="form-text text-muted"></span>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-4 form-group-sub">
                                        <label class="form-control-label">Payment Amount<span class="required"> *</span></label>
                                        <input type="text" name="data[total_currency]" id="payment_amount" class="form-control money" placeholder="payment_amount" value="" required>
                                    </div>
                                    <div class="col-lg-4 form-group-sub">
                                        <label class="form-control-label">Currency<span class="required"> *</span></label>
                                        <select class="form-control" name="data[currency_id]" id="currency_id" required>
                                            <option value="" selected>Please Select</option>
                                            @foreach ($currencies as $currency)
                                                <option value="{{$currency->id}}">{{$currency->name_en}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4 form-group-sub">
                                        <label class="form-control-label">Exchange Rate<span class="required"> *</span></label>
                                        <input type="text" name="data[user_exchange_rate]" id="exchange_rate" class="form-control money" placeholder="exchange rate" value="" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="submit" data-ktwizard-type="action-submit" class="btn btn-sm btn-label-success btn-bold"><i class="la la-save"></i> @lang('common.submit')</button>
                                    <button onClick="window.location.reload();" type="reset" class="btn btn-sm btn-bold btn-label-warning"><i class="la la-rotate-right"></i>Reset</button>
                                    <a href="/" class="btn btn-bold btn-sm btn-label-danger"> <i class="la la-close"></i>@lang('common.cancel') </a>
                                    {{--                                    <a href="#" id="submitForm" type="submit"--}}
                                    {{--                                    class="btn btn-label-primary btn-bold">--}}
                                    {{--                                    <i class="la la-check"></i>Submit--}}
                                    {{--                                    </a>--}}
                                    {{--                                    <a href="#" id="submitForm" type="submit"--}}
                                    {{--                                        class="btn btn-label-warning btn-bold">--}}
                                    {{--                                        <i class="la la-remove"></i>Cancel--}}
                                    {{--                                    </a>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!--end::Form-->
            </div>
            <!--end::Portlet-->
        </div>
    </div>
    <!-- end:: Content -->
@stop
@section('script')
    @include('layouts.include.script.script_jquery_form')
    {!! Html::script('assets/js/demo2/pages/crud/forms/validation/form-controls-operational-advance.js') !!}
    <script>
        $("#currency_id").change(function () {
            if ($("#currency_id").val() == "87034") {
                $("#exchange_rate").val("1").prop("readonly", true);
            } else if ($("#currency_id").val()) {
                $.get('/service/getexchangerate/' + $("#currency_id").val(), function (data) {
                    $("#exchange_rate").val(data).prop("readonly", false);
                });
            } else {
                // if there is no currency selected, then reset the exchange rate value
                $("#exchange_rate").val("").prop("readonly", false);
            }
        });
    </script>
@stop
