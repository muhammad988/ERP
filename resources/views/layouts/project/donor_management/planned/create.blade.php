@extends('layouts.app')
@section('style')
    @include('layouts.include.style.style_form')
@stop
@section('content')
    <!-- begin:: Content -->
    <div class="kt-container  kt-container--fluid  kt-grid__item    kt-grid__item--fluid">
        <div class="row">
            <div class="col-lg-12">
                <!--begin::Portlet-->
                <div class="kt-portlet kt-portlet--last kt-portlet--head-lg kt-portlet--responsive-mobile">
                    <div class="kt-portlet__head kt-portlet__head--lg">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">Donors Operation <small>Please start by adding donor operational card</small></h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <a href="/project/donor-management-ongoing-actual-payments/{{$project->id}}" class="btn btn-clean kt-margin-r-10">
                                <span class="btn btn-brand">Actual</span>
                            </a>
                        </div>
                    </div>
                    <div class="kt-portlet__body" id="headingOne">
                        <form method="POST" action="{{route('project.donor_payment_request_store')}}" class="kt-form" id="kt_form_1" name="donorForm" enctype="multipart/form-data">
                            @csrf
                            <input hidden value="{{$project->id}}" name="project_id">
                            <!--begin::Accordion-->
                            <div class="repeater">
                                <div data-repeater-list="outer_list">
                                    @foreach($project->donors as $donor_edit)
                                        <div data-repeater-item>
                                            <div class="accordion  accordion-toggle-arrow" id="accordionExample1">
                                                <div class="card" name="donorCard">
                                                    <div class="card-header" id="headingOne1">
                                                        <div class="card-title collapsed" data-toggle="collapse"
                                                             data-target="#collapseOne1"
                                                             aria-expanded="false" aria-controls="collapseOne1">
                                                            <div class="row col-12 ">
                                                                <div class="donorName col-6" id="donorNameId">{{$donor_edit->name_en}}</div>
                                                                <div class="col-6 kt-align-right">
                                                                    @if($project->edit_plan_donor_management)
                                                                        <a href="javascript:;" data-repeater-delete
                                                                           class="btn-sm btn  btn-label-danger deleteDonorAccordion">
                                                                            <i class="la la-trash-o"></i>
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="collapseOne1" class="collapse" aria-labelledby="headingOne1" data-parent="#accordionExample1" style="">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-xl-1"></div>
                                                                <div class="col-xl-10">
                                                                    <div class="kt-section kt-section--first">
                                                                        <div class="kt-section__body">
                                                                            <h3 class="kt-section__title kt-section__title-lg">
                                                                                Information</h3>
                                                                            <div class="row col-12">
                                                                                <div class="form-group col-4">
                                                                                    <div class="col-12">
                                                                                        <label class="col-12 col-form-label">Donor</label>
                                                                                        <select class="form-control selectDonor"
                                                                                                {{ ($project->edit_plan_donor_management==false ? "disabled":null ) }}
                                                                                                onchange="selectdonorChange()"
                                                                                                type="text"
                                                                                                name="donor_id"
                                                                                                id="selectDonor">
                                                                                            <option value="">Select Donor
                                                                                            </option>
                                                                                            @foreach($project->detailed_proposal_budget()->select(['donors.name_en','donors.id'])->groupBy('donors.name_en','donors.id')->get() as $donor)
                                                                                                <option {{ $donor_edit->id == $donor->id ? "selected" : null }}  value="{{$donor->id}}">{{$donor->name_en}} </option>
                                                                                            @endforeach

                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group col-4">
                                                                                    <div class="col-12">
                                                                                        <label class="col-12 col-form-label">Project Name in Agreement</label>
                                                                                        <input class="form-control nameInAgreement"
                                                                                               id="nameInAgreement"
                                                                                               type="text"
                                                                                               {{ ($project->edit_plan_donor_management==false ? "readonly":null ) }}
                                                                                               value="{{$donor_edit->pivot->project_name_en}}"
                                                                                               name="project_name_en">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group col-4">
                                                                                    <div class="col-12">
                                                                                        <label class="col-12 col-form-label">Project
                                                                                            Code in
                                                                                            Agreement</label>
                                                                                        <input class="form-control codeInAgreement"
                                                                                               id="codeInAgreement"
                                                                                               type="text"
                                                                                               {{ ($project->edit_plan_donor_management==false ? "readonly":null ) }}
                                                                                               value="{{$donor_edit->pivot->project_code}}"

                                                                                               name="project_code">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                                                                            <div class="form-group row">
                                                                                <div class="col-2">
                                                                                    <label class="col-12 col-form-label">Monetary
                                                                                        Donation</label>
                                                                                    <input type="text"
                                                                                           class="form-control monetaryDonation money money-1"
                                                                                           name="monetary"
                                                                                           readonly
                                                                                           value="{{$donor_edit->pivot->monetary}}"

                                                                                           aria-describedby="basic-addon1">
                                                                                </div>
                                                                                <div class="col-2">
                                                                                    <label class="col-12 col-form-label">In-kind
                                                                                        Donation</label>
                                                                                    <input type="text"
                                                                                           class="form-control inKindDonation money money-1"
                                                                                           readonly name="in_kind"
                                                                                           value="{{$donor_edit->pivot->in_kind}}"

                                                                                           aria-describedby="basic-addon1">
                                                                                </div>
                                                                                <div class="col-2">
                                                                                    <label class="col-12 col-form-label">Total</label>
                                                                                    <input type="text"
                                                                                           class="form-control monetaryInKindTotal money money-1"
                                                                                           readonly
                                                                                           value="{{$donor_edit->pivot->in_kind + $donor_edit->pivot->monetary}}"
                                                                                           aria-describedby="basic-addon1">
                                                                                </div>
                                                                            </div>
                                                                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                                                                            <!-- files Attachements-->
                                                                            <div class="form-group row">
                                                                                <!-- RACA -->
                                                                                <div class="col-6">
                                                                                    <div class="row">
                                                                                        @if($project->edit_plan_donor_management)
                                                                                            <div class="col-lg-6 ">
                                                                                                <label>RACA</label>
                                                                                                <div>
                                                                                                    <input type="file"
                                                                                                           name="raca_file">
                                                                                                </div>
                                                                                            </div>
                                                                                        @endif
                                                                                        @if($donor_edit->pivot->raca_file)
                                                                                            <div class="col-lg-2 ">
                                                                                                <label>RACA File</label>
                                                                                                <a target="_blank" href="/file/donor/{{$donor_edit->pivot->raca_file}}" class="btn btn-bold btn-primary">View </a>
                                                                                            </div>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                                <!-- Donor Agreement -->
                                                                                <div class="col-6">
                                                                                    <div class="row">
                                                                                        @if($project->edit_plan_donor_management)

                                                                                            <div class="col-lg-6 ">
                                                                                                <label>Donor Agreement</label>
                                                                                                <div>
                                                                                                    <input type="file"
                                                                                                           name="agreement_file">
                                                                                                </div>
                                                                                            </div>
                                                                                        @endif
                                                                                        @if($donor_edit->pivot->agreement_file)
                                                                                            <div class="col-lg-2 ">
                                                                                                <label>Agreement File</label>
                                                                                                <a target="_blank" href="/file/donor/{{$donor_edit->pivot->agreement_file}}" class="btn btn-bold btn-primary">View</a>
                                                                                            </div>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <div class="col-6">
                                                                                    <div class="row">
                                                                                        @if($project->edit_plan_donor_management)
                                                                                            <div class="col-lg-6 ">
                                                                                                <label>Proposal</label>
                                                                                                <div>
                                                                                                    <input type="file"
                                                                                                           name="proposal_file">
                                                                                                </div>
                                                                                            </div>
                                                                                        @endif
                                                                                        @if($donor_edit->pivot->proposal_file)
                                                                                            <div class="col-lg-2 ">
                                                                                                <label>Proposal File</label>
                                                                                                <a target="_blank" href="/file/donor/{{$donor_edit->pivot->proposal_file}}" class="btn btn-bold btn-primary">View</a>
                                                                                            </div>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <div class="row">
                                                                                        @if($project->edit_plan_donor_management)
                                                                                            <div class="col-lg-6 ">
                                                                                                <label>Budget</label>
                                                                                                <div>
                                                                                                    <input type="file"
                                                                                                           name="budget_file">
                                                                                                </div>
                                                                                            </div>
                                                                                        @endif
                                                                                        @if($donor_edit->pivot->budget_file)
                                                                                            <div class="col-lg-2 ">
                                                                                                <label>Budget File</label>
                                                                                                <a target="_blank" href="/file/donor/{{$donor_edit->pivot->budget_file}}" class="btn btn-bold btn-primary">View</a>
                                                                                            </div>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                            <div class="form-group row last row">
                                                                                <div class="col-6">
                                                                                    <div class="row">
                                                                                        @if($project->edit_plan_donor_management)

                                                                                            <div class="col-lg-6 ">
                                                                                                <label>Delegation</label>
                                                                                                <div>
                                                                                                    <input type="file"
                                                                                                           name="delegation_file">
                                                                                                </div>
                                                                                            </div>
                                                                                        @endif
                                                                                        @if($donor_edit->pivot->delegation_file)
                                                                                            <div class="col-lg-2 ">
                                                                                                <label>Proposal File</label>
                                                                                                <a target="_blank" href="/file/donor/{{$donor_edit->pivot->delegation_file}}" class="btn btn-bold btn-primary">View</a>
                                                                                            </div>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="kt-separator kt-separator--border-2x kt-separator--space-lg"></div>
                                                                    <div class="kt-section">
                                                                        <div class="kt-section__body">
                                                                            <h3 class="kt-section__title kt-section__title-lg">Agreed Reports</h3>
                                                                            <div class="row inner-repeater">
                                                                                <div class="row col-12"
                                                                                     data-repeater-list="donorAgreedReports_list">
                                                                                    @foreach($project->donor_report($donor_edit->id) as $donor_report)
                                                                                        <div class="row col-12"
                                                                                             data-repeater-item>
                                                                                            <input hidden value="{{$donor_report->pivot->id}}" name="id">
                                                                                            <div class="form-group col-3">
                                                                                                <div class="kt-form__group--inline">
                                                                                                    <div class="kt-form__label">
                                                                                                        <label>Report Type</label>
                                                                                                    </div>
                                                                                                    {!! Form::select('report_type_id',$report_types,$donor_report->pivot->report_type_id,['class'=>'selecReportType form-control',($project->edit_plan_donor_management==false ? "disabled":null )]) !!}
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class=" form-group col-4">
                                                                                                <div class="kt-form__group--inline">
                                                                                                    <div class="kt-form__label">
                                                                                                        <label>Report
                                                                                                            Name</label>
                                                                                                    </div>
                                                                                                    <input class="form-control reportName"
                                                                                                           type="text"
                                                                                                           {{ ($project->edit_plan_donor_management==false ? "readonly":null ) }}
                                                                                                           value="{{$donor_report->pivot->name_en}}"
                                                                                                           name="name_en">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group col-3">
                                                                                                <div class="kt-form__group--inline">
                                                                                                    <div class="kt-form__label">
                                                                                                        <label>Report Due
                                                                                                            date</label>
                                                                                                    </div>
                                                                                                    <input class="form-control reportDueDate"
                                                                                                           type="Date"
                                                                                                           value="{{$donor_report->pivot->due_date}}"
                                                                                                           {{ ($project->edit_plan_donor_management==false ? "readonly":null ) }}
                                                                                                           name="due_date">
                                                                                                </div>
                                                                                            </div>
                                                                                            @if($project->edit_plan_donor_management)
                                                                                                <div class="form-group col-2">
                                                                                                    <div class="kt-form__group--inline">
                                                                                                        <div class="kt-form__label">
                                                                                                            <label>---</label>
                                                                                                        </div>
                                                                                                        <a href="javascript:;"
                                                                                                           data-repeater-delete=""
                                                                                                           class="btn-sm btn btn-label-danger btn-bold">
                                                                                                            <i class="la la-trash-o"></i>
                                                                                                        </a>
                                                                                                    </div>
                                                                                                </div>
                                                                                            @endif

                                                                                        </div>
                                                                                    @endforeach
                                                                                </div>
                                                                                @if($project->edit_plan_donor_management)

                                                                                    <div class="form-group form-group-last row">
                                                                                        <label class="col-6 col-form-label"></label>
                                                                                        <div class="col-12">
                                                                                            <a href="javascript:;"
                                                                                               data-repeater-create=""
                                                                                               class="btn btn-bold btn-sm btn-label-brand">
                                                                                                <i class="la la-plus"></i> Add
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="kt-separator kt-separator--border-2x kt-separator--space-lg"></div>
                                                                    <div class="kt-section kt-section--last">
                                                                        <div class="kt-section__body">
                                                                            <h3 class="kt-section__title kt-section__title-lg">
                                                                                Donor
                                                                                Agreed Payments</h3>
                                                                            <div class="row inner-repeater">
                                                                                <div class="row col-12"
                                                                                     data-repeater-list="donorAgreedPayments_list">
                                                                                    @foreach($project->donor_payment($donor_edit->id) as $donor_payment)
                                                                                        <div class="row col-12"
                                                                                             data-repeater-item>
                                                                                            <input hidden value="{{$donor_payment->pivot->id}}" name="id">

                                                                                            <div class="form-group col-3">
                                                                                                <div class="kt-form__group--inline">
                                                                                                    <div class="kt-form__label">
                                                                                                        <label>Payment
                                                                                                            Number</label>
                                                                                                    </div>
                                                                                                    {!! Form::select('payment_number_id',$payment_number,$donor_payment->pivot->payment_number_id ,['class'=>'paymentNumber form-control',($project->edit_plan_donor_management==false ? "disabled":null )]) !!}
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group col-4">
                                                                                                <div class="kt-form__group--inline">
                                                                                                    <div class="kt-form__label">
                                                                                                        <label>Payment Due Date</label>
                                                                                                    </div>
                                                                                                    <input class="form-control paymentDueDate"
                                                                                                           type="date"
                                                                                                           {{ ($project->edit_plan_donor_management==false ? "readonly":null ) }}
                                                                                                           value="{{$donor_payment->pivot->due_date}}"
                                                                                                           name="due_date">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group col-3">
                                                                                                <div class="kt-form__group--inline"></div>
                                                                                                <div class="kt-form__label">
                                                                                                    <label>Agreed Amount of Money</label>
                                                                                                </div>
                                                                                                <input class="form-control agreedAmountOfMoney currency"
                                                                                                       type="number"
                                                                                                       value="{{$donor_payment->pivot->agreed_amount}}"
                                                                                                       {{ ($project->edit_plan_donor_management==false ? "readonly":null ) }}
                                                                                                       name="agreed_amount">
                                                                                            </div>
                                                                                            @if($project->edit_plan_donor_management)
                                                                                                <div class="form-group col-2">
                                                                                                    <div class="kt-form__group--inline">
                                                                                                        <div class="kt-form__label">
                                                                                                            <label>---</label>
                                                                                                        </div>
                                                                                                        <a href="javascript:;"
                                                                                                           data-repeater-delete=""
                                                                                                           class="btn-sm btn btn-label-danger btn-bold">
                                                                                                            <i class="la la-trash-o"></i>
                                                                                                        </a>
                                                                                                    </div>
                                                                                                </div>
                                                                                            @endif
                                                                                        </div>
                                                                                    @endforeach
                                                                                </div>
                                                                                @if($project->edit_plan_donor_management)
                                                                                    <div class="    form-group form-group-last row">
                                                                                        <label class="col-6 col-form-label"></label>
                                                                                        <div class="col-12">
                                                                                            <a href="javascript:;"
                                                                                               data-repeater-create=""
                                                                                               class="btn btn-bold btn-sm btn-label-brand">
                                                                                                <i class="la la-plus"></i> Add
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="kt-separator kt-separator--border-2x kt-separator--space-lg"></div>
                                                                    <div class="kt-form__actions col-12">
                                                                    </div>
                                                                    <div class="col-xl-1"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="kt-separator kt-separator--border-2x kt-separator--space-lg"></div>
                                        </div>
                                    @endforeach
                                    @if($project->donors->count()==0)
                                        <div data-repeater-item>
                                            <div class="accordion  accordion-toggle-arrow" id="accordionExample1">
                                                <div class="card" name="donorCard">
                                                    <div class="card-header" id="headingOne1">
                                                        <div class="card-title collapsed" data-toggle="collapse"
                                                             data-target="#collapseOne1"
                                                             aria-expanded="false" aria-controls="collapseOne1">
                                                            <div class="row col-12 ">
                                                                <div class="donorName col-6" id="donorNameId">Donor?</div>
                                                                <div class="col-6 kt-align-right">
                                                                    <a href="javascript:;" data-repeater-delete
                                                                       class="btn-sm btn  btn-label-danger deleteDonorAccordion">
                                                                        <i class="la la-trash-o"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="collapseOne1" class="collapse" aria-labelledby="headingOne1" data-parent="#accordionExample1" style="">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-xl-1"></div>
                                                                <div class="col-xl-10">
                                                                    <div class="kt-section kt-section--first">
                                                                        <div class="kt-section__body">
                                                                            <h3 class="kt-section__title kt-section__title-lg"> Information</h3>
                                                                            <div class="row col-12">
                                                                                <div class="form-group col-4">
                                                                                    <div class="col-12">
                                                                                        <label class="col-12 col-form-label">Donor</label>
                                                                                        <select class="form-control selectDonor"
                                                                                                onchange="selectdonorChange()"
                                                                                                type="text"
                                                                                                name="donor_id"
                                                                                                id="selectDonor">
                                                                                            <option value="">Select Donor </option>
                                                                                            @foreach($project->detailed_proposal_budget()->select(['donors.name_en','donors.id'])->groupBy('donors.name_en','donors.id')->get() as $donor)
                                                                                                <option value="{{$donor->id}}">{{$donor->name_en}} </option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group col-4">
                                                                                    <div class="col-12">
                                                                                        <label class="col-12 col-form-label">Project Name in Agreement</label>
                                                                                        <input class="form-control nameInAgreement"
                                                                                               id="nameInAgreement"
                                                                                               type="text"
                                                                                               name="project_name_en">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group col-4">
                                                                                    <div class="col-12">
                                                                                        <label class="col-12 col-form-label">Project  Code in  Agreement</label>
                                                                                        <input class="form-control codeInAgreement" id="codeInAgreement" type="text" name="project_code">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                                                                            <div class="form-group row">
                                                                                <div class="col-2">
                                                                                    <label class="col-12 col-form-label">Monetary  Donation</label>
                                                                                    <input type="text"
                                                                                           class="form-control monetaryDonation money-1"
                                                                                           name="monetary"
                                                                                           readonly
                                                                                           aria-describedby="basic-addon1">
                                                                                </div>
                                                                                <div class="col-2">
                                                                                    <label class="col-12 col-form-label">In-kind Donation</label>
                                                                                    <input type="text"
                                                                                           class="form-control inKindDonation money-1"
                                                                                           readonly name="in_kind"
                                                                                           aria-describedby="basic-addon1">
                                                                                </div>
                                                                                <div class="col-2">
                                                                                    <label class="col-12 col-form-label">Total</label>
                                                                                    <input type="text"
                                                                                           class="form-control monetaryInKindTotal money-1"
                                                                                           readonly
                                                                                           aria-describedby="basic-addon1">
                                                                                </div>
                                                                            </div>
                                                                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                                                                            <!-- files Attachments-->
                                                                            <div class="form-group row">
                                                                                <!-- RACA -->
                                                                                <div class="col-6">
                                                                                    <label>RACA</label>
                                                                                    <div></div>
                                                                                    <div>
                                                                                        <input type="file"
                                                                                               name="raca_file">
                                                                                    </div>
                                                                                </div>
                                                                                <!-- Donor Agreement -->
                                                                                <div class="col-6">
                                                                                    <label>Donor Agreement</label>
                                                                                    <div></div>
                                                                                    <div>
                                                                                        <input type="file"
                                                                                               name="agreement_file">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <!-- Proposal -->
                                                                                <div class="col-6">
                                                                                    <label>Proposal</label>
                                                                                    <div></div>
                                                                                    <div>
                                                                                        <input type="file"
                                                                                               name="proposal_file">

                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <!-- Budget -->
                                                                                    <label>Budget</label>
                                                                                    <div></div>
                                                                                    <div>
                                                                                        <input type="file"
                                                                                               name="budget_file">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row last row">
                                                                                <!-- Delegation -->
                                                                                <div class="col-6">
                                                                                    <label>Delegation</label>
                                                                                    <div>
                                                                                        <input
                                                                                            type="file"
                                                                                            name="delegation_file">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="kt-separator kt-separator--border-2x kt-separator--space-lg"></div>
                                                                    <div class="kt-section">
                                                                        <div class="kt-section__body">
                                                                            <h3 class="kt-section__title kt-section__title-lg">Agreed Reports</h3>
                                                                            <div class="row inner-repeater">
                                                                                <div class="row col-12" data-repeater-list="donorAgreedReports_list">
                                                                                    <div class="row col-12" data-repeater-item>
                                                                                        <input hidden value="" name="id">
                                                                                        <div class="form-group col-3">
                                                                                            <div class="kt-form__group--inline">
                                                                                                <div class="kt-form__label">
                                                                                                    <label>Report Type</label>
                                                                                                </div>
                                                                                                {!! Form::select('report_type_id',$report_types,null ,['class'=>'selecReportType form-control']) !!}
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class=" form-group col-4">
                                                                                            <div class="kt-form__group--inline">
                                                                                                <div class="kt-form__label">
                                                                                                    <label>Report Name</label>
                                                                                                </div>
                                                                                                <input class="form-control reportName"
                                                                                                       type="text"
                                                                                                       name="name_en">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group col-3">
                                                                                            <div class="kt-form__group--inline">
                                                                                                <div class="kt-form__label">
                                                                                                    <label>Report Due date</label>
                                                                                                </div>
                                                                                                <input class="form-control reportDueDate"
                                                                                                       type="Date"
                                                                                                       name="due_date">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group col-2">
                                                                                            <div class="kt-form__group--inline">
                                                                                                <div class="kt-form__label">
                                                                                                    <label>---</label>
                                                                                                </div>
                                                                                                <a href="javascript:;"
                                                                                                   data-repeater-delete=""
                                                                                                   class="btn-sm btn btn-label-danger btn-bold">
                                                                                                    <i class="la la-trash-o"></i>
                                                                                                </a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group form-group-last row">
                                                                                    <label class="col-6 col-form-label"></label>
                                                                                    <div class="col-12">
                                                                                        <a href="javascript:;"
                                                                                           data-repeater-create=""
                                                                                           class="btn btn-bold btn-sm btn-label-brand">
                                                                                            <i class="la la-plus"></i> Add
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="kt-separator kt-separator--border-2x kt-separator--space-lg"></div>
                                                                    <div class="kt-section kt-section--last">
                                                                        <div class="kt-section__body">
                                                                            <h3 class="kt-section__title kt-section__title-lg">
                                                                                Donor  Agreed Payments</h3>
                                                                            <div class="row inner-repeater">
                                                                                <div class="row col-12"
                                                                                     data-repeater-list="donorAgreedPayments_list">
                                                                                    <div class="row col-12"
                                                                                         data-repeater-item>
                                                                                        <input hidden value="" name="id">
                                                                                        <div class="form-group col-3">
                                                                                            <div class="kt-form__group--inline">
                                                                                                <div class="kt-form__label">
                                                                                                    <label>Payment Number</label>
                                                                                                </div>
                                                                                                {!! Form::select('payment_number_id',$payment_number,null ,['class'=>'paymentNumber form-control']) !!}
                                                                                            </div>
                                                                                        </div>
                                                                                            <div class="form-group col-4">
                                                                                                <div class="kt-form__group--inline">
                                                                                                    <div class="kt-form__label">
                                                                                                        <label>Payment
                                                                                                            Due
                                                                                                            Date</label>
                                                                                                    </div>
                                                                                                    <input class="form-control paymentDueDate"
                                                                                                           type="date"
                                                                                                           name="due_date">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group col-3">
                                                                                                <div class="kt-form__group--inline"></div>
                                                                                                <div class="kt-form__label">
                                                                                                    <label>Agreed Amount
                                                                                                        of
                                                                                                        Money</label>
                                                                                                </div>
                                                                                                <input class="form-control agreedAmountOfMoney currency"
                                                                                                       type="number"
                                                                                                       name="agreed_amount">
                                                                                            </div>
                                                                                            <div class="form-group col-2">
                                                                                                <div class="kt-form__group--inline">
                                                                                                    <div class="kt-form__label">
                                                                                                        <label>---</label>
                                                                                                    </div>
                                                                                                    <a href="javascript:;"
                                                                                                       data-repeater-delete=""
                                                                                                       class="btn-sm btn btn-label-danger btn-bold">
                                                                                                        <i class="la la-trash-o"></i>
                                                                                                    </a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="    form-group form-group-last row">
                                                                                        <label class="col-6 col-form-label"></label>
                                                                                        <div class="col-12">
                                                                                            <a href="javascript:;"
                                                                                               data-repeater-create=""
                                                                                               class="btn btn-bold btn-sm btn-label-brand">
                                                                                                <i class="la la-plus"></i> Add
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="kt-separator kt-separator--border-2x kt-separator--space-lg"></div>
                                                                        <div class="kt-form__actions col-12">
                                                                        </div>
                                                                        <div class="col-xl-1"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kt-separator kt-separator--border-2x kt-separator--space-lg"></div>
                                            </div>

                                            @endif
                                </div>
                                @if($project->edit_plan_donor_management)
                                    <div class="row col-12">
                                        <div class="col-lg-4">
                                            <a href="javascript:;" data-repeater-create=""
                                               class="btn btn-bold btn-sm btn-label-brand">
                                                <i class="la la-plus"></i> Add Donor
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                <div class="kt-separator kt-separator--border-2x kt-separator--space-lg"></div>
                                @if($project->edit_plan_donor_management)
                                    <div class="row col-12">
                                        <div class="col-4 ">
                                            <a href="#" id="submitForm" type="submit"
                                               class="btn btn-sm btn-label-success btn-bold">
                                                <i class="la la-save"></i>Save
                                            </a>
                                            <a type="reset" class="btn btn-sm btn-bold btn-label-warning">
                                                <i class="la la-rotate-right"></i> Reset
                                            </a>
                                            <a type="reset" class="btn btn-bold btn-sm btn-label-danger">
                                                <i class="la la-close"></i>Cancel
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <!--end::Accordion-->
                        </form>
                    </div>
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
    <!-- end:: Content -->
