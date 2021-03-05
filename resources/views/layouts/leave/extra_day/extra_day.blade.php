@extends('layouts.app')
@section('style')
    @include('layouts.include.style.style_modal_list')
@stop
@section('content')
    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label"><span class="kt-portlet__head-icon"><i class="kt-font-brand flaticon2-user"></i></span>
                    <h3 class="kt-portlet__head-title">
                        @lang('common.list') @lang('common.of') @lang('url.extra-day')
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <button type="button" class="btn btn-brand btn-icon-sm" data-toggle="modal" data-target="#add"><i class="flaticon2-plus"></i>@lang('url.extra-day')</button>
                        <!--begin::Modal-->
                    @yield('create')
                    <!--end::Modal-->
                    </div>
                </div>
            </div>

            <div class="kt-portlet__body">
                <!--begin: Search Form -->
                <div class="kt-form kt-form--label-right kt-margin-t-20 kt-margin-b-10">
                    <div class="row align-items-center">
                        <div class="col-xl-12">
                            <div class="row align-items-center">
                                <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                                    <div class="kt-input-icon kt-input-icon--left">
                                        <label>@lang('common.search') </label>
                                        <input type="text" class="form-control" placeholder="Search..." id="generalSearch">
                                        <span class="kt-input-icon__icon kt-input-icon__icon--left"> <span><i class="la la-search"></i></span> </span>
                                    </div>
                                </div>
                                <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                                    <div class="kt-input-icon kt-input-icon--left">
                                        <label>@lang('hr.employee') </label>
                                        {!! Form::select('user_id', $filter_user,null,['class' => 'form-control select2','id'=>'user_id']) !!}
                                    </div>
                                </div>
                                <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                                    <div class="kt-input-icon kt-input-icon--left">
                                        <label>@lang('hr.position') </label>
                                        {!! Form::select('position_id', $filter_position,null,['class' => 'form-control select2','id'=>'position_id']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @yield('edit')
            <!--end: Search Form -->
            </div>
            <div class="kt-portlet__body kt-portlet__body--fit">
                <!--begin: Datatable -->
                <div class="kt-datatable" id="auto_column_hide"></div>
                <!--end: Datatable -->
            </div>
        </div>
    </div>
    <!-- end:: Content -->
@stop
@section('script')
    @include('layouts.include.script.script_modal_list')
    {!! Html::script('assets/app/custom/general/crud/metronic-datatable/advanced/table-extra-day.js') !!}
    {!! Html::script('assets/js/demo2/pages/crud/forms/validation/form-extra-day.js') !!}
    <script>
        $('#add-date').change(function () {
            let date = $('#add-date').val();
            let year =  date.slice(0, 4);
            $('#add-year').val(year);
        });
        $('#edit-date').change(function () {
            let date = $('#edit-date').val();
            let year =  date.slice(0, 4);
            $('#edit-year').val(year);
        });
        function time_diff(time_value) {

            let time = time_value;
            let data = [];

            let hours = Number(time.match(/^(\d+)/)[1]);
            let minutes = Number(time.match(/:(\d+)/)[1]);
            let sHours = hours.toString();
            let sMinutes = minutes.toString();
            if (hours < 10) {
                sHours = "0" + sHours;
            }
            if (minutes < 10) {
                sMinutes = "0" + sMinutes;
            }
            if(sHours==0){
                sHours='24';
            }
            data['sHours'] = sHours;
            data['sMinutes'] = sMinutes;
            return data;
        }

        function num_of_hour(type) {

            if ($(`#${type}-end-time`).val() == '') {
                return true;
            }
            let start_time = time_diff($(`#${type}-start-time`).val());
            let end_time = time_diff($(`#${type}-end-time`).val());

            let start_timeS = (start_time['sHours'] * 3600) + (start_time['sMinutes'] * 60);
            let end_timeS = (end_time['sHours'] * 3600) + (end_time['sMinutes'] * 60);
            let td;
            if(start_timeS >end_timeS){
                td = start_timeS - end_timeS;
            }else{
                td =  end_timeS - start_timeS;
            }
            let hours = parseInt(td / 3600);
            let minutes = parseInt((td - hours * 3600) / 60);
            if (hours < 10) {
                hours = "0" + hours;
            }
            if (minutes < 10) {
                minutes = "0" + minutes;
            }
            let diff = hours + ':' + minutes;

            $(`#${type}_hours`).val(diff);
            return true;
        }
    </script>
@stop
