@extends('layouts.app')
@section('style')
    @include('layouts.include.style.style_form')
    {{--    {!! Html::style('assets/app/custom/wizard/wizard-v1.demo2.css') !!}--}}
@stop
@section('content')
    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">

        <!--Begin::Section-->
        <div class="kt-portlet ">
            <div class="kt-portlet__body">
                <div class="kt-widget kt-widget--user-profile-3">
                    <div class="kt-widget__top">
                        <div class="kt-widget__content">
                            <div class="kt-widget__head">
                                <a href="#" class="kt-widget__title">{{$project->name_en}}</a>
                                <div class="kt-widget__action">

                                    @if($first_project_notification->requester === Auth::id () && $project->status_id==$status->in_progress && $project->stage_id === $stage->concept )
                                        <a href="{{route ('proposal.edit',$project->id)}}" class="btn btn-warning btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u">@lang('common.edit')</a>
                                    @endif
                                        @if($first_project_notification->requester === Auth::id () && $last_project_notification->status_id === $status->in_progress && $project->status_id == 171)
                                            <a href="#" id="confirm" class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"> Confirm</a>
                                            <form id="confirm-form" action="{{ route('project.action') }}" method="POST" hidden>
                                                @csrf
                                                <input hidden name="action" value="confirm">
                                                <input hidden name="id" value="{{$project->id}}">
                                            </form>
                                        @endif
                                    @if($last_project_notification->receiver === Auth::id ()  && $project->status_id==$status->in_progress  && $project->stage_id === $stage->concept )
                                            <a href="#" id="accept" class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"> @lang('common.accept')</a>
                                            <form id="accept-form" action="{{ route('proposal.action') }}" method="POST" hidden>
                                                @csrf
                                                <input hidden name="action" value="accept">
                                                <input hidden name="id" value="{{$project->id}}">
                                            </form>
                                            <a href="#" id="reject" class="btn btn-danger btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"> @lang('common.reject')</a>
                                            <form id="reject-form" action="{{ route('proposal.action') }}" method="POST" hidden>
                                                @csrf
                                                <input hidden name="action" value="reject">
                                                <input hidden name="id" value="{{$project->id}}">
                                            </form>
                                        @endif
                                </div>
                            </div>
                            <div class="kt-widget__info">
                                <div class="kt-widget__stats  align-items-center row">
                                    <div class="kt-widget__item  col-lg-2">
                                <span class="kt-widget__date">
                                   @lang('common.location')
                                </span>
                                        <div class="kt-widget__label">
                                            {{$project->organisation_unit->name_en}}
                                        </div>
                                    </div>
                                    <div class="kt-widget__item  col-lg-2">
                                <span class="kt-widget__date">
                                   @lang('common.department')
                                </span>
                                        <div class="kt-widget__label">
                                            {{  $project->sector->department->department->name_en }}
                                        </div>
                                    </div>
                                    <div class="kt-widget__item  col-lg-2">
                                <span class="kt-widget__date">
                                   @lang('common.sector')
                                </span>
                                        <div class="kt-widget__label">
                                            {{ $project->sector->sector->name_en }}
                                        </div>
                                    </div>
                                    <div class="kt-widget__item  col-lg-2">
                                <span class="kt-widget__date">
                                     @lang('common.start')@lang('common.date')
                                </span>
                                        <div class="kt-widget__label">
                                            <span class="btn btn-label-brand btn-sm btn-bold btn-upper">{{$project->start_date}}</span>
                                        </div>
                                    </div>
                                    <div class="kt-widget__item col-lg-2">
                                <span class="kt-widget__date">
                                    @lang('common.end')@lang('common.date')
                                </span>
                                        <div class="kt-widget__label">
                                            <span class="btn btn-label-danger btn-sm btn-bold btn-upper">{{  $project->end_date }}</span>
                                        </div>
                                    </div>
                                    <div class="kt-widget__item col-lg-2">
                                <span class="kt-widget__date">
                                    @lang('common.duration')
                                </span>
                                        <div class="kt-widget__label">
                                            {{get_duration($project->start_date, $project->end_date)}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-widget__bottom">
                        <div class="kt-widget__item">
                            <div class="kt-widget__icon">
                                <i class="flaticon-coins"></i>
                            </div>
                            <div class="kt-widget__details">
                                <span class="kt-widget__title"> @lang('common.total') @lang('project.budget')</span>
                                <span class="kt-widget__value money"> {{$project->project_budget}}</span>
                            </div>
                        </div>

                        <div class="kt-widget__item">
                            <div class="kt-widget__icon">
                                <i class="flaticon2-group"></i>
                            </div>
                            <div class="kt-widget__details">
                                <span class="kt-widget__title"> @lang('project.catchment') @lang('common.area')</span>
                                <span class="kt-widget__value money">{{$project->proposal->catchment_area}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End::Section-->
        <!--Begin::Section-->
        <div class="row">
            <div class="col-xl-6">
                <!--begin:: Widgets/Download Files-->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                @lang('project.project') @lang('project.beneficiaries')
                            </h3>
                        </div>

                    </div>
                    <div class="kt-portlet__body">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <th> @lang('common.type') </th>
                            {{--                            <th> @lang('common.logistic') </th>--}}
                            <th> @lang('project.men')  </th>
                            <th> @lang('project.women') </th>
                            <th> @lang('project.boys')  </th>
                            <th>@lang('project.girls')  </th>
                            <th>@lang('common.total')  </th>
                            </thead>
                            <tbody>
                            @foreach($project->beneficiaries as $key=>$value)
                                <tr>
                                    <td> {{$value->type_name_en}}  </td>
                                    {{--                                    <td> {{$project->organisation_unit->name_en}} </td>--}}
                                    <td class="money">{{$value->men}}</td>
                                    <td class="money">{{$value->women}}</td>
                                    <td class="money">{{$value->boys}}</td>
                                    <td class="money">{{$value->girls}}</td>
                                    <td class="money">{{$value->men+$value->women+$value->boys+$value->girls}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!--end:: Widgets/Download Files-->
            </div>
            <div class="col-xl-6">
                <!--begin:: Widgets/Download Files-->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                @lang('project.indirect') @lang('project.beneficiaries')
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        {{$project->proposal->indirect_beneficiaries}}
                    </div>
                </div>

                <!--end:: Widgets/Download Files-->
            </div>
        </div>

        <!--End::Section-->

        <!--Begin::Section-->
        <div class="row">
            <div class="col-xl-6">
                <!--begin:: Widgets/Last Updates-->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                @lang('project.project')  @lang('project.summary')
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        {{$project->proposal->project_summary}}

                    </div>
                </div>

                <!--end:: Widgets/Last Updates-->
            </div>
            <div class="col-xl-6">
                <!--begin:: Widgets/Last Updates-->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                @lang('common.general')  @lang('project.objectives')
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        {{$project->proposal->overall_objective}}
                    </div>
                </div>

                <!--end:: Widgets/Last Updates-->
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <!--begin:: Widgets/Last Updates-->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                @lang('common.needs')  @lang('common.assessment')
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        {{$project->proposal->needs_assessment}}

                    </div>
                </div>

                <!--end:: Widgets/Last Updates-->
            </div>
            <div class="col-xl-6">
                <!--begin:: Widgets/Last Updates-->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                @lang('project.budget')  @lang('project.summary')
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th class="text-center"> #</th>
                                <th>@lang('project.budget') @lang('common.line')  </th>
                                <th class="text-center"> @lang('common.value') ($)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($project->proposal_budgets as $key=>$value)
                                <tr>
                                    <th class="text-center"> {{++$key}} </th>
                                    <td>{{$value->budget_name_en}} </td>
                                    <td class="text-center money">{{$value->value}}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <th class="text-center"> {{++$key}} </th>
                                <td>@lang('common.total')</td>
                                <td class="text-center money">{{$project->proposal_budgets->sum('value')}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!--end:: Widgets/Last Updates-->
            </div>
        </div>

        <!--End::Section-->
    </div>
    <!-- end:: Content -->
@stop
@section('script')
    @include('layouts.include.script.script_jquery_form')
    <script>
        submit_form('accept', 'accept-form');
        submit_form('reject', 'reject-form');
        submit_form('confirm', 'confirm-form');
    </script>
    {{--    {!! Html::script('assets/app/custom/wizard/wizard-proposal-v1.js') !!}--}}
    {{--    <script>--}}
    {{--        nested('mission', 'department', "{{$nested_url_department}}");--}}
    {{--        nested('department', 'sector', "{{$nested_url_sector}}");--}}
    {{--        get_duration('start_date', 'end_date', 'duration');--}}
    {{--        get_sum('sum_host', 'total_host');--}}
    {{--        get_sum('sum_internally', 'total_internally');--}}
    {{--        get_sum('sum_budget', 'total_budget');--}}
    {{--    </script>--}}
@stop
