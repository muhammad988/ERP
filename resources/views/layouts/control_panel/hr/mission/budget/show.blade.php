@extends('layouts.app')
@section('style')
    @include('layouts.include.style.style_form')
    {{--    {!! Html::style('assets/app/custom/wizard/wizard-v1.demo2.css') !!}--}}
@stop
@section('content')
    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">

        <!--Begin::Section-->
        <div class="kt-portlet ">
            <div class="kt-portlet__body">
                <div class="kt-widget kt-widget--user-profile-3">
                    <div class="kt-widget__top">
                        <div class="kt-widget__content">
                            <div class="kt-widget__head">
                                <a href="#" class="kt-widget__title">{{$mission_budget->name_en}}</a>
                            </div>
                            <div class="kt-widget__info">
                                <div class="kt-widget__stats  align-items-center row">

                                    <div class="kt-widget__item  col-lg-2">
                                <span class="kt-widget__date">
                                     @lang('common.start')@lang('common.date')
                                </span>
                                        <div class="kt-widget__label">
                                            <span class="btn btn-label-brand btn-sm btn-bold btn-upper">{{$mission_budget->start_date}}</span>
                                        </div>
                                    </div>
                                    <div class="kt-widget__item col-lg-2">
                                <span class="kt-widget__date">
                                    @lang('common.end')@lang('common.date')
                                </span>
                                        <div class="kt-widget__label">
                                            <span class="btn btn-label-danger btn-sm btn-bold btn-upper">{{  $mission_budget->end_date }}</span>
                                        </div>
                                    </div>
                                    <div class="kt-widget__item col-lg-2">
                                <span class="kt-widget__date">
                                    @lang('common.duration')
                                </span>
                                        <div class="kt-widget__label">
                                            {{get_duration($mission_budget->start_date, $mission_budget->end_date)}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @foreach($budget_categories as $budget_category)
        @if($mission_budget->detailed_proposal_budget->where('budget_category_id',$budget_category->id)->sum('quantity'))
            <!--Begin::Section-->
                <div class="row">
                    <div class="col-xl-12">
                        <!--begin:: Widgets/Download Files-->
                        <div class="kt-portlet kt-portlet--height-fluid">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title">
                                        {{$budget_category->name_en}}
                                    </h3>
                                </div>
                            </div>
                            <div class="kt-portlet__body">
                                @php
                                    $total_budget=0
                                @endphp
                                @foreach($mission_budget->detailed_proposal_budget->where('budget_category_id',$budget_category->id) as $key=>$value)
                                    @php
                                        $total_budget += ($value->unit_cost * $value->chf * $value->quantity * $value->duration)/100;
                                         $total_budgets += ($value->unit_cost * $value->chf * $value->quantity * $value->duration)/100
                                    @endphp
                                    <div class="row form-group">
                                        <div class=" col-lg-2">
                                            <h6>Budget Line</h6>
                                            {{$value->budget_line}}
                                        </div>
                                        <div class="col-lg-2">
                                            <h6>Category Option </h6>
                                            {{$value->category_option_name_en}}
                                        </div>
                                        <div class="col-lg-2">
                                            <h6>Unit </h6>
                                            {{$value->unit_name_en}}
                                        </div>
                                        <div class="col-lg-1">
                                            <h6>Duration </h6>
                                            {{$value->duration}}
                                        </div>
                                        <div class="col-lg-1">
                                            <h6>Quantity </h6>
                                            {{$value->quantity}}
                                        </div>
                                        <div class="col-lg-1">
                                            <h6>Unit Cost </h6>
                                            <span class="currency">{{$value->unit_cost}}</span>
                                        </div>
                                        <div class="col-lg-1">
                                            <h6>CHF </h6>
                                            {{$value->chf}}
                                        </div>
                                        <div class="col-lg-1">
                                            <h6>Total </h6>
                                            <span class="currency">{{($value->unit_cost * $value->chf * $value->quantity * $value->duration)/100 }}</span>
                                        </div>
                                    </div>
                                    <div class="row form-group">

                                        <div class="col-lg-2">
                                            <h6>In kind/Monetary</h6>
                                            {{ $value->in_kind === false ? 'In kind' : 'Monetary' }}
                                        </div>
                                        <div class="col-lg-2">
                                            <h6>Direct/Support</h6>
                                            {{ $value->in_kind === true ? 'Support' : 'Direct' }}
                                        </div>
                                        <div class="col-lg-2">
                                            <h6>Administrative Cost</h6>
                                            {{ $value->out_of_administrative_cost === true ? 'Not Included' : 'Include' }}
                                        </div>
                                        <div class="col-lg-4">
                                            <h6>description</h6>
                                            {{ $value->description }}
                                        </div>
                                    </div>
                                    <hr class="row">
                                @endforeach
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5>Total </h5>
                                        <span class="currency">{{ $total_budget }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end:: Widgets/Download Files-->
                    </div>

                </div>
                <!--End::Section-->
        @endif
    @endforeach

    <!--Begin::Section-->
        <div class="row">
            <div class="col-xl-12">
                <!--begin:: Widgets/Download Files-->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Total Budget Line
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">

                        <div class="row ">
                            <div class="col-lg-2">
                                <h6>Total Cost </h6>
                                <span class="currency">{{$total_budgets }}</span>
                            </div>
                        </div>

                    </div>
                </div>
                <!--end:: Widgets/Download Files-->
            </div>

        </div>
        <!--End::Section-->
    </div>
    <!-- end:: Content -->
@stop
@section('script')
    @include('layouts.include.script.script_jquery_form')
    <script>
        submit_form('accept', 'accept-form');
        submit_form('reject', 'reject-form');
        submit_form('confirm', 'confirm-form');
    </script>
@stop
