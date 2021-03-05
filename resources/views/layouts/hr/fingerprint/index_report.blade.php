@extends('layouts.app')
{{--@extends('layouts.worksheet.worksheet')--}}

@section('style')
    @include('layouts.include.style.style_list')
@stop
@section('content')
    <div class="kt-portlet  kt-portlet--collapse" data-ktportlet="true" id="kt_portlet_tools_1">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    بحث
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
                                <label>بحث</label>
                                <input type="text" class="form-control" placeholder="Search..." id="search">
                                <span class="kt-input-icon__icon kt-input-icon__icon--left">
																<span><i class="la la-search"></i></span>
															</span>
                            </div>
                        </div>
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label">
                                    <label>القسم</label>
                                </div>
                                <div class="kt-form__control">
                                    {!! Form::select('department_id', $departments,null,['class' => 'form-control  kt-selectpicker','id'=>'kt_form_department','data-live-search'=>'true','multiple']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label">
                                    <label>المشروع</label>
                                </div>
                                <div class="kt-form__control">
                                    {!! Form::select('project_id', $projects,null,['class' => 'form-control  kt-selectpicker','id'=>'kt_form_project','data-live-search'=>'true','multiple']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label">
                                    <label>مركز</label>
                                </div>
                                <div class="kt-form__control">
                                    {!! Form::select('center_id', $centers,null,['class' => 'form-control  kt-selectpicker','id'=>'kt_form_center','data-live-search'=>'true','multiple']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label">
                                    <label>الدوام المفترض</label>
                                </div>
                                <div class="kt-form__control">
                                    {!! Form::select('work_status_id', $work_statuses,null,['class' => 'form-control  kt-selectpicker','id'=>'kt_form_work_status','data-live-search'=>'true','multiple']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" form-group row align-items-center">
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label">
                                    <label>المنصب</label>
                                </div>
                                <div class="kt-form__control">
                                    {!! Form::select('position_id', $positions,null,['class' => 'form-control  kt-selectpicker','id'=>'kt_form_position','data-live-search'=>'true','multiple']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label"><label>تاريخ البدء</label></div>
                                <div class="kt-form__control">
                                    <input type="text" class="form-control  kt_datepicker_1_validate" autocomplete="off" name="start_date" placeholder="تاريخ البدء" value="" id="kt_form_start_date" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label"><label>تاريخ الانتهاء</label></div>
                                <div class="kt-form__control">
                                    <input type="text" class="form-control  kt_datepicker_1_validate" name="end_date" autocomplete="off" placeholder="تاريخ الانتهاء" value="" id="kt_form_end_date"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" id="kt_form_search">بحث</button>
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
                        التقرير
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-toolbar">
                            <div class="kt-portlet__head-wrapper">
                                <button class="btn btn-primary" id="export"><i class="la la-download"></i>Export To Excel </button>
{{--                                <button class="btn btn-primary" id="export"><i class="la la-download"></i> Export</button>--}}
                            </div>
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
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('common.edit')  @lang('url.worksheet')</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('worksheet.update',0)}}" id="kt_edit_form" class="kt-form">
                        @method('PUT')
                        @csrf
                        <input type="hidden" id="edit_id" value="" name="id">
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="form-group col-xl-4">
                                    <label>@lang('common.date')</label>
                                    <input type="text" class="form-control" disabled  autocomplete="off" id="edit_day" value="">
                                </div>
                                <div class="form-group col-xl-4">
                                    <label>@lang('user')</label>
                                    {!! Form::select('user_id', $users,null,['class' => 'form-control','id'=>'edit_user','disabled']) !!}
                                </div>
                            </div>
                            <div class="col-lg-12 kt-separator kt-separator--border-dashed kt-separator--space-sm"></div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <h6 id="edit_name_day">Saturday</h6>
                                    <div class="form-group">
                                        <label>Work Status</label>
                                        {!! Form::select('work_status_id', $work_statuses,null,['id' => 'edit_work_status_id','class' => 'form-control','required']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('common.start') @lang('common.time') </label>
                                        <input class="form-control kt_timepicker_2"  value="" id="edit_start_time" name="start_time" placeholder="Select time" type="text"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="row col-lg-12">Add Day</label>
                                        <span class=" kt-switch kt-switch--icon">
                                    <label>
                                        <input  type="checkbox" value="true"  id="edit_add_day"  name="add_day">
                                         <span></span>
                                     </label>
                                     </span>
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('common.end') @lang('common.time') </label>
                                        <input class="form-control kt_timepicker_2" id="edit_end_time"  name="end_time" placeholder="Select time" type="text"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <button class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-submit">@lang('common.submit')</button>
                                <button class="btn btn-danger  btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-dismiss="modal">@lang('common.cancel')</button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <form id="export-form" action="{{route ('fingerprint.export_report')}}" method="POST" hidden>
        @csrf
        <input  name="search" value="" id="search" >
        <input  name="department_ids" value="" id="department_ids" >
        <input  name="position_ids" value="" id="position_ids" >
        <input  name="work_status_ids" value="" id="work_status_ids" >
        <input  name="center_ids" value="" id="center_ids" >
        <input  name="project_ids" value="" id="project_ids" >
        <input  name="start_date" value="" id="start_date" >
        <input  name="end_date" value="" id="end_date" >
    </form>
@stop
@section('script')
    @include('layouts.include.script.script_list')
    {!! Html::script('assets/app/custom/general/crud/metronic-datatable/advanced/table-fingerprint-report.js') !!}
    {!! Html::script('assets/js/demo2/pages/crud/forms/validation/form-worksheet.js') !!}

    <script>
        $( "#export" ).click(function() {
            $(`#search`).val($('#search').val()) ;
            $(`#department_ids`).val($('#kt_form_department').val());
            $(`#position_ids`).val($('#kt_form_position').val());
            $(`#center_ids`).val($('#kt_form_center').val());
            $(`#project_ids`).val($('#kt_form_project').val()) ;
            $(`#work_status_ids`).val($('#kt_form_work_status').val())  ;
            $(`#start_date`).val($('#kt_form_start_date').val()) ;
            $(`#end_date`).val($('#kt_form_end_date').val());
            $(`#export-form`).submit();
            {{--let data: {search: search,department_ids: department_ids,position_ids: position_ids,organisation_unit_ids: organisation_unit_ids,project_ids: project_ids,status_ids: status_ids--}}
            {{--     ,start_date: start_date,end_date:end_date,min: min,max: max},--}}

        });
        {{--nested('department_status', 'superior_status', "{{$nested_url_superior}}");--}}
        {{--nested('mission_status', 'department_status', "{{$nested_url_department}}");--}}
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