@stop
@section('script')
    @include('layouts.include.script.script_jquery_form')
    <script>
        let addValidateClassToInput = function () {
            $.validator.addClassRules('selectDonor', {
                required: true
            });
            $.validator.addClassRules('nameInAgreement', {
                required: true,
                minlength: 2,
                maxlength: 20
            });
            $.validator.addClassRules('codeInAgreement', {
                required: true,
                minlength: 2,
                maxlength: 20
            });
            $.validator.addClassRules('selecReportType', {
                required: true
            });
            $.validator.addClassRules('reportName', {
                required: true,
                minlength: 2,
                maxlength: 20
            });
            $.validator.addClassRules('reportDueDate', {
                required: true
            });
            $.validator.addClassRules('paymentNumber', {
                required: true
            });
            $.validator.addClassRules('paymentDueDate', {
                required: true
            });
            $.validator.addClassRules('agreedAmountOfMoney', {
                required: true
            });
            $("#kt_form_1").validate({
                focusInvalid: false,
                invalidHandler: function (form, validator) {

                    if (!validator.numberOfInvalids())
                        return;
                    $('html, body').animate({
                            scrollTop: $(validator.errorList[0].element).offset().top,
                        }, 1000, console.log($(validator.errorList[0].element).offset().top),
                        $(validator.errorList[0].element).closest('#collapseOne1').attr('class', 'show')
                    );

                }
            });
// $('[id^=nameInAgreement]').each(function (e) {
//     $(this).rules('add', {
//         required: true,
//         minlength: 2,
//         invalidHandler: function (event, validator) {
//             let alert = $('#kt_form_1_msg');
//             alert.removeClass('kt--hide').show();
//             KTUtil.scrollTop();
//         }
//     })
// });
        };
        let selectdonorChange = function () {
            $('.selectDonor').each(function (i) {
                let donorClass = $(this).closest('div.card').children('div.card-header').find('div.donorName').attr('class');
                let selectDonor = $(this).find('option:selected').text();
                let id = $(this).find('option:selected').val();
                console.log(i);
                $.ajax({
                    type: "POST",
                    url: '{{route('project.get_donor_budget')}}',
                    data: {donor_id: id, project_id: `{{$project->id}}`},
                    dataType: 'json',
                    success: function (data) {
                        $('.monetaryInKindTotal:eq(' + i + ')').val(data.total);
                        $('.monetaryDonation:eq(' + i + ')').val(data.monetary);
                        $('.inKindDonation:eq(' + i + ')').val(data.in_kind);
                        $(".money-1").inputmask({
                            "alias": "decimal",
                            "digits": 4,
                            "suffix": " $",
                            "autoGroup": true,
                            "allowMinus": true,
                            "rightAlign": false,
                            autoUnmask: true,
                            removeMaskOnSubmit: true,
                            "groupSeparator": ",",
                            "radixPoint": ".",
                        });
                    },
                    error: function (data) {
                    }
                });
                $(this).closest('div.card').children('div.card-header').find('div.donorName').text(selectDonor)
            });
        };
        let repeterRow = function () {
            $('.repeater').repeater({
                hide: function (e) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                position: 'top-end',
                                type: 'success',
                                title: 'Deleted',
                                showConfirmButton: false,
                                timer: 1000,
                            }) && $(this).slideUp(e);
// result.dismiss can be 'cancel', 'overlay',
// 'close', and 'timer'
                        } else if (result.dismiss === 'cancel') {
                            Swal.fire({
                                position: 'top-end',
                                type: 'error',
                                title: 'Not Deleted',
                                showConfirmButton: false,
                                timer: 1000
                            })
                        }
                    })
                },
