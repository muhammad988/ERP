@extends('layouts.app')
@section('style')
    @include('layouts.include.style.style_form')
@stop
@section('content')
    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h1 class="kt-portlet__head-title">
                        @lang('url.create')
                    </h1>
                </div>
            </div>
            <!--begin::Form-->
            <form method="POST" action="{{route('leave.daily_store')}} " class="kt-form" id="kt_form_2">
                @csrf
                {!! Form::hidden ('lang','en') !!}
                <div class="kt-portlet__body">
                    <div class="kt-section">
                        <div class="kt-section__content">
                            <div class="form-group">
                                <div class="col-lg-4 " id="service_method_dev">
                                    <label class="form-control-label">On behalf of</label>
                                    {!! Form::select('on_behalf_of_id', $on_behalf_users,null,['class' => 'form-control ','id'=>'on_behalf_of_id']) !!}

                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="col-lg-4 " id="service_method_dev">
                                    <label class="form-control-label">Type</label>
                                    {!! Form::select('leave_type_id', $leave_types,null,['class' => 'form-control ','id'=>'leave_type','required']) !!}
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="col-lg-4">
                                    <label class="form-control-label">Date Range <span class="required"> *</span></label>
                                    <div class="input-group" id="kt_daterangepicker_leave">
                                        <input type="text" class="form-control" value="" readonly required name="date_range" id="date_range"  placeholder="Select date range">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="file" style="display: none;" >
                                <div class="col-lg-4">
                                    <label class="form-control-label">File <span class="required"> *</span></label>
                                    <div class="custom-file">
                                        <input type="file" required class="custom-file-input"  name="file" id="input-file">
                                        <label class="custom-file-label" for="input-file">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="col-lg-4">
                                    <label class="form-control-label">Reason</label>
                                    <textarea name="reason" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" data-ktwizard-type="action-submit" class="btn btn-sm btn-label-success btn-bold"><i class="la la-save"></i> @lang('common.save')</button>
                                <button onClick="window.location.reload();" type="reset" class="btn btn-sm btn-bold btn-label-warning"><i class="la la-rotate-right"></i>Reset</button>
                                <a href="/" class="btn btn-bold btn-sm btn-label-danger"> <i class="la la-close"></i>@lang('common.cancel') </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Portlet-->
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Budget Line</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead class="thead-light">
                        <tr>
                            <th>Budget</th>
                            <th>Reserve</th>
                            <th>Expense</th>
                            <th>Usable</th>
                            <th>Remaining</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr id="tr-row">

                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end:: Content -->
@stop
@section('script')
    @include('layouts.include.script.script_jquery_form')
    {!! Html::script('assets/js/demo2/pages/crud/forms/validation/form-annual.js') !!}
    <script>
       let type= $("#leave_type");
       type.change(function () {
           if (type.val() == 50019 || type.val() == 55160) {
               $('#kt_daterangepicker_leave').daterangepicker({
                   buttonClasses: ' btn',
                   applyClass: 'btn-primary',
                   cancelClass: 'btn-secondary',
                   singleDatePicker: true,
               }, function (start, end, label) {
                   if (type.val() == 50019) {
                       end.add(1, 'year');
                   }
                   if (type.val() == 55160) {
                       end.add(3, 'days');
                   }
                   $('#kt_daterangepicker_leave .form-control').val(start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
               });
           }


        });
       type.change(function () {
           let file=$("#file");
            if (type.val() == 50018 || type.val() ==55161 || type.val() ==55151 || type.val() ==50019 || type.val() ==313622) {
                file.show(500);
                $('#input-file').prop('disabled', false);

            }else{
                file.hide(500);
                $('#input-file').prop('disabled', true);

                // $('#input-file').val('tets');
            }
        });
        $('#kt_daterangepicker_leave').daterangepicker({
            buttonClasses: ' btn',
            applyClass: 'btn-primary',
            cancelClass: 'btn-secondary',
            // singleDatePicker: true,
            // showDropdowns: true,
        }, function (start, end, label) {
            $('#kt_daterangepicker_leave .form-control').val(start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
    </script>
@stop
