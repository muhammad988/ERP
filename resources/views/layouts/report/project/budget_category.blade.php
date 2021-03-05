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
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label">
                                    <label>@lang('common.mission')</label>
                                </div>
                                <div class="kt-form__control">
                                    {!! Form::select('mission_id', [],null,['class' => 'form-control kt-selectpicker','id'=>'kt_form_mission','data-live-search'=>'true','multiple']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label">
                                    <label>@lang('common.department')</label>
                                </div>
                                <div class="kt-form__control">
                                    {!! Form::select('department_id', [],null,['class' => 'form-control  kt-selectpicker','id'=>'kt_form_department','data-live-search'=>'true','multiple']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label">
                                    <label>@lang('common.sector')</label>
                                </div>
                                <div class="kt-form__control">
                                    {!! Form::select('sector_id', [],null,['class' => 'form-control  kt-selectpicker','id'=>'kt_form_sector','data-live-search'=>'true','multiple']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label">
                                    <label>Stage</label>
                                </div>
                                <div class="kt-form__control">
                                    {!! Form::select('stage_id', [],null,['class' => 'form-control  kt-selectpicker','id'=>'kt_form_stage','data-live-search'=>'true','multiple']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label"><label>@lang('common.status')</label></div>
                                <div class="kt-form__control">
                                    {!! Form::select('status_id', [],null,['class' => 'form-control  kt-selectpicker','id'=>'kt_form_status','data-live-search'=>'true','multiple']) !!}
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
                                <div class="kt-form__label"><label>Maximum @lang('project.budget')</label></div>
                                <div class="kt-form__control">
                                    <input type="text" class="form-control  currency" name="max_budget" placeholder="Maximum @lang('project.budget')" value=""  id="kt_form_max_budget"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label"><label>Minimum @lang('project.budget')</label></div>
                                <div class="kt-form__control">
                                    <input type="text" class="form-control  currency" name="min_budget" placeholder="Minimum @lang('project.budget')" value="" id="kt_form_min_budget"/>
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
                        @lang('common.list') @lang('common.of') @lang('project.project')
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="dropdown dropdown-inline">
                            <a href="{{route( 'proposal.create' )}}" class="btn btn-brand btn-icon-sm" aria-haspopup="true" aria-expanded="false">
                                <i class="flaticon2-plus"></i> @lang('project.project')
                            </a>
                        </div>
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
    <!-- end:: Content -->
@stop
@section('script')
    @include('layouts.include.script.script_list')
    {!! Html::script('assets/app/custom/general/crud/metronic-datatable/advanced/table-project.js') !!}
    {{--    {!! Html::script('assets/js/demo2/pages/crud/forms/validation/form-employee.js') !!}--}}

    {{--    <script>--}}
    {{--        $(`#kt_form_mission`).change(function () {--}}
    {{--            let dropdown = $(`#kt_form_department`);--}}
    {{--            dropdown.empty();--}}
    {{--            let val = $(this).val();--}}
    {{--            $.ajax({--}}
    {{--                url: '{{$nested_url_department_multiple}}',--}}
    {{--                method: 'POST',--}}
    {{--                data: {id: val},--}}
    {{--                success: function (data) {--}}
    {{--                    dropdown.append($('<option></option>').attr('value', '').text('All'));--}}
    {{--                    $.each(data, function (i, item) {--}}
    {{--                        dropdown.append($('<option></option>').attr('value', i).text(item));--}}
    {{--                    });--}}
    {{--                    $('#kt_form_department').selectpicker('refresh')--}}
    {{--                },--}}
    {{--                error: function () {--}}
    {{--                }--}}
    {{--            });--}}
    {{--        });--}}
    {{--        $(`#kt_form_department`).change(function () {--}}
    {{--            let dropdown = $(`#kt_form_sector`);--}}
    {{--            dropdown.empty();--}}
    {{--            let val = $(this).val();--}}
    {{--            let mission_id =$(`#kt_form_mission`).val();--}}
    {{--            $.ajax({--}}
    {{--                url: '{{$nested_url_sector_multiple}}',--}}
    {{--                method: 'POST',--}}
    {{--                data: {id: val,mission_id:mission_id},--}}
    {{--                success: function (data) {--}}
    {{--                    dropdown.append($('<option></option>').attr('value', '').text('All'));--}}
    {{--                    $.each(data, function (i, item) {--}}
    {{--                        dropdown.append($('<option></option>').attr('value', i).text(item));--}}
    {{--                    });--}}
    {{--                    $('#kt_form_sector').selectpicker('refresh')--}}
    {{--                },--}}
    {{--                error: function () {--}}
    {{--                }--}}
    {{--            });--}}
    {{--        });--}}
    {{--    </script>--}}

@stop
