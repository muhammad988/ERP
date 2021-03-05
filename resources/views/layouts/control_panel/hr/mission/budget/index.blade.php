@extends('layouts.app')
@section('style')
    @include('layouts.include.style.style_modal_list')
@stop
@section('content')
    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__body">
                <!--begin: Search Form -->
                <div class="kt-form kt-form--label-right kt-margin-t-20 kt-margin-b-10">
                    <div class="row align-items-center">
                        <div class="col-xl-12">
                            <div class="row align-items-center">
                                <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                                    <div class="kt-input-icon kt-input-icon--left">
                                        <label>@lang('common.search') </label>
                                        <input type="text" class="form-control" placeholder="Search..." id="generalSearch">
                                        <input hidden value="{{$id}}" id="mission_id" >

                                        <span class="kt-input-icon__icon kt-input-icon__icon--left">
																<span><i class="la la-search"></i></span>
															</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
    {!! Html::script('assets/app/custom/general/crud/metronic-datatable/advanced/table-mission-budget.js') !!}
@stop
