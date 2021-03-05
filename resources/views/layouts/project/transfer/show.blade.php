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
                                <a href="#" class="kt-widget__title">Transfer From</a>
                                <div class="kt-widget__action">

                                                                        @if(!is_null ($check_notification) && $info->status_id == 170)
                                                                            <a href="#" id="confirm" class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"> Confirm</a>
                                                                            <form id="confirm-form" action="{{ route('transfer.action') }}" method="POST" hidden>
                                                                                @csrf
                                                                                <input hidden name="action" value="confirm">
                                                                                <input hidden name="id" value="{{$info->id}}">
                                                                            </form>
                                                                        @endif
                                                                        @if(!is_null ($check_notification) && $info->status_id == 174)
                                                                            <a href="#" id="accept" class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"> @lang('common.accept')</a>
                                                                            <form id="accept-form" action="{{ route('transfer.action') }}" method="POST" hidden>
                                                                                @csrf
                                                                                <input hidden name="action" value="accept">
                                                                                <input hidden name="id" value="{{$info->id}}">
                                                                                <input hidden name="project_id" value="{{$info->project_to->id}}">
                                                                            </form>
                                                                            <a href="#" id="reject" class="btn btn-danger btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"> @lang('common.reject')</a>
                                                                            <form id="reject-form" action="{{ route('transfer.action') }}" method="POST" hidden>
                                                                                @csrf
                                                                                <input hidden name="action" value="reject">
                                                                                <input hidden name="id" value="{{$info->id}}">
                                                                            </form>
                                                                        @endif
                                </div>
                            </div>
                            <div class="kt-widget__info">
                                <div class="kt-widget__stats  align-items-center row">
                                    <div class="kt-widget__item  col-lg-1">
                                <span class="kt-widget__date">
                                  Code
                                </span>
                                        <div class="kt-widget__label">
                                           40
                                        </div>
                                    </div>
                                    <div class="kt-widget__item  col-lg-2">
                                <span class="kt-widget__date">
                                  Department
                                </span>
                                        <div class="kt-widget__label">
                                            Relief and Development -  {{ $info->project_from->sector->department->mission->name_en }}
                                        </div>
                                    </div>
                                    <div class="kt-widget__item  col-lg-1">
                                <span class="kt-widget__date">
                                 Project code
                                </span>
                                        <div class="kt-widget__label">
                                            {{$info->project_from->code}}
                                        </div>
                                    </div>
                                    <div class="kt-widget__item  col-lg-2">
                                <span class="kt-widget__date">
                                Project name
                                </span>
                                        <div class="kt-widget__label">
                                            {{$info->project_from->name_en}}
                                        </div>
                                    </div>
                                    <div class="kt-widget__item  col-lg-2">
                                <span class="kt-widget__date">
                                   Approved Budget  amount
                                </span>
                                        <div class="kt-widget__label">
                                            <span class="money">  {{$info->project_from->project_budget}}</span>
                                        </div>
                                    </div>
                                    <div class="kt-widget__item  col-lg-2">
                                <span class="kt-widget__date">
                                Amount Transfer To  Project
                                </span>
                                        <div class="kt-widget__label">
                                            <span class="money">{{ $info->amount }}</span>
                                        </div>
                                    </div>
                                    <div class="kt-widget__item  col-lg-2">
                                <span class="kt-widget__date">
                                     Balance after Deduction from Project
                                </span>
                                        <div class="kt-widget__label">
                                            <span class="money">  {{$info->project_from->project_budget+$info->amount}}</span>
                                        </div>
                                    </div>
                                    <div class="kt-widget__item col-lg-12">
                                <span class="kt-widget__date">
                                  Explanation
                                </span>
                                        <div class="kt-widget__label">
                                            {{  $info->explanation_from }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="kt-portlet">
            <div class="kt-portlet__body">
                <div class="kt-widget kt-widget--user-profile-3">
                    <div class="kt-widget__top">
                        <div class="kt-widget__content">
                            <div class="kt-widget__head">
                                <a href="#" class="kt-widget__title">Transfer To</a>
                            </div>
                            <div class="kt-widget__info">
                                <div class="kt-widget__stats  align-items-center row">
                                    <div class="kt-widget__item  col-lg-1">
                                <span class="kt-widget__date">
                                  Code
                                </span>
                                        <div class="kt-widget__label">
                                            40
                                        </div>
                                    </div>
                                    <div class="kt-widget__item  col-lg-2">
                                <span class="kt-widget__date">
                                  Department
                                </span>
                                        <div class="kt-widget__label">
                                            Relief and Development -  {{ $info->project_from->sector->department->mission->name_en }}
                                        </div>
                                    </div>
                                    <div class="kt-widget__item  col-lg-1">
                                <span class="kt-widget__date">
                                   Project  code
                                </span>
                                        <div class="kt-widget__label">
                                            {{$info->project_to->code}}
                                        </div>
                                    </div>
                                    <div class="kt-widget__item  col-lg-2">
                                <span class="kt-widget__date">
                                   Project  name
                                </span>
                                        <div class="kt-widget__label">
                                            {{$info->project_to->name_en}}
                                        </div>
                                    </div>
                                    <div class="kt-widget__item  col-lg-2">
                                <span class="kt-widget__date">
                                   Approved Budget  amount
                                </span>
                                        <div class="kt-widget__label">
                                            <span class="money">  {{$info->project_to->project_budget}}</span>
                                        </div>
                                    </div>
                                    <div class="kt-widget__item  col-lg-2">
                                <span class="kt-widget__date">
                                  Amount Transfer from Project
                                </span>
                                        <div class="kt-widget__label">
                                            <span class="money">{{ $info->amount }}</span>
                                        </div>
                                    </div>
                                    <div class="kt-widget__item  col-lg-2">
                                <span class="kt-widget__date">
                                     Balance after Deduction from Project
                                </span>
                                        <div class="kt-widget__label">
                                            <span class="money">  {{$info->project_to->project_budget-$info->amount}}</span>
                                        </div>
                                    </div>
                                    <div class="kt-widget__item col-lg-12">
                                <span class="kt-widget__date">
                                  Explanation
                                </span>
                                        <div class="kt-widget__label">
                                            {{  $info->explanation_to }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
