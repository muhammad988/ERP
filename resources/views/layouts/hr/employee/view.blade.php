@extends('layouts.app')
@section('style')
    @include('layouts.include.style.style_list')
@stop
@section('content')
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">

        <!--Begin::App-->
        <div class="kt-grid kt-grid--desktop kt-grid--ver kt-grid--ver-desktop kt-app">
            <!--Begin:: App Aside Mobile Toggle-->
            <button class="kt-app__aside-close" id="kt_user_profile_aside_close">
                <i class="la la-close"></i>
            </button>
            <!--End:: App Aside Mobile Toggle-->

            <!--Begin:: App Aside-->
            <div class="kt-grid__item kt-app__toggle kt-app__aside" id="kt_user_profile_aside">
                <!--Begin::Portlet-->
                <div class="kt-portlet kt-portlet--height-fluid-">
                    <div class="kt-portlet__head kt-portlet__head--noborder">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">

                            </h3>
                        </div>
                        {{--                        <div class="kt-portlet__head-toolbar">--}}
                        {{--                            <a href="#" class="btn btn-clean btn-sm btn-icon btn-icon-md" data-toggle="dropdown">--}}
                        {{--                                <i class="flaticon-more-1"></i>--}}
                        {{--                            </a>--}}
                        {{--                            <div class="dropdown-menu dropdown-menu-right">--}}
                        {{--                                <ul class="kt-nav">--}}
                        {{--                                    <li class="kt-nav__item">--}}
                        {{--                                        <a href="#" class="kt-nav__link">--}}
                        {{--                                            <i class="kt-nav__link-icon flaticon2-line-chart"></i>--}}
                        {{--                                            <span class="kt-nav__link-text">Reports</span>--}}
                        {{--                                        </a>--}}
                        {{--                                    </li>--}}
                        {{--                                    <li class="kt-nav__item">--}}
                        {{--                                        <a href="#" class="kt-nav__link">--}}
                        {{--                                            <i class="kt-nav__link-icon flaticon2-send"></i>--}}
                        {{--                                            <span class="kt-nav__link-text">Messages</span>--}}
                        {{--                                        </a>--}}
                        {{--                                    </li>--}}
                        {{--                                    <li class="kt-nav__item">--}}
                        {{--                                        <a href="#" class="kt-nav__link">--}}
                        {{--                                            <i class="kt-nav__link-icon flaticon2-pie-chart-1"></i>--}}
                        {{--                                            <span class="kt-nav__link-text">Charts</span>--}}
                        {{--                                        </a>--}}
                        {{--                                    </li>--}}
                        {{--                                    <li class="kt-nav__item">--}}
                        {{--                                        <a href="#" class="kt-nav__link">--}}
                        {{--                                            <i class="kt-nav__link-icon flaticon2-avatar"></i>--}}
                        {{--                                            <span class="kt-nav__link-text">Members</span>--}}
                        {{--                                        </a>--}}
                        {{--                                    </li>--}}
                        {{--                                    <li class="kt-nav__item">--}}
                        {{--                                        <a href="#" class="kt-nav__link">--}}
                        {{--                                            <i class="kt-nav__link-icon flaticon2-settings"></i>--}}
                        {{--                                            <span class="kt-nav__link-text">Settings</span>--}}
                        {{--                                        </a>--}}
                        {{--                                    </li>--}}
                        {{--                                </ul>            </div>--}}
                        {{--                        </div>--}}
                    </div>
                    <div class="kt-portlet__body">
                        <!--begin::Widget -->
                        <div class="kt-widget kt-widget--user-profile-2">
                            <div class="kt-widget__head">
                                <div class="kt-widget__media">
                                    {{Html::image('images/user/'.$user->photo.'','',['class'=>'kt-widget__img kt-hidden-'])}}
                                    {{--                                    <img class="kt-widget__img kt-hidden-" src="./assets/media/users/100_1.jpg" alt="image">--}}
                                    {{--                                    <div class="kt-widget__pic kt-widget__pic--danger kt-font-danger kt-font-boldest kt-font-light kt-hidden">--}}
                                    {{--                                        MP--}}
                                    {{--                                    </div>--}}
                                </div>
                                <div class="kt-widget__info">
                                    <a href="#" class="kt-widget__username">
                                        {{$user->full_name}}
                                    </a>
                                    <span class="kt-widget__desc">
                        {{$user->position->name_en}}
                    </span>
                                </div>
                            </div>

                            <div class="kt-widget__body">
                                <div class="kt-widget__section">
                                    {{$user->note}}
                                </div>
                                <div class="kt-widget__content">
                                    <div class="kt-widget__stats kt-margin-r-20">
                                        <div class="kt-widget__icon">
                                            <i class="flaticon-attachment"></i>
                                        </div>
                                        <div class="kt-widget__details">
                                            <span class="kt-widget__title">@lang('hr.employee') @lang('common.no'):</span>
                                            <span>{{$user->employee_number}}</span>
                                        </div>
                                    </div>
                                    <div class="kt-widget__stats">
                                        <div class="kt-widget__icon">
                                            <i class="flaticon2-soft-icons-1"></i>
                                        </div>
                                        <div class="kt-widget__details">
                                            <span class="kt-widget__title">@lang('common.mission')</span>
                                            <span> {{$user->mission->name_en}}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="kt-widget__item">
                                    <div class="kt-widget__contact">
                                        <span class="kt-widget__label">@lang('common.email'):</span>
                                        <a href="#" class="kt-widget__data">{{$user->email}}</a>
                                    </div>
                                    <div class="kt-widget__contact">
                                        <span class="kt-widget__label">@lang('hr.phone'):</span>
                                        <a href="#" class="kt-widget__data"> {{$user->phone_number}}</a>
                                    </div>
                                    <div class="kt-widget__contact">
                                        <span class="kt-widget__label">@lang('common.organisation_unit'):</span>
                                        <span class="kt-widget__data">@if(!is_null($user->organisation_unit_id)) {{$user->organisation_unit->name_en}} @endif
