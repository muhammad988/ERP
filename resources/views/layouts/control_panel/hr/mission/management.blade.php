@extends('layouts.app')
@section('style')
    @include('layouts.include.style.style_modal_list')
@stop
@section('content')
    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        {{$mission['name_'.app()->getLocale() .'']}} - @lang('common.department')
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-group">
                        <button type="button" class="btn btn-brand btn-icon-sm" data-toggle="modal" data-target="#add"><i class="flaticon2-plus"></i>@lang('common.department')</button>
                        <a href="#" data-ktportlet-tool="toggle" class="btn btn-sm btn-icon btn-clean btn-icon-md" aria-describedby="tooltip_nrgbx2wq7w"><i class="la la-angle-down"></i></a>
                        {{--                        <a href="#" data-ktportlet-tool="reload" class="btn btn-sm btn-icon btn-clean btn-icon-md"><i class="la la-refresh"></i></a>--}}
                        {{--                        <a href="#" data-ktportlet-tool="remove" class="btn btn-sm btn-icon btn-clean btn-icon-md"><i class="la la-close"></i></a>--}}
                        <div class="tooltip tooltip-portlet tooltip bs-tooltip-top" role="tooltip" id="tooltip_nrgbx2wq7w" aria-hidden="true" x-placement="top" style="position: absolute; will-change: transform; visibility: hidden; top: 0px; left: 0px; transform: translate3d(440px, -38px, 0px);">
                            <div class="tooltip-arrow arrow" style="left: 34px;"></div>
                            <div class="tooltip-inner">Collapse</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="kt-portlet__content">
                    <div id="new_html_department">
                        @foreach($mission->departments_with_parent as $key=>$value)
                            <div class="form-group row row_{{$value->pivot->id}}">
                                <div class="col-md-4">
                                    <label class="review">@lang('common.department')</label>
                                    <br>
                                    {{$value->name_en}}
                                </div>
                                <div class="col-md-2">
                                    <label class="review">@lang('common.parent')</label>
                                    <br>
                                    {{$value->parent}}
                                </div>
                                <div class="col-md-2">
                                    <label class="review">@lang('common.start') @lang('common.date')</label>
                                    <br>
                                    {{$value->pivot->start_date}}
                                </div>
                                <div class="col-md-2">
                                    <label class="review">Active</label>
                                    <br>
                                    <label class="kt-checkbox kt-checkbox--bold kt-checkbox--disabled">
                                        <input type="checkbox"  {{$value->pivot->status == '1' ? 'checked' : '' }} disabled="disabled">
                                        <span></span>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <a href="{{route( 'mission.management_department_sector_edit', $value->pivot->id )}}" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-plus"></i></a>
                                    <button onclick="action_delete({{$value->pivot->id}})" data-form-type="action-edit" data-id="180719" data-target="#edit_mission" class="btn btn-sm btn-clean btn-icon btn-icon-md test" title="Edit details">
                                        <i class="la la-trash"></i>
                                    </button>
                                    <button onclick="action_edit({{$value->pivot->id}})" data-form-type="action-edit" data-id="180719" data-target="#edit_mission" class="btn btn-sm btn-clean btn-icon btn-icon-md test" title="Edit details">
                                        <i class="la la-edit"></i>
                                    </button>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_2">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        {{$mission['name_'.app()->getLocale() .'']}} - @lang('authority.authority') @lang('common.and')  @lang('common.responsibility')
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-group">
                        <a href="#" data-ktportlet-tool="toggle" class="btn btn-sm btn-icon btn-clean btn-icon-md" aria-describedby="tooltip_nrgbx2wq7w"><i class="la la-angle-down"></i></a>
                        <div class="tooltip tooltip-portlet tooltip bs-tooltip-top" role="tooltip" id="tooltip_nrgbx2wq7w" aria-hidden="true" x-placement="top" style="position: absolute; will-change: transform; visibility: hidden; top: 0px; left: 0px; transform: translate3d(440px, -38px, 0px);">
                            <div class="tooltip-arrow arrow" style="left: 34px;"></div>
                            <div class="tooltip-inner">Collapse</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="kt-portlet__content">
                    <div id="new_html_department">
                        @foreach($authority as $key=>$value)
                            <div class="form-group row row_{{$value}}">
                                <div class="form-group col-lg-3">
                                    <label>@lang('common.mission') </label>
                                    {!! Form::select('mission_id', $missions,null,['class' => 'form-control select2 ','id'=>'mission-'.$value.'']) !!}
                                    <span class="form-text text-muted"></span>
                                </div>
                                <div class="form-group col-lg-3">
                                    <label>@lang('hr.department') </label>
                                    {!! Form::select('department_id', [''=>trans('common.please_select')],null,['class' => 'form-control select2 ','id'=>'department-'.$value.'']) !!}
                                    <span class="form-text text-muted"></span>
                                </div>
                                <div class="form-group col-lg-3">
                                    <label>@foreach(explode('_', $value) as $data)
                                            @lang('common.'.$data.'')
                                        @endforeach  <span class="required" aria-required="true"> *</span></label>
                                    {!! Form::select($value, $users ,$mission->$value,['class' => 'form-control select2 authority ','id'=>''.$value.'']) !!}
                                    <span class="form-text text-muted"></span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!--end::Portlet-->
        @include('layouts.control_panel.hr.mission.department.add')
        @include('layouts.control_panel.hr.mission.department.edit')
    </div>
    <!-- end:: Content -->
@stop
@section('script')
    @include('layouts.include.script.script_modal_list')
    {!! Html::script('assets/js/demo2/pages/crud/forms/validation/form-management.js') !!}
    <script>
        @foreach($authority as $key=>$value)
            nested('department-{{$value}}', '{{$value}}', "{{$nested_url_superior}}");
             nested('mission-{{$value}}', 'department-{{$value}}', "{{$nested_url_department}}");
        @endforeach
        $(`.authority`).change(function () {
            let val = $(this).val();
            let name = $(this).attr("name");
            $.ajax({
                url: '{{$authority_update}}',
                method: 'POST',
                data: {'id': '{{$mission->id}}','user_id': val,'name':name},
                success: function (data) {
                    toastr.success(data.success);
                },
                error: function (data) {
                    toastr.error(data.responseJSON.error);
                }
            });
        });
    </script>
@stop
