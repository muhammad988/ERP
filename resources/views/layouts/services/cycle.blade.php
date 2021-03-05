@extends('layouts.app')
@section('style')
    @include('layouts.include.style.style_list')
@stop
@section('content')
        <!--Begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        @lang('url.cycle')
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="row">
                    <div class="col-xl-1">
                    </div>
                    <div class="col-xl-10">
                        <div class="kt-timeline-v1">
                            <div class="kt-timeline-v1__items">
                                <div class="kt-timeline-v1__marker"></div>
                                @foreach($notifications as $key=>$notification)
                                    <div class="kt-timeline-v1__item @if ($key % 2 == 0) kt-timeline-v1__item--left @else kt-timeline-v1__item--right @endif     @if ($loop->first) kt-timeline-v1__item--first @endif ">
                                        <div class="kt-timeline-v1__item-circle">
                                            @if($notification->status_id==171)
                                                <div class="kt-bg-danger"></div>
                                            @elseif($notification->status_id==170)
                                                <div class="kt-bg-success"></div>
                                            @else
                                                <div class="kt-bg-warning"></div>
                                            @endif
                                        </div>
                                        <span class="kt-timeline-v1__item-time kt-font-brand">{{ \Carbon\Carbon::parse ($notification->created_at)->format('Y-m-d H:i:s')  }}</span></span>
                                        <div class="kt-timeline-v1__item-content">
                                            <div class="kt-timeline-v1__item-body">
                                                <div class="kt-widget4">
                                                    <div class="kt-widget4__item">
                                                        <div class="kt-widget4__pic">
                                                            {{Html::image('assets/media/users/'.$notification->user_receiver->photo,'',['title'=>$notification->user_receiver->full_name])}}
                                                        </div>
                                                        <div class="kt-widget4__info">
                                                            <a href="#" class="kt-widget4__username">
                                                                {{$notification->user_receiver->full_name}}
                                                            </a>
                                                            <p class="kt-widget4__text">
                                                                {{$notification->user_receiver->position->name_en}}
                                                            </p>
                                                        </div>
                                                        @if($notification->delegated_user_id)
                                                        <a   class="btn btn-sm btn-label-success btn-bold disabled">delegated</a>
                                                        @endif
                                                    </div>
                                                    @if($notification->delegated_user_id)
                                                    <div class="kt-widget4__item">
                                                        <div class="kt-widget4__pic">
                                                            {{Html::image('assets/media/users/'.$notification->delegated_user->photo,'',['title'=>$notification->user_receiver->full_name])}}
                                                        </div>
                                                        <div class="kt-widget4__info">
                                                            <a href="#" class="kt-widget4__username">
                                                                {{$notification->delegated_user->full_name}}
                                                            </a>
                                                            <p class="kt-widget4__text">
                                                                {{$notification->delegated_user->position->name_en}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                        @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-1">
                    </div>
                </div>
            </div>
        </div>
        <!--End::Portlet-->

@stop
@section('script')
    @include('layouts.include.script.script_list')
    <script>
    </script>

@stop
