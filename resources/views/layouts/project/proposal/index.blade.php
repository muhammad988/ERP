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
                                    {!! Form::select('mission_id', $missions,null,['class' => 'form-control kt-selectpicker','id'=>'kt_form_mission','data-live-search'=>'true','multiple']) !!}
                                </div>
                            </div>
                        </div>
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
                                    <label>@lang('project.project')</label>
                                </div>
                                <div class="kt-form__control">
                                    {!! Form::select('project_id', $projects,null,['class' => 'form-control  kt-selectpicker','id'=>'kt_form_project','data-live-search'=>'true','multiple']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label">
                                    <label>@lang('hr.contract')</label>
                                </div>
                                <div class="kt-form__control">
                                    {!! Form::select('contract_id', $contracts,null,['class' => 'form-control  kt-selectpicker','id'=>'kt_form_contract','data-live-search'=>'true','multiple']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label">
                                    <label>@lang('common.type') @lang('common.of')@lang('hr.contract')</label>
                                </div>
                                <div class="kt-form__control">
                                    {!! Form::select('type_of_contract_id', $type_of_contracts,null,['class' => 'form-control  kt-selectpicker','id'=>'kt_form_type_of_contract','onclick'=>'test()','data-live-search'=>'true','multiple']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" form-group row align-items-center">
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label">
                                    <label>@lang('common.position')</label>
                                </div>
                                <div class="kt-form__control">
                                    {!! Form::select('position_id', $positions,null,['class' => 'form-control  kt-selectpicker','id'=>'kt_form_position','data-live-search'=>'true','multiple']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label">
                                    <label>@lang('hr.nationality')</label>
                                </div>
                                <div class="kt-form__control">
                                    {!! Form::select('nationality_id', $nationalities,null,['class' => 'form-control  kt-selectpicker','id'=>'kt_form_nationality','data-live-search'=>'true','multiple']) !!}
                                </div>
                            </div>
                        </div>
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
                                <div class="kt-form__label"><label>@lang('common.active')</label></div>
                                <div class="kt-form__control">
                                    {!! Form::select('disabled',[''=>'All','0'=> ' Active','1'=> 'disabled'],null,['class' => 'form-control  kt-selectpicker','id'=>'kt_form_disabled']) !!}                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" id="kt_form_search">@lang('common.search')</button>
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
                        @lang('common.list') @lang('common.of') @lang('hr.employee')
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="dropdown dropdown-inline">
                            <a href="{{route( 'employee.create' )}}" class="btn btn-brand btn-icon-sm" aria-haspopup="true" aria-expanded="false">
                                <i class="flaticon2-plus"></i> @lang('hr.employee')
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
@include('layouts.project.proposal.status')
    <!-- end:: Content -->
@stop
@section('script')
    @include('layouts.include.script.script_list')
    {!! Html::script('assets/app/custom/general/crud/metronic-datatable/advanced/table-employee.js') !!}
    {!! Html::script('assets/js/demo2/pages/crud/forms/validation/form-employee.js') !!}

    <script>
        nested('department_status', 'superior_status', "{{$nested_url_superior}}");
        nested('mission_status', 'department_status', "{{$nested_url_department}}");
        $(`#kt_form_department`).change(function () {
            let dropdown = $(`#kt_form_position`);
            dropdown.empty();
            let val = $(this).val();
            $.ajax({
                url: '{{$nested_url_position}}',
                method: 'POST',
                data: {id: val},
                success: function (data) {
                    dropdown.append($('<option></option>').attr('value', '').text('All'));
                    $.each(data, function (i, item) {
                        dropdown.append($('<option></option>').attr('value', i).text(item));
                    });
                    $('#kt_form_position').selectpicker('refresh')
                },
                error: function () {
                }
            });

        });

        $(`#kt_form_mission`).change(function () {
            let dropdown = $(`#kt_form_department`);
            dropdown.empty();
            let val = $(this).val();
            $.ajax({
                url: '{{$nested_url_department_multiple}}',
                method: 'POST',
                data: {id: val},
                success: function (data) {
                    dropdown.append($('<option></option>').attr('value', '').text('All'));
                    $.each(data, function (i, item) {
                        dropdown.append($('<option></option>').attr('value', i).text(item));
                    });
                    $('#kt_form_department').selectpicker('refresh')
                },
                error: function () {
                }
            });
        });
    </script>

@stop
