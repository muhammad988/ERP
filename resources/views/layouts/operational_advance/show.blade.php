

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
                        Operational Advance
                    </h1>
                </div>
            </div>
            <!--begin::Form-->
            <div class="kt-portlet__body">
                <div class="kt-section">
                    <h3 class="kt-section__title">
                        Operational Advance Information:
                    </h3>
                    <div class="kt-section__content">
                        <div class="form-group form-group-last">
                            <table class="table table-bordered table-hover">
                                <thead>
                                </thead>
                                <tbody>
                                <tr>
                                    <td style="width: 50%"><b>Project Name:</b>&nbsp;&nbsp;{{$service->project->name_en}}</td>
                                    <td style="width: 50%"><b>Service Type:</b>&nbsp;Operational Advance</td>
                                </tr>
                                <tr>
                                    <td style="width: 50%"><b>Project Code:</b>&nbsp;&nbsp;{{$service->project->code}}</td>
                                    <td style="width: 50%"><b>Service Code:</b>&nbsp;&nbsp;{{$service->code}}</td>
                                </tr>
                                <tr>
                                    <td style="width: 50%">
                                        <b>Recipient:</b>&nbsp;&nbsp;{{$service->user_recipient->first_name_en . ' ' . $service->user_recipient->last_name_en}}
                                    </td>
                                    <td style="width: 50%"><b>Service Date:</b>&nbsp;&nbsp;{{$service->created_at}}</td>
                                </tr>
                                <tr>
                                    <td style="width: 50%"><b>Currency:</b>&nbsp;&nbsp;{{$service->currency->name_en}}</td>
                                    <td style="width: 50%"><b>Exchange Rate:</b>&nbsp;&nbsp;{{$service->user_exchange_rate}}</td>
                                </tr>
                                <tr>
                                    <td style="width: 50%"><b>Total USD:</b>&nbsp;&nbsp;<span class="money">{{$service->total_dollar}}</span></td>
                                    <td>{!! $service->currency_id != 87034? '<b>Total '.$service->currency->name_en .':</b>&nbsp;&nbsp;<span class="money">' . $service->total_currency .'</span>' : ''!!}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                <div class="row">
                    <div class="col-lg-2">
                        <h5 id="title_service_total">Service Total :</h5>
                        <input id="service_total" value="{{$service->total_currency}}" name="total" readonly class="form-control money">
                    </div>

                </div>
            </div>

            <div class="kt-portlet__foot">
                <div class="kt-form__actions">
                    <div class="row">
                        <div class="col-lg-12">
                            @if($check_notification->authorized)
                                <a href="javascript:;" id="accept" class="btn btn-sm btn-label-primary btn-bold"><i class="la la-check"></i> @lang('common.accept')</a>
                                <a href="javascript:;" id="reject" class="btn btn-sm  btn-label-danger btn-bold"><i class="la la-ban"></i> @lang('common.reject')</a>
                            @else
                                <a href="javascript:;" id="confirm" class="btn  btn-sm  btn-label-primary btn-bold"><i class="la la-check"></i> Confirm</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Form-->
        </div>
        <!--end::Portlet-->
    </div>
    <!-- end:: Content -->
    <form id="reject-form" action="{{route ('operational_advance.action')}}" method="POST" hidden>
        @csrf
        <input hidden name="action" value="reject">
        <input hidden name="id" value="{{$service->id}}">
    </form>
    <form id="confirm-form" action="{{route ('operational_advance.action')}}" method="POST" hidden>
        @csrf
        <input hidden name="action" value="confirm">
        <input hidden name="id" value="{{$service->id}}">
    </form>
    <form id="accept-form" action="{{route ('operational_advance.action')}}" method="POST" hidden>
        @csrf
        <input hidden name="action" value="accept">
        <input hidden name="id" value="{{$service->id}}">
        <input hidden name="project_id" value="{{$service->project_id}}">
    </form>
@stop
@section('script')
    @include('layouts.include.script.script_jquery_form')
    <script>
        submit_form('accept', 'accept-form');
        submit_form('reject', 'reject-form');
        submit_form('confirm', 'confirm-form');
    </script>
@endsection
