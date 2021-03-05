@extends('layouts.app')
@section('style')
    @include('layouts.include.style.style_list')
@stop
@section('content')
    <div class="kt-portlet  kt-portlet--collapse" data-ktportlet="true" id="kt_portlet_tools_1">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    @lang('common.search')
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-group">
                    <a href="#" data-ktportlet-tool="toggle" class="btn btn-sm btn-icon btn-clean btn-icon-md" aria-describedby="tooltip_nrgbx2wq7w"><i class="la la-angle-down"></i></a>
                    <div class="tooltip tooltip-portlet tooltip bs-tooltip-top" role="tooltip" id="tooltip_nrgbx2wq7w" aria-hidden="true" x-placement="top">
                        <div class="tooltip-arrow arrow"></div>
                        {{--                        <div class="tooltip-inner">Collapse</div>--}}
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body" style="display: none;">
            <div class="kt-portlet__content">
                <!--begin: Search Form -->
                <div class="kt-form kt-form--label-right kt-margin-t-20 kt-margin-b-10">
                    <div class=" form-group row align-items-center">
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-input-icon kt-input-icon--left">
                                <label>@lang('common.search')</label>
                                <input type="text" class="form-control" placeholder="Search..." id="generalSearch">
                                <span class="kt-input-icon__icon kt-input-icon__icon--left">
																<span><i class="la la-search"></i></span>
															</span>
                            </div>
                        </div>
{{--                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">--}}
{{--                            <div class="kt-form__group">--}}
{{--                                <div class="kt-form__label">--}}
{{--                                    <label>@lang('common.mission')</label>--}}
{{--                                </div>--}}
{{--                                <div class="kt-form__control">--}}
{{--                                    {!! Form::select('mission_id', $missions,null,['class' => 'form-control kt-selectpicker','id'=>'kt_form_mission','data-live-search'=>'true','multiple']) !!}--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label">
                                    <label>@lang('common.department')</label>
                                </div>
                                <div class="kt-form__control">
                                    {!! Form::select('department_id', $departments,null,['class' => 'form-control  kt-selectpicker','id'=>'kt_form_department','data-live-search'=>'true','multiple']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label">
                                    <label>Position</label>
                                </div>
                                <div class="kt-form__control">
                                    {!! Form::select('position_id', $positions,null,['class' => 'form-control  kt-selectpicker','id'=>'kt_form_position','data-live-search'=>'true','multiple']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label">
                                    <label>Organisation Unit</label>
                                </div>
                                <div class="kt-form__control">
                                    {!! Form::select('organisation_unit_id', $organisation_units,null,['class' => 'form-control  kt-selectpicker','id'=>'kt_form_organisation_unit','data-live-search'=>'true','multiple']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label">
                                    <label>Project</label>
                                </div>
                                <div class="kt-form__control">
                                    {!! Form::select('project_id', $projects,null,['class' => 'form-control  kt-selectpicker','id'=>'kt_form_project','data-live-search'=>'true','multiple']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label"><label>@lang('common.status')</label></div>
                                <div class="kt-form__control">
                                    {!! Form::select('status_id', $statuses,null,['class' => 'form-control  kt-selectpicker','id'=>'kt_form_status','multiple']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" form-group row align-items-center">
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label"><label>@lang('common.start') @lang('common.date')</label></div>
                                <div class="kt-form__control">
                                    <input type="text" class="form-control  kt_datepicker_1_validate" autocomplete="off" name="start_date" placeholder="@lang('common.start') @lang('common.date')" value="" id="kt_form_start_date" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label"><label>@lang('common.end') @lang('common.date')</label></div>
                                <div class="kt-form__control">
                                    <input type="text" class="form-control  kt_datepicker_1_validate" name="end_date" autocomplete="off" placeholder="@lang('common.start') @lang('common.date')" value="" id="kt_form_end_date"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label"><label>Minimum Leave Period</label></div>
                                <div class="kt-form__control">
                                    <input type="text" class="form-control number_mask"  autocomplete="off" name="min" placeholder="Minimum Leave Period" value="" id="kt_form_min"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label"><label>Maximum Leave Period</label></div>
                                <div class="kt-form__control">
                                    <input type="text" class="form-control number_mask"  autocomplete="on"  name="max" placeholder="Maximum Leave Period" value=""  id="kt_form_max"/>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" id="kt_form_search">@lang('common.apply')</button>
                    </div>
                </div>
                <!--end: Search Form -->
            </div>
        </div>
    </div>
    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
										<span class="kt-portlet__head-icon">
											<i class="kt-font-brand flaticon2-user"></i>
										</span>
                    <h3 class="kt-portlet__head-title">
                        @lang('common.list') @lang('common.of') @lang('url.leave')
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <button class="btn btn-primary" id="export">Export To Excel <i class="flaticon2-download"></i></button>
                    </div>
                </div>
            </div>

            <div class="kt-portlet__body kt-portlet__body--fit">
                <!--begin: Datatable -->
                <div class="kt-datatable" id="auto_column_hide"></div>

                <!--end: Datatable -->
            </div>
        </div>
    </div>
    <form id="export-form" action="{{route ('leave.export')}}" method="POST" hidden>
        @csrf
        <input  name="search" value="" id="search" >
        <input  name="department_ids" value="" id="department_ids" >
        <input  name="position_ids" value="" id="position_ids" >
        <input  name="organisation_unit_ids" value="" id="organisation_unit_ids" >
        <input  name="project_ids" value="" id="project_ids" >
        <input  name="status_ids" value="" id="status_ids" >
        <input  name="start_date" value="" id="start_date" >
        <input  name="end_date" value="" id="end_date" >
        <input  name="min" value="" id="min" >
        <input  name="max" value="" id="max" >
    </form>
    <!-- end:: Content -->
@stop
@section('script')
    @include('layouts.include.script.script_list')
    {!! Html::script('assets/app/custom/general/crud/metronic-datatable/advanced/table-leave.js') !!}
    {{--    {!! Html::script('assets/js/demo2/pages/crud/forms/validation/form-employee.js') !!}--}}

    <script>
$( "#export" ).click(function() {
        $(`#search`).val($('#generalSearch').val()) ;
        $(`#department_ids`).val($('#kt_form_department').val());
        $(`#position_ids`).val($('#kt_form_position').val());
        $(`#organisation_unit_ids`).val($('#kt_form_organisation_unit').val());
        $(`#project_ids`).val($('#kt_form_project').val()) ;
        $(`#status_ids`).val($('#kt_form_status').val())  ;
        $(`#start_date`).val($('#kt_form_start_date').val()) ;
        $(`#end_date`).val($('#kt_form_end_date').val());
        $(`#min`).val($('#kt_form_min').val()) ;
        $(`#max`).val($('#kt_form_max').val()) ;
    $(`#export-form`).submit();
   {{--let data: {search: search,department_ids: department_ids,position_ids: position_ids,organisation_unit_ids: organisation_unit_ids,project_ids: project_ids,status_ids: status_ids--}}
   {{--     ,start_date: start_date,end_date:end_date,min: min,max: max},--}}

});
    </script>

@stop
