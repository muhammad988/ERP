@extends('layouts.app')
@section('style')
    @include('layouts.include.style.style_form')

    {!! Html::style('assets/css/demo2/pages/general/invoices/invoice-2.css') !!}
@stop
@section('content')
    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <!--begin:: Widgets/Finance Summary-->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                LEAVE DAYS AVAILABLE
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Leave Days Available</th>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control kt_datepicker_1_validate date" autocomplete="off" id="start_date"  name="start_date">
                                    </div>
                                </td>
                                <td>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control kt_datepicker_1_validate date" autocomplete="off" id="end_date" name="end_date">

                                    </div>
                                </td>
                                <td id="days"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--end:: Widgets/Finance Summary-->    </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <!--begin:: Widgets/Finance Summary-->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                LEAVE REPORT SUMMARY
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <th> Number of Due days</th>
                            <th> Number of Accumulated days</th>
                            <th> Number of Extra Days</th>
                            <th> Number of Completed Vacations</th>
                            <th>Number of leaves remaining</th>
                            </thead>
                            <tbody>
                            <tr>
                                <td><h6>{{$totalDays}}</h6></td>
                                <td><h6>{{$accumulatedDays}}</h6></td>
                                <td><h6>{{$extra_days}}</h6></td>
                                <td><h6>{{$leave_days}}</h6></td>
                                <td><h6>{{($totalDays+$accumulatedDays+$extra_days)-$leave_days}}</h6></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--end:: Widgets/Finance Summary-->    </div>
        </div>
        <div class="row">
            @if(!$user->leave_request(50001)->isEmpty()  )
                <div class="col-xl-6 col-lg-6">
                    <!--begin:: Widgets/Finance Summary-->
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Hourly Report
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="kt-widget12  kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">
                                <table class="table table-bordered table-striped">
                                    <thead>

                                    <th> #</th>
                                    <th>Date</th>

                                    <th> Start Time</th>
                                    <th>End Time</th>
                                    <th> Number of Hours</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    </thead>
                                    <tbody>
                                    @foreach($user->leave_request(50001) as $key=>$hour)
                                        @php
                                            $status=$hour->status;
                                            $hourly = getHourly($hour->start_time,$hour->end_time);
                                        @endphp
                                        @if ($status->id != 171)
                                            @php
                                                $totalHourly = AddPlayTime($totalHourly,$hourly);
                                            @endphp
                                        @endif
                                        <tr>
                                            <td><h6>{{$key+1}}</h6></td>
                                            <td><h6>{{$hour->start_date}}</h6></td>
                                            <td><h6>{{$hour->start_time}}</h6></td>
                                            <td><h6>{{$hour->end_time}}</h6></td>
                                            <td><h6>{{$hourly}}</h6></td>

                                            <td><h6>{!! $hour->reason !!}</h6></td>
                                            <td>
                                                {{--                                            <a target="_blank"--}}
                                                {{--                                               href="{{route("cycle.leaveRequest",$hour->id)}}">--}}
                                                {{--                                                <h6>{{$status->name_en}}</h6></a>--}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <table class="table table-bordered table-striped">
                                <thead>
                                <th> Total Number of Hours Leave</th>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><h6>{{$totalHourly}}</h6></td>
                                </tr>
                                </tbody>
                            </table>


                        </div>
                    </div>
                    <!--end:: Widgets/Finance Summary-->    </div>
            @endif
            @if(!$user->leave_request(101883)->isEmpty()  )
                <div class="col-xl-6 col-lg-6">
                    <!--begin:: Widgets/Finance Summary-->
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Hourly Unpaid Report
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="kt-widget12  kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">
                                <table class="table table-bordered table-striped">
                                    <thead>

                                    <th> #</th>
                                    <th>Date</th>

                                    <th> Start Time</th>
                                    <th>End Time</th>
                                    <th> Number of Hours</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    </thead>
                                    <tbody>
                                    @foreach($user->leave_request(101883) as $key=>$hourlyUnpaid)
                                        @php
                                            $status=$hourlyUnpaid->status;
                                            $hourly = getHourly($hourlyUnpaid->start_time,$hourlyUnpaid->end_time);
                                        @endphp
                                        @if ($status->id != 171)
                                            @php
                                                $totalHourlyUnpaid = AddPlayTime($totalHourlyUnpaid,$hourly);
                                            @endphp
                                        @endif
                                        <tr>
                                            <td><h6>{{$key+1}}</h6></td>
                                            <td><h6>{{$hourlyUnpaid->start_date}}</h6></td>
                                            <td><h6>{{$hourlyUnpaid->start_time}}</h6></td>
                                            <td><h6>{{$hourlyUnpaid->end_time}}</h6></td>
                                            <td><h6>{{$hourly}}</h6></td>

                                            <td><h6>{!! $hourlyUnpaid->reason !!}</h6></td>
                                            <td>
                                                {{--                                            <a target="_blank"--}}
                                                {{--                                               href="{{route("cycle.leaveRequest",$hour->id)}}">--}}
                                                {{--                                                <h6>{{$status->name_en}}</h6></a>--}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <table class="table table-bordered table-striped">
                                <thead>
                                <th> Total Number of Hours Leave</th>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><h6>{{$totalHourlyUnpaid}}</h6></td>
                                </tr>
                                </tbody>
                            </table>


                        </div>
                    </div>
                    <!--end:: Widgets/Finance Summary-->
                </div>
            @endif
            @if(!$user->leave_request(50000)->isEmpty()  )
                <div class="col-xl-6 col-lg-6">
                    <!--begin:: Widgets/Finance Summary-->
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Annual Report
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="kt-widget12  kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <th> #</th>
                                    <th>Start Date Leave</th>
                                    <th> End Date Leave</th>
                                    <th>Number Of Days</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    </thead>
                                    <tbody>
                                    @foreach($user->leave_request(50000) as $key=>$annual)
                                        @php
                                            $status=$annual->status;
                                        @endphp
                                        @if ($status->id != 171)
                                            @php
                                                $totalDaysAnnual=$totalDaysAnnual+$annual->leave_days;
                                            @endphp
                                        @endif
                                        <tr>
                                            <td><h6>{{$key+1}}</h6></td>
                                            <td><h6>{{$annual->start_date}}</h6></td>
                                            <td><h6>{{$annual->end_date}}</h6></td>
                                            <td><h6>{{$annual->leave_days}}</h6></td>
                                            <td><h6>{!! $annual->reason !!}</h6></td>
                                            <td>
                                                {{--                                        <a target="_blank"--}}
                                                {{--                                           href="{{Route("cycleAnnual.leave",$annual->id)}}">--}}
                                                {{--                                            <h6>{{$status->nameen}}</h6></a>--}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <table class="table table-bordered table-striped">
                                <thead>

                                <th>Total Day</th>

                                </thead>
                                <tbody>
                                <tr>
                                    <td><h6>{{$totalDaysAnnual}}</h6></td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!--end:: Widgets/Finance Summary-->    </div>
            @endif
            @if(!$user->leave_request(185872)->isEmpty()  || !$user->leave_request(185873)->isEmpty() )

                <div class="col-xl-6 col-lg-6">
                    <!--begin:: Widgets/Finance Summary-->
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    sick hourly Report
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="kt-widget12  kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">
                                <table class="table table-bordered table-striped">
                                    <thead>

                                    <th> #</th>
                                    <th>Date</th>

                                    <th> Start Time</th>
                                    <th>End Time</th>
                                    <th> Number of Hours</th>
                                    <th>Reason</th>
                                    <th>File</th>
                                    <th>Status</th>
                                    </thead>
                                    <tbody>
                                    @foreach($dataSickHourly as $key=>$hourSick)
                                        @php
                                            $status=$hourSick->status;
                                            $hourly = getHourly($hourSick->start_time,$hourSick->end_time);
                                        @endphp
                                        @if ($status->id != 171)
                                            @php
                                                $sickHourly = AddPlayTime($sickHourly,$hourly);
                                            @endphp
                                        @endif
                                        <tr>
                                            <td><h6>{{$key+1}}</h6></td>
                                            <td><h6>{{$hourSick->start_date}}</h6></td>
                                            <td><h6>{{$hourSick->start_time}}</h6></td>
                                            <td><h6>{{$hourSick->end_time}}</h6></td>
                                            <td><h6>{{$hourly}}</h6></td>

                                            <td><h6>{!! $hourSick->reason !!}</h6></td>
                                            <td><a target="_blank" href="{{asset('storage/'.$hourSick->file) }}">
                                                    <h6>File</h6></a></td>
                                            <td><a target="_blank"
                                                   href="{{asset('storage/file.txt')}}">
                                                    <h6>{{$status->name_en}}</h6></a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <table class="table table-bordered table-striped">
                                <thead>
                                <th> Total Number of Hours Leave</th>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><h6>{{$sickHourly}}</h6></td>
                                </tr>
                                </tbody>
                            </table>


                        </div>
                    </div>
                    <!--end:: Widgets/Finance Summary-->    </div>
            @endif
            @if(!$user->leave_request(50002)->isEmpty()  )
                <div class="col-xl-6 col-lg-6">
                    <!--begin:: Widgets/Finance Summary-->
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Unpaid Report
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="kt-widget12  kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <th> #</th>
                                    <th>Start Date Leave</th>
                                    <th> End Date Leave</th>
                                    <th>Number Of Days</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    </thead>
                                    <tbody>
                                    @foreach($user->leave_request(50002) as $key=>$unpaid)
                                        @php
                                            $status=$unpaid->status;
                                        @endphp
                                        @if ($status->id != 171)
                                            @php
                                                $totalDaysUnpaid=$totalDaysUnpaid+$unpaid->leave_days;
                                            @endphp
                                        @endif
                                        <tr>
                                            <td><h6>{{$key+1}}</h6></td>
                                            <td><h6>{{$unpaid->start_date}}</h6></td>
                                            <td><h6>{{$unpaid->end_date}}</h6></td>
                                            <td><h6>{{$unpaid->leave_days}}</h6></td>
                                            <td><h6>{!! $unpaid->reason !!}</h6></td>
                                            <td>
                                                {{--                                        <a target="_blank"--}}
                                                {{--                                           href="{{Route("cycleAnnual.leave",$annual->id)}}">--}}
                                                {{--                                            <h6>{{$status->nameen}}</h6></a>--}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <table class="table table-bordered table-striped">
                                <thead>

                                <th>Total Day</th>

                                </thead>
                                <tbody>
                                <tr>
                                    <td><h6>{{$totalDaysUnpaid}}</h6></td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!--end:: Widgets/Finance Summary-->    </div>
            @endif
            @if(!$user->leave_request(50018)->isEmpty()  )
                <div class="col-xl-6 col-lg-6">
                    <!--begin:: Widgets/Finance Summary-->
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Sick Report
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="kt-widget12  kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <th> #</th>
                                    <th>Start Date Leave</th>
                                    <th> End Date Leave</th>
                                    <th>Number Of Days</th>
                                    <th>Reason</th>
                                    <th>File</th>
                                    <th>Status</th>
                                    </thead>
                                    <tbody>
                                    @foreach($user->leave_request(50018) as $key=>$sick)
                                        @php
                                            $status=$sick->status;
                                        @endphp
                                        @if ($status->id != 171)
                                            @php
                                                $totalDaysSick=$totalDaysSick+$sick->leave_days;
                                            @endphp
                                        @endif
                                        <tr>
                                            <td><h6>{{$key+1}}</h6></td>
                                            <td><h6>{{$sick->start_date}}</h6></td>
                                            <td><h6>{{$sick->end_date}}</h6></td>
                                            <td><h6>{{$sick->leave_days}}</h6></td>
                                            <td><h6>{!! $sick->reason !!}</h6></td>
                                            <td><a target="_blank" href="{{asset('storage/'.$sick->file) }}">
                                                    <h6>File</h6></a></td>
                                            <td>
                                                {{--                                        <a target="_blank"--}}
                                                {{--                                           href="{{Route("cycleAnnual.leave",$annual->id)}}">--}}
                                                {{--                                            <h6>{{$status->nameen}}</h6></a>--}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <table class="table table-bordered table-striped">
                                <thead>

                                <th>Total Day</th>

                                </thead>
                                <tbody>
                                <tr>
                                    <td><h6>{{$totalDaysSick}}</h6></td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!--end:: Widgets/Finance Summary-->    </div>
            @endif
            @if(!$user->leave_request(50019)->isEmpty()  )
                <div class="col-xl-6 col-lg-6">
                    <!--begin:: Widgets/Finance Summary-->
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Maternity Report
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="kt-widget12  kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <th> #</th>
                                    <th>Start Date Leave</th>
                                    <th> End Date Leave</th>
                                    <th>Number Of Days</th>
                                    <th>Reason</th>
                                    <th>File</th>
                                    <th>Status</th>
                                    </thead>
                                    <tbody>
                                    @foreach($user->leave_request(50019) as $key=>$motherhood)
                                        @php
                                            $status=$motherhood->status;
                                        @endphp
                                        @if ($status->id != 171)
                                            @php
                                                $totalDaysMotherhood=$totalDaysMotherhood+$motherhood->leave_days;
                                            @endphp
                                        @endif
                                        <tr>
                                            <td><h6>{{$key+1}}</h6></td>
                                            <td><h6>{{$motherhood->start_date}}</h6></td>
                                            <td><h6>{{$motherhood->end_date}}</h6></td>
                                            <td><h6>{{$motherhood->leave_days}}</h6></td>
                                            <td><h6>{!! $motherhood->reason !!}</h6></td>
                                            <td><a target="_blank" href="{{asset('storage/'.$motherhood->file) }}">
                                                    <h6>File</h6></a></td>
                                            <td>
                                                {{--                                        <a target="_blank"--}}
                                                {{--                                           href="{{Route("cycleAnnual.leave",$annual->id)}}">--}}
                                                {{--                                            <h6>{{$status->nameen}}</h6></a>--}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <table class="table table-bordered table-striped">
                                <thead>

                                <th>Total Day</th>

                                </thead>
                                <tbody>
                                <tr>
                                    <td><h6>{{$totalDaysMotherhood}}</h6></td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!--end:: Widgets/Finance Summary-->    </div>
            @endif
            @if(!$user->leave_request(55151)->isEmpty()  )
                <div class="col-xl-6 col-lg-6">
                    <!--begin:: Widgets/Finance Summary-->
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Paternity Report
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="kt-widget12  kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <th> #</th>
                                    <th>Start Date Leave</th>
                                    <th> End Date Leave</th>
                                    <th>Number Of Days</th>
                                    <th>Reason</th>
                                    <th>File</th>
                                    <th>Status</th>
                                    </thead>
                                    <tbody>
                                    @foreach($user->leave_request(55151) as $key=>$fatherhood)
                                        @php
                                            $status=$fatherhood->status;
                                        @endphp
                                        @if ($status->id != 171)
                                            @php
                                                $totalDaysFatherhood=$totalDaysFatherhood+$fatherhood->leave_days;
                                            @endphp
                                        @endif
                                        <tr>
                                            <td><h6>{{$key+1}}</h6></td>
                                            <td><h6>{{$fatherhood->start_date}}</h6></td>
                                            <td><h6>{{$fatherhood->end_date}}</h6></td>
                                            <td><h6>{{$fatherhood->leave_days}}</h6></td>
                                            <td><h6>{!! $fatherhood->reason !!}</h6></td>
                                            <td><a target="_blank" href="{{asset('storage/'.$fatherhood->file) }}">
                                                    <h6>File</h6></a></td>
                                            <td><a target="_blank" href="{{URL('../file/sick/'.$fatherhood->file)}}"><h6>File</h6></a></td>
                                            <td>
                                                {{--                                        <a target="_blank"--}}
                                                {{--                                           href="{{Route("cycleAnnual.leave",$annual->id)}}">--}}
                                                {{--                                            <h6>{{$status->nameen}}</h6></a>--}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <table class="table table-bordered table-striped">
                                <thead>

                                <th>Total Day</th>

                                </thead>
                                <tbody>
                                <tr>
                                    <td><h6>{{$totalDaysFatherhood}}</h6></td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!--end:: Widgets/Finance Summary-->    </div>
            @endif
            @if(!$user->leave_request(55160)->isEmpty()  )

                <div class="col-xl-6 col-lg-6">
                    <!--begin:: Widgets/Finance Summary-->
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Wedding Report
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="kt-widget12  kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <th> #</th>
                                    <th>Start Date Leave</th>
                                    <th> End Date Leave</th>
                                    <th>Number Of Days</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    </thead>
                                    <tbody>
                                    @foreach($user->leave_request(55160) as $key=>$wedding)
                                        @php
                                            $status=$wedding->status;
                                        @endphp
                                        @if ($status->id != 171)
                                            @php
                                                $totalDaysWedding=$totalDaysWedding+$wedding->leave_days;
                                            @endphp
                                        @endif
                                        <tr>
                                            <td><h6>{{$key+1}}</h6></td>
                                            <td><h6>{{$wedding->start_date}}</h6></td>
                                            <td><h6>{{$wedding->end_date}}</h6></td>
                                            <td><h6>{{$wedding->leave_days}}</h6></td>
                                            <td><h6>{!! $wedding->reason !!}</h6></td>
                                            <td>
                                                {{--                                        <a target="_blank"--}}
                                                {{--                                           href="{{Route("cycleAnnual.leave",$annual->id)}}">--}}
                                                {{--                                            <h6>{{$status->nameen}}</h6></a>--}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <table class="table table-bordered table-striped">
                                <thead>

                                <th>Total Day</th>

                                </thead>
                                <tbody>
                                <tr>
                                    <td><h6>{{$totalDaysWedding}}</h6></td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!--end:: Widgets/Finance Summary-->    </div>
            @endif
            @if(!$user->leave_request(55161)->isEmpty()  )
                <div class="col-xl-6 col-lg-6">
                    <!--begin:: Widgets/Finance Summary-->
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Bereavement Report
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="kt-widget12  kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <th> #</th>
                                    <th>Start Date Leave</th>
                                    <th> End Date Leave</th>
                                    <th>Number Of Days</th>
                                    <th>Reason</th>
                                    <th>File</th>
                                    <th>Status</th>
                                    </thead>
                                    <tbody>
                                    @foreach($user->leave_request(55161) as $key=>$death)
                                        @php
                                            $status=$death->status;
                                        @endphp
                                        @if ($status->id != 171)
                                            @php
                                                $totalDaysDeath=$totalDaysDeath+$death->leave_days;
                                            @endphp
                                        @endif
                                        <tr>
                                            <td><h6>{{$key+1}}</h6></td>
                                            <td><h6>{{$death->start_date}}</h6></td>
                                            <td><h6>{{$death->end_date}}</h6></td>
                                            <td><h6>{{$death->leave_days}}</h6></td>
                                            <td><h6>{!! $death->reason !!}</h6></td>
                                            <td><a target="_blank" href="{{asset('storage/'.$death->file) }}">
                                                    <h6>File</h6></a></td>

                                            <td>
                                                {{--                                        <a target="_blank"--}}
                                                {{--                                           href="{{Route("cycleAnnual.leave",$annual->id)}}">--}}
                                                {{--                                            <h6>{{$status->nameen}}</h6></a>--}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <table class="table table-bordered table-striped">
                                <thead>

                                <th>Total Day</th>

                                </thead>
                                <tbody>
                                <tr>
                                    <td><h6>{{$totalDaysDeath}}</h6></td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!--end:: Widgets/Finance Summary-->    </div>
            @endif
            @if(!$user->leave_request(50017)->isEmpty()  )
                <div class="col-xl-6 col-lg-6">
                    <!--begin:: Widgets/Finance Summary-->
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Business Report
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="kt-widget12  kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <th> #</th>
                                    <th>Start Date Leave</th>
                                    <th> End Date Leave</th>
                                    <th>Number Of Days</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    </thead>
                                    <tbody>
                                    @foreach($user->leave_request(50017) as $key=>$business)
                                        @php
                                            $status=$business->status;
                                        @endphp
                                        @if ($status->id != 171)
                                            @php
                                                $totalDaysBusiness=$totalDaysBusiness+$business->leave_days;
                                            @endphp
                                        @endif
                                        <tr>
                                            <td><h6>{{$key+1}}</h6></td>
                                            <td><h6>{{$business->start_date}}</h6></td>
                                            <td><h6>{{$business->end_date}}</h6></td>
                                            <td><h6>{{$business->leave_days}}</h6></td>
                                            <td><h6>{!! $business->reason !!}</h6></td>
                                            <td>
                                                {{--                                        <a target="_blank"--}}
                                                {{--                                           href="{{Route("cycleAnnual.leave",$annual->id)}}">--}}
                                                {{--                                            <h6>{{$status->nameen}}</h6></a>--}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <table class="table table-bordered table-striped">
                                <thead>

                                <th>Total Day</th>

                                </thead>
                                <tbody>
                                <tr>
                                    <td><h6>{{$totalDaysBusiness}}</h6></td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!--end:: Widgets/Finance Summary-->    </div>
            @endif
            @if(!$user->leave_request(375479)->isEmpty()  )
                <div class="col-xl-6 col-lg-6">
                    <!--begin:: Widgets/Finance Summary-->
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Hourly Report
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="kt-widget12  kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">
                                <table class="table table-bordered table-striped">
                                    <thead>

                                    <th> #</th>
                                    <th>Date</th>

                                    <th> Start Time</th>
                                    <th>End Time</th>
                                    <th> Number of Hours</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    </thead>
                                    <tbody>
                                    @foreach($user->leave_request(375479) as $key=>$hourlyBusiness)
                                        @php
                                            $status=$hour->status;
                                            $hourly = getHourly($hourlyBusiness->start_time,$hourlyBusiness->end_time);
                                        @endphp
                                        @if ($status->id != 171)
                                            @php
                                                $totalHourlyBusiness = AddPlayTime($totalHourlyBusiness,$hourly);
                                            @endphp
                                        @endif
                                        <tr>
                                            <td><h6>{{$key+1}}</h6></td>
                                            <td><h6>{{$hourlyBusiness->start_date}}</h6></td>
                                            <td><h6>{{$hourlyBusiness->start_time}}</h6></td>
                                            <td><h6>{{$hourlyBusiness->end_time}}</h6></td>
                                            <td><h6>{{$hourly}}</h6></td>

                                            <td><h6>{!! $hourlyBusiness->reason !!}</h6></td>
                                            <td>
                                                {{--                                            <a target="_blank"--}}
                                                {{--                                               href="{{route("cycle.leaveRequest",$hour->id)}}">--}}
                                                {{--                                                <h6>{{$status->name_en}}</h6></a>--}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <table class="table table-bordered table-striped">
                                <thead>
                                <th> Total Number of Hours Leave</th>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><h6>{{$totalHourlyBusiness}}</h6></td>
                                </tr>
                                </tbody>
                            </table>


                        </div>
                    </div>
                    <!--end:: Widgets/Finance Summary-->    </div>
            @endif
            @if(!$user->leave_request(313622)->isEmpty()  )
                <div class="col-xl-6 col-lg-6">
                    <!--begin:: Widgets/Finance Summary-->
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Patient Accompanying Report
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="kt-widget12  kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <th> #</th>
                                    <th>Start Date Leave</th>
                                    <th> End Date Leave</th>
                                    <th>Number Of Days</th>
                                    <th>Reason</th>
                                    <th>File</th>
                                    <th>Status</th>
                                    </thead>
                                    <tbody>
                                    @foreach($user->leave_request(313622) as $key=>$patientAccompanying)
                                        @php
                                            $status=$patientAccompanying->status;
                                        @endphp
                                        @if ($status->id != 171)
                                            @php
                                                $totalDaysPatientAccompanying=$totalDaysPatientAccompanying+$patientAccompanying->leave_days;
                                            @endphp
                                        @endif
                                        <tr>
                                            <td><h6>{{$key+1}}</h6></td>
                                            <td><h6>{{$patientAccompanying->start_date}}</h6></td>
                                            <td><h6>{{$patientAccompanying->end_date}}</h6></td>
                                            <td><h6>{{$patientAccompanying->leave_days}}</h6></td>
                                            <td><h6>{!! $patientAccompanying->reason !!}</h6></td>
                                            <td><a target="_blank" href="{{asset('storage/'.$patientAccompanying->file) }}">
                                                    <h6>File</h6></a></td>
                                            <td>
                                                {{--                                        <a target="_blank"--}}
                                                {{--                                           href="{{Route("cycleAnnual.leave",$annual->id)}}">--}}
                                                {{--                                            <h6>{{$status->nameen}}</h6></a>--}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <table class="table table-bordered table-striped">
                                <thead>

                                <th>Total Day</th>

                                </thead>
                                <tbody>
                                <tr>
                                    <td><h6>{{$totalDaysPatientAccompanying}}</h6></td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!--end:: Widgets/Finance Summary-->    </div>
            @endif
        </div>
    </div>
@stop
@section('script')
    @include('layouts.include.script.script_jquery_form')
    <script>
        $('.date').change(function () {
            let start_date = $('#start_date').val();
            let end_date = $('#end_date').val();
            let user_id = '{{Auth::id ()}}';
            $.ajax({
                type: "POST",
                url: '{{route('leave.available_days')}}',
                data: {"start_date": start_date, "end_date": end_date, "user_id": user_id},
                success: function (data) {
                    $("#days").html(data);
                }
            })
        });
    </script>
@endsection