</span>
                                    </div>
                                    <div class="kt-widget__contact">
                                        <span class="kt-widget__label">@lang('hr.gender'):</span>
                                        <span class="kt-widget__data">{{$user->gender_en}}
</span>
                                    </div>
                                    <div class="kt-widget__contact">
                                        <span class="kt-widget__label">@lang('hr.birth') @lang('common.date'):</span>
                                        <span class="kt-widget__data">{{$user->date_of_birth}}
</span>
                                    </div>
                                    <div class="kt-widget__contact">
                                        <span class="kt-widget__label">@lang('hr.marital') @lang('common.status'):</span>
                                        <span class="kt-widget__data">@if(!is_null($user->marital_status_id)) {{$user->marital_status->name_en}} @endif
</span>
                                    </div>
                                </div>
                            </div>
                                                        <div class="kt-widget__footer">
                                                            <button onclick="history.back();"  class="btn btn-brand btn-sm btn-upper">@lang('common.back')</button>

                                                        </div>
                        </div>
                        <!--end::Widget -->


                    </div>
                </div>
                <!--End::Portlet-->
            </div>
            <!--End:: App Aside-->

            <!--Begin:: App Content-->
            <div class="kt-grid__item kt-grid__item--fluid kt-app__content">
                <div class="row">
                    <div class="col">
                        <!--Begin::Section-->
                        <div class="kt-portlet">
                            <div class="kt-portlet__body kt-portlet__body--fit">
                                <div class="row row-no-padding row-col-separator-xl">
                                    <div class="col-md-12 col-lg-12 col-xl-4">
                                        <!--begin:: Widgets/Stats2-1 -->
                                        <div class="kt-widget1">
                                            <div class="kt-widget1__item">
                                                <div class="kt-widget1__info">
                                                    <h3 class="kt-widget1__title">@lang('common.first') @lang('common.name')
                                                        EN</h3>
                                                    <span class="kt-widget1__desc">  {{$user->first_name_en}}</span>
                                                </div>
                                                {{--                                                <span class="kt-widget1__number kt-font-brand">+$17,800</span>--}}
                                            </div>

                                            <div class="kt-widget1__item">
                                                <div class="kt-widget1__info">
                                                    <h3 class="kt-widget1__title">@lang('common.first') @lang('common.name')
                                                        AR</h3>
                                                    <span class="kt-widget1__desc">  {{$user->first_name_ar}}</span>
                                                </div>
                                                {{--                                                <span class="kt-widget1__number kt-font-danger">+1,800</span>--}}
                                            </div>

                                            <div class="kt-widget1__item">
                                                <div class="kt-widget1__info">
                                                    <h3 class="kt-widget1__title">@lang('hr.nationality')</h3>
                                                    <span class="kt-widget1__desc"> @if(!is_null($user->nationality_id)) {{ $user->nationality->name_en}} @endif</span>
                                                </div>
                                            </div>
                                            <div class="kt-widget1__item">
                                                <div class="kt-widget1__info">
                                                    <h3 class="kt-widget1__title">@lang('passwords.password') @lang('common.number')</h3>
                                                    <span class="kt-widget1__desc"> {{$user->passport_number}}</span>
                                                </div>
                                            </div>
                                            <div class="kt-widget1__item">
                                                <div class="kt-widget1__info">
                                                    <h3 class="kt-widget1__title">@lang('hr.emergency') @lang('common.contact')  @lang('common.name')</h3>
                                                    <span class="kt-widget1__desc">  {{$user->emergency_contact_name_en}}</span>
                                                </div>
                                            </div>
                                            <div class="kt-widget1__item">
                                                <div class="kt-widget1__info">
                                                    <h3 class="kt-widget1__title">@lang('hr.superior')</h3>
                                                    <span class="kt-widget1__desc"> @if(!is_null($user->parent_id)) {{ $user->parent->full_name}} @endif</span>
                                                </div>
                                            </div>
                                            <div class="kt-widget1__item">
                                                <div class="kt-widget1__info">
                                                    <h3 class="kt-widget1__title">@lang('common.type_of_contract')</h3>
                                                    <span class="kt-widget1__desc">@if(!is_null($user->type_of_contract_id))   {{$user->type_of_contract->name_en}} @endif
