@extends('layouts.app')
@section('style')
    @include('layouts.include.style.style_list')
@stop
@section('content')
    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
										<span class="kt-portlet__head-icon">
											<i class="kt-font-brand flaticon2-user"></i>
										</span>
                    <h3 class="kt-portlet__head-title">
                        @lang('common.list') @lang('common.of') @lang('url.fingerprint')
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
{{--                            <button class="btn btn-primary" id="export"><i class="la la-download"></i> Export</button>--}}
                            <button class="btn btn-primary" data-toggle="modal" data-target="#import"><i class="la la-upload"></i> Import</button>
                            <div class="modal fade" id="import" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog  modal-dialog-centered  modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" >Import</h5>
                                        </div>
                                        <form id="import_form" action="{{route ('fingerprint.import')}}"  method="POST" enctype="multipart/form-data" class="form-horizontal">

                                        <div class="modal-body">
                                                <div class="kt-form__group">
                                                    <div class="kt-form__label"><label>Select Excel File max (10M) (csv / xlsx)</label></div>
                                                    <div class="kt-form__control">
                                                        <input type="file" required name="file" id="file" />
                                                    </div>
                                                </div>

                                                <div class="progress mt-3" id="process" style="display: none;">
                                                    <div class="progress-bar progress-bar-striped" id="bar"  role="progressbar" style="width: 100%">90%</div>
                                                </div>
                                        </div>
                                        <div class="kt-portlet__foot">
                                            <div class="kt-form__actions">
                                                <button  type="submit"  class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u">@lang('common.submit')</button>
                                                <div class="btn btn-danger  btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-dismiss="modal">@lang('common.cancel')</div>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
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
    <form id="export-form" action="{{route ('leave.export')}}" method="POST" hidden>
        @csrf
        <input  name="search" value="" id="search" >
        <input  name="department_ids" value="" id="department_ids" >
        <input  name="position_ids" value="" id="position_ids" >
        <input  name="organisation_unit_ids" value="" id="organisation_unit_ids" >
        <input  name="project_ids" value="" id="project_ids" >
        <input  name="start_date" value="" id="start_date" >
        <input  name="end_date" value="" id="end_date" >
    </form>
    <!-- end:: Content -->
@stop
@section('script')
    @include('layouts.include.script.script_list')
    {!! Html::script('assets/app/custom/general/crud/metronic-datatable/advanced/table-fingerprint.js') !!}
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
$(function() {
    let process = $('#process');
    let br = $('#bar');
    // var status = $('#status');
    $('#import_form').ajaxForm({
        beforeSend: function() {
            // status.empty();
            let percentVal = '0%';
            br.width(percentVal);
            br.html(percentVal);

            process.show();
            // percent.html(percentVal);
        },
        uploadProgress: function(event, position, total, percentComplete) {

            let percentVal = percentComplete + '%';
            br.width(percentVal);
            br.html(percentVal);
        },
        success: function(data) {

            if(data.error_row_count > 0){
                swal .fire({
                    title: `Total Row: ${data.row_count}
                    Total Success Row: ${data.success_row_count}
                     Total Error Row: ${data.error_row_count}` ,
                    html:  `Error in index:
                      <b>${data.error_row}</b>` ,
                    type: 'warning',
                    confirmButtonText: "OK",

                })
            }else if(data.error_row_count ==0 || data.success_row_count==0){
                swal .fire({
                    title: `Total Row: ${data.row_count}
                    Total Success Row: ${data.success_row_count}
                     Total Error Row: ${data.error_row_count}` ,
                    text:  `This file already exists` ,
                    type: 'error',
                    confirmButtonText: "OK",
                })
            }else{
                swal .fire({
                    title: `Total Row: ${data.row_count}
                    Total Success Row: ${data.success_row_count}
                     Total Error Row: ${data.error_row_count}` ,
                    type: 'success',
                    confirmButtonText: "OK",
                })
            }
            $("#import_form")[0].reset();
            process.hide();
            let percentVal = '0%';
            br.width(percentVal);
            br.html(percentVal);
            // status.html(xhr.responseText);
        }
    });
});
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


    </script>

@stop
