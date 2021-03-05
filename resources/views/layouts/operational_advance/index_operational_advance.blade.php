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
                        <input hidden id="id" value="{{$service->id}}">
                        @lang('common.list') @lang('common.of') Clearance / {{$service->code}}
                    </h3>
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
    <!-- end:: Content -->
    <div class="modal fade" id="clearance-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Clearance Request Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="view-clearance">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    @include('layouts.include.script.script_list')
    {!! Html::script('assets/app/custom/general/crud/metronic-datatable/advanced/table-clearance-operational-advance.js') !!}
    <script>
        $(document).on('click', `.view`, function () {
            let view_clearance = $('#view-clearance');
            $.ajax({
                url: `/clearance/view/${$(this).attr('id')}`,
                type: 'get',
                success: function ($data) {
                    view_clearance.empty();
                    view_clearance.append(`${$data}`);
                    $(".money").inputmask({
                        "alias": "decimal",
                        "digits": 2,
                        "autoGroup": true,
                        "allowMinus": true,
                        "rightAlign": false,
                        "groupSeparator": ",",
                        "radixPoint": ".",
                    });
                }
            });
        });
    </script>
@stop
