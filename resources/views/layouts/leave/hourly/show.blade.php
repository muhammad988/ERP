@extends('layouts.app')
@section('style')
    @include('layouts.include.style.style_form')

    {!! Html::style('assets/css/demo2/pages/general/invoices/invoice-2.css') !!}
@stop
@section('content')
    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h1 class="kt-portlet__head-title">
                        {{$leave->leave_type->name_en}}
                    </h1>
                </div>
            </div>
            <!--begin::Form-->
            <div class="kt-portlet__body">
                <div class="row row-no-padding row-col-separator-xl">
                    <div class="col-md-12 col-lg-12 col-xl-3">
                        <!--begin:: Widgets/Stats2-1 -->
                        <div class="kt-widget1">
                            <div class="kt-widget1__item">
                                <div class="kt-widget1__info">
                                    <h3 class="kt-widget1__title">REQUESTER</h3>
                                    <span class="kt-widget1__desc">{{$leave->user->full_name}}</span>
                                </div>
                            </div>

                            <div class="kt-widget1__item">
                                <div class="kt-widget1__info">
                                    <h3 class="kt-widget1__title">REASON</h3>
                                    <span class="kt-widget1__desc">{{$leave->reason}}</span>
                                </div>
                            </div>

                        </div>
                        <!--end:: Widgets/Stats2-1 -->
                    </div>
                    <div class="col-md-12 col-lg-12 col-xl-3">
                        <!--begin:: Widgets/Stats2-2 -->
                        <div class="kt-widget1">
                            <div class="kt-widget1__item">
                                <div class="kt-widget1__info">
                                    <h3 class="kt-widget1__title">DATE</h3>
                                    <span class="kt-widget1__desc">{{$leave->start_date}}</span>
                                </div>
                            </div>
                            <div class="kt-widget1__item">
                                <div class="kt-widget1__info">
                                    <h3 class="kt-widget1__title">HOURS</h3>
                                    <span class="kt-widget1__desc">{{ gmdate('H:i', \Carbon\Carbon::parse ($leave->end_time)->diffInSeconds($leave->start_time))}}</span>
                                </div>
                            </div>
                        </div>
                        <!--end:: Widgets/Stats2-2 -->
                    </div>
                    <div class="col-md-12 col-lg-12 col-xl-3">
                        <!--begin:: Widgets/Stats2-3 -->
                        <div class="kt-widget1">
                            <div class="kt-widget1__item">
                                <div class="kt-widget1__info">
                                    <h3 class="kt-widget1__title">START TIME</h3>
                                    <span class="kt-widget1__desc">{{$leave->start_time}}</span>
                                </div>
                            </div>
                            <div class="kt-widget1__item">
                                <div class="kt-widget1__info">
                                    <h3 class="kt-widget1__title">@lang('common.status')</h3>
                                    <span class="kt-widget1__desc">{{$leave->status->name_en}}</span>
                                </div>
                            </div>

                        </div>

                        <!--end:: Widgets/Stats2-3 -->
                    </div>
                    <div class="col-md-12 col-lg-12 col-xl-3">
                        <!--begin:: Widgets/Stats2-3 -->
                        <div class="kt-widget1">
                            <div class="kt-widget1__item">
                                <div class="kt-widget1__info">
                                    <h3 class="kt-widget1__title">END TIME</h3>
                                    <span class="kt-widget1__desc">{{$leave->end_time}}</span>
                                </div>
                            </div>

                        </div>
                        <!--end:: Widgets/Stats2-3 -->
                    </div>
                </div>
            </div>

            <div class="kt-portlet__foot">
                <div class="kt-form__actions">
                    <div class="row">
                        <div class="col-lg-12">
                            <a href="javascript:;" id="accept" class="btn btn-sm btn-label-success btn-bold"><i class="la la-check"></i> @lang('common.accept')</a>
                            <a href="javascript:;" id="reject" class="btn btn-sm  btn-label-danger btn-bold"><i class="la la-ban"></i> @lang('common.reject')</a>
                            <a href="javascript:;" id="confirm" class="btn  btn-sm  btn-label-primary btn-bold"><i class="la la-check"></i> Confirm</a>
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
        <input hidden name="id" value="">
    </form>
    <form id="confirm-form" action="{{route ('operational_advance.action')}}" method="POST" hidden>
        @csrf
        <input hidden name="action" value="confirm">
        <input hidden name="id" value="">
    </form>
    <form id="accept-form" action="{{route ('operational_advance.action')}}" method="POST" hidden>
        @csrf
        <input hidden name="action" value="accept">
        <input hidden name="id" value="">
        <input hidden name="project_id" value="">
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
