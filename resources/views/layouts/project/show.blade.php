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

                                    @if($last_project_notification->requester === Auth::id () && $project->status_id == $status->in_progress)
                                        <a href="{{route ('project.edit',$project->id)}}" class="btn btn-warning btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u">@lang('common.edit')</a>
                                    @endif
                                    @if($first_project_notification->requester === Auth::id () && $project->status_id == 170)
                                        <a href="#" id="confirm" class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"> Confirm</a>
                                        <form id="confirm-form" action="{{ route('project.action') }}" method="POST" hidden>
                                            @csrf
                                            <input hidden name="action" value="confirm">
                                            <input hidden name="id" value="{{$project->id}}">
                                        </form>
                                    @endif
                                    @if($first_project_notification->requester !== Auth::id () && $notification_check  && $project->status_id == $status->in_progress)
                                        <a href="#" id="accept" class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"> @lang('common.accept')</a>
                                        <form id="accept-form" action="{{ route('project.action') }}" method="POST" hidden>
                                            @csrf
                                            <input hidden name="action" value="accept">
                                            <input hidden name="id" value="{{$project->id}}">
                                        </form>
                                        <a href="#" id="reject" class="btn btn-danger btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"> @lang('common.reject')</a>
                                        <form id="reject-form" action="{{ route('project.action') }}" method="POST" hidden>
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
                                Context
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        {{$project->detailed_proposal->context }}
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
                                Monitoring & Evaluation
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        {{$project->detailed_proposal->monitoring_evaluation}}
                    </div>
                </div>

                <!--end:: Widgets/Download Files-->
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
                                Link To Cluster Objectives
                            </h3>
                        </div>

                    </div>
                    <div class="kt-portlet__body">
                        {{$project->detailed_proposal->link_to_cluster_objectives }}
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
                                Reporting
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        {{$project->detailed_proposal->reporting}}
                    </div>
                </div>

                <!--end:: Widgets/Download Files-->
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
                                Implementation Plan
                            </h3>
                        </div>

                    </div>
                    <div class="kt-portlet__body">
                        {{$project->detailed_proposal->implementation_plan }}
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
                                Gender Marker
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        {{$project->detailed_proposal->gender_marker}}
                    </div>
                </div>

                <!--end:: Widgets/Download Files-->
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
                                Overall Objectives
                            </h3>
                        </div>

                    </div>
                    <div class="kt-portlet__body">
                        {{$project->detailed_proposal->overall_objective }}
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
                                Accountability
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        {{$project->detailed_proposal->accountability}}
                    </div>
                </div>

                <!--end:: Widgets/Download Files-->
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
                                Distribution of Beneficiaries Per Locations
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <th> Organisation Unit</th>
                            {{--                            <th> @lang('common.logistic') </th>--}}
                            <th> @lang('project.men')  </th>
                            <th> @lang('project.women') </th>
                            <th> @lang('project.boys')  </th>
                            <th>@lang('project.girls')  </th>
                            <th>@lang('common.total')  </th>
                            </thead>
                            <tbody>
                            @foreach($project->submission_beneficiaries as $key=>$value)
                                <tr>
                                    <td> {{$value->organisation_unit_name_en}}  </td>
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
                                Plan @lang('common.file')
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="kt-widget__action">
                            <a href="/file/m_&_e_plan/{{$project->file_plan}}" target="_blank" class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u">  @lang('common.view') @lang('common.file')</a>
                        </div>

                    </div>
                </div>

                <!--end:: Widgets/Download Files-->
            </div>
        </div>
        <!--End::Section-->
        <!--Begin::Section-->
        <div class="row">
            <div class="col-xl-12">
                <!--begin:: Widgets/Download Files-->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Work Plan
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <th>Outcome</th>
                            <th>Output</th>
                            <th>Activity</th>
                            <th style="width: 15%;">Description</th>
                            <th>Phase</th>
                            <th>Responsibility</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Duration</th>
                            <th>Cost</th>
                            <th>Planned Progress</th>
                            <th>Days</th>
                            <th>Percentage of Cost</th>
                            <th>Total Perc</th>
                            <th>Indirect Cost</th>

                            </thead>
                            <tbody id="work_plan">
                            @foreach($project->outcomes as $key=>$outcome)
                                @php
                                    $total=0;
                                    $planned_progress=0;
                                    $days=0;
                                    $precent_of_cost=0;
                                    $total_percentage=0;
                                    $indirect_cost=0;
                                        foreach($outcome->outputs as $output){
                                       $total+=  $output->activities->sum('direct_cost');
                                       $planned_progress+=  $output->activities->sum('planned_progress');
                                       $days+=  $output->activities->sum('days');
                                       $precent_of_cost+=  $output->activities->sum('precent_of_cost');
                                       $total_percentage+=  $output->activities->sum('total_percentage');
                                       $indirect_cost+=  $output->activities->sum('indirect_cost');
                                        }
                                @endphp
                                <tr>
                                    <td>{{$outcome->name_en}}</td>
                                    <td></td>
                                    <td></td>
                                    <td>{{$outcome->description}}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><span class="currency">{{$total}}</span></td>
                                    <td>{{$planned_progress}} %</td>
                                    <td>{{$days}}</td>
                                    <td>{{$precent_of_cost}} %</td>
                                    <td>{{$total_percentage}} %</td>
                                    <td><span class="currency">{{$indirect_cost}}</span></td>
                                </tr>
                                @foreach($outcome->outputs as $output)
                                    <tr>
                                        <td></td>
                                        <td>{{$output->name_en}}</td>
                                        <td></td>
                                        <td>{{$output->description}}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><span class="currency">{{$output->activities->sum('direct_cost')}}</span></td>
                                        <td>{{$output->activities->sum('planned_progress')}} %</td>
                                        <td>{{$output->activities->sum('days')}}</td>
                                        <td>{{$output->activities->sum('precent_of_cost')}} %</td>
                                        <td>{{$output->activities->sum('total_percentage')}} %</td>
                                        <td><span class="currency">{{$output->activities->sum('indirect_cost')}}</span></td>
                                    </tr>

                                    @foreach($output->activities as $activate)
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>{{$activate->name_en}}</td>
                                            <td>{{$activate->description}}</td>
                                            <td>{{$activate->phase_name_en}}</td>
                                            <td>{{$activate->first_name_en }} {{$activate->last_name_en }}</td>
                                            <td>{{$activate->start_date }}</td>
                                            <td>{{$activate->end_date }}</td>
                                            <td>{{$activate->duration }}</td>
                                            <td><span class="currency">{{$activate->direct_cost}}</span></td>
                                            <td> {{$activate->planned_progress}} %</td>
                                            <td>{{$activate->days}}</td>
                                            <td>{{$activate->precent_of_cost}} %</td>
                                            <td>{{$activate->total_percentage}} %</td>
                                            <td><span class="currency">{{$activate->indirect_cost}}</span></td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>

                <!--end:: Widgets/Download Files-->
            </div>
        </div>
    @foreach($budget_categories as $budget_category)
        @if($project->detailed_proposal_budget->where('budget_category_id',$budget_category->id)->sum('quantity'))
            <!--Begin::Section-->
                <div class="row">
                    <div class="col-xl-12">
                        <!--begin:: Widgets/Download Files-->
                        <div class="kt-portlet kt-portlet--height-fluid">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title">
                                        {{$budget_category->name_en}}
                                    </h3>
                                </div>
                            </div>
                            <div class="kt-portlet__body">
                                @php
                                    $total_budget=0
                                @endphp
                                @foreach($project->detailed_proposal_budget->where('budget_category_id',$budget_category->id) as $key=>$value)
                                    @php
                                        $total_budget += ($value->unit_cost * $value->chf * $value->quantity * $value->duration)/100;
                                         $total_budgets += ($value->unit_cost * $value->chf * $value->quantity * $value->duration)/100
                                    @endphp
                                    <div class="row form-group">
                                        <div class=" col-lg-1">
                                            <h6>Budget Line</h6>
                                            {{$value->budget_line}}
                                        </div>
                                        <div class="col-lg-2">
                                            <h6>Category Option </h6>
                                            {{$value->category_option_name_en}}
                                        </div>
                                        <div class="col-lg-2">
                                            <h6>Unit </h6>
                                            {{$value->unit_name_en}}
                                        </div>
                                        <div class="col-lg-1">
                                            <h6>Duration </h6>
                                            {{$value->duration}}
                                        </div>
                                        <div class="col-lg-1">
                                            <h6>Quantity </h6>
                                            {{$value->quantity}}
                                        </div>
                                        <div class="col-lg-1">
                                            <h6>Unit Cost </h6>
                                            <span class="currency">{{$value->unit_cost}}</span>
                                        </div>
                                        <div class="col-lg-1">
                                            <h6>CHF </h6>
                                            {{$value->chf}}
                                        </div>
                                        <div class="col-lg-1">
                                            <h6>Total </h6>
                                            <span class="currency">{{($value->unit_cost * $value->chf * $value->quantity * $value->duration)/100 }}</span>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-1">
                                            <h6>Donor</h6>
                                            {{$value->donor_name_en}}
                                        </div>
                                        <div class="col-lg-2">
                                            <h6>In kind/Monetary</h6>
                                            {{ $value->in_kind === false ? 'In kind' : 'Monetary' }}
                                        </div>
                                        <div class="col-lg-2">
                                            <h6>Direct/Support</h6>
                                            {{ $value->in_kind === true ? 'Support' : 'Direct' }}
                                        </div>
                                        <div class="col-lg-2">
                                            <h6>Administrative Cost</h6>
                                            {{ $value->out_of_administrative_cost === true ? 'Not Included' : 'Include' }}
                                        </div>
                                        <div class="col-lg-4">
                                            <h6>description</h6>
                                            {{ $value->description }}
                                        </div>
                                    </div>
                                    <hr class="row">
                                @endforeach
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5>Total </h5>
                                        <span class="currency">{{ $total_budget }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end:: Widgets/Download Files-->
                    </div>

                </div>
                <!--End::Section-->
        @endif
    @endforeach

    <!--Begin::Section-->
        <div class="row">
            <div class="col-xl-12">
                <!--begin:: Widgets/Download Files-->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Total Budget Line
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">

                        <div class="row ">
                            <div class="form-group col-lg-2">
                                <h6>Subtotal Before Contingency</h6>
                                <span class="currency"> {{$project->detailed_proposal->overhead}}</span>
                            </div>
                            <div class="col-lg-2">
                                <h6>Subtotal After Contingency</h6>
                                <span class="currency"> {{$total_budgets}}</span>
                            </div>
                            <div class="col-lg-2">
                                <h6>Grand Total</h6>
                                <span class="currency">{{$total_budgets}}</span>
                            </div>
                            @foreach($project->detailed_proposal_budget()->select('donors.name_en')->selectRaw('sum ((unit_cost * chf * quantity * duration)/100) as total ')->groupBy('donors.name_en')->get() as $donor)
                                <div class="col-lg-2">
                                    <h6>Donor </h6>
                                    {{$donor->name_en}}: <span class="currency">{{$donor->total}}</span>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
                <!--end:: Widgets/Download Files-->
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
@stop
