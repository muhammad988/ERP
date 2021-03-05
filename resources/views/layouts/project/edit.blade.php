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
                                            @lang('project.concept')  @lang('common.review')
                                        </div>
                                    </div>
                                </a>
                                <a class="kt-wizard-v1__nav-item" href="javascript:;" data-ktwizard-type="step">
                                    <div class="kt-wizard-v1__nav-body">
                                        <div class="kt-wizard-v1__nav-icon">
                                            <i class="flaticon-background"></i>
                                        </div>
                                        <div class="kt-wizard-v1__nav-label">
                                            @lang('project.project')  @lang('common.details')
                                        </div>
                                    </div>
                                </a>
                                <a class="kt-wizard-v1__nav-item" href="javascript:;" data-ktwizard-type="step">
                                    <div class="kt-wizard-v1__nav-body">
                                        <div class="kt-wizard-v1__nav-icon">
                                            <i class="flaticon-interface-3"></i>
                                        </div>
                                        <div class="kt-wizard-v1__nav-label">
                                            @lang('project.logical') @lang('project.framework')
                                        </div>
                                    </div>
                                </a>
                                <a class="kt-wizard-v1__nav-item" href="javascript:;" data-ktwizard-type="step">
                                    <div class="kt-wizard-v1__nav-body">
                                        <div class="kt-wizard-v1__nav-icon">
                                            <i class="flaticon-list"></i>
                                        </div>
                                        <div class="kt-wizard-v1__nav-label">
                                            @lang('project.project')  @lang('common.&') @lang('project.complementary')
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
                                <a class="kt-wizard-v1__nav-item" href="javascript:;" data-ktwizard-type="step">
                                    <div class="kt-wizard-v1__nav-body">
                                        <div class="kt-wizard-v1__nav-icon">
                                            <i class="flaticon-map"></i>
                                        </div>
                                        <div class="kt-wizard-v1__nav-label">
                                            Work Plan
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!--end: Form Wizard Nav -->
                    </div>
                    <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v1__wrapper">
                        <!--begin: Form Wizard Form-->
                        <form method="POST" action="{{route('project.update')}} " class="kt-form" id="kt_form" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input name="id" type="hidden" value="{{$project->id}}">
                            <input name="total_direct" class="total_direct" type="hidden" value="0">
                            <input name="total_indirect" class="total_indirect" type="hidden" value="0">
                            <input name="total_cost" class="total_cost" type="hidden" value="0">
                            <input name="total_day" class="total_day" type="hidden" value="0">
                            <!--begin: Form Wizard Step 1-->
                            <div class="kt-wizard-v1__content" data-ktwizard-type="step-content"
                                 data-ktwizard-state="current">
                                <div class="kt-form__section kt-form__section--first">
                                    <div class="kt-wizard-v1__form">
                                        <div class="kt-form__section kt-form__section--first">
                                            <div class="kt-wizard-v1__review">
                                                <div class="kt-wizard-v1__review-item">
                                                    <div class="kt-wizard-v1__review-title">
                                                        @lang('project.project') @lang('common.details')
                                                    </div>
                                                    <div class="kt-wizard-v1__review-content">
                                                        <table class="table table-bordered table-striped">
                                                            <thead>
                                                            <th class="th-quarter">
                                                                @lang('project.project') @lang('common.name')
                                                            </th>
                                                            <th class="th-quarter">
                                                                @lang('common.logistic')
                                                            </th>
                                                            <th class="th-quarter">
                                                                @lang('common.department')
                                                            </th>
                                                            <th class="th-quarter">
                                                                @lang('common.sector')
                                                            </th>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td>{{$project->name_en}}</td>
                                                                <td>{{$project->organisation_unit->name_en}}</td>
                                                                <td>{{  $project->sector->department->department->name_en }}</td>
                                                                <td>{{ $project->sector->sector->name_en }}</td>

                                                            </tr>
                                                            </tbody>
                                                        </table>

                                                    </div>
                                                </div>
                                                <div class="kt-wizard-v1__review-item">
                                                    <div class="kt-wizard-v1__review-title">
                                                        @lang('project.project') @lang('project.budget')
                                                    </div>
                                                    <div class="kt-wizard-v1__review-content">
                                                        <table class="table table-bordered table-striped">
                                                            <thead>
                                                            <th class="th-quarter">
                                                                @lang('project.budget')
                                                            </th>
                                                            <th class="th-quarter">
                                                                @lang('common.start')@lang('common.date')
                                                            </th>
                                                            <th class="th-quarter">
                                                                @lang('common.end')@lang('common.date')
                                                            </th>
                                                            <th class="th-quarter">
                                                                @lang('common.duration')
                                                            </th>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td class="money">{{$project->project_budget}}</td>
                                                                <td>{{$project->start_date}}</td>
                                                                <td>{{  $project->end_date }}</td>
                                                                <td>{{get_duration($project->start_date, $project->end_date)}}</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>

                                                    </div>
                                                </div>
                                                <div class="kt-wizard-v1__review-item">
                                                    <div class="kt-wizard-v1__review-title">
                                                        @lang('project.project') @lang('project.beneficiaries')
                                                    </div>
                                                    <div class="kt-wizard-v1__review-content">
                                                        <table class="table table-bordered table-striped">
                                                            <thead>
                                                            <th> @lang('common.type') </th>
                                                            <th> @lang('common.logistic') </th>
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
                                                                    <td> {{$project->organisation_unit->name_en}} </td>
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
                                                <div class="kt-wizard-v1__review-item">
                                                    <div class="kt-wizard-v1__review-title">
                                                        @lang('project.catchment') @lang('common.area')
                                                    </div>
                                                    <div class="kt-wizard-v1__review-content">
                                                        <span class="money">{{$project->proposal->catchment_area}}</span>
                                                    </div>
                                                </div>
                                                <div class="kt-wizard-v1__review-item">
                                                    <div class="kt-wizard-v1__review-title">
                                                        @lang('project.indirect') @lang('project.beneficiaries')
                                                    </div>
                                                    <div class="kt-wizard-v1__review-content">
                                                        {{$project->proposal->indirect_beneficiaries}}
                                                    </div>
                                                </div>
                                                <div class="kt-wizard-v1__review-item">
                                                    <div class="kt-wizard-v1__review-title">
                                                        @lang('project.project')  @lang('project.summary')
                                                    </div>
                                                    <div class="kt-wizard-v1__review-content">
                                                        {{$project->proposal->project_summary}}
                                                    </div>
                                                </div>
                                                <div class="kt-wizard-v1__review-item">
                                                    <div class="kt-wizard-v1__review-title">
                                                        @lang('common.general')  @lang('project.objectives')
                                                    </div>
                                                    <div class="kt-wizard-v1__review-content">
                                                        {{$project->proposal->overall_objective}}
                                                    </div>
                                                </div>
                                                <div class="kt-wizard-v1__review-item">
                                                    <div class="kt-wizard-v1__review-title">
                                                        @lang('common.needs')  @lang('common.assessment')
                                                    </div>
                                                    <div class="kt-wizard-v1__review-content">
                                                        {{$project->proposal->needs_assessment}}
                                                    </div>
                                                </div>
                                                <div class="kt-wizard-v1__review-item">
                                                    <div class="kt-wizard-v1__review-title">
                                                        @lang('project.budget')  @lang('project.summary')
                                                    </div>
                                                    <div class="kt-wizard-v1__review-content">
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
                                            <div class="form-group col-md-12">
                                                <label for="context">@lang('project.context') <span class="required" aria-required="true"> *</span></label>
                                                <textarea required class="form-control" id="context" name="project[context]" rows="6">{{($project->detailed_proposal->context ?? null)}}</textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="link_to_cluster_objectives"> @lang('project.link_to_cluster_objectives') <span class="required" aria-required="true"> *</span></label>
                                                <textarea required class="form-control" id="link_to_cluster_objectives" name="project[link_to_cluster_objectives]"
                                                          rows="6">{{($project->detailed_proposal->link_to_cluster_objectives ?? null)}}</textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="implementation_plan"> @lang('project.implementation')  @lang('project.plan') <span class="required" aria-required="true"> *</span></label>
                                                <textarea required class="form-control" id="implementation_plan" name="project[implementation_plan]"
                                                          rows="6">{{($project->detailed_proposal->link_to_cluster_objectives ?? null)}}</textarea>
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
                                                <label for="overall_objectives"> @lang('project.overall')  @lang('project.objectives') <span class="required" aria-required="true"> *</span></label>
                                                <textarea required class="form-control" id="overall_objective" name="project[overall_objective]"
                                                          rows="6">{{($project->detailed_proposal->overall_objective ?? null)}}</textarea>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label>Distribution of Beneficiaries Per Locations</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <div id="kt_repeater_3">
                                                    <div class="form-group  row">
                                                        <div data-repeater-list="beneficiary" class="col-lg-12">
                                                            @if(isset($project->submission_beneficiaries))

                                                                @foreach($project->submission_beneficiaries as $key=>$value)
                                                                    <div data-repeater-item class="row kt-margin-b-10 align-items-center">
                                                                        <div class="form-group col-lg-2">
                                                                            <label>@lang('common.organisation_unit') <span class="required" aria-required="true"> *</span></label>
                                                                            <i style="float: right;" class="la la-map-marker fa-lg get_organisation_unit"></i>
                                                                            <select required name="organisation_unit" class=" form-control ">
                                                                                <option value="{{$value->organisation_unit_id}}">{{$value->organisation_unit_name_en}}</option>
                                                                            </select>
                                                                            <input type="hidden" name="option_name" value="{{$value->organisation_unit_name_en}}">
                                                                        </div>
                                                                        <div class="form-group col-lg-1">
                                                                            <label>@lang('project.men') <span class="required" aria-required="true"> *</span></label>
                                                                            <input type="text" class="form-control" required onkeyup="getTotalBeneficiaries(this)" name="men"
                                                                                   placeholder="@lang('project.men')" value="{{ $value->men}}">
                                                                        </div>
                                                                        <div class="form-group col-lg-1">
                                                                            <label>@lang('project.women') <span class="required" aria-required="true"> *</span></label>
                                                                            <input type="text" class="form-control " required onkeyup="getTotalBeneficiaries(this)" name="women"
                                                                                   placeholder="@lang('project.women')" value="{{ $value->women}}">
                                                                        </div>
                                                                        <div class="form-group col-lg-1">
                                                                            <label>@lang('project.boys') <span class="required" aria-required="true"> *</span></label>
                                                                            <input type="text" class="form-control " required onkeyup="getTotalBeneficiaries(this)" name="boys"
                                                                                   placeholder="@lang('project.boys')" value="{{ $value->boys}}">
                                                                        </div>
                                                                        <div class="form-group col-lg-1">
                                                                            <label>@lang('project.girls') <span class="required" aria-required="true"> *</span></label>
                                                                            <input type="text" class="form-control " required onkeyup="getTotalBeneficiaries(this)" name="girls"
                                                                                   placeholder="@lang('project.girls')" value="{{ $value->girls}}">
                                                                        </div>
                                                                        <div class="form-group col-lg-1">
                                                                            <label>@lang('common.total') <span class="required" aria-required="true"> *</span></label>
                                                                            <input type="text" class="form-control " required readonly name="total" placeholder="@lang('common.total')"
                                                                                   value="{{$value->men+$value->women+$value->boys+$value->girls}}">
                                                                        </div>
                                                                        <div class="col-lg-1">
                                                                            <button type="button" data-repeater-delete="" class="btn btn-danger btn-sm btn-icon btn-circle"><i
                                                                                    class="la la-trash-o"></i></button>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <div data-repeater-item class="row kt-margin-b-10 align-items-center">
                                                                    <div class="form-group col-lg-2">
                                                                        <label>@lang('common.organisation_unit') <span class="required" aria-required="true"> *</span></label>
                                                                        <i style="float: right;" class="la la-map-marker fa-lg get_organisation_unit"></i>
                                                                        <select required name="organisation_unit" class=" form-control "></select>
                                                                        <input type="hidden" name="option_name" value="">
                                                                    </div>
                                                                    <div class="form-group col-lg-1">
                                                                        <label>@lang('project.men') <span class="required" aria-required="true"> *</span></label>
                                                                        <input type="text" class="form-control " required onkeyup="getTotalBeneficiaries(this)" name="men"
                                                                               placeholder="@lang('project.men')" value="">
                                                                    </div>
                                                                    <div class="form-group col-lg-1">
                                                                        <label>@lang('project.women') <span class="required" aria-required="true"> *</span></label>
                                                                        <input type="text" class="form-control " required onkeyup="getTotalBeneficiaries(this)" name="women"
                                                                               placeholder="@lang('project.women')" value="">
                                                                    </div>
                                                                    <div class="form-group col-lg-1">
                                                                        <label>@lang('project.boys') <span class="required" aria-required="true"> *</span></label>
                                                                        <input type="text" class="form-control " required onkeyup="getTotalBeneficiaries(this)" name="boys"
                                                                               placeholder="@lang('project.boys')" value="">
                                                                    </div>
                                                                    <div class="form-group col-lg-1">
                                                                        <label>@lang('project.girls') <span class="required" aria-required="true"> *</span></label>
                                                                        <input type="text" class="form-control " required onkeyup="getTotalBeneficiaries(this)" name="girls"
                                                                               placeholder="@lang('project.girls')" value="">
                                                                    </div>
                                                                    <div class="form-group col-lg-1">
                                                                        <label>@lang('common.total') <span class="required" aria-required="true"> *</span></label>
                                                                        <input type="text" class="form-control " required readonly name="total" placeholder="@lang('common.total')" value="">
                                                                    </div>
                                                                    <div class="col-lg-1">
                                                                        <button type="button" data-repeater-delete="" class="btn btn-danger btn-sm btn-icon btn-circle"><i class="la la-trash-o"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div data-repeater-create="" class="btn btn btn-primary">
																	<span>
																		<i class="la la-plus"></i>
																		<span>Add</span>
																	</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label><h5> Work plan</h5></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <div id="outcomes">
                                                    <div class="form-group">
                                                        <button class="btn btn-primary" id="add_outcome">
                                                            Add Outcome
                                                        </button>
                                                    </div>

                                                    @if(isset($project->outcomes) )
                                                        @foreach($project->outcomes as $key=>$outcome)
                                                            @php
                                                                $newKey=$key+1;
                                                            @endphp
                                                            <div class="outcome" id="outcome{{$newKey}}" name="outcome{{$newKey}}">
                                                                <div class="row  form-group align-items-center">
                                                                    <div class="col-lg-12  outcome-title"><h5>Outcome - {{$newKey}}</h5></div>
                                                                    <div class="col-lg-10 form-group"><label>Description<span class="required" aria-required="true"> *</span></label>
                                                                        <textarea required id="outcome{{$newKey}}" name="description[]" class="form-control kt_maxlength_3 m-input" maxlength="100"
                                                                                  placeholder="Description">{{$outcome->description}}</textarea></div>
                                                                    <div class="col-lg-2">
                                                                        <button type="button" class="btn btn-label-info btn-sm  add_output"><i class="la la-plus"></i>put</button>
                                                                        <button type="button" class="btn  btn-label-danger btn-sm deleteOutcome float-right"><i class="la la-trash-o"></i></button>
                                                                    </div>
                                                                </div>
                                                                @if(isset($outcome->outputs ))
                                                                    @foreach($outcome->outputs as $keyOutput=> $valueOutput)
                                                                        @php
                                                                            $newKeyOutput=$keyOutput+1;
                                                                        @endphp
                                                                        <div class="output" id="output{{$newKey}}{{$newKeyOutput}}"
                                                                             name="output{{$newKey}}{{$newKeyOutput}}">
                                                                            <div class="row  form-group   align-items-center">
                                                                                <div class="col-lg-12 title"><h5>Output-{{$newKey}}{{$newKeyOutput}}</h5></div>
                                                                                <div class="col-lg-5  form-group  description"><label>Description<span class="required"
                                                                                                                                                       aria-required="true"> *</span></label>
                                                                                    <textarea required class="form-control kt_maxlength_3" maxlength="100" required="required"
                                                                                              placeholder="Description 1 1"
                                                                                              id="output{{$newKey}}{{$newKeyOutput}}"
                                                                                              name="output_description_{{$newKey}}[]">{{$valueOutput->description}}</textarea></div>
                                                                                <div class="col-lg-5  form-group  assumption"><label>Assumption Risk<span class="required"
                                                                                                                                                          aria-required="true"> *</span></label>
                                                                                    <textarea required class="form-control kt_maxlength_3" maxlength="100" required="required"
                                                                                              placeholder="Risk &amp; Assumption 1 1"
                                                                                              id="output{{$newKey}}{{$newKeyOutput}}"
                                                                                              name="output_assumption_{{$newKey}}[]">{{$valueOutput->assumption}}</textarea></div>
                                                                                <div class="col-lg-2">
                                                                                    <button type="button" class="btn btn-sm btn-label-info add_activity"><i class="la la-plus"></i>Act</button>
                                                                                    <button type="button" class="btn btn-sm btn-label-info addIndicator"><i class="la la-plus"></i>Ind</button>
                                                                                    <button class="btn btn-sm btn-label-danger deleteOutput float-right"><i class="la la-trash-o"></i></button>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row output-12">

                                                                                <div class="col-lg-7 activity-7">
                                                                                    @if(isset($valueOutput->activities) )
                                                                                        @foreach($valueOutput->activities as $keyActivity=> $valueActivity)
                                                                                            @php
                                                                                                $newKeyActivity=$keyActivity+1;
                                                                                            @endphp
                                                                                            <div class="activity" id="activity{{$newKey}}{{$newKeyOutput}}{{$newKeyActivity}}"
                                                                                                 name="activity{{$newKey}}{{$newKeyOutput}}{{$newKeyActivity}}">
                                                                                                <div class="row form-group align-items-center">
                                                                                                    <div class="col-lg-12 title"><h5>Activity-{{$newKey}}{{$newKeyOutput}}{{$newKeyActivity}}</h5></div>
                                                                                                    <div class="col-lg-2 activity_phase  form-group "><label class="title_phase">Activity Phase<span
                                                                                                                class="required" aria-required="true"> *</span></label>
                                                                                                        {!! Form::select("activity_phase_".$newKey.$newKeyOutput."[]",$activity_phase,$valueActivity->activity_phase_id ,['class'=>"select_activity_phase form-control" ,'required']) !!}
                                                                                                    </div>
                                                                                                    <div class="col-lg-2 responsibility  form-group ">
                                                                                                        <label class="title_responsibility">Responsibility<span class="required"
                                                                                                                                                                aria-required="true"> *</span>
                                                                                                        </label><i style="float: right;" class="la la-user-plus fa-lg get_employee"></i>
                                                                                                        <select required="required" class="form-control select_responsibility "
                                                                                                                id="responsibility_{{$newKey}}{{$newKeyOutput}}{{$newKeyActivity}}"
                                                                                                                name="responsibility_{{$newKey}}{{$newKeyOutput}}[]">
                                                                                                            <option value="{{$valueActivity->responsibility}}"
                                                                                                                    selected="selected">{{$valueActivity->first_name_en }} {{$valueActivity->last_name_en }}</option>
                                                                                                        </select>
                                                                                                        <input type="hidden" name="option_name_responsibility_{{$newKey}}{{$newKeyOutput}}[]"
                                                                                                               value="{{$valueActivity->first_name_en }} {{$valueActivity->last_name_en }}">
                                                                                                    </div>
                                                                                                    <div class="col-lg-2 start_date  form-group ">
                                                                                                        <label class="title_start_date">Start Date<span class="required" aria-required="true"> *</span></label>
                                                                                                        <input required="required" class="form-control  date-picker start_date_activity"
                                                                                                               value="{{$valueActivity->start_date}}"
                                                                                                               data-date-format="yyyy-mm-dd" type="text"
                                                                                                               id="start_date_{{$newKey}}{{$newKeyOutput}}{{$newKeyActivity}}"
                                                                                                               name="start_date_{{$newKey}}{{$newKeyOutput}}[]">
                                                                                                    </div>
                                                                                                    <div class="col-lg-2 end_date  form-group ">
                                                                                                        <label class="title_end_date">End Date<span class="required"
                                                                                                                                                    aria-required="true"> *</span></label>
                                                                                                        <input required="required" class="form-control  date-picker end_date_activity"
                                                                                                               data-date-format="yyyy-mm-dd" type="text"
                                                                                                               value="{{$valueActivity->end_date}}"
                                                                                                               id="end_date_{{$newKey}}{{$newKeyOutput}}{{$newKeyActivity}}"
                                                                                                               name="end_date_{{$newKey}}{{$newKeyOutput}}[]">
                                                                                                    </div>
                                                                                                    <div class="col-lg-2 cost  form-group ">
                                                                                                        <label class="title_cost">cost <span class="required" aria-required="true"> *</span></label>
                                                                                                        <input required="" class="form-control money"
                                                                                                               value="{{$valueActivity->direct_cost}}"
                                                                                                               im-insert="true"
                                                                                                               id="cost_{{$newKey}}{{$newKeyOutput}}{{$newKeyActivity}}"
                                                                                                               name="cost_{{$newKey}}{{$newKeyOutput}}[]">
                                                                                                    </div>
                                                                                                    <div class="col-lg-9  form-group  description_activity">
                                                                                                        <label class="title_description">Description<span class="required"
                                                                                                                                                          aria-required="true"> *</span></label>
                                                                                                        <textarea required class="form-control textarea_description_activity kt_maxlength_3"
                                                                                                                  maxlength="100"
                                                                                                                  required="required"
                                                                                                                  placeholder="Activity Description-{{$newKey}}{{$newKeyOutput}}{{$newKeyActivity}}"
                                                                                                                  id="activity_description_{{$newKey}}{{$newKeyOutput}}{{$newKeyActivity}}"
                                                                                                                  name="activity_description_{{$newKey}}{{$newKeyOutput}}[]">{{$valueActivity->description}}</textarea>
                                                                                                    </div>
                                                                                                    <div class="col-lg-3">
                                                                                                        <button class="btn btn-label-danger btn-sm deleteActivity"><i class="la la-trash-o"></i>
                                                                                                        </button>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </div>
                                                                                <div class="col-lg-5 indicator-5">
                                                                                    @if(isset($valueOutput->indicators))
                                                                                        @foreach($valueOutput->indicators as $keyIndicator=> $valueIndicator)
                                                                                            @php
                                                                                                $newKeyIndicator=$keyIndicator+1;
                                                                                            @endphp
                                                                                            <div class="indicator" id="indicator{{$newKey}}{{$newKeyOutput}}{{$newKeyIndicator}}"
                                                                                                 name="indicator{{$newKey}}{{$newKeyOutput}}{{$newKeyIndicator}}">
                                                                                                <div class="row  form-group   align-items-center">
                                                                                                    <div class="col-lg-12 title"><h5>Indicator-{{$newKey}}{{$newKeyOutput}}{{$newKeyIndicator}}</h5>
                                                                                                    </div>
                                                                                                    <div class="col-lg-5  form-group  indicator_description"><label>Description</label>
                                                                                                        <textarea class="form-control kt_maxlength_3" maxlength="100" required="required"
                                                                                                                  placeholder="Description-{{$newKey}}{{$newKeyOutput}}{{$newKeyIndicator}}"
                                                                                                                  id="indicator_description{{$newKey}}{{$newKeyOutput}}{{$newKeyIndicator}}"
                                                                                                                  name="indicator_description_{{$newKey}}{{$newKeyOutput}}[]">{{$valueIndicator->description}}</textarea>
                                                                                                    </div>
                                                                                                    <div class="col-lg-5  form-group  verification"><label>Verification</label>
                                                                                                        <textarea class="form-control kt_maxlength_3" maxlength="100" required="required"
                                                                                                                  placeholder="verification-{{$newKey}}{{$newKeyOutput}}{{$newKeyIndicator}}"
                                                                                                                  id="verification{{$newKey}}{{$newKeyOutput}}{{$newKeyIndicator}}"
                                                                                                                  name="verification_{{$newKey}}{{$newKeyOutput}}[]">{{$valueIndicator->means_of_verification}}</textarea>
                                                                                                    </div>
                                                                                                    <div class="col-lg-2">
                                                                                                        <button class="btn btn-label-danger btn-sm deleteIndicator float-right"><i
                                                                                                                class="la la-trash-o"></i></button>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    @endif
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
                                            <div class="form-group col-md-12">
                                                <label for="monitoring_and_evaluation">Monitoring & Evaluation <span class="required" aria-required="true"> *</span></label>
                                                <textarea required class="form-control" id="monitoring_and_evaluation" name="project[monitoring_evaluation]"
                                                          rows="6">{{($project->detailed_proposal->monitoring_evaluation ?? null)}}</textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="reporting">Reporting <span class="required" aria-required="true"> *</span></label>
                                                <textarea required class="form-control" id="reporting" name="project[reporting]"
                                                          rows="6">{{($project->detailed_proposal->reporting ?? null)}}</textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="gender_marker">Gender Marker <span class="required" aria-required="true"> *</span></label>
                                                <textarea required class="form-control" id="gender_marker" name="project[gender_marker]"
                                                          rows="6">{{($project->detailed_proposal->gender_marker ?? null)}}</textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="accountability">Accountability <span class="required" aria-required="true"> *</span></label>
                                                <textarea required class="form-control" id="accountability" name="project[accountability]"
                                                          rows="6">{{($project->detailed_proposal->accountability ?? null)}}</textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label class="row  col-md-12" for="plan">plan @lang('common.file') <span class="required" aria-required="true"> *</span></label>
                                                <input id="plan" type="file" name="plan_file">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end: Form Wizard Step 4-->
                            <!--begin: Form Wizard Step 5 -->
                            <div class="kt-wizard-v1__content" data-ktwizard-type="step-content">
                                <div class="kt-form__section kt-form__section--first">
                                    @foreach($budget_categories as $key=>$item)
                                        <div class="row">
                                            <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
                                                <div class="kt-portlet__head">
                                                    <div class="kt-portlet__head-label">
                                                        <h3 class="kt-portlet__head-title">{{$item}}</h3>
                                                    </div>
                                                    <div class="kt-portlet__head-toolbar">
                                                        <div class="kt-portlet__head-group">
                                                            Total: <input style="border: none;padding-left: 3px;;background-color: #fff;" readonly name="total_{{Str::replaceFirst(',','', Str::lower
                                                            (Str::words($item, 1, ''))) }}" id="total_{{Str::replaceFirst(',','',
                                                                          Str::lower(Str::words($item, 1, ''))) }}"
                                                                          class="currency"
                                                                          value="{{($project->detailed_proposal_budget()->where('budget_category_id',$key)->select('budget_category_id')->groupBy
                                                                          ('budget_category_id') ->selectRaw('sum ((unit_cost * chf * quantity * duration)/100) as total ')->first()->total ?? 0)}}">
                                                            Total Budget: <input style="border: none;padding-left: 3px;;background-color: #fff;" name="total_budget" readonly
                                                                                 class="total_budget currency"
                                                                                 value="{{($project->detailed_proposal_budget()->select('project_id')->groupBy('project_id')->selectRaw('sum (
                                                                                 (unit_cost * chf * quantity * duration)/100) as total ') ->first()->total ?? 0)}}">
                                                            <a href="#" data-ktportlet-tool="toggle" class="btn btn-sm btn-icon btn-clean btn-icon-md" aria-describedby="tooltip_nrgbx2wq7w"><i
                                                                    class="la la-angle-down"></i></a>
                                                            <div class="tooltip tooltip-portlet tooltip bs-tooltip-top" role="tooltip" id="tooltip_nrgbx2wq7w" aria-hidden="true" x-placement="top"
                                                                 style="position: absolute; will-change: transform; visibility: hidden; top: 0px; left: 0px; transform: translate3d(440px, -38px, 0px);">
                                                                <div class="tooltip-arrow arrow" style="left: 34px;"></div>
                                                                <div class="tooltip-inner">Collapse</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kt-portlet__body">
                                                    <div class="kt-portlet__content">
                                                        <div class="form-group col-md-12">
                                                            <div class="kt_repeater">
                                                                <div class="form-group  row">
                                                                    <div data-repeater-list="budget[{{Str::replaceFirst(',','',Str::lower(Str::words($item, 1, ''))) }}]" class="col-lg-12">
                                                                        @if($project->detailed_proposal_budget->where('budget_category_id',$key)->count())
                                                                            @foreach($project->detailed_proposal_budget->where('budget_category_id',$key) as $value)
                                                                                <div data-repeater-item class="kt-margin-b-10">
                                                                                    <input hidden name="budget_id" value="{{$value->id}}">
                                                                                    <input hidden name="budget_category_id" value="{{$key}}">
                                                                                    <div class="row  align-items-center">
                                                                                        <div class="form-group col-lg-1">
                                                                                            <label>Budget Line <span class="required" aria-required="true"> *</span></label>
                                                                                            <input type="text" class="form-control budget_line" required name="budget_line" placeholder="Budget Line"
                                                                                                   value="{{$value->budget_line}}">
                                                                                        </div>
                                                                                        <div class="form-group col-lg-2">
                                                                                            <label>Category Option <span class="required" aria-required="true"> *</span></label>
                                                                                            {!! Form::select('category_option_id',  category_options($key),$value->category_option_id,['class' => 'form-control select2-multiple ','required' => 'true']) !!}
                                                                                            <span class="form-text text-muted"></span>
                                                                                        </div>
                                                                                        <div class="form-group col-lg-2">
                                                                                            <label>Unit <span class="required" aria-required="true"> *</span></label>
                                                                                            {!! Form::select('unit_id', $units,$value->unit_id,['class' => 'form-control','required' => 'true']) !!}
                                                                                            <span class="form-text text-muted"></span>

                                                                                        </div>
                                                                                        <div class="form-group col-lg-1">
                                                                                            <label>Duration<span class="required" aria-required="true"> *</span></label>
                                                                                            <input type="text" class="form-control duration" required onkeyup="getTotal(this)" name="duration"
                                                                                                   placeholder="Duration" value="{{$value->duration}}">
                                                                                        </div>
                                                                                        <div class="form-group col-lg-1">
                                                                                            <label>Quantity<span class="required" aria-required="true"> *</span></label>
                                                                                            <input type="text" class="form-control quantity" required onkeyup="getTotal(this)" name="quantity"
                                                                                                   placeholder="Quantity" value="{{$value->quantity}}">
                                                                                        </div>
                                                                                        <div class="form-group col-lg-1">
                                                                                            <label>Unit Cost <span class="required" aria-required="true"> *</span></label>
                                                                                            <input type="text" class="form-control unit_cost" required onkeyup="getTotal(this)" name="unit_cost"
                                                                                                   placeholder="Unit Cost" value="{{$value->unit_cost}}">
                                                                                        </div>
                                                                                        <div class="form-group col-lg-1">
                                                                                            <label>CHF<span class="required" aria-required="true"> *</span></label>
                                                                                            <input type="text" class="form-control chf" required onkeyup="getTotal(this)" name="chf" placeholder="CHF"
                                                                                                   value="{{$value->chf}}">
                                                                                        </div>
                                                                                        <div class="form-group col-lg-1">
                                                                                            <label>Total <span class="required" aria-required="true"> *</span></label>
                                                                                            <input type="text" class="form-control total_one_budget total_personnel" readonly required name="total"
                                                                                                   placeholder="Total"
                                                                                                   value="{{($value->unit_cost * $value->chf * $value->quantity * $value->duration)/100 }}">
                                                                                        </div>

                                                                                        <div class="col-lg-2">
                                                                                            <a href="javascript:;" data-repeater-delete=""
                                                                                               class="btn btn-danger btn-sm btn-icon btn-circle float-right">
                                                                                                <i class="la la-trash-o "></i>
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr>
                                                                                    <div style="background-color: #fcfdff;" class="row">
                                                                                        <div class="form-group col-lg-2">
                                                                                            <label>Donor <span class="required" aria-required="true"> *</span></label>
                                                                                            {!! Form::select('donor_id', $donors,$value->donor_id,['class' => 'form-control select2-multiple ','required' => 'true']) !!}
                                                                                            <span class="form-text text-muted"></span>
                                                                                        </div>
                                                                                        <div class="form-group col-lg-2">
                                                                                            <label>In kind/Monetary <span class="required" aria-required="true"> *</span></label>
                                                                                            {!! Form::select('in_kind', [''=>'monetary','0'=>'In kind'],$value->in_kind,['class' => 'form-control ']) !!}
                                                                                        </div>
                                                                                        <div class="form-group col-lg-2">
                                                                                            <label>D/S<span class="required" aria-required="true"> *</span></label>
                                                                                            {!! Form::select('support', [''=>'Direct','1'=>'Support'],$value->support,['class' => 'form-control']) !!}
                                                                                        </div>
                                                                                        <div class="form-group col-lg-2">
                                                                                            <label>Administrative Cost<span class="required" aria-required="true"> *</span></label>
                                                                                            {!! Form::select('out_of_administrative_cost', [''=>'Include','1'=>'Not Included'],$value->out_of_administrative_cost,['class' => 'form-control  ']) !!}
                                                                                        </div>
                                                                                        <div class="form-group col-lg-4">
                                                                                            <label>description <span class="required" aria-required="true"> *</span></label>
                                                                                            <textarea required class="form-control " required name="description">{{$value->description}}</textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr>
                                                                                    <hr>
                                                                                </div>
                                                                            @endforeach
                                                                        @else
                                                                            <div data-repeater-item class="kt-margin-b-10 empty-div">
                                                                                <div class="row  align-items-center">
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Budget Line <span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control budget_line" required name="budget_line" placeholder="Budget Line"
                                                                                               value="">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-2">
                                                                                        <label>Category Option <span class="required" aria-required="true"> *</span></label>
                                                                                        {!! Form::select('category_option_id',  category_options($key),null,['class' => 'form-control select2-multiple ','required' => 'true']) !!}
                                                                                        <span class="form-text text-muted"></span>
                                                                                    </div>
                                                                                    <div class="form-group col-lg-2">
                                                                                        <label>Unit <span class="required" aria-required="true"> *</span></label>
                                                                                        {!! Form::select('unit_id', $units,null,['class' => 'form-control','required' => 'true']) !!}
                                                                                        <span class="form-text text-muted"></span>

                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Duration<span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control duration" required onkeyup="getTotal(this)" name="duration"
                                                                                               placeholder="Duration" value="">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Quantity<span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control quantity" required onkeyup="getTotal(this)" name="quantity"
                                                                                               placeholder="Quantity" value="">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Unit Cost <span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control unit_cost" required onkeyup="getTotal(this)" name="unit_cost"
                                                                                               placeholder="Unit Cost" value="">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>CHF<span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control chf" required onkeyup="getTotal(this)" name="chf" placeholder="CHF"
                                                                                               value="">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Total <span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control total_one_budget total_personnel" readonly required name="total"
                                                                                               placeholder="Total" value="">
                                                                                    </div>

                                                                                    <div class="col-lg-2">
                                                                                        <a href="javascript:;" data-repeater-delete="" class="btn btn-danger btn-sm btn-icon btn-circle float-right">
                                                                                            <i class="la la-trash-o "></i>
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                                <hr>
                                                                                <div style="background-color: #fcfdff;" class="row">
                                                                                    <div class="form-group col-lg-2">
                                                                                        <label>Donor <span class="required" aria-required="true"> *</span></label>
                                                                                        {!! Form::select('donor_id', $donors,null,['class' => 'form-control select2-multiple ','required' => 'true']) !!}
                                                                                        <span class="form-text text-muted"></span>
                                                                                    </div>
                                                                                    <div class="form-group col-lg-2">
                                                                                        <label>In kind/Monetary <span class="required" aria-required="true"> *</span></label>
                                                                                        {!! Form::select('in_kind', [''=>'monetary','0'=>'In kind'],'',['class' => 'form-control ']) !!}
                                                                                    </div>
                                                                                    <div class="form-group col-lg-2">
                                                                                        <label>D/S<span class="required" aria-required="true"> *</span></label>
                                                                                        {!! Form::select('support', [''=>'Direct','1'=>'Support'],'',['class' => 'form-control']) !!}
                                                                                    </div>
                                                                                    <div class="form-group col-lg-2">
                                                                                        <label>Overhead<span class="required" aria-required="true"> *</span></label>
                                                                                        {!! Form::select('out_of_administrative_cost', [''=>'Include','1'=>'Not Included'],'',['class' => 'form-control  ']) !!}
                                                                                    </div>
                                                                                    <div class="form-group col-lg-4">
                                                                                        <label>description <span class="required" aria-required="true"> *</span></label>
                                                                                        <textarea class="form-control " required name="description"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <hr>
                                                                                <hr>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div data-repeater-create="" class="btn btn btn-primary">
																	<span>
																		<i class="la la-plus"></i>
																		<span>Add</span>
																	</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <!--end: Form Wizard Step 5-->
                            <!--begin: Form Wizard Step 6 -->
                            <div class="kt-wizard-v1__content" data-ktwizard-type="step-content">
                                <div class="kt-form__section kt-form__section--first">
                                    <div class="form-group">
                                        <button type="button" id="generate"
                                                class="btn btn-primary margin-right"><i
                                                class="fa fa-check"></i>generate
                                        </button>
                                    </div>
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <th>Outcome</th>
                                        <th>Output</th>
                                        <th>Activity</th>
                                        <th style="width: 20%;">Description</th>
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
                                        <tbody id="work_plan" style="font-size: 11px;">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--end: Form Wizard Step 6-->
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
                                {{--                                <button type="button" style="margin-left: 8px;" onclick="save_continue()"--}}
                                {{--                                        class="btn btn-brand btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"> save & continue--}}
                                {{--                                </button>--}}
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
    <div class="modal fade" id="add" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Responsibility</h5>
                </div>
                <div class="modal-body">
                    <div class="kt-portlet__body">
                        <div class="row">
                            <input type="hidden" id="employee_responsibility" value="">
                            <div class="form-group col-lg-4">
                                <label>@lang('common.mission') </label>
                                {!! Form::select('mission_id', $missions,null,['class' => 'form-control kt_select2_modal ','id'=>'mission']) !!}
                                <span class="form-text text-muted"></span>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>@lang('hr.department') </label>
                                {!! Form::select('department_id', [''=>trans('common.please_select')],null,['class' => 'form-control kt_select2_modal ','id'=>'department']) !!}
                                <span class="form-text text-muted"></span>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>@lang('hr.employee') <span class="required" aria-required="true"> *</span></label>
                                {!! Form::select('employee',  [''=>trans('common.please_select')] ,'',['class' => 'form-control ','id'=>'employee']) !!}
                                <span class="form-text text-muted"></span>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" onclick="save()" data-ktwizard-type="action-submit">
                                @lang('common.save')
                            </div>
                            <div class="btn btn-danger  btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-dismiss="modal">@lang('common.cancel')</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add_organisation_unit" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Organisation unit</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="num" value="">
                    <input type="hidden" id="organisation_unit_name" value="">
                    <input type="hidden" id="organisation_unit_id" value="">

                    <div id="kt_tree_6" class="tree-demo">
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" onclick="save_organisation_unit()" data-dismiss="modal">
                                @lang('common.ok')
                            </div>
                            <div class="btn btn-danger  btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-dismiss="modal">@lang('common.cancel')</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script>
        $("#generate").click(function () {
            $('#work_plan').html('');
            let output_cost = 0;
            let total_cost = 0;
            let outcome_cost = 0;
            let output_day = 0;
            let total_day = 0;
            let outcome_day = 0;
            let total_indirect = 0;
            let total_direct = 0;
            $('.total_one_budget').each(function () {
                let select = $(this).parent().parent().parent().children('div').eq(1).children('div').children('select').eq(2).find('option:selected');
                if (select.val() == 1) {
                    total_indirect += Number(parseFloat($(this).val()));
                } else {
                    total_direct += Number(parseFloat($(this).val()));
                }
            });
            $('.total_indirect').val(total_indirect);
            $('.total_direct').val(total_direct);
            for (let x = 0; x < $('#outcomes .outcome').length; x++) {
                for (let x1 = 0; x1 < $('#outcomes .outcome:eq(' + x + ') .output ').length; x1++) {
                    output_day = 0;
                    for (let x2 = 0; x2 < $('#outcomes .outcome:eq(' + x + ')  .output:eq(' + x1 + ') .activity').length; x2++) {
                        let cost_1 = $('#outcomes .outcome:eq(' + x + ') .output:eq(' + x1 + ') .activity:eq(' + x2 + ') .cost input').val();

                        let start_date_1 = $('#outcomes .outcome:eq(' + x + ') .output:eq(' + x1 + ') .activity:eq(' + x2 + ') .start_date input').val();
                        let end_date_1 = $('#outcomes .outcome:eq(' + x + ') .output:eq(' + x1 + ') .activity:eq(' + x2 + ') .end_date input').val();
                        const date1 = new Date(start_date_1);
                        const date2 = new Date(end_date_1);
                        const diffTime = Math.abs(date2.getTime() - date1.getTime());
                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                        total_cost += Number(parseFloat(cost_1));
                        total_day += Number(parseFloat(diffDays));
                    }

                }
            }
            $('.total_cost').val(total_cost);
            $('.total_day').val(total_day);
            for (let x = 0; x < $('#outcomes .outcome').length; x++) {
                outcome_cost = 0;
                outcome_day = 0;
                output_cost = 0;
                output_day = 0;
                for (let x1 = 0; x1 < $('#outcomes .outcome:eq(' + x + ') .output').length; x1++) {
                    for (let x2 = 0; x2 < $('#outcomes .outcome:eq(' + x + ')  .output:eq(' + x1 + ') .activity').length; x2++) {
                        let cost_1 = $('#outcomes .outcome:eq(' + x + ') .output:eq(' + x1 + ') .activity:eq(' + x2 + ') .cost input').val();
                        let start_date_1 = $('#outcomes .outcome:eq(' + x + ') .output:eq(' + x1 + ') .activity:eq(' + x2 + ') .start_date input').val();
                        let end_date_1 = $('#outcomes .outcome:eq(' + x + ') .output:eq(' + x1 + ') .activity:eq(' + x2 + ') .end_date input').val();
                        const date1 = new Date(start_date_1);
                        const date2 = new Date(end_date_1);
                        const diffTime = Math.abs(date2.getTime() - date1.getTime());
                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                        output_cost += Number(parseFloat(cost_1));
                        // total_cost += Number(parseFloat(cost_1));
                        output_day += Number(parseFloat(diffDays));
                    }

                }
                outcome_cost += Number(parseFloat(output_cost));
                outcome_day += Number(parseFloat(output_day));

                let outcome_title = $('#outcomes .outcome:eq(' + x + ')').attr('id');
                let outcome_description = $('#outcomes .outcome textarea:eq(' + x + ')').val();
                outcome_work_plan(outcome_title, outcome_description, outcome_cost, outcome_day, total_day, total_cost, total_indirect);
                for (let x1 = 0; x1 < $('#outcomes .outcome:eq(' + x + ') .output ').length; x1++) {
                    let output_title = $('#outcomes .outcome:eq(' + x + ') .output:eq(' + x1 + ')').attr('id');
                    let output_description = $('#outcomes .outcome:eq(' + x + ') .output:eq(' + x1 + ') textarea').val();
                    for (let x1 = 0; x1 < $('#outcomes .outcome:eq(' + x + ') .output ').length; x1++) {
                        output_cost = 0;
                        output_day = 0;
                        for (let x2 = 0; x2 < $('#outcomes .outcome:eq(' + x + ')  .output:eq(' + x1 + ') .activity').length; x2++) {
                            let cost_1 = $('#outcomes .outcome:eq(' + x + ') .output:eq(' + x1 + ') .activity:eq(' + x2 + ') .cost input').val();
                            let start_date_1 = $('#outcomes .outcome:eq(' + x + ') .output:eq(' + x1 + ') .activity:eq(' + x2 + ') .start_date input').val();
                            let end_date_1 = $('#outcomes .outcome:eq(' + x + ') .output:eq(' + x1 + ') .activity:eq(' + x2 + ') .end_date input').val();
                            const date1 = new Date(start_date_1);
                            const date2 = new Date(end_date_1);
                            const diffTime = Math.abs(date2.getTime() - date1.getTime());
                            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                            output_cost += Number(parseFloat(cost_1));
                            output_day += Number(parseFloat(diffDays));
                            // total_day += Number(parseFloat(diffDays));
                        }

                    }
                    output_work_plan(output_title, output_description, output_cost, output_day, total_day, total_cost, total_indirect);
                    for (let x2 = 0; x2 < $('#outcomes .outcome:eq(' + x + ')  .output:eq(' + x1 + ') .activity').length; x2++) {
                        let activity_title = $('#outcomes .outcome:eq(' + x + ') .output:eq(' + x1 + ')  .activity:eq(' + x2 + ')').attr('id');
                        let activity_description = $('#outcomes .outcome:eq(' + x + ') .output:eq(' + x1 + ') .activity:eq(' + x2 + ') textarea').val();
                        let activity_responsibility = $('#outcomes .outcome:eq(' + x + ') .output:eq(' + x1 + ') .activity:eq(' + x2 + ') .responsibility select').find('option:selected').text();
                        let activity_activity_phase = $('#outcomes .outcome:eq(' + x + ') .output:eq(' + x1 + ') .activity:eq(' + x2 + ') .activity_phase select').find('option:selected').text();
                        let activity_cost = $('#outcomes .outcome:eq(' + x + ') .output:eq(' + x1 + ') .activity:eq(' + x2 + ') .cost input').val();
                        let activity_start_date = $('#outcomes .outcome:eq(' + x + ') .output:eq(' + x1 + ') .activity:eq(' + x2 + ') .start_date input').val();
                        let activity_end_date = $('#outcomes .outcome:eq(' + x + ') .output:eq(' + x1 + ') .activity:eq(' + x2 + ') .end_date input').val();
                        const date1 = new Date(activity_start_date);
                        const date2 = new Date(activity_end_date);
                        const diffTime = Math.abs(date2.getTime() - date1.getTime());
                        const activity_day = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                        activity_work_plan(activity_title, activity_description, activity_responsibility, activity_activity_phase, activity_cost, activity_start_date, activity_end_date, activity_day, total_day, total_cost, total_indirect)
                    }
                }
            }
            $(".money_2").inputmask({
                "alias": "decimal",
                "digits": 2,
                "suffix": " $",
                "autoGroup": true,
                "allowMinus": true,
                "rightAlign": false,
                "groupSeparator": ",",
                "radixPoint": ".",
                autoUnmask: true,
            });
        });

        //
        function activity_work_plan(activity_title, activity_description, activity_responsibility, activity_activity_phase, activity_cost, activity_start_date, activity_end_date, diffDays, days, total_cost, total_indirect) {
            $('#work_plan').append(`<tr> <td></td>
                                        <td> </td>
                                        <td>${activity_title}</td>
                                        <td>${activity_description}</td>
                                        <td>${activity_activity_phase}</td>
                                        <td>${activity_responsibility}</td>
                                        <td>${activity_start_date}</td>
                                        <td>${activity_end_date}</td>
                                        <td> ${Math.ceil(Number(diffDays) / Number(30))}</td>
                                        <td><span class="money_2">${activity_cost} </span></td>
                                        <td> ${Number((diffDays / days) * 100).toFixed(2)} %</td>
                                        <td>${diffDays}</td>
                                        <td>${parseFloat((activity_cost / total_cost) * 100).toFixed(2)} %</td>
                                        <td>${((Number(parseFloat((activity_cost / total_cost) * 100).toFixed(2)) + Number(parseFloat((diffDays / days) * 100).toFixed(2))) / 2).toFixed(2)} %</td>
                                        <td><span class="money_2">${(((Number(parseFloat((activity_cost / total_cost) * 100)) + Number(parseFloat((diffDays / days) * 100).toFixed(2))) / Number(2)) * total_indirect) / Number(100)} </span></td>
</tr>`);

        }

        function output_work_plan(output_title, output_description, output_cost, diffDays, days, total_cost, total_indirect) {
            $('#work_plan').append(`<tr> <td></td>
                                        <td>${output_title} </td>
                                        <td></td>
                                        <td>${output_description}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>${Math.round(Number(diffDays) / Number(30))}</td>
                                        <td><span class="money_2">${output_cost}</span></td>
                                        <td>${parseFloat((diffDays / days) * 100).toFixed(2)} %</td>
                                        <td>${diffDays}</td>
                                        <td>${parseFloat((output_cost / total_cost) * 100).toFixed(2)} %</td>
                                        <td>${((Number(parseFloat((output_cost / total_cost) * 100).toFixed(2)) + Number(parseFloat((diffDays / days) * 100).toFixed(2))) / 2).toFixed(2)} %</td>
                                        <td><span class="money_2">${(((Number(parseFloat((output_cost / total_cost) * 100).toFixed(2)) + Number(parseFloat((diffDays / days) * 100).toFixed(2))) / Number(2)) * total_indirect) / Number(100)} </span></td>
</tr>`);

        }

        function outcome_work_plan(outcome_title, outcome_description, outcome_cost, diffDays, days, total_cost, total_indirect) {
            $('#work_plan').append(`<tr> <td>${outcome_title}</td>
                                        <td> </td>
                                        <td></td>
                                        <td>${outcome_description}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>${Math.round(Number(diffDays) / Number(30))}</td>
                                        <td><span class="money_2">${outcome_cost}</span></td>
                                        <td>${parseFloat((diffDays / days) * 100).toFixed(2)} %</td>
                                        <td>${diffDays}</td>
                                        <td>${parseFloat((outcome_cost / total_cost) * 100).toFixed(2)} %</td>
                                        <td>${((Number(parseFloat((outcome_cost / total_cost) * 100).toFixed(2)) + Number(parseFloat((diffDays / days) * 100).toFixed(2))) / 2).toFixed(2)} % </td>
                                        <td><span class="money_2">${(((Number(parseFloat((outcome_cost / total_cost) * 100).toFixed(2)) + Number(parseFloat((diffDays / days) * 100).toFixed(2))) / Number(2)) * total_indirect) / Number(100)}  </span></td>
</tr>`);

        }

        function save() {
            let class_name = $('#employee_responsibility').val();
            let select = $("#employee option:selected");
            $(`#${class_name}`).children('div').children('.responsibility').children('select').html('');
            $(`#${class_name}`).children('div').children('.responsibility').children('input').val(select.text());
            $(`#${class_name}`).children('div').children('.responsibility').children('select').append($('<option></option>').attr('value', select.val()).text(select.text()));
            $('#add').modal('hide');
            $('#employee_responsibility').val(null);
        }

        function save_organisation_unit() {
            let num = $('#num').val();
            let name = $('#organisation_unit_name').val();
            let id = $('#organisation_unit_id').val();
            let my_select = $(`select[name="beneficiary[${num}][organisation_unit]"]`);
            let option_name = $(`input[name="beneficiary[${num}][option_name]"]`);
            my_select.html('');
            my_select.append($('<option></option>').attr('value', id).text(name));
            // $('#add').modal('hide');
            option_name.val(name);
        }

        nested('mission', 'department', "{{$nested_url_department}}");
        nested('department', 'employee', "{{$nested_url_superior}}");
        $(document).on('click', '.get_organisation_unit', function () {
            let name = $(this).parent('div').children('select').attr('name');
            let name_str = name.split("]");
            let category = name_str[0].split("[");
            let num = category[1];
            $('#num').val(num);
            $('#add_organisation_unit').modal('show');
        });
        @foreach($budget_categories as $key=>$item)
        total_one_budget('total_{{Str::replaceFirst(',','',Str::lower(Str::words($item, 1, '')))}}');

        @endforeach
        function total_one_budget(name) {
            $(document).on('change', `.${name}`, function () {
                // console.log( $( this ));
                setTimeout(function () {
                    let total = 0;
                    let total_budget = 0;
                    $(`.${name}`).each(function () {
                        total += Number(parseFloat($(this).val().replace(/,/g, '')));
                    });
                    $(`.total_one_budget`).each(function () {
                        total_budget += Number(parseFloat($(this).val().replace(/,/g, '')));
                    });
                    $(`.total_budget`).val(total_budget);
                    $(`#${name}`).val(total);
                    $(".currency").inputmask({
                        "alias": "decimal",
                        "digits": 2,
                        "suffix": " $",
                        "autoGroup": true,
                        "allowMinus": true,
                        "rightAlign": false,
                        autoUnmask: true,
                        "groupSeparator": ",",
                        "radixPoint": ".",

                    });
                }, 500);
            });

        }

        function getTotalBeneficiaries(e) {
            let name = e.getAttribute("name");
            let name_str = name.split("]");
            let category = name_str[0].split("[");
            let categoryName = category[0];
            let num = category[1];
            let men = document.getElementsByName('' + categoryName + '[' + num + '][men]')[0].value;
            let women = document.getElementsByName('' + categoryName + '[' + num + '][women]')[0].value;
            let boys = document.getElementsByName('' + categoryName + '[' + num + '][boys]')[0].value;
            let girls = document.getElementsByName('' + categoryName + '[' + num + '][girls]')[0].value;
            let total;
            total = (Number(men) + Number(women) + Number(boys) + Number(girls));
            document.getElementsByName('' + categoryName + '[' + num + '][total]')[0].value = total;
        }

        function getTotal(e) {
            let name = e.getAttribute("name");
            let name_str = name.split("]");
            let category = name_str[0].split("[");
            let categoryName = category[1];
            let num = name_str[1];
            let cost = document.getElementsByName('budget[' + categoryName + ']' + num + '][unit_cost]')[0].value;
            let duration = document.getElementsByName('budget[' + categoryName + ']' + num + '][duration]')[0].value;
            let chf = document.getElementsByName('budget[' + categoryName + ']' + num + '][chf]')[0].value;
            let quantity = document.getElementsByName('budget[' + categoryName + ']' + num + '][quantity]')[0].value;
            let total;
            if (duration == '') {
                duration = 0;
            }
            if (quantity == '') {
                quantity = 0;
            }
            if (cost == '') {
                cost = '0';
            }
            if (chf == '') {
                chf = 0;
            } else if (chf > 100) {
                chf = 100;
            }
            total = (Number(duration) * Number(parseFloat(chf)) * Number(parseFloat(cost.replace(/,/g, ''))) * Number(quantity)) / 100;
            if (total > 0) {
                document.getElementsByName('budget[' + categoryName + ']' + num + '][total]')[0].value = total;
                let el = document.getElementsByName('budget[' + categoryName + ']' + num + '][total]')[0];
                let ev = document.createEvent('Event');
                ev.initEvent('change', true, false);
                el.dispatchEvent(ev);
            }
        }
    </script>
    @include('layouts.include.script.script_jquery_form')
    {!! Html::script('assets/app/custom/wizard/wizard-project-v1.js') !!}
    {!! Html::script('js/logical-framework.js') !!}
    <script>
        $(document).ready(function () {
            $('.empty-div').html('');
            $('.date-picker').datepicker({});

            $(".unit_cost").inputmask({
                "alias": "decimal",
                "digits": 4,
                "suffix": " $",
                "autoGroup": true,
                "allowMinus": true,
                "rightAlign": false,
                autoUnmask: true,
                "groupSeparator": ",",
                "radixPoint": ".",

            });
            $(".total_one_budget").inputmask({
                "alias": "decimal",
                "digits": 2,
                "suffix": " $",
                "autoGroup": true,
                "allowMinus": true,
                "rightAlign": false,
                autoUnmask: true,
                "groupSeparator": ",",
                "radixPoint": ".",
            });
            $(".chf").inputmask({
                "rightAlign": false,
                'alias': 'numeric',
                "min": 1,
                "max": 100,
                "suffix": " %",
                autoUnmask: true,
            });
            $(".quantity").inputmask({
                'alias': 'numeric',
                "rightAlign": false,
                autoUnmask: true,
            });
            $(".duration").inputmask({
                'alias': 'numeric',
                "rightAlign": false,
                autoUnmask: true,

            });
            $(".budget_line").inputmask({
                'alias': 'numeric',
                "rightAlign": false,
                autoUnmask: true,

            });
            $('.select2-multiple').select2();

        });

    </script>
@stop
