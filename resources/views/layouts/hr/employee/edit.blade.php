@extends('layouts.app')
@section('style')
    @include('layouts.include.style.style_form')
    {!! Html::style('assets/app/custom/wizard/wizard-v1.demo2.css') !!}
@stop
@section('content')
    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="kt-portlet">
            <div class="kt-portlet__body kt-portlet__body--fit">
                <div class="kt-grid  kt-wizard-v1 kt-wizard-v1--white" id="kt_wizard_v1" data-ktwizard-state="step-first">
                    <div class="kt-grid__item">

                        <!--begin: Form Wizard Nav -->
                        <div class="kt-wizard-v1__nav">
                            <div class="kt-wizard-v1__nav-items">
                                <a class="kt-wizard-v1__nav-item" href="javascript:;" data-ktwizard-type="step" data-ktwizard-state="current">
                                    <div class="kt-wizard-v1__nav-body">
                                        <div class="kt-wizard-v1__nav-icon">
                                            <i class="flaticon-earth-globe"></i>
                                        </div>
                                        <div class="kt-wizard-v1__nav-label">
                                            @lang('common.general')  @lang('common.information')
                                        </div>
                                    </div>
                                </a>
                                <a class="kt-wizard-v1__nav-item" href="javascript:;" data-ktwizard-type="step">
                                    <div class="kt-wizard-v1__nav-body">
                                        <div class="kt-wizard-v1__nav-icon">
                                            <i class="flaticon-home-2"></i>
                                        </div>
                                        <div class="kt-wizard-v1__nav-label">
                                            @lang('hr.residency')  @lang('common.status')
                                        </div>
                                    </div>
                                </a>
                                <a class="kt-wizard-v1__nav-item" href="javascript:;" data-ktwizard-type="step">
                                    <div class="kt-wizard-v1__nav-body">
                                        <div class="kt-wizard-v1__nav-icon">
                                            <i class="flaticon-support"></i>
                                        </div>
                                        <div class="kt-wizard-v1__nav-label">
                                            @lang('hr.emergency')  @lang('common.contact')
                                        </div>
                                    </div>
                                </a>
                                <a class="kt-wizard-v1__nav-item" href="javascript:;" data-ktwizard-type="step">
                                    <div class="kt-wizard-v1__nav-body">
                                        <div class="kt-wizard-v1__nav-icon">
                                            <i class="flaticon-edit-1"></i>
                                        </div>
                                        <div class="kt-wizard-v1__nav-label">
                                            @lang('hr.employment')  @lang('common.information')
                                        </div>
                                    </div>
                                </a>
                                <a class="kt-wizard-v1__nav-item" href="javascript:;" data-ktwizard-type="step">
                                    <div class="kt-wizard-v1__nav-body">
                                        <div class="kt-wizard-v1__nav-icon">
                                            <i class="flaticon-coins"></i>
                                        </div>
                                        <div class="kt-wizard-v1__nav-label">
                                            @lang('hr.salary')  @lang('common.information')
                                        </div>
                                    </div>
                                </a>
                                <a class="kt-wizard-v1__nav-item" href="javascript:;" data-ktwizard-type="step">
                                    <div class="kt-wizard-v1__nav-body">
                                        <div class="kt-wizard-v1__nav-icon">
                                            <i class="flaticon-user-add"></i>
                                        </div>
                                        <div class="kt-wizard-v1__nav-label">
                                            @lang('common.account')  @lang('common.details')
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!--end: Form Wizard Nav -->
                    </div>

                    <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v1__wrapper">
                        <!--begin: Form Wizard Form-->
                        <form action="{{route('employee.update',$user->id)}} " class="kt-form" id="kt_form" method="POST">
                            @method('PUT')
                            @csrf
                            <input type="hidden" value="{{$user->id}}" name="id">
                            <!--begin: Form Wizard Step 1-->
                            <div class="kt-wizard-v1__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
                                <div class="kt-form__section kt-form__section--first">
                                    <div class="kt-wizard-v1__form">
                                        <div class="row">
                                            <div class="form-group col-lg-3">
                                                <label>Financial Code<span class="required" aria-required="true"> *</span></label>
                                                <input type="text" class="form-control kt_inputmask_6" maxlength="20" name="financial_code" placeholder="Financial Code"
                                                       value="{{$user->financial_code}}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group  col-lg-3">
                                                <label>@lang('common.first') @lang('common.name') EN <span class="required" aria-required="true"> *</span></label>
                                                <input type="text" class="form-control " name="first_name_en" placeholder="@lang('common.first') @lang('common.name')" value="{{$user->first_name_en}}">
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>@lang('common.middle') @lang('common.name') EN </label>
                                                    <input type="text" class="form-control kt_maxlength_3" maxlength="20" name="middle_name_en"
                                                           placeholder="@lang('common.middle') @lang('common.name')" value="{{$user->middle_name_en}}">
                                                </div>
                                            </div>
                                            <div class=" form-group  col-lg-3">
                                                <label>@lang('common.last') @lang('common.name') EN <span class="required" aria-required="true"> *</span></label>
                                                <input type="text" class="form-control kt_maxlength_3" maxlength="20" name="last_name_en" placeholder="@lang('common.last') @lang('common.name')"
                                                       value="{{$user->last_name_en}}">
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="form-group  col-lg-3">
                                                <label>@lang('common.first') @lang('common.name') AR <span class="required" aria-required="true"> *</span></label>
                                                <input type="text" class="form-control " name="first_name_ar" placeholder="@lang('common.first') @lang('common.name')" value="{{$user->first_name_ar}}">
                                                {{--                                                    <span class="form-text text-muted">Please enter your first name.</span>--}}
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>@lang('common.middle') @lang('common.name') AR</label>
                                                <input type="text" class="form-control " name="middle_name_ar" placeholder="@lang('common.middle') @lang('common.name')"
                                                       value="{{$user->middle_name_ar}}">
                                            </div>
                                            <div class="form-group  col-lg-3">
                                                <label>@lang('common.last') @lang('common.name') AR <span class="required" aria-required="true"> *</span></label>
                                                <input type="text" class="form-control" name="last_name_ar" placeholder="@lang('common.last') @lang('common.name')" value="{{$user->last_name_ar}}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Center </label>
                                                    {!! Form::select('center_id', $center,$user->center_id,['class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>@lang('hr.birth') @lang('common.date') </label>
                                                    <input type="text" class="form-control kt_datepicker_1_validate" name="date_of_birth" placeholder="@lang('hr.birth') @lang('common.date') "
                                                           value="{{$user->date_of_birth}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>@lang('hr.gender')</label>
                                                    {!! Form::select('gender_en', [ ''=>'Please Select','male'=>'Male',  'female'=>'Female' ],$user->gender_en,['class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>@lang('hr.marital') @lang('common.status') </label>
                                                    {!! Form::select('marital_status_id', $marital_statuses,$user->marital_status_id,['class' => 'form-control']) !!}
                                                </div>
                                            </div>


                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-3">
                                                <label>@lang('common.organisation_unit') </label>
                                                {!! Form::select('organisation_unit_id', $organisation_unit,$user->organisation_unit_id,['class' => 'form-control select2','id'=>'organisation_unit_id']) !!}
                                                <span class="form-text text-muted"></span>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>@lang('hr.nationality')</label>
                                                {!! Form::select('nationality_id', $nationalities,$user->nationality_id,['class' => 'form-control']) !!}
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>@lang('hr.identity') @lang('common.number')</label>
                                                <input type="text" class="form-control  kt_inputmask_6" placeholder="@lang('hr.nationality') @lang('common.id') " name="identity_number"
                                                       value="{{$user->identity_number}}">
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>@lang('hr.phone') @lang('common.number')</label>
                                                <input type="text" class="form-control phone_mask" name="phone_number" placeholder="@lang('hr.phone') @lang('common.number')"
                                                       value="{{$user->phone_number}}">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!--end: Form Wizard Step 1-->
                            <!--begin: Form Wizard Step 2-->
                            <div class="kt-wizard-v1__content" data-ktwizard-type="step-content">
                                <div class="kt-form__section kt-form__section--first">
                                    <div class="kt-wizard-v1__form">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>@lang('hr.residency') </label>
                                                    {!! Form::select('visa_type_id', $visa_type,$user->visa_type_id,['class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>@lang('passwords.password') @lang('common.number')</label>
                                                    <input type="text" class="form-control" name="passport_number" placeholder="@lang('passwords.password') @lang('common.number')"
                                                           value="{{$user->passport_number}}"/>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>@lang('passwords.password') @lang('common.validity') @lang('common.date') </label>
                                                    <input type="text" class="form-control kt_datepicker_1_validate" name="passport_date"
                                                           placeholder="@lang('passwords.password') @lang('common.validity') @lang('common.date')" value="{{$user->passport_date}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>@lang('hr.visa') @lang('common.validity') @lang('common.date')</label>
                                                    <input type="text" class="form-control kt_datepicker_1_validate" name="visa_validity"
                                                           placeholder="@lang('hr.visa') @lang('common.validity') @lang('common.date')" value="{{$user->visa_validity}}">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!--end: Form Wizard Step 2-->
                            <!--begin: Form Wizard Step 3-->
                            <div class="kt-wizard-v1__content" data-ktwizard-type="step-content">
                                <div class="kt-form__section kt-form__section--first">
                                    <div class="kt-wizard-v1__form">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>@lang('hr.emergency') @lang('common.contact')  @lang('common.name') En</label>
                                                    <input type="text" class="form-control" name="emergency_contact_name_en" placeholder="@lang('hr.emergency') @lang('common.contact')"
                                                           value="{{$user->emergency_contact_name_en}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>@lang('hr.emergency') @lang('common.contact')  @lang('common.name') AR</label>
                                                    <input type="text" class="form-control" name="emergency_contact_name_ar" placeholder="@lang('hr.emergency') @lang('common.contact')"
                                                           value="{{$user->emergency_contact_name_ar}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>@lang('hr.relationship')</label>
                                                    <input type="text" class="form-control" name="emergency_contact_relationship" placeholder="@lang('hr.relationship')"
                                                           value="{{$user->emergency_contact_relationship}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>@lang('hr.phone') @lang('common.number')</label>
                                                    <input type="text" class="form-control phone_mask" name="emergency_contact_phone" placeholder="@lang('hr.phone') @lang('common.number')"
                                                           value="{{$user->emergency_contact_phone}}">

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!--end: Form Wizard Step 3-->
                            <!--begin: Form Wizard Step 4 -->
                            <div class="kt-wizard-v1__content" data-ktwizard-type="step-content">
                                <div class="kt-form__section kt-form__section--first">
                                    <div class="kt-wizard-v1__form">
                                        <div class="row">
                                            <div class="col form-group">

                                                <label>@lang('hr.position') @lang('hr.category') <span class="required" aria-required="true"> *</span></label>
                                                {!! Form::select('position_category_id', $position_categories,$user->position_category_id,['class' => 'form-control','id'=>'category']) !!}
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>@lang('hr.position') <span class="required" aria-required="true"> *</span></label>
                                                {!! Form::select('position_id', $positions,$user->position_id,['class' => 'form-control select2 position','id'=>'position']) !!}
                                                <span class="form-text text-muted"></span>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>@lang('common.mission') <span class="required" aria-required="true"> *</span></label>
                                                {!! Form::select('mission_id', $missions,$user->mission_id,['class' => 'form-control select2 ','id'=>'mission']) !!}
                                                <span class="form-text text-muted"></span>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>@lang('hr.department') <span class="required" aria-required="true"> *</span></label>
                                                {!! Form::select('department_id',$departments,$user->department_id,['class' => 'form-control select2 ','id'=>'department']) !!}
                                                <span class="form-text text-muted"></span>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-3">
                                                <label>@lang('hr.superior') <span class="required" aria-required="true"> *</span></label>
                                                {!! Form::select('parent_id', $superior ,$user->parent_id,['class' => 'form-control select2 superior','id'=>'superior']) !!}
                                                <span class="form-text text-muted"></span>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>@lang('hr.contract') <span class="required" aria-required="true"> *</span></label>
                                                {!! Form::select('contract_type_id', $contracts,$user->contract_type_id,['class' => 'form-control']) !!}
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>@lang('project.project') @lang('common.name')</label>
                                                {!! Form::select('project_id', $projects,$user->project_id,['class' => 'form-control select2','id'=>'project']) !!}

                                            </div>
                                            {{--                                            <div class="form-group col-lg-3">--}}
                                            {{--                                                <label>@lang('hr.major') <span class="required" aria-required="true"> *</span></label>--}}
                                            {{--                                                {!! Form::select('major_id', $majors,null,['class' => 'form-control  select2']) !!}--}}

                                            {{--                                            </div>--}}

                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-3">
                                                <label>@lang('common.type_of_contract') </label>
                                                {!! Form::select('type_of_contract_id', $type_of_contract,$user->type_of_contract_id,['class' => 'form-control']) !!}
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>@lang('hr.contract') @lang('common.start') @lang('common.date') </label>
                                                <input type="text" class="form-control kt_datepicker_1_validate" autocomplete="off" name="start_date"
                                                       placeholder="@lang('hr.contract') @lang('common.start') @lang('common.date')" value="{{$user->start_date}}">
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>@lang('hr.contract') @lang('common.end') @lang('common.date') </label>
                                                <input type="text" class="form-control kt_datepicker_1_validate" name="end_date" autocomplete="off"
                                                       placeholder="@lang('hr.contract') @lang('common.end') @lang('common.date')" value="{{$user->end_date}}">
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="form-group col-lg-3">
                                                <label>@lang('hr.user') @lang('hr.group') <span class="required" aria-required="true"> *</span></label>
                                                {!! Form::select('user_group_id', $user_group,$user->user_group_id,['class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-3">
                                                <label>@lang('common.number') @lang('common.of') @lang('common.working') @lang('common.hours') <span class="required"
                                                                                                                                                     aria-required="true"> *</span></label>
                                                <input type="text" class="form-control kt_inputmask_6" name="number_of_hours"
                                                       placeholder="@lang('common.number') @lang('common.of') @lang('common.working') @lang('common.hours')" value="{{$user->number_of_hours}}">
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label> @lang('common.working') @lang('common.start') @lang('common.time') </label>
                                                <input class="form-control kt_timepicker_1" readonly value="{{$user->first_name_en}}" placeholder="Select time" type="text">
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label> @lang('common.working') @lang('common.end') @lang('common.time') </label>
                                                <input class="form-control kt_timepicker_1" readonly value="{{$user->first_name_en}}" placeholder="Select time" type="text"/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-9">
                                                <label>@lang('common.note') </label>
                                                <input type="text" class="form-control kt_maxlength_3" placeholder="@lang('common.note')" name="note" minlength="3" maxlength="200"
                                                       value="{{$user->note}}">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!--end: Form Wizard Step 4-->
                            <!--begin: Form Wizard Step 5 -->
                            <div class="kt-wizard-v1__content" data-ktwizard-type="step-content">
                                <div class="kt-form__section kt-form__section--first">
                                    <div class="kt-wizard-v1__form">
                                        <div class="row">
                                            <div class="form-group col-lg-3">
                                                <label>@lang('hr.starting') @lang('hr.salary')</label>
                                                <input type="text" class="form-control money" name="starting_salary" placeholder="@lang('hr.starting') @lang('hr.salary')"
                                                       value="{{$user->starting_salary}}"/>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>@lang('common.basic') @lang('hr.salary') <span class="required" aria-required="true"> *</span></label>
                                                <input type="text" class="form-control money total_price" name="basic_salary" placeholder="@lang('common.basic') @lang('hr.salary')"
                                                       value="{{$user->basic_salary}}"/>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>@lang('common.gross') @lang('hr.salary') <span class="required" aria-required="true"> *</span></label>
                                                <input type="text" class="form-control money gross_salary" readonly name="gross_salary" placeholder="@lang('common.gross') @lang('hr.salary')"
                                                       value="{{$user->gross_salary}}"/>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-3">
                                                <label>@lang('common.taxes') <span class="required" aria-required="true"> *</span></label>
                                                <input type="text" class="form-control money total_price" name="taxes" placeholder="@lang('common.taxes')" value="{{$user->taxes}}"/>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>@lang('hr.insurance') <span class="required" aria-required="true"> *</span></label>
                                                <input type="text" class="form-control money total_price" name="insurance" placeholder="@lang('hr.insurance')" value="{{$user->insurance}}"/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-3">
                                                <label>@lang('hr.house') @lang('hr.allowance')</label>
                                                <input type="text" class="form-control money total_price" name="house_allowance" placeholder="@lang('hr.house') @lang('hr.allowance')"
                                                       value="{{$user->house_allowance}}"/>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>@lang('hr.management')  @lang('hr.allowance') </label>
                                                <input type="text" class="form-control money total_price" name="management_allowance" placeholder="@lang('hr.management')  @lang('hr.allowance')"
                                                       value="{{$user->management_allowance}}"/>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>@lang('hr.phone')  @lang('hr.allowance')</label>
                                                <input type="text" class="form-control money total_price" name="cell_phone_allowance" placeholder="@lang('hr.phone')  @lang('hr.allowance')"
                                                       value="{{$user->cell_phone_allowance}}"/>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>@lang('common.cost')  @lang('common.of')  @lang('hr.living')  @lang('hr.allowance')</label>
                                                <input type="text" class="form-control money total_price" name="cost_of_living_allowance"
                                                       placeholder="@lang('common.cost')  @lang('common.of')  @lang('hr.living')  @lang('hr.allowance')" value="{{$user->cost_of_living_allowance}}"/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-3">
                                                <label>@lang('hr.fuel')  @lang('hr.allowance')</label>
                                                <input type="text" class="form-control money total_price" name="fuel_allowance" placeholder="@lang('hr.fuel')  @lang('hr.allowance')"
                                                       value="{{$user->fuel_allowance}}"/>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>@lang('hr.appearance')  @lang('hr.allowance')</label>
                                                <input type="text" class="form-control money total_price" name="appearance_allowance" placeholder="@lang('hr.appearance')  @lang('hr.allowance')"
                                                       value="{{$user->appearance_allowance}}"/>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>@lang('hr.transportation')  @lang('hr.allowance')</label>
                                                <input type="text" class="form-control money total_price" name="transportation_allowance"
                                                       placeholder="@lang('hr.transportation')  @lang('hr.allowance')" value="{{$user->transportation_allowance}}"/>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>@lang('hr.work_nature')  @lang('hr.allowance')</label>
                                                <input type="text" class="form-control money total_price" name="work_nature_allowance" placeholder="@lang('hr.work_nature')  @lang('hr.allowance')"
                                                       value="{{$user->work_nature_allowance}}"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end: Form Wizard Step 5-->
                            <!--begin: Form Wizard Step 6 -->
                            <div class="kt-wizard-v1__content" data-ktwizard-type="step-content">
                                <div class="kt-form__section kt-form__section--first">
                                    <div class="kt-wizard-v1__form">
                                        <div class="row">
                                            <div class="col-lg-3 form-group">
                                                <label>@lang('common.on') @lang('hr.behalf') @lang('common.of')</label>
                                                {!! Form::select('on_behalf_user_id', $users , $user->on_behalf_user_id,['class' => 'form-control select2','id'=>'on_behalf_user']) !!}
                                                <span class="form-text text-muted"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end: Form Wizard Step 6-->
                            <!--begin: Form Actions -->
                            <div class="kt-form__actions">
                                <button type="reset" onclick="history.back();" class="btn btn-secondary btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"> @lang('common.back')</button>

                                <div class="btn btn-secondary btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-prev">
                                    @lang('common.previous')
                                </div>
                                <div class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-submit">

                                    @lang('common.submit')
                                </div>
                                <div class="btn btn-brand btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-next">
                                    @lang('common.next') @lang('common.step')
                                </div>
                            </div>
                            <!--end: Form Actions -->
                        </form>
                        <!--end: Form Wizard Form-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end:: Content -->
@stop
@section('script')
    @include('layouts.include.script.script_jquery_form')
    {!! Html::script('assets/app/custom/wizard/wizard-employee-v1.js') !!}
    <script>
        nested('category', 'position', "{{$nested_url_position}}");
        nested('department', 'superior', "{{$nested_url_superior}}");
        nested('mission', 'department', "{{$nested_url_department}}");
        get_sum('total_price', 'gross_salary');
    </script>
@stop
