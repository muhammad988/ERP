@extends('layouts.app')
@section('style')
    @include('layouts.include.style.style_form')
@stop
@section('content')
    <!-- begin:: Content -->
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-12">
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <div class="kt-portlet__head-title">
                                Donor Operation Ongoing
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <!-- begin of accordion -->
                        <div class="accordion  accordion-toggle-arrow" id="accordionExample1">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseOne1"
                                         aria-expanded="false" aria-controls="collapseOne1">
                                        Donor One
                                    </div>
                                </div>
                                <div id="collapseOne1" class="collapse" aria-labelledby="headingOne"
                                     data-parent="#accordionExample1" style>
                                    <div class="row col-12">
                                        <div class="card-body">
                                            <div class="accordion  accordion-light  accordion-toggle-plus" id="donor1Accordion1">
                                                <div class="card">
                                                    <div class="card-header" id="donor1headingOne">
                                                        <div class="card-title collapsed" data-toggle="collapse"
                                                             data-target="#donor1Collapse1" aria-expanded="false"
                                                             aria-controls="donor1Collapse1">
                                                            Information
                                                        </div>
                                                    </div>
                                                    <div id="donor1Collapse1" class="collapse"
                                                         aria-labelledby="donor1headingOne"
                                                         data-parent="#donor1Accordion1" style>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="kt-section kt-section--first">
                                                                        <div class="kt-section__body">
                                                                            <div class="row col-12">
                                                                                <div class="form-group col-4">
                                                                                    <div class="col-12">
                                                                                        <label class="col-12 col-form-label">Project
                                                                                            Donor</label>
                                                                                        <input class="form-control donorName" readonly
                                                                                               id="donorName"
                                                                                               type="text"
                                                                                               name="donorName" value="QFFD">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group col-4">
                                                                                    <div class="col-12">
                                                                                        <label class="col-12 col-form-label">Project
                                                                                            Name in
                                                                                            Agreement</label>
                                                                                        <input class="form-control nameInAgreement" readonly
                                                                                               id="nameInAgreement"
                                                                                               type="text"
                                                                                               name="nameInAgreement" value="Project name">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group col-4">
                                                                                    <div class="col-12">
                                                                                        <label class="col-12 col-form-label">Project
                                                                                            Code in
                                                                                            Agreement</label>
                                                                                        <input class="form-control codeInAgreement" readonly
                                                                                               id="codeInAgreement"
                                                                                               type="text"
                                                                                               name="codeInAgreement" value="Project Code">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                                                                            <div class="form-group row">
                                                                                <div class="col-2">
                                                                                    <label class="col-12 col-form-label">Monetary
                                                                                        Donation</label>
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                           name="monetaryDonation"
                                                                                           readonly
                                                                                           aria-describedby="basic-addon1">
                                                                                </div>
                                                                                <div class="col-2">
                                                                                    <label class="col-12 col-form-label">In-kind
                                                                                        Donation</label>
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                           readonly name="inKindDonation"
                                                                                           aria-describedby="basic-addon1">
                                                                                </div>
                                                                                <div class="col-2">
                                                                                    <label class="col-12 col-form-label">Total</label>
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                           readonly
                                                                                           name="monetaryInKindTotal"
                                                                                           aria-describedby="basic-addon1">
                                                                                </div>
                                                                            </div>
                                                                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                                                                            <!-- files Attachements-->
                                                                            <div class="form-group row">
                                                                                <!-- RACA -->
                                                                                <div class="col-6">
                                                                                    <label>RACA</label>
                                                                                    <div></div>
                                                                                    <div class="custom-file">
                                                                                        <input type="file"
                                                                                               class="custom-file-input "
                                                                                               id="customFile"
                                                                                               name="racaAttachement">
                                                                                        <label class="custom-file-label"
                                                                                               for="customFile">Choose
                                                                                            file</label>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- Donor Agreement -->
                                                                                <div class="col-6">
                                                                                    <label>Donor Agreement</label>
                                                                                    <div></div>
                                                                                    <div class="custom-file">
                                                                                        <input type="file"
                                                                                               class="custom-file-input racaAttachement"
                                                                                               id="customFile"
                                                                                               name="donorAgreementAttachement">
                                                                                        <label class="custom-file-label"
                                                                                               for="customFile">Choose
                                                                                            file</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <!-- Proposal -->
                                                                                <div class="col-6">
                                                                                    <label>Proposal</label>
                                                                                    <div></div>
                                                                                    <div class="custom-file">
                                                                                        <input type="file"
                                                                                               class="custom-file-input"
                                                                                               id="customFile"
                                                                                               name="proposalAttachement">
                                                                                        <label class="custom-file-label"
                                                                                               for="customFile">Choose
                                                                                            file</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <!-- Budget -->
                                                                                    <label>Budget</label>
                                                                                    <div></div>
                                                                                    <div class="custom-file">
                                                                                        <input type="file"
                                                                                               class="custom-file-input"
                                                                                               id="customFile"
                                                                                               name="budgetAttachement">
                                                                                        <label class="custom-file-label"
                                                                                               for="customFile">Choosee
                                                                                            file</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row last row">
                                                                                <!-- Delegation -->
                                                                                <div class="col-6">
                                                                                    <label>Delegation</label>
                                                                                    <div></div>
                                                                                    <div class="custom-file">
                                                                                        <input type="file"
                                                                                               class="custom-file-input"
                                                                                               id="customFile"
                                                                                               name="delegationAttachement">
                                                                                        <label class="custom-file-label"
                                                                                               for="customFile">Choose
                                                                                            file</label>
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
                                                <div class="card">
                                                    <div class="card-header" id="donor1headingTwo">
                                                        <div class="card-title collapsed" data-toggle="collapse"
                                                             data-target="#donor1Collapse2" aria-expanded="false"
                                                             aria-controls="donor1Collapse2">
                                                            Agreed Reports
                                                        </div>
                                                    </div>
                                                    <div id="donor1Collapse2" class="collapse"
                                                         aria-labelledby="donor1headingTwo"
                                                         data-parent="#donor1Accordion1" style>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="kt-section">
                                                                        <div class="kt-section__body">
                                                                            <div class="row inner-repeater">
                                                                                <div class="row col-12"
                                                                                     data-repeater-list="donorAgreedReports-list">
                                                                                    <div class="row col-12"
                                                                                         data-repeater-item>
                                                                                        <div class="form-group col-3">
                                                                                            <div class="kt-form__group--inline">
                                                                                                <div class="kt-form__label">
                                                                                                    <label>Report
                                                                                                        Type</label>
                                                                                                </div>
                                                                                                <select class="form-control selecReportType"
                                                                                                        name="selecReportType">
                                                                                                    <option value="">
                                                                                                        Pleasey
                                                                                                        select
                                                                                                    </option>
                                                                                                    <option value="monthly">
                                                                                                        Monthly
                                                                                                    </option>
                                                                                                    <option value="Yearly">
                                                                                                        Yearly
                                                                                                    </option>
                                                                                                </select>
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
                                                                                                       name="reportName">
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
                                                                                                       name="reportDueDate">
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
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header" id="donor1headingThree">
                                                        <div class="card-title collapsed" data-toggle="collapse"
                                                             data-target="#donor1Collapse3" aria-expanded="false"
                                                             aria-controls="donor1Collapse3">
                                                            Agreed Payments
                                                        </div>
                                                    </div>
                                                    <div id="donor1Collapse3" class="collapse"
                                                         aria-labelledby="donor1headingThree"
                                                         data-parent="#donor1Accordion1" style>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="kt-section kt-section--last">
                                                                        <div class="kt-section__body">
                                                                            <div class="row inner-repeater">
                                                                                <div class="row col-12"
                                                                                     data-repeater-list="donorAgreedPayments-list">
                                                                                    <div class="row col-12"
                                                                                         data-repeater-item>
                                                                                        <div class="form-group col-3">
                                                                                            <div class="kt-form__group--inline">
                                                                                                <div class="kt-form__label">
                                                                                                    <label>Payment
                                                                                                        Number</label>
                                                                                                </div>
                                                                                                <select class="form-control paymentNumber"
                                                                                                        type="text"
                                                                                                        name="paymentNumber">
                                                                                                    <option value="">Select
                                                                                                        Payment Number
                                                                                                    </option>
                                                                                                    <option value="first">
                                                                                                        first
                                                                                                    </option>
                                                                                                    <option value="second">
                                                                                                        second
                                                                                                    </option>
                                                                                                </select>
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
                                                                                                       name="paymentDueDate">
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
                                                                                                   name="agreedAmountOfMoney">
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
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer"></div>
                                </div>
                            </div>
                        </div>
                        <!-- end of accordion -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end:: Content -->
@stop
@section('script')
    @include('layouts.include.script.script_jquery_form')
    <script>

        $(document).ready(function () {

        });
    </script>
@stop
