@extends('layouts.app')
@section('style')
    @include('layouts.include.style.style_modal_list')
@stop
@section('content')
    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_2">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        {{$project['name_'.app()->getLocale() .'']}} - @lang('common.responsibility')
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
                        @foreach($responsibility as $key=>$value)
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
                                    <label>
                                        @foreach(explode('_', $value) as $data)
                                            @lang('common.'.$data.'')
                                        @endforeach
                                        <span class="required" aria-required="true"> *</span>
                                    </label>
                                    @if($value !='project_officer')
                                        {!! Form::select($value,  [''=>trans('common.please_select')]+$users ,$project_responsibility->$value,['class' => 'form-control select2 authority ','id'=>''.$value.'']) !!}
                                    @else
                                        {!! Form::select($value, $users,json_decode ($project_responsibility->$value),['class' => 'form-control  kt-selectpicker-2 authority','id'=>''.$value.'','data-live-search'=>'true','data-actions-box'=>'true','multiple']) !!}
                                    @endif
                                    <span class="form-text text-muted"></span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!--end::Portlet-->
    </div>
    <!-- end:: Content -->
@stop
@section('script')
    @include('layouts.include.script.script_modal_list')
    <script>
        $(document).ready(function () {
            $(".kt-selectpicker-2").selectpicker({
                noneSelectedText: 'Please Select' // by this default 'Nothing selected' -->will change to Please Select
            });
        });
        @foreach($responsibility as $key=>$value)
        nested('department-{{$value}}', '{{$value}}', "{{$nested_url_superior}}");
        nested('mission-{{$value}}', 'department-{{$value}}', "{{$nested_url_department}}");
        @endforeach
        $(`.authority`).change(function () {
            let val = $(this).val();
            let name = $(this).attr("name");
            $.ajax({
                url: '{{$responsibility_update}}',
                method: 'POST',
                data: {'id': '{{$project->id}}', 'user_id': val, 'name': name, 'mission_id': `{{$project->sector->department->mission->id}}`},
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
