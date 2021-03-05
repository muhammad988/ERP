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
                <div class="kt-grid  kt-wizard-v1 kt-wizard-v1--white" id="kt_wizard_v1"
                     data-ktwizard-state="step-first">
                    <div class="kt-grid__item">

                        <!--begin: Form Wizard Nav -->
                        <div class="kt-wizard-v1__nav">
                            <div class="kt-wizard-v1__nav-items">
                                <a class="kt-wizard-v1__nav-item" href="javascript:;" data-ktwizard-type="step"
                                   data-ktwizard-state="current">
                                    <div class="kt-wizard-v1__nav-body">
                                        <div class="kt-wizard-v1__nav-icon">
                                            <i class="flaticon-book"></i>
                                        </div>
                                        <div class="kt-wizard-v1__nav-label">
                                            @lang('common.general')  @lang('project.information')
                                        </div>
                                    </div>
                                </a>
                                <a class="kt-wizard-v1__nav-item" href="javascript:;" data-ktwizard-type="step">
                                    <div class="kt-wizard-v1__nav-body">
                                        <div class="kt-wizard-v1__nav-icon">
                                            <i class="flaticon2-group"></i>
                                        </div>
                                        <div class="kt-wizard-v1__nav-label">
                                            @lang('project.beneficiaries')
                                        </div>
                                    </div>
                                </a>
                                <a class="kt-wizard-v1__nav-item" href="javascript:;" data-ktwizard-type="step">
                                    <div class="kt-wizard-v1__nav-body">
                                        <div class="kt-wizard-v1__nav-icon">
                                            <i class="flaticon-list"></i>
                                        </div>
                                        <div class="kt-wizard-v1__nav-label">
                                            @lang('project.objectives')  @lang('common.&') @lang('project.risks')
                                        </div>
                                    </div>
                                </a>
                                <a class="kt-wizard-v1__nav-item" href="javascript:;" data-ktwizard-type="step">
                                    <div class="kt-wizard-v1__nav-body">
                                        <div class="kt-wizard-v1__nav-icon">
                                            <i class="flaticon-map"></i>
                                        </div>
                                        <div class="kt-wizard-v1__nav-label">
                                            @lang('project.budget')
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!--end: Form Wizard Nav -->
                    </div>
                    <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v1__wrapper">
                        <!--begin: Form Wizard Form-->
                        <form method="POST" action="{{route('proposal.update',['id'=>$project->id])}} " class="kt-form" id="kt_form">
                        @csrf
                        @method('PUT')
                        <!--begin: Form Wizard Step 1-->
                            <div class="kt-wizard-v1__content" data-ktwizard-type="step-content"
                                 data-ktwizard-state="current">
                                <div class="kt-form__section kt-form__section--first">
                                    <div class="kt-wizard-v1__form">
                                        <div class="row">
                                            <div class="form-group col-lg-6">
                                                <label>@lang('project.project') @lang('common.name') EN<span
                                                            class="required" aria-required="true"> *</span></label>
                                                <input type="text" class="form-control kt_maxlength_3" maxlength="100"
                                                       name="project[name_en]"
                                                       placeholder="@lang('project.project') @lang('common.name') EN"
                                                       value="{{$project->name_en}}">
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label>@lang('project.project') @lang('common.name') AR<span
                                                            class="required" aria-required="true"> *</span></label>
                                                <input type="text" class="form-control kt_maxlength_3" maxlength="100"
                                                       name="project[name_er]"
                                                       placeholder="@lang('project.project') @lang('common.name') AR"
                                                       value="{{$project->name_ar}}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-3">
                                                <label>@lang('common.mission') <span class="required"
                                                                                     aria-required="true"> *</span></label>
                                                {!! Form::select('mission_id',$missions,$mission_id,['class' => 'form-control select2 ','id'=>'mission']) !!}
                                                <span class="form-text text-muted"></span>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>@lang('hr.department') <span class="required"
                                                                                    aria-required="true"> *</span></label>
                                                {!! Form::select('department_id', $departments ,$department_id,['class' => 'form-control select2 ','id'=>'department']) !!}
                                                <span class="form-text text-muted"></span>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>@lang('common.sector') <span class="required"
                                                                                    aria-required="true"> *</span></label>
                                                {!! Form::select('project[sector_id]', $sectors ,$project->sector_id,['class' => 'form-control select2','id'=>'sector']) !!}
                                                <span class="form-text text-muted"></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-3">
                                                <label>@lang('common.start') @lang('common.date') <span class="required"
                                                                                                        aria-required="true"> *</span></label>
                                                <input type="text" class="form-control kt_datepicker_1_validate"
                                                       name="project[start_date]" value="{{$project->start_date}}" autocomplete="off" id="start_date"
                                                       placeholder="@lang('common.start') @lang('common.date')">
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>@lang('common.end') @lang('common.date') <span class="required"
                                                                                                      aria-required="true"> *</span></label>
                                                <input type="text" class="form-control kt_datepicker_1_validate"
                                                       name="project[end_date]" value="{{$project->end_date}}" id="end_date"
                                                       autocomplete="off"
                                                       placeholder="@lang('common.end') @lang('common.date')">
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>@lang('common.duration') </label>
                                                <input type="text" class="form-control kt_datepicker_1_validate"
                                                       id="duration" value="{{get_duration ($project->start_date,$project->end_date)}}" readonly disabled
                                                       placeholder="@lang('common.duration')">
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>@lang('common.organisation_unit') <span class="required"
                                                                                               aria-required="true"> *</span></label>
                                                {!! Form::select('project[organisation_unit_id]', $organisation_unit,$project->organisation_unit_id,['class' => 'form-control select2','id'=>'organisation_unit']) !!}
                                                <span class="form-text text-muted"></span>
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
                                            <div class="col-md-12">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>
                                                            @lang('project.beneficiaries') @lang('common.type')
                                                        </th>
                                                        <th>
                                                            @lang('project.men')
                                                        </th>
                                                        <th>
                                                            @lang('project.women')
                                                        </th>
                                                        <th>
                                                            @lang('project.boys')
                                                        </th>
                                                        <th>
                                                            @lang('project.girls')
                                                        </th>
                                                        <th>
                                                            @lang('common.total')
                                                        </th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($project->beneficiaries as $key=>$value)
                                                        <tr>

                                                            <input type="hidden" name="beneficiary[type][]" value="{{$value->type_id}}">
                                                            <td>{{$value->type_name_en}} </td>
                                                            <td>
                                                                <div class="form-group ">
                                                                    <input type="text"
                                                                           name='beneficiary[men][]'
                                                                           placeholder='0'
                                                                           required
                                                                           value="{{$value->men}}"
                                                                           class="form-control money  sum_{{$key}} m-input"/>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group ">
                                                                    <input type="text"
                                                                           name='beneficiary[women][]'
                                                                           placeholder='0'
                                                                           required
                                                                           value="{{$value->women}}"
                                                                           class="form-control money sum_{{$key}} m-input"/>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group ">

                                                                    <input type="text"
                                                                           name='beneficiary[boys][]'
                                                                           placeholder='0'
                                                                           required
                                                                           value="{{$value->boys}}"
                                                                           class="form-control money sum_{{$key}} m-input"/>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group ">
                                                                    <input type="text"
                                                                           name='beneficiary[girls][]'
                                                                           placeholder='0'

                                                                           value="{{$value->girls}}"
                                                                           class="form-control money sum_{{$key}} m-input"/>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group ">
                                                                    <input type="text"
                                                                           placeholder='0'
                                                                           value="{{$value->men+$value->women+$value->boys+$value->girls}}"
                                                                           readonly
                                                                           class="form-control total_{{$key}} money"/>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label
                                                        for="indirect_beneficiaries"> @lang('project.indirect')  @lang('project.beneficiaries')
                                                    <span
                                                            class="required" aria-required="true"> *</span></label>
                                                <textarea class="form-control" id="indirect_beneficiaries"
                                                          name="proposal[indirect_beneficiaries]" rows="6">{{$project->proposal->indirect_beneficiaries}}</textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-3">
                                                <label>@lang('project.catchment') @lang('common.area')<span
                                                            class="required" aria-required="true"> *</span></label>
                                                <input type="text" class="form-control money" name="proposal[catchment_area]"
                                                       placeholder="0" value="{{$project->proposal->catchment_area}}">
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
                                            <div class="form-group col-md-12">
                                                <label
                                                        for="project_summary"> @lang('project.project')  @lang('project.summary')
                                                    <span class="required" aria-required="true"> *</span></label>
                                                <textarea class="form-control" id="project_summary"
                                                          name="proposal[project_summary]" rows="6"> {{$project->proposal->project_summary}}</textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label
                                                        for="overall_objective">@lang('project.overall')  @lang('project.objectives')
                                                    <span class="required" aria-required="true"> *</span></label>
                                                <textarea class="form-control" id="overall_objective"
                                                          name="proposal[overall_objective]" rows="6">{{$project->proposal->overall_objective}}</textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label
                                                        for="needs_assessment">@lang('common.needs') @lang('common.assessment')
                                                    <span class="required" aria-required="true"> *</span></label>
                                                <textarea class="form-control" id="needs_assessment"
                                                          name="proposal[needs_assessment]" rows="6">{{$project->proposal->needs_assessment}}</textarea>
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
                                            @foreach($project->proposal_budgets as $key=>$value)
                                                <div class="form-group col-lg-3">
                                                    <label>{{$value->budget_name_en}}<span
                                                                class="required" aria-required="true"> *</span></label>
                                                    <input type="text" required class="form-control money sum_budget"
                                                           name="budget[{{$value->budget_category_id}}]"
                                                           placeholder="0"
                                                           value="{{$value->value}}">
                                                </div>
                                            @endforeach

                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-3">
                                                <label>@lang('common.total') @lang('project.budget')<span
                                                            class="required" aria-required="true"> *</span></label>
                                                <input type="text" required class="form-control money total_budget"
                                                       name="project_budget"
                                                       placeholder="0"
                                                       value="{{$project->proposal_budgets->sum('value')}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end: Form Wizard Step 4-->
                            <!--begin: Form Actions -->
                            <div class="kt-form__actions">
                                <button type="reset" onclick="history.back();"
                                        class="btn btn-secondary btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"> @lang('common.back')</button>

                                <div class="btn btn-secondary btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
                                     data-ktwizard-type="action-prev">
                                    @lang('common.previous')
                                </div>
                                <div class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
                                     data-ktwizard-type="action-submit">

                                    @lang('common.submit')
                                </div>
                                <div class="btn btn-brand btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
                                     data-ktwizard-type="action-next">
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
    {!! Html::script('assets/app/custom/wizard/wizard-proposal-v1.js') !!}
    <script>
        nested('mission', 'department', "{{$nested_url_department}}");
        nested('department', 'sector', "{{$nested_url_sector}}");
        get_duration('start_date', 'end_date', 'duration');
        get_sum('sum_0', 'total_0');
        get_sum('sum_1', 'total_1');
        get_sum('sum_budget', 'total_budget');
    </script>
@stop
