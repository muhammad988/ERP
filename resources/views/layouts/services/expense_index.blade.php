@extends('layouts.app')
@section('style')
    @include('layouts.include.style.style_list')
@stop
@section('content')
    <div class="kt-portlet  kt-portlet--collapse" data-ktportlet="true" id="kt_portlet_tools_1">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    Filter
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-group">
                    <a href="#" data-ktportlet-tool="toggle" class="btn btn-sm btn-icon btn-clean btn-icon-md"
                       aria-describedby="tooltip_nrgbx2wq7w"><i class="la la-angle-down"></i></a>
                    <div class="tooltip tooltip-portlet tooltip bs-tooltip-top" role="tooltip" id="tooltip_nrgbx2wq7w"
                         aria-hidden="true" x-placement="top">
                        <div class="tooltip-arrow arrow"></div>
                        {{--                        <div class="tooltip-inner">Collapse</div>--}}
                    </div>
                </div>
            </div>
        </div>
        <input hidden id="project_id" value="{{$id}}">
        <input hidden id="type" value="{{$type}}">
        <div class="kt-portlet__body" style="display: none;">
            <div class="kt-portlet__content">
                <!--begin: Search Form -->
                <div class="kt-form kt-form--label-right">
                    <div class=" form-group row align-items-center">
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label"><label>@lang('common.start') @lang('common.date')</label>
                                </div>
                                <div class="kt-form__control">
                                    <input type="text" class="form-control  kt_datepicker_1_validate" autocomplete="off" name="start_date"
                                           placeholder="@lang('common.start') @lang('common.date')" value=""
                                           id="kt_form_start_date"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label"><label>@lang('common.end') @lang('common.date')</label>
                                </div>
                                <div class="kt-form__control">
                                    <input type="text" class="form-control  kt_datepicker_1_validate" name="end_date"
                                           autocomplete="off"
                                           placeholder="@lang('common.start') @lang('common.date')" value=""
                                           id="kt_form_end_date"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label"><label>Maximum Total Service</label></div>
                                <div class="kt-form__control">
                                    <input type="text" class="form-control  money" name="max_total"
                                           placeholder="Maximum Total" value="" id="kt_form_max_total"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label"><label>Minimum Total Service</label></div>
                                <div class="kt-form__control">
                                    <input type="text" class="form-control  money" name="min_total"
                                           placeholder="Minimum Total" value="" id="kt_form_min_total"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" form-group row align-items-center">
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label">
                                    <label>Service Method</label>
                                </div>
                                <div class="kt-form__control">
                                    {!! Form::select('service_method_id',$service_method,null,['class' => 'form-control kt-selectpicker','id'=>'kt_form_service_method','data-live-search'=>'true','multiple']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label">
                                    <label>Payment Method</label>
                                </div>
                                <div class="kt-form__control">
                                    {!! Form::select('payment_method_id',$payment_method,null,['class' => 'form-control kt-selectpicker','id'=>'kt_form_payment_method','data-live-search'=>'true','multiple']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label">
                                    <label>Service Type</label>
                                </div>
                                <div class="kt-form__control">
                                    {!! Form::select('service_type_id', $service_type,null,['class' => 'form-control  kt-selectpicker','id'=>'kt_form_service_type','data-live-search'=>'true','multiple']) !!}
                                </div>
                            </div>
                        </div>

                        @if($type=='expense')
                            <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                                <div class="kt-form__group">
                                    <div class="kt-form__label">
                                        <label>Close</label>
                                    </div>
                                    <div class="kt-form__control">
                                        {!! Form::select('close', [''=>trans('common.all'),'false'=>'Partial Closure','true'=>'Closed'],null,['class' => 'form-control','id'=>'kt_form_close']) !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group">
                                <div class="kt-form__label">
                                    <label>Requester</label>
                                </div>
                                <div class="kt-form__control">
                                    {!! Form::select('requester_id', $requester,null,['class' => 'form-control  kt-selectpicker','id'=>'kt_form_service_requester','data-live-search'=>'true','multiple']) !!}
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
            <div class="kt-portlet__head kt-portlet__head--lg form-group">
                <div class="kt-portlet__head-label">
										<span class="kt-portlet__head-icon">
											<i class="kt-font-brand flaticon2-user"></i>
										</span>
                    <h3 class="kt-portlet__head-title">
                        @lang('common.list') @lang('common.of') Service
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__head kt-portlet__head--lg">
                {{--                <div class=" form-group  col-md-12 row">--}}
                {{--                    <div class="col-md-2 row kt-margin-b-20-tablet-and-mobile">--}}
                {{--                        <div class="kt-input-icon kt-input-icon--left">--}}
                {{--                            <label class="col-form-label col-lg-3 col-sm-12">@lang('common.search') By Code</label>--}}
                {{--                            <div class="col-lg-4 col-md-9 col-sm-12">--}}
                {{--                                <input type="text" class="form-control" placeholder="Code..." id="generalSearch">--}}
                {{--                                <span class="kt-input-icon__icon kt-input-icon__icon--left"><span><i class="la la-search"></i></span></span>--}}
                {{--                            </div>--}}

                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                <div class="col-lg-12">
                    <div class=" row">
                        <label class="col-form-label col-lg-1">@lang('common.search') By Code</label>
                        <div class="col-lg-2">
                            <input type="text" class="form-control" placeholder="Code..." id="generalSearch">
                        </div>
                        <label class="col-form-label col-lg-1" style="text-align: right;">Group By</label>
                        <div class="col-lg-2">
                            {!! Form::select('group_by', [''=>trans('common.all'),'service_type_id'=>'Service Type','service_method_id'=>'Service method','payment_method_id'=>'Payment Method'],null,['class' => 'form-control','id'=>'kt_form_group_by']) !!}
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
    <div class="modal fade" id="service-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Service Request Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="view-service">
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
    {!! Html::script('assets/app/custom/general/crud/metronic-datatable/advanced/table-expense-service.js') !!}
    <script>
        $(document).on('click', `.view`, function () {
            let view_service = $('#view-service');
            $.ajax({
                url: `/service/view/${$(this).attr('id')}`,
                type: 'get',
                success: function ($data) {
                    view_service.empty();
                    view_service.append(`${$data}`);
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