// (Required if there is a nested repeater)
// Specify the configuration of the nested repeaters.
// Nested configuration follows the same format as the base configuration,
// supporting options "defaultValues", "show", "hide", etc.
// Nested repeaters additionally require a "selector" field.
                repeaters: [{
// (Required)
// Specify the jQuery selector for this nested repeater
                    selector: '.inner-repeater',
                    hide: function (e) {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then(function (result) {
                            if (result.value) {
                                Swal.fire({
                                    position: 'top-end',
                                    type: 'success',
                                    title: 'Deleted',
                                    showConfirmButton: false,
                                    timer: 500,
                                }) && $(this).slideUp(e);
// result.dismiss can be 'cancel', 'overlay',
// 'close', and 'timer'
                            } else if (result.dismiss === 'cancel') {
                                Swal.fire({
                                    position: 'top-end',
                                    type: 'error',
                                    title: 'Not Deleted',
                                    showConfirmButton: false,
                                    timer: 500
                                })
                            }
                        })
                    }
                }]
            });
        };
        let KTFormControls = function () {
// Private functions
            let demo1 = function () {
                $("#kt_form_1").validate({
// define validation rules
                    ignore: [],
                    rules: {
                        "outer_list[0][nameInAgreement]": {
                            required: true,
                            minlength: 4,
                            maxlength: 10
                        },
                        "outer_list[1][nameInAgreement]": {
                            required: true,
                            minlength: 4,
                            maxlength: 10
                        },
                        email: {
                            required: true,
                            email: true,
                            minlength: 10
                        },
                        url: {
                            required: true
                        },
                        digits: {
                            required: true,
                            digits: true
                        },
                        creditcard: {
                            required: true,
                            creditcard: true
                        },
                        phone: {
                            required: true,
                            phoneUS: true
                        },
                        option: {
                            required: true
                        },
                        options: {
                            required: true,
                            minlength: 2,
                            maxlength: 4
                        },
                        memo: {
                            required: true,
                            minlength: 10,
                            maxlength: 100
                        },

                        checkbox: {
                            required: true
                        },
                        checkboxes: {
                            required: true,
                            minlength: 1,
                            maxlength: 2
                        },
                        radio: {
                            required: true
                        }
                    },

//display error alert on form submit
                    invalidHandler: function (event, validator) {
                        let alert = $('#kt_form_1_msg');
                        alert.removeClass('kt--hide').show();
                        KTUtil.scrollTop();
                    },

                    submitHandler: function (form) {
//form[0].submit(); // submit the form
                    }
                });

            };

            let demo2 = function () {
                $("#kt_form_2").validate({
// define validation rules
                    rules: {
//= Client Information(step 3)
// Billing Information
                        billing_card_name: {
                            required: true
                        },
                        billing_card_number: {
                            required: true,
                            creditcard: true
                        },
                        billing_card_exp_month: {
                            required: true
                        },
                        billing_card_exp_year: {
                            required: true
                        },
                        billing_card_cvv: {
                            required: true,
                            minlength: 2,
                            maxlength: 3
                        },

// Billing Address
                        billing_address_1: {
                            required: true
                        },
                        billing_address_2: {},
                        billing_city: {
                            required: true
                        },
                        billing_state: {
                            required: true
                        },
                        billing_zip: {
                            required: true,
                            number: true
                        },

                        billing_delivery: {
                            required: true
                        }
                    },

//display error alert on form submit
                    invalidHandler: function (event, validator) {
                        swal.fire({
                            "title": "",
                            "text": "There are some errors in your submission. Please correct them.",
                            "type": "error",
                            "confirmButtonClass": "btn btn-secondary",
                            "onClose": function (e) {
                                console.log('on close event fired!');
                            }
                        });

                        event.preventDefault();
                    },

                    submitHandler: function (form) {
//form[0].submit(); // submit the form
                        swal.fire({
                            "title": "",
                            "text": "Form validation passed. All good!",
                            "type": "success",
                            "confirmButtonClass": "btn btn-secondary"
                        });

                        return false;
                    }
                });
            }

            return {
// public functions
                init: function () {
// demo0();
// demo1();
// demo2();
                }
            };
        }();
        let submitForm = function () {
            $("#submitForm").click(function () {
                $("#kt_form_1").submit();
            });
        };
        $(document).ready(function () {
            submitForm();
            repeterRow();
            addValidateClassToInput();
        });
    </script>
@stop