</span>
                                                </div>
                                            </div>
                                            <div class="kt-widget1__item">
                                                <div class="kt-widget1__info">
                                                    <h3 class="kt-widget1__title">@lang('common.number') @lang('common.of') @lang('common.working') @lang('common.hours')</h3>
                                                    <span class="kt-widget1__desc"> {{$user->number_of_hours}}
</span>
                                                </div>
                                            </div>

                                        </div>
                                        <!--end:: Widgets/Stats2-1 -->
                                    </div>
                                    <div class="col-md-12 col-lg-12 col-xl-4">
                                        <!--begin:: Widgets/Stats2-2 -->
                                        <div class="kt-widget1">
                                            <div class="kt-widget1__item">
                                                <div class="kt-widget1__info">
                                                    <h3 class="kt-widget1__title">@lang('common.middle') @lang('common.name')
                                                        EN</h3>
                                                    <span class="kt-widget1__desc">{{$user->middle_name_en}}</span>
                                                </div>
                                                {{--                                                <span class="kt-widget1__number kt-font-success">+24%</span>--}}
                                            </div>

                                            <div class="kt-widget1__item">
                                                <div class="kt-widget1__info">
                                                    <h3 class="kt-widget1__title">@lang('common.middle') @lang('common.name')
                                                        AR</h3>
                                                    <span class="kt-widget1__desc">{{$user->middle_name_ar}}</span>
                                                </div>
                                            </div>
                                            <div class="kt-widget1__item">
                                                <div class="kt-widget1__info">
                                                    <h3 class="kt-widget1__title">@lang('hr.identity') @lang('common.number')</h3>
                                                    <span class="kt-widget1__desc"> {{$user->identity_number}}</span>
                                                </div>
                                            </div>

                                            <div class="kt-widget1__item">
                                                <div class="kt-widget1__info">
                                                    <h3 class="kt-widget1__title">@lang('passwords.password') @lang('common.validity') @lang('common.date')</h3>
                                                    <span class="kt-widget1__desc">{{$user->passport_date}}</span>
                                                </div>
                                            </div>
                                            <div class="kt-widget1__item">
                                                <div class="kt-widget1__info">
                                                    <h3 class="kt-widget1__title">@lang('hr.relationship')</h3>
                                                    <span class="kt-widget1__desc">{{$user->emergency_contact_relationship}}</span>
                                                </div>
                                            </div>
                                            <div class="kt-widget1__item">
                                                <div class="kt-widget1__info">
                                                    <h3 class="kt-widget1__title">@lang('hr.contract')</h3>
                                                    <span class="kt-widget1__desc">@if(!is_null($user->contract_type_id))   {{$user->contract_type->name_en}}  @endif</span>
                                                </div>
                                            </div>
                                            <div class="kt-widget1__item">
                                                <div class="kt-widget1__info">
                                                    <h3 class="kt-widget1__title">@lang('hr.contract') @lang('common.start') @lang('common.date') </h3>
                                                    <span class="kt-widget1__desc"> {{$user->start_date}}</span>
                                                </div>
                                            </div>
                                            <div class="kt-widget1__item">
                                                <div class="kt-widget1__info">
                                                    <h3 class="kt-widget1__title">@lang('common.working') @lang('common.start') @lang('common.time') </h3>
                                                    <span class="kt-widget1__desc">  {{$user->start_time}}</span>
                                                </div>
                                            </div>

                                        </div>
                                        <!--end:: Widgets/Stats2-2 -->
                                    </div>
                                    <div class="col-md-12 col-lg-12 col-xl-4">
                                        <!--begin:: Widgets/Stats2-3 -->
                                        <div class="kt-widget1">
                                            <div class="kt-widget1__item">
                                                <div class="kt-widget1__info">
                                                    <h3 class="kt-widget1__title">@lang('common.last') @lang('common.name')
                                                        EN</h3>
                                                    <span class="kt-widget1__desc">{{$user->last_name_en}}</span>
                                                </div>
                                                {{--                                                <span class="kt-widget1__number kt-font-success">+15%</span>--}}
                                            </div>

                                            <div class="kt-widget1__item">
                                                <div class="kt-widget1__info">
                                                    <h3 class="kt-widget1__title">@lang('common.last') @lang('common.name')
                                                        AR</h3>
                                                    <span class="kt-widget1__desc">{{$user->last_name_ar}}</span>
                                                </div>
                                                {{--                                                <span class="kt-widget1__number kt-font-danger">+80%</span>--}}
                                            </div>

                                            <div class="kt-widget1__item">
                                                <div class="kt-widget1__info">
                                                    <h3 class="kt-widget1__title">@lang('hr.residency')</h3>
                                                    <span class="kt-widget1__desc"> @if(!is_null($user->visa_type_id)) {{ $user->visa_type->name_en}} @endif</span>
                                                </div>
                                            </div>
                                            <div class="kt-widget1__item">
                                                <div class="kt-widget1__info">
                                                    <h3 class="kt-widget1__title">@lang('hr.visa') @lang('common.validity') @lang('common.date')</h3>
                                                    <span class="kt-widget1__desc"> {{$user->visa_validity}}</span>
                                                </div>
                                            </div>
                                            <div class="kt-widget1__item">
                                                <div class="kt-widget1__info">
                                                    <h3 class="kt-widget1__title">@lang('hr.emergency') @lang('hr.phone') @lang('common.number')</h3>
                                                    <span class="kt-widget1__desc">  {{$user->emergency_contact_phone}}</span>
                                                </div>
                                            </div>
                                            <div class="kt-widget1__item">
                                                <div class="kt-widget1__info">
                                                    <h3 class="kt-widget1__title">@lang('project.project') @lang('common.name')</h3>
                                                    <span class="kt-widget1__desc">   @if(!is_null($user->project_id))   {{$user->project->name_en}} @endif</span>
                                                </div>
                                            </div>
                                            <div class="kt-widget1__item">
                                                <div class="kt-widget1__info">
                                                    <h3 class="kt-widget1__title">@lang('hr.contract') @lang('common.end') @lang('common.date')</h3>
                                                    <span class="kt-widget1__desc">   {{$user->end_date}}</span>
                                                </div>
                                            </div>
                                            <div class="kt-widget1__item">
                                                <div class="kt-widget1__info">
                                                    <h3 class="kt-widget1__title">@lang('common.working') @lang('common.end') @lang('common.time')</h3>
                                                    <span class="kt-widget1__desc">  {{$user->end_time}}</span>
                                                </div>
                                            </div>

                                        </div>
                                        <!--end:: Widgets/Stats2-3 -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--End::Section-->
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <!--begin:: Widgets/Finance Summary-->
                        <div class="kt-portlet kt-portlet--height-fluid">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title">
                                       @lang('common.finance')
                                    </h3>
                                </div>
                            </div>
                            <div class="kt-portlet__body">
                                <div class="kt-widget12">
                                    <div class="kt-widget12__content">
                                        <div class="kt-widget12__item">
                                            <div class="kt-widget12__info">
                                                <span class="kt-widget12__desc">@lang('hr.starting') @lang('hr.salary')</span>
                                                <span class="kt-widget12__value money">{{$user->starting_salary}}</span>
                                            </div>
                                            <div class="kt-widget12__info">
                                                <span class="kt-widget12__desc">@lang('common.basic') @lang('hr.salary')</span>
                                                <span class="kt-widget12__value money">{{$user->basic_salary}}</span>
                                            </div>
                                            <div class="kt-widget12__info">
                                                <span class="kt-widget12__desc">@lang('common.gross') @lang('hr.salary') </span>
                                                <span class="kt-widget12__value money">{{$user->gross_salary}}</span>
                                            </div>
                                        </div>
                                        <div class="kt-widget12__item">
                                            <div class="kt-widget12__info">
                                                <span class="kt-widget12__desc">@lang('common.taxes')</span>
                                                <span class="kt-widget12__value money"> {{$user->taxes}}</span>
                                            </div>
                                            <div class="kt-widget12__info">
                                                <span class="kt-widget12__desc">@lang('hr.insurance')</span>
                                                <span class="kt-widget12__value money">{{$user->insurance}}</span>
                                            </div>
                                            <div class="kt-widget12__info">
                                                <span class="kt-widget12__desc">@lang('hr.house') @lang('hr.allowance') </span>
                                                <span class="kt-widget12__value money">{{$user->house_allowance}}</span>
                                            </div>
                                        </div>
                                        <div class="kt-widget12__item">
                                            <div class="kt-widget12__info">
                                                <span class="kt-widget12__desc">@lang('common.cost')  @lang('common.of')  @lang('hr.living')  @lang('hr.allowance')</span>
                                                <span class="kt-widget12__value money"> {{$user->cost_of_living_allowance}}</span>
                                            </div>
                                            <div class="kt-widget12__info">
                                                <span class="kt-widget12__desc">@lang('hr.management')  @lang('hr.allowance')</span>
                                                <span class="kt-widget12__value money"> {{$user->management_allowance}}</span>
                                            </div>
                                            <div class="kt-widget12__info">
                                                <span class="kt-widget12__desc">@lang('hr.phone')  @lang('hr.allowance')</span>
                                                <span class="kt-widget12__value money"> {{$user->cell_phone_allowance}}</span>
                                            </div>
                                        </div>
                                        <div class="kt-widget12__item">
                                            <div class="kt-widget12__info">
                                                <span class="kt-widget12__desc">@lang('hr.fuel')  @lang('hr.allowance')</span>
                                                <span class="kt-widget12__value money"> {{$user->fuel_allowance}}</span>
                                            </div>
                                            <div class="kt-widget12__info">
                                                <span class="kt-widget12__desc">@lang('hr.appearance')  @lang('hr.allowance')</span>
                                                <span class="kt-widget12__value money">{{$user->appearance_allowance}}</span>
                                            </div>
                                            <div class="kt-widget12__info">
                                                <span class="kt-widget12__desc">@lang('hr.transportation')  @lang('hr.allowance')</span>
                                                <span class="kt-widget12__value money"> {{$user->transportation_allowance}}</span>
                                            </div>
                                        </div>
                                        <div class="kt-widget12__item">
                                            <div class="kt-widget12__info">
                                                <span class="kt-widget12__desc">@lang('hr.work_nature')  @lang('hr.allowance')</span>
                                                <span class="kt-widget12__value money">{{$user->work_nature_allowance}}</span>
                                            </div>
{{--                                            <div class="kt-widget12__info">--}}
{{--                                                <span class="kt-widget12__desc">@lang('hr.insurance')</span>--}}
{{--                                                <span class="kt-widget12__value money">{{$user->insurance}}</span>--}}
{{--                                            </div>--}}
{{--                                            <div class="kt-widget12__info">--}}
{{--                                                <span class="kt-widget12__desc">@lang('hr.house') @lang('hr.allowance') </span>--}}
{{--                                                <span class="kt-widget12__value money">{{$user->house_allowance}}</span>--}}
{{--                                            </div>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end:: Widgets/Finance Summary-->
                    </div>
                </div>
            </div>
            <!--End:: App Content-->
        </div>
        <!--End::App-->
    </div>
@stop
@section('script')
    @include('layouts.include.script.script_list')
@stop
