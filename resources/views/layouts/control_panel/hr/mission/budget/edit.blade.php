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
                                <a class="kt-wizard-v1__nav-item" href="javascript:;" data-ktwizard-type="step">
                                    <div class="kt-wizard-v1__nav-body">
                                        <div class="kt-wizard-v1__nav-icon">
                                            <i class="flaticon-background"></i>
                                        </div>
                                        <div class="kt-wizard-v1__nav-label">
                                            @lang('common.mission') @lang('common.budget')  @lang('common.details')
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
                        <form method="POST" action="{{route('mission.update_budget')}} " class="kt-form" id="kt_form">
                            @csrf
                            @method('PUT')
                            <input name="mission_budget[id]" type="hidden" value="{{$mission_budget->id}}">
                            <input name="mission_budget[mission_id]" type="hidden" value="{{$mission_id}}">
                            <!--begin: Form Wizard Step 1-->
                            <div class="kt-wizard-v1__content" data-ktwizard-type="step-content">
                                <div class="kt-form__section kt-form__section--first">
                                    <div class="kt-wizard-v1__form">
                                        <div class="row">
                                            <div class="form-group col-lg-6">
                                                <label>@lang('common.mission') @lang('common.budget') @lang('common.name') EN<span
                                                        class="required" aria-required="true"> *</span></label>
                                                <input type="text" class="form-control kt_maxlength_3" maxlength="100"
                                                       name="mission_budget[name_en]"
                                                       placeholder="@lang('common.mission') @lang('common.budget') @lang('common.name') EN"
                                                       value="{{$mission_budget->name_en}}">
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label>@lang('common.mission') @lang('common.budget') @lang('common.name') AR</label>
                                                <input type="text" class="form-control kt_maxlength_3" maxlength="100"
                                                       name="mission_budget[name_ar]"
                                                       placeholder="@lang('common.mission') @lang('common.budget') @lang('common.name') AR"
                                                       value="{{$mission_budget->name_ar}}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-3">
                                                <label>@lang('common.start') @lang('common.date') <span class="required"
                                                                                                        aria-required="true"> *</span></label>
                                                <input type="text" class="form-control kt_datepicker_1_validate"
                                                       name="mission_budget[start_date]" autocomplete="off" id="start_date"
                                                       value="{{$mission_budget->start_date}}"
                                                       placeholder="@lang('common.start') @lang('common.date')">
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>@lang('common.end') @lang('common.date') <span class="required"
                                                                                                      aria-required="true"> *</span></label>
                                                <input type="text" class="form-control kt_datepicker_1_validate"
                                                       name="mission_budget[end_date]" id="end_date"
                                                       value="{{$mission_budget->end_date}}"
                                                       autocomplete="off"
                                                       placeholder="@lang('common.end') @lang('common.date')">
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>@lang('common.duration') </label>
                                                <input type="text" class="form-control kt_datepicker_1_validate"
                                                       id="duration" readonly disabled
                                                       value="{{get_duration ($mission_budget->start_date,$mission_budget->end_date)}}"
                                                       placeholder="@lang('common.duration')">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end: Form Wizard Step 1-->
                            <!--begin: Form Wizard Step 2 -->
                            <div class="kt-wizard-v1__content" data-ktwizard-type="step-content">
                                <div class="kt-form__section kt-form__section--first">
                                    <div class="row">
                                        <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_2">
                                            <div class="kt-portlet__head">
                                                <div class="kt-portlet__head-label">
                                                    <h3 class="kt-portlet__head-title">
                                                        Personnel & Fringe Benefits
                                                    </h3>
                                                </div>
                                                <div class="kt-portlet__head-toolbar">
                                                    Total: <input style="border: none;padding-left: 3px;;background-color: #fff;" readonly name="total_personnel" id="total_personnel" class="currency" value="{{($mission_budget->detailed_proposal_budget()->where('budget_category_id',374766)->select('budget_category_id')->groupBy('budget_category_id')->selectRaw('sum ((unit_cost * chf * quantity * duration)/100) as total ')->first()->total ?? 0)}}">
                                                    Total Budget: <input style="border: none;padding-left: 3px;;background-color: #fff;" readonly class="total_budget currency"  value="{{($mission_budget->detailed_proposal_budget()->select('mission_budget_lines.mission_budget_id')->groupBy('mission_budget_lines.mission_budget_id')->selectRaw('sum ((unit_cost * chf * quantity * duration)/100) as total ')->first()->total ?? 0)}}">
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
                                                    <div class="form-group col-md-12">
                                                        <div class="kt_repeater">
                                                            <div class="form-group  row">
                                                                <div data-repeater-list="personnel" class="col-lg-12">
                                                                    @if($mission_budget->detailed_proposal_budget->where('budget_category_id',374766)->count())
                                                                        @foreach($mission_budget->detailed_proposal_budget->where('budget_category_id',374766) as $key=>$value)
                                                                            <div data-repeater-item class="kt-margin-b-10">
                                                                                <input type="hidden"  name="budget_id" value="{{$value->id}}">

                                                                                <div class="row  align-items-center">
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Budget Line <span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control budget_line" required name="budget_line" placeholder="Budget Line" value="{{$value->budget_line}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-2">
                                                                                        <label>Category Option <span class="required" aria-required="true"> *</span></label>
                                                                                        {!! Form::select('category_option_id', $category_options,$value->category_option_id,['class' => 'form-control select2-multiple ','required' => 'true']) !!}
                                                                                        <span class="form-text text-muted"></span>
                                                                                    </div>
                                                                                    <div class="form-group col-lg-2">
                                                                                        <label>Unit <span class="required" aria-required="true"> *</span></label>
                                                                                        {!! Form::select('unit_id', $units,$value->unit_id,['class' => 'form-control select2-multiple','required' => 'true']) !!}
                                                                                        <span class="form-text text-muted"></span>

                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Duration<span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control duration" required onkeyup="getTotal(this)" name="duration" placeholder="Duration" value="{{$value->duration}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Quantity<span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control quantity" required onkeyup="getTotal(this)" name="quantity" placeholder="Quantity" value="{{$value->quantity}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Unit Cost <span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control unit_cost" required onkeyup="getTotal(this)" name="unit_cost" placeholder="Unit Cost" value="{{$value->unit_cost}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>CHF<span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="numeric" class="form-control chf" required onkeyup="getTotal(this)" name="chf" placeholder="CHF" value="{{$value->chf}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Total <span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control total_one_budget total_personnel" readonly required name="total" placeholder="Total" value="{{($value->unit_cost * $value->chf * $value->quantity * $value->duration)/100 }}">
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
                                                                                    <input type="text" class="form-control budget_line" required name="budget_line" placeholder="Budget Line" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-2">
                                                                                    <label>Category Option <span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('category_option_id', $category_options,null,['class' => 'form-control select2-multiple ','required' => 'true']) !!}
                                                                                    <span class="form-text text-muted"></span>
                                                                                </div>
                                                                                <div class="form-group col-lg-2">
                                                                                    <label>Unit <span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('unit_id', $units,null,['class' => 'form-control select2-multiple','required' => 'true']) !!}
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>Duration<span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="text" class="form-control duration" required onkeyup="getTotal(this)" name="duration" placeholder="Duration" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>Quantity<span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="text" class="form-control quantity" required onkeyup="getTotal(this)" name="quantity" placeholder="Quantity" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>Unit Cost <span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="text" class="form-control unit_cost" required onkeyup="getTotal(this)" name="unit_cost" placeholder="Unit Cost" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>CHF<span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="numeric" class="form-control chf" required onkeyup="getTotal(this)" name="chf" placeholder="CHF" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>Total <span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="text" class="form-control total_one_budget total_personnel" readonly required name="total" placeholder="Total" value="">
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
                                                                                    <textarea required class="form-control " required name="description"></textarea>
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
																		<i class="la la-plus fa-2x"></i>
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
                                    <div class="row">
                                        <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
                                            <div class="kt-portlet__head">
                                                <div class="kt-portlet__head-label">
                                                    <h3 class="kt-portlet__head-title">
                                                        Supplies, Commodities, Materials
                                                    </h3>
                                                </div>
                                                <div class="kt-portlet__head-toolbar">
                                                    <div class="kt-portlet__head-group">
                                                        Total: <input style="border: none;padding-left: 3px;;background-color: #fff;" readonly name="total_supplies" id="total_supplies" class="currency" value="{{($mission_budget->detailed_proposal_budget()->where('budget_category_id',374767)->select('budget_category_id')->groupBy('budget_category_id')->selectRaw('sum ((unit_cost * chf * quantity * duration)/100) as total ')->first()->total ?? 0)}}">
                                                        {{--                                                        Total Budget: <input style="border: none;padding-left: 3px;;background-color: #fff;" readonly class="total_budget currency" value="{{($data_value->total_budget ?? null)}}">--}}
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
                                                    <div class="form-group col-md-12">
                                                        <div class="kt_repeater">
                                                            <div class="form-group  row">
                                                                <div data-repeater-list="supplies" class="col-lg-12">
                                                                    @if($mission_budget->detailed_proposal_budget->where('budget_category_id',374767)->count())
                                                                        @foreach($mission_budget->detailed_proposal_budget->where('budget_category_id',374767) as $key=>$value)
                                                                            <div data-repeater-item class="kt-margin-b-10">
                                                                                <input type="hidden"  name="budget_id" value="{{$value->id}}">

                                                                                <div class="row  align-items-center">
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Budget Line <span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control budget_line" required name="budget_line" placeholder="Budget Line" value="{{$value->budget_line}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-2">
                                                                                        <label>Category Option <span class="required" aria-required="true"> *</span></label>
                                                                                        {!! Form::select('category_option_id', $category_options,$value->category_option_id,['class' => 'form-control select2-multiple ','required' => 'true']) !!}
                                                                                        <span class="form-text text-muted"></span>
                                                                                    </div>
                                                                                    <div class="form-group col-lg-2">
                                                                                        <label>Unit <span class="required" aria-required="true"> *</span></label>
                                                                                        {!! Form::select('unit_id', $units,$value->unit_id,['class' => 'form-control select2-multiple','required' => 'true']) !!}
                                                                                        <span class="form-text text-muted"></span>
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Duration<span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control duration" required onkeyup="getTotal(this)" name="duration" placeholder="Duration" value="{{$value->duration}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Quantity<span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control quantity" required onkeyup="getTotal(this)" name="quantity" placeholder="Quantity" value="{{$value->quantity}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Unit Cost <span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control unit_cost" required onkeyup="getTotal(this)" name="unit_cost" placeholder="Unit Cost" value="{{$value->unit_cost}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>CHF<span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="numeric" class="form-control chf" required onkeyup="getTotal(this)" name="chf" placeholder="CHF" value="{{$value->chf}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Total <span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control total_one_budget total_supplies" readonly required name="total" placeholder="Total" value="{{($value->unit_cost * $value->chf * $value->quantity * $value->duration)/100 }}">
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
                                                                                    <input type="text" class="form-control budget_line" required name="budget_line" placeholder="Budget Line" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-2">
                                                                                    <label>Category Option <span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('category_option_id', $category_options,null,['class' => 'form-control select2-multiple ','required' => 'true']) !!}
                                                                                    <span class="form-text text-muted"></span>
                                                                                </div>
                                                                                <div class="form-group col-lg-2">
                                                                                    <label>Unit <span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('unit_id', $units,null,['class' => 'form-control select2-multiple','required' => 'true']) !!}
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>Duration<span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="text" class="form-control duration" required onkeyup="getTotal(this)" name="duration" placeholder="Duration" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>Quantity<span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="text" class="form-control quantity" required onkeyup="getTotal(this)" name="quantity" placeholder="Quantity" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>Unit Cost <span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="text" class="form-control unit_cost" required onkeyup="getTotal(this)" name="unit_cost" placeholder="Unit Cost" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>CHF<span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="numeric" class="form-control chf" required onkeyup="getTotal(this)" name="chf" placeholder="CHF" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>Total <span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="text" class="form-control total_one_budget total_supplies" readonly required name="total" placeholder="Total" value="">
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
                                                                                    <textarea required class="form-control " required name="description"></textarea>
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
                                    <div class="row">
                                        <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
                                            <div class="kt-portlet__head">
                                                <div class="kt-portlet__head-label">
                                                    <h3 class="kt-portlet__head-title">
                                                        Equipment
                                                    </h3>

                                                </div>
                                                <div class="kt-portlet__head-toolbar">
                                                    <div class="kt-portlet__head-group">
                                                        Total: <input style="border: none;padding-left: 3px;;background-color: #fff;" readonly name="total_equipment" id="total_equipment" class="currency" value="{{($data_value->total_equipment ?? null)}}">
                                                        {{--                                                        Total Budget: <input style="border: none;padding-left: 3px;;background-color: #fff;" readonly class="total_budget currency" value="{{($data_value->total_budget ?? null)}}">--}}
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
                                                    <div class="form-group col-md-12">
                                                        <div class="kt_repeater">
                                                            <div class="form-group  row">
                                                                <div data-repeater-list="equipment" class="col-lg-12">
                                                                    @if($mission_budget->detailed_proposal_budget->where('budget_category_id',374768)->count())
                                                                        @foreach($mission_budget->detailed_proposal_budget->where('budget_category_id',374768) as $key=>$value)
                                                                            <div data-repeater-item class="kt-margin-b-10">
                                                                                <input type="hidden"  name="budget_id" value="{{$value->id}}">

                                                                                <div class="row  align-items-center">
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Budget Line <span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control budget_line" required name="budget_line" placeholder="Budget Line" value="{{$value->budget_line}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-2">
                                                                                        <label>Category Option <span class="required" aria-required="true"> *</span></label>
                                                                                        {!! Form::select('category_option_id', $category_options,$value->category_option_id,['class' => 'form-control select2-multiple ','required' => 'true']) !!}
                                                                                        <span class="form-text text-muted"></span>
                                                                                    </div>
                                                                                    <div class="form-group col-lg-2">
                                                                                        <label>Unit <span class="required" aria-required="true"> *</span></label>
                                                                                        {!! Form::select('unit_id', $units,$value->unit_id,['class' => 'form-control select2-multiple','required' => 'true']) !!}
                                                                                        <span class="form-text text-muted"></span>
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Duration<span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control duration" required onkeyup="getTotal(this)" name="duration" placeholder="Duration" value="{{$value->duration}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Quantity<span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control quantity" required onkeyup="getTotal(this)" name="quantity" placeholder="Quantity" value="{{$value->quantity}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Unit Cost <span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control unit_cost" required onkeyup="getTotal(this)" name="unit_cost" placeholder="Unit Cost" value="{{$value->unit_cost}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>CHF<span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="numeric" class="form-control chf" required onkeyup="getTotal(this)" name="chf" placeholder="CHF" value="{{$value->chf}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Total <span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control total_one_budget total_equipment" readonly required name="total" placeholder="Total" value="{{($value->unit_cost * $value->chf * $value->quantity * $value->duration)/100 }}">
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
                                                                                    <input type="text" class="form-control budget_line" required name="budget_line" placeholder="Budget Line" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-2">
                                                                                    <label>Category Option <span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('category_option_id', $category_options,null,['class' => 'form-control select2-multiple ','required' => 'true']) !!}
                                                                                    <span class="form-text text-muted"></span>
                                                                                </div>
                                                                                <div class="form-group col-lg-2">
                                                                                    <label>Unit <span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('unit_id', $units,null,['class' => 'form-control select2-multiple','required' => 'true']) !!}
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>Duration<span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="text" class="form-control duration" required onkeyup="getTotal(this)" name="duration" placeholder="Duration" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>Quantity<span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="text" class="form-control quantity" required onkeyup="getTotal(this)" name="quantity" placeholder="Quantity" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>Unit Cost <span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="text" class="form-control unit_cost" required onkeyup="getTotal(this)" name="unit_cost" placeholder="Unit Cost" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>CHF<span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="numeric" class="form-control chf" required onkeyup="getTotal(this)" name="chf" placeholder="CHF" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>Total <span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="text" class="form-control total_one_budget total_equipment" readonly required name="total" placeholder="Total" value="">
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
                                                                                    <label>In kind/Monetary <span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('in_kind', [''=>'monetary','0'=>'In kind'],'',['class' => 'form-control ']) !!}
                                                                                </div>
                                                                                <div class="form-group col-lg-2">
                                                                                    <label>D/S<span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('support', [''=>'Direct','1'=>'Support'],'',['class' => 'form-control']) !!}
                                                                                </div>
                                                                                <div class="form-group col-lg-2">
                                                                                    <label>Administrative Cost<span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('out_of_administrative_cost', [''=>'Include','1'=>'Not Included'],'',['class' => 'form-control  ']) !!}
                                                                                </div>
                                                                                <div class="form-group col-lg-4">
                                                                                    <label>description <span class="required" aria-required="true"> *</span></label>
                                                                                    <textarea required class="form-control " required name="description"></textarea>
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
                                    <div class="row">
                                        <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
                                            <div class="kt-portlet__head">
                                                <div class="kt-portlet__head-label">
                                                    <h3 class="kt-portlet__head-title">Contractual
                                                    </h3>

                                                </div>
                                                <div class="kt-portlet__head-toolbar">
                                                    <div class="kt-portlet__head-group">
                                                        Total: <input style="border: none;padding-left: 3px;;background-color: #fff;" readonly id="total_contractual" class="currency" value="{{($mission_budget->detailed_proposal_budget()->where('budget_category_id',374769)->select('budget_category_id')->groupBy('budget_category_id')->selectRaw('sum ((unit_cost * chf * quantity * duration)/100) as total ')->first()->total ?? 0)}}">
                                                        {{--                                                        Total Budget: <input style="border: none;padding-left: 3px;;background-color: #fff;" readonly class="total_budget currency" value="{{($data_value->total_budget ?? null)}}">--}}
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
                                                    <div class="form-group col-md-12">
                                                        <div class="kt_repeater">
                                                            <div class="form-group  row">
                                                                <div data-repeater-list="contractual" class="col-lg-12">
                                                                    @if($mission_budget->detailed_proposal_budget->where('budget_category_id',374769)->count())
                                                                        @foreach($mission_budget->detailed_proposal_budget->where('budget_category_id',374769) as $key=>$value)
                                                                            <div data-repeater-item class="kt-margin-b-10">
                                                                                <input type="hidden"  name="budget_id" value="{{$value->id}}">

                                                                                <div class="row  align-items-center">
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Budget Line <span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control budget_line" required name="budget_line" placeholder="Budget Line" value="{{$value->budget_line}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-2">
                                                                                        <label>Category Option <span class="required" aria-required="true"> *</span></label>
                                                                                        {!! Form::select('category_option_id', $category_options,$value->category_option_id,['class' => 'form-control select2-multiple ','required' => 'true']) !!}
                                                                                        <span class="form-text text-muted"></span>
                                                                                    </div>
                                                                                    <div class="form-group col-lg-2">
                                                                                        <label>Unit <span class="required" aria-required="true"> *</span></label>
                                                                                        {!! Form::select('unit_id', $units,$value->unit_id,['class' => 'form-control select2-multiple','required' => 'true']) !!}
                                                                                        <span class="form-text text-muted"></span>
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Duration<span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control duration" required onkeyup="getTotal(this)" name="duration" placeholder="Duration" value="{{$value->duration}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Quantity<span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control quantity" required onkeyup="getTotal(this)" name="quantity" placeholder="Quantity" value="{{$value->quantity}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Unit Cost <span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control unit_cost" required onkeyup="getTotal(this)" name="unit_cost" placeholder="Unit Cost" value="{{$value->unit_cost}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>CHF<span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="numeric" class="form-control chf" required onkeyup="getTotal(this)" name="chf" placeholder="CHF" value="{{$value->chf}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Total <span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control total_one_budget total_contractual" readonly required name="total" placeholder="Total" value="{{($value->unit_cost * $value->chf * $value->quantity * $value->duration)/100 }}">
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
                                                                                    <input type="text" class="form-control budget_line" required name="budget_line" placeholder="Budget Line" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-2">
                                                                                    <label>Category Option <span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('category_option_id', $category_options,null,['class' => 'form-control select2-multiple ','required' => 'true']) !!}
                                                                                    <span class="form-text text-muted"></span>
                                                                                </div>
                                                                                <div class="form-group col-lg-2">
                                                                                    <label>Unit <span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('unit_id', $units,null,['class' => 'form-control select2-multiple','required' => 'true']) !!}
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>Duration<span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="text" class="form-control duration" required onkeyup="getTotal(this)" name="duration" placeholder="Duration" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>Quantity<span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="text" class="form-control quantity" required onkeyup="getTotal(this)" name="quantity" placeholder="Quantity" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>Unit Cost <span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="text" class="form-control unit_cost" required onkeyup="getTotal(this)" name="unit_cost" placeholder="Unit Cost" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>CHF<span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="numeric" class="form-control chf" required onkeyup="getTotal(this)" name="chf" placeholder="CHF" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>Total <span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="text" class="form-control total_one_budget total_contractual" readonly required name="total" placeholder="Total" value="">
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
                                                                                    <label>In kind/Monetary <span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('in_kind', [''=>'monetary','0'=>'In kind'],'',['class' => 'form-control ']) !!}
                                                                                </div>
                                                                                <div class="form-group col-lg-2">
                                                                                    <label>D/S<span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('support', [''=>'Direct','1'=>'Support'],'',['class' => 'form-control']) !!}
                                                                                </div>
                                                                                <div class="form-group col-lg-2">
                                                                                    <label>Administrative Cost<span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('out_of_administrative_cost', [''=>'Include','1'=>'Not Included'],'',['class' => 'form-control  ']) !!}
                                                                                </div>
                                                                                <div class="form-group col-lg-4">
                                                                                    <label>description <span class="required" aria-required="true"> *</span></label>
                                                                                    <textarea required class="form-control " required name="description"></textarea>
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
                                    <div class="row">
                                        <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
                                            <div class="kt-portlet__head">
                                                <div class="kt-portlet__head-label">
                                                    <h3 class="kt-portlet__head-title">
                                                        Travel
                                                    </h3>

                                                </div>
                                                <div class="kt-portlet__head-toolbar">
                                                    <div class="kt-portlet__head-group">
                                                        Total: <input style="border: none;padding-left: 3px;;background-color: #fff;" readonly id="total_travel" class="currency" value="{{($mission_budget->detailed_proposal_budget()->where('budget_category_id',374770)->select('budget_category_id')->groupBy('budget_category_id')->selectRaw('sum ((unit_cost * chf * quantity * duration)/100) as total ')->first()->total ?? 0)}}">
                                                        {{--                                                        Total Budget: <input style="border: none;padding-left: 3px;;background-color: #fff;" readonly class="total_budget currency" value="{{($data_value->total_budget ?? null)}}">--}}
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
                                                    <div class="form-group col-md-12">
                                                        <div class="kt_repeater">
                                                            <div class="form-group  row">
                                                                <div data-repeater-list="travel" class="col-lg-12">
                                                                    @if($mission_budget->detailed_proposal_budget->where('budget_category_id',374770)->count())
                                                                        @foreach($mission_budget->detailed_proposal_budget->where('budget_category_id',374770) as $key=>$value)
                                                                            <div data-repeater-item class="kt-margin-b-10">
                                                                                <input type="hidden"  name="budget_id" value="{{$value->id}}">

                                                                                <div class="row  align-items-center">
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Budget Line <span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control budget_line" required name="budget_line" placeholder="Budget Line" value="{{$value->budget_line}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-2">
                                                                                        <label>Category Option <span class="required" aria-required="true"> *</span></label>
                                                                                        {!! Form::select('category_option_id', $category_options,$value->category_option_id,['class' => 'form-control select2-multiple ','required' => 'true']) !!}
                                                                                        <span class="form-text text-muted"></span>
                                                                                    </div>
                                                                                    <div class="form-group col-lg-2">
                                                                                        <label>Unit <span class="required" aria-required="true"> *</span></label>
                                                                                        {!! Form::select('unit_id', $units,$value->unit_id,['class' => 'form-control select2-multiple','required' => 'true']) !!}
                                                                                        <span class="form-text text-muted"></span>
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Duration<span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control duration" required onkeyup="getTotal(this)" name="duration" placeholder="Duration" value="{{$value->duration}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Quantity<span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control quantity" required onkeyup="getTotal(this)" name="quantity" placeholder="Quantity" value="{{$value->quantity}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Unit Cost <span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control unit_cost" required onkeyup="getTotal(this)" name="unit_cost" placeholder="Unit Cost" value="{{$value->unit_cost}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>CHF<span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="numeric" class="form-control chf" required onkeyup="getTotal(this)" name="chf" placeholder="CHF" value="{{$value->chf}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Total <span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control total_one_budget total_travel" readonly required name="total" placeholder="Total" value="{{($value->unit_cost * $value->chf * $value->quantity * $value->duration)/100 }}">
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
                                                                                    <input type="text" class="form-control budget_line" required name="budget_line" placeholder="Budget Line" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-2">
                                                                                    <label>Category Option <span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('category_option_id', $category_options,null,['class' => 'form-control select2-multiple ','required' => 'true']) !!}
                                                                                    <span class="form-text text-muted"></span>
                                                                                </div>
                                                                                <div class="form-group col-lg-2">
                                                                                    <label>Unit <span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('unit_id', $units,null,['class' => 'form-control select2-multiple','required' => 'true']) !!}
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>Duration<span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="text" class="form-control duration" required onkeyup="getTotal(this)" name="duration" placeholder="Duration" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>Quantity<span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="text" class="form-control quantity" required onkeyup="getTotal(this)" name="quantity" placeholder="Quantity" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>Unit Cost <span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="text" class="form-control unit_cost" required onkeyup="getTotal(this)" name="unit_cost" placeholder="Unit Cost" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>CHF<span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="numeric" class="form-control chf" required onkeyup="getTotal(this)" name="chf" placeholder="CHF" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>Total <span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="text" class="form-control total_one_budget total_travel" readonly required name="total" placeholder="Total" value="">
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
                                                                                    <label>In kind/Monetary <span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('in_kind', [''=>'monetary','0'=>'In kind'],'',['class' => 'form-control ']) !!}
                                                                                </div>
                                                                                <div class="form-group col-lg-2">
                                                                                    <label>D/S<span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('support', [''=>'Direct','1'=>'Support'],'',['class' => 'form-control']) !!}
                                                                                </div>
                                                                                <div class="form-group col-lg-2">
                                                                                    <label>Administrative Cost<span class="required" aria-required="true"> *</span></label>
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
                                    <div class="row">
                                        <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
                                            <div class="kt-portlet__head">
                                                <div class="kt-portlet__head-label">
                                                    <h3 class="kt-portlet__head-title">
                                                        Transfers and Grants to Counter parts
                                                    </h3>

                                                </div>
                                                <div class="kt-portlet__head-toolbar">
                                                    <div class="kt-portlet__head-group">
                                                        Total: <input style="border: none;padding-left: 3px;;background-color: #fff;" readonly  id="total_trans" class="currency" value="{{($mission_budget->detailed_proposal_budget()->where('budget_category_id',374771)->select('budget_category_id')->groupBy('budget_category_id')->selectRaw('sum ((unit_cost * chf * quantity * duration)/100) as total ')->first()->total ?? 0)}}">
                                                        {{--                                                        Total Budget: <input style="border: none;padding-left: 3px;;background-color: #fff;" readonly class="total_budget currency" value="0">--}}
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
                                                    <div class="form-group col-md-12">
                                                        <div class="kt_repeater">
                                                            <div class="form-group  row">
                                                                <div data-repeater-list="trans" class="col-lg-12">
                                                                    @if($mission_budget->detailed_proposal_budget->where('budget_category_id',374771)->count())
                                                                        @foreach($mission_budget->detailed_proposal_budget->where('budget_category_id',374771) as $key=>$value)
                                                                            <div data-repeater-item class="kt-margin-b-10">
                                                                                <input type="hidden"  name="budget_id" value="{{$value->id}}">

                                                                                <div class="row  align-items-center">
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Budget Line <span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control budget_line" required name="budget_line" placeholder="Budget Line" value="{{$value->budget_line}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-2">
                                                                                        <label>Category Option <span class="required" aria-required="true"> *</span></label>
                                                                                        {!! Form::select('category_option_id', $category_options,$value->category_option_id,['class' => 'form-control select2-multiple ','required' => 'true']) !!}
                                                                                        <span class="form-text text-muted"></span>
                                                                                    </div>
                                                                                    <div class="form-group col-lg-2">
                                                                                        <label>Unit <span class="required" aria-required="true"> *</span></label>
                                                                                        {!! Form::select('unit_id', $units,$value->unit_id,['class' => 'form-control select2-multiple','required' => 'true']) !!}
                                                                                        <span class="form-text text-muted"></span>
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Duration<span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control duration" required onkeyup="getTotal(this)" name="duration" placeholder="Duration" value="{{$value->duration}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Quantity<span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control quantity" required onkeyup="getTotal(this)" name="quantity" placeholder="Quantity" value="{{$value->quantity}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Unit Cost <span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control unit_cost" required onkeyup="getTotal(this)" name="unit_cost" placeholder="Unit Cost" value="{{$value->unit_cost}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>CHF<span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="numeric" class="form-control chf" required onkeyup="getTotal(this)" name="chf" placeholder="CHF" value="{{$value->chf}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Total <span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control total_one_budget total_trans" readonly required name="total" placeholder="Total" value="{{($value->unit_cost * $value->chf * $value->quantity * $value->duration)/100 }}">
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
                                                                                    <input type="text" class="form-control budget_line" required name="budget_line" placeholder="Budget Line" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-2">
                                                                                    <label>Category Option <span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('category_option_id', $category_options,null,['class' => 'form-control select2-multiple ','required' => 'true']) !!}
                                                                                    <span class="form-text text-muted"></span>
                                                                                </div>
                                                                                <div class="form-group col-lg-2">
                                                                                    <label>Unit <span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('unit_id', $units,null,['class' => 'form-control select2-multiple','required' => 'true']) !!}
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>Duration<span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="text" class="form-control duration" required onkeyup="getTotal(this)" name="duration" placeholder="Duration" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>Quantity<span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="text" class="form-control quantity" required onkeyup="getTotal(this)" name="quantity" placeholder="Quantity" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>Unit Cost <span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="text" class="form-control unit_cost" required onkeyup="getTotal(this)" name="unit_cost" placeholder="Unit Cost" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>CHF<span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="numeric" class="form-control chf" required onkeyup="getTotal(this)" name="chf" placeholder="CHF" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>Total <span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="text" class="form-control total_one_budget total_trans" readonly required name="total" placeholder="Total" value="">
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
                                                                                    <label>In kind/Monetary <span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('in_kind', [''=>'monetary','0'=>'In kind'],'',['class' => 'form-control ']) !!}
                                                                                </div>
                                                                                <div class="form-group col-lg-2">
                                                                                    <label>D/S<span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('support', [''=>'Direct','1'=>'Support'],'',['class' => 'form-control']) !!}
                                                                                </div>
                                                                                <div class="form-group col-lg-2">
                                                                                    <label>Administrative Cost<span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('out_of_administrative_cost', [''=>'Include','1'=>'Not Included'],'',['class' => 'form-control  ']) !!}
                                                                                </div>
                                                                                <div class="form-group col-lg-4">
                                                                                    <label>description <span class="required" aria-required="true"> *</span></label>
                                                                                    <textarea required class="form-control " required name="description"></textarea>
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
                                    <div class="row">
                                        <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
                                            <div class="kt-portlet__head">
                                                <div class="kt-portlet__head-label">
                                                    <h3 class="kt-portlet__head-title">
                                                        General Operating and Other direct costs
                                                    </h3>

                                                </div>
                                                <div class="kt-portlet__head-toolbar">
                                                    <div class="kt-portlet__head-group">
                                                        Total: <input style="border: none;padding-left: 3px;;background-color: #fff;" readonly  id="total_general" class="currency"  value="{{($mission_budget->detailed_proposal_budget()->where('budget_category_id',374772)->select('budget_category_id')->groupBy('budget_category_id')->selectRaw('sum ((unit_cost * chf * quantity * duration)/100) as total ')->first()->total ?? 0)}}">
                                                        {{--                                                        Total Budget: <input style="border: none;padding-left: 3px;;background-color: #fff;" readonly class="total_budget currency" value="0">--}}
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
                                                    <div class="form-group col-md-12">
                                                        <div class="kt_repeater">
                                                            <div class="form-group  row">
                                                                <div data-repeater-list="general" class="col-lg-12">
                                                                    @if($mission_budget->detailed_proposal_budget->where('budget_category_id',374772)->count())
                                                                        @foreach($mission_budget->detailed_proposal_budget->where('budget_category_id',374772) as $key=>$value)
                                                                            <div data-repeater-item class="kt-margin-b-10">
                                                                                <input type="hidden"  name="budget_id" value="{{$value->id}}">

                                                                                <div class="row  align-items-center">
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Budget Line <span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control budget_line" required name="budget_line" placeholder="Budget Line" value="{{$value->budget_line}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-2">
                                                                                        <label>Category Option <span class="required" aria-required="true"> *</span></label>
                                                                                        {!! Form::select('category_option_id', $category_options,$value->category_option_id,['class' => 'form-control select2-multiple ','required' => 'true']) !!}
                                                                                        <span class="form-text text-muted"></span>
                                                                                    </div>
                                                                                    <div class="form-group col-lg-2">
                                                                                        <label>Unit <span class="required" aria-required="true"> *</span></label>
                                                                                        {!! Form::select('unit_id', $units,$value->unit_id,['class' => 'form-control select2-multiple','required' => 'true']) !!}
                                                                                        <span class="form-text text-muted"></span>
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Duration<span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control duration" required onkeyup="getTotal(this)" name="duration" placeholder="Duration" value="{{$value->duration}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Quantity<span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control quantity" required onkeyup="getTotal(this)" name="quantity" placeholder="Quantity" value="{{$value->quantity}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Unit Cost <span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control unit_cost" required onkeyup="getTotal(this)" name="unit_cost" placeholder="Unit Cost" value="{{$value->unit_cost}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>CHF<span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="numeric" class="form-control chf" required onkeyup="getTotal(this)" name="chf" placeholder="CHF" value="{{$value->chf}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Total <span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control total_one_budget total_general" readonly required name="total" placeholder="Total" value="{{($value->unit_cost * $value->chf * $value->quantity * $value->duration)/100 }}">
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
                                                                                    <input type="text" class="form-control budget_line" required name="budget_line" placeholder="Budget Line" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-2">
                                                                                    <label>Category Option <span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('category_option_id', $category_options,null,['class' => 'form-control select2-multiple ','required' => 'true']) !!}
                                                                                    <span class="form-text text-muted"></span>
                                                                                </div>
                                                                                <div class="form-group col-lg-2">
                                                                                    <label>Unit <span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('unit_id', $units,null,['class' => 'form-control select2-multiple','required' => 'true']) !!}
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>Duration<span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="text" class="form-control duration" required onkeyup="getTotal(this)" name="duration" placeholder="Duration" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>Quantity<span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="text" class="form-control quantity" required onkeyup="getTotal(this)" name="quantity" placeholder="Quantity" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>Unit Cost <span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="text" class="form-control unit_cost" required onkeyup="getTotal(this)" name="unit_cost" placeholder="Unit Cost" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>CHF<span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="numeric" class="form-control chf" required onkeyup="getTotal(this)" name="chf" placeholder="CHF" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>Total <span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="text" class="form-control total_one_budget total_general" readonly required name="total" placeholder="Total" value="">
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
                                                                                    <label>In kind/Monetary <span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('in_kind', [''=>'monetary','0'=>'In kind'],'',['class' => 'form-control ']) !!}
                                                                                </div>
                                                                                <div class="form-group col-lg-2">
                                                                                    <label>D/S<span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('support', [''=>'Direct','1'=>'Support'],'',['class' => 'form-control']) !!}
                                                                                </div>
                                                                                <div class="form-group col-lg-2">
                                                                                    <label>Administrative Cost<span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('out_of_administrative_cost', [''=>'Include','1'=>'Not Included'],'',['class' => 'form-control  ']) !!}
                                                                                </div>
                                                                                <div class="form-group col-lg-4">
                                                                                    <label>description <span class="required" aria-required="true"> *</span></label>
                                                                                    <textarea required class="form-control " required name="description"></textarea>
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
                                    <div class="row">
                                        <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
                                            <div class="kt-portlet__head">
                                                <div class="kt-portlet__head-label">
                                                    <h3 class="kt-portlet__head-title">
                                                        Support costs
                                                    </h3>

                                                </div>
                                                <div class="kt-portlet__head-toolbar">
                                                    <div class="kt-portlet__head-group">
                                                        Total: <input style="border: none;padding-left: 3px;;background-color: #fff;"  readonly id="total_support_cost" class="currency"   value="{{($mission_budget->detailed_proposal_budget()->where('budget_category_id',374773)->select('budget_category_id')->groupBy('budget_category_id')->selectRaw('sum ((unit_cost * chf * quantity * duration)/100) as total ')->first()->total ?? 0)}}">
                                                        {{--                                                        Total Budget: <input style="border: none;padding-left: 3px;;background-color: #fff;" readonly class="total_budget currency" value="0">--}}
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
                                                    <div class="form-group col-md-12">
                                                        <div class="kt_repeater">
                                                            <div class="form-group  row">
                                                                <div data-repeater-list="support_cost" class="col-lg-12">
                                                                    @if($mission_budget->detailed_proposal_budget->where('budget_category_id',374773)->count())
                                                                        @foreach($mission_budget->detailed_proposal_budget->where('budget_category_id',374773) as $key=>$value)
                                                                            <div data-repeater-item class="kt-margin-b-10">
                                                                                <input type="hidden"  name="budget_id" value="{{$value->id}}">

                                                                                <div class="row  align-items-center">
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Budget Line <span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control budget_line" required name="budget_line" placeholder="Budget Line" value="{{$value->budget_line}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-2">
                                                                                        <label>Category Option <span class="required" aria-required="true"> *</span></label>
                                                                                        {!! Form::select('category_option_id', $category_options,$value->category_option_id,['class' => 'form-control select2-multiple ','required' => 'true']) !!}
                                                                                        <span class="form-text text-muted"></span>
                                                                                    </div>
                                                                                    <div class="form-group col-lg-2">
                                                                                        <label>Unit <span class="required" aria-required="true"> *</span></label>
                                                                                        {!! Form::select('unit_id', $units,$value->unit_id,['class' => 'form-control select2-multiple','required' => 'true']) !!}
                                                                                        <span class="form-text text-muted"></span>
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Duration<span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control duration" required onkeyup="getTotal(this)" name="duration" placeholder="Duration" value="{{$value->duration}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Quantity<span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control quantity" required onkeyup="getTotal(this)" name="quantity" placeholder="Quantity" value="{{$value->quantity}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Unit Cost <span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control unit_cost" required onkeyup="getTotal(this)" name="unit_cost" placeholder="Unit Cost" value="{{$value->unit_cost}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>CHF<span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="numeric" class="form-control chf" required onkeyup="getTotal(this)" name="chf" placeholder="CHF" value="{{$value->chf}}">
                                                                                    </div>
                                                                                    <div class="form-group col-lg-1">
                                                                                        <label>Total <span class="required" aria-required="true"> *</span></label>
                                                                                        <input type="text" class="form-control total_one_budget total_support_cost" readonly required name="total" placeholder="Total" value="{{($value->unit_cost * $value->chf * $value->quantity * $value->duration)/100 }}">
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
                                                                                    <input type="text" class="form-control budget_line" required name="budget_line" placeholder="Budget Line" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-2">
                                                                                    <label>Category Option <span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('category_option_id', $category_options,null,['class' => 'form-control select2-multiple ','required' => 'true']) !!}
                                                                                    <span class="form-text text-muted"></span>
                                                                                </div>
                                                                                <div class="form-group col-lg-2">
                                                                                    <label>Unit <span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('unit_id', $units,null,['class' => 'form-control select2-multiple','required' => 'true']) !!}
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>Duration<span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="text" class="form-control duration" required onkeyup="getTotal(this)" name="duration" placeholder="Duration" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>Quantity<span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="text" class="form-control quantity" required onkeyup="getTotal(this)" name="quantity" placeholder="Quantity" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>Unit Cost <span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="text" class="form-control unit_cost" required onkeyup="getTotal(this)" name="unit_cost" placeholder="Unit Cost" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>CHF<span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="numeric" class="form-control chf" required onkeyup="getTotal(this)" name="chf" placeholder="CHF" value="">
                                                                                </div>
                                                                                <div class="form-group col-lg-1">
                                                                                    <label>Total <span class="required" aria-required="true"> *</span></label>
                                                                                    <input type="text" class="form-control total_one_budget total_support_cost" readonly required name="total" placeholder="Total" value="">
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
                                                                                    <label>In kind/Monetary <span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('in_kind', [''=>'monetary','0'=>'In kind'],'',['class' => 'form-control ']) !!}
                                                                                </div>
                                                                                <div class="form-group col-lg-2">
                                                                                    <label>D/S<span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('support', [''=>'Direct','1'=>'Support'],'',['class' => 'form-control']) !!}
                                                                                </div>
                                                                                <div class="form-group col-lg-2">
                                                                                    <label>Administrative Cost<span class="required" aria-required="true"> *</span></label>
                                                                                    {!! Form::select('out_of_administrative_cost', [''=>'Include','1'=>'Not Included'],'',['class' => 'form-control  ']) !!}
                                                                                </div>
                                                                                <div class="form-group col-lg-4">
                                                                                    <label>description <span class="required" aria-required="true"> *</span></label>
                                                                                    <textarea required class="form-control " required name="description"></textarea>
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
                                </div>
                            </div>
                            <!--end: Form Wizard Step 2-->
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
    {!! Html::script('assets/app/custom/wizard/wizard-mission-v1.js') !!}
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
                "digits": 4,
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
        total_one_budget('total_personnel');
        total_one_budget('total_supplies');
        total_one_budget('total_equipment');
        total_one_budget('total_contractual');
        total_one_budget('total_travel');
        total_one_budget('total_trans');
        total_one_budget('total_general');
        total_one_budget('total_support_cost');
        get_duration('start_date', 'end_date', 'duration');

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
                    console.log(total_budget);
                    $(`.total_budget`).val(total_budget);
                    $(`#${name}`).val(total);
                    $(".currency").inputmask({
                        "alias": "decimal",
                        "digits": 2,
                        "suffix": " $",
                        "autoGroup": true,
                        autoUnmask: true,
                        "allowMinus": true,
                        "rightAlign": false,
                        "groupSeparator": ",",
                        "radixPoint": ".",

                    });
                }, 500);
            });
        }

        function getTotal(e) {
            let name = e.getAttribute("name");
            let name_str = name.split("]");
            let category = name_str[0].split("[");
            let categoryName = category[0];
            let num = category[1];
            let cost = document.getElementsByName('' + categoryName + '[' + num + '][unit_cost]')[0].value;
            let duration = document.getElementsByName('' + categoryName + '[' + num + '][duration]')[0].value;
            let chf = document.getElementsByName('' + categoryName + '[' + num + '][chf]')[0].value;
            let quantity = document.getElementsByName('' + categoryName + '[' + num + '][quantity]')[0].value;
            let total;
            if (duration == '') {
                duration = 0;
            }
            if (duration == '') {
                duration = 0;
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
                document.getElementsByName('' + categoryName + '[' + num + '][total]')[0].value = total;
                let el = document.getElementsByName('' + categoryName + '[' + num + '][total]')[0];
                let ev = document.createEvent('Event');
                ev.initEvent('change', true, false);
                el.dispatchEvent(ev);
            }

        }
    </script>
@stop
