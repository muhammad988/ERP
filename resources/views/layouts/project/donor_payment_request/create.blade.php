@extends('layouts.app')
@section('style')
    @include('layouts.include.style.style_form')
@stop
@section('content')
    <!-- begin:: Portlet -->
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Donor Payment Request
                            </h3>
                        </div>
                    </div>
                    <form class="kt-form kt-form--label" id="donorPaymentRequest">
                        <div class="kt-portlet__body">
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label class="form-control-label">Project name</label>
                                    <input type="text" name="projectName" class="form-control" placeholder="" value="">
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-control-label">Project code</label>
                                    <input type="text" name="projectCode" class="form-control" placeholder="" value="">
                                </div>
                                <div class="col-4">
                                    <label>Relief / Development</label>
                                    <div class="kt-radio-inline">
                                        <label class="kt-radio  kt-radio--brand">
                                            <input type="radio" name="reliefDevelopment"> Relief
                                            <span></span>
                                        </label>
                                        <label class="kt-radio  kt-radio--brand">
                                            <input type="radio" name="reliefDevelopment"> Development
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label class="form-control-label">Project license number</label>
                                    <input type="text" name="projectLicenseNumber" class="form-control" placeholder=""
                                           value="">
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-control-label">Project Location</label>
                                    <input type="text" name="projectLocation" class="form-control" placeholder=""
                                           value="">
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-control-label">Project Coordinates</label>
                                    <input type="text" name="projectCoordinates" class="form-control" placeholder=""
                                           value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label class="form-control-label">Donor</label>
                                    <select class="form-control" name="projectSelectDonor" id="projectSelectDonor">
                                        <option value="">Select Donor</option>
                                        <option value="QFFD">QFFD</option>
                                        <option value="OCHA">OCHA</option>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-control-label">Donor Financial Agreement File</label>
                                    <input type="text" name="projectDonorFinancialAgreementFile" readonly
                                           class="form-control" placeholder="" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label class="form-control-label">Project Executor</label>
                                    <select class="form-control" name="projectSelectExecutorPartner"
                                            id="projectSelectExecutorPartner">
                                        <option value="">Select Executor Partner</option>
                                        <option value="ACU">ACU</option>
                                        <option value="Saad">Saad</option>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-control-label">Executor reliance File</label>
                                    <input type="text" name="projectExecutorRelianceFile" readonly class="form-control"
                                           placeholder="" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-2">
                                    <label class="form-control-label">Project Total Budget</label>
                                    <input type="text" name="projectTotalBudget" readonly class="form-control"
                                           placeholder="" value="">
                                </div>
                                <div class="col-lg-2">
                                    <label class="form-control-label">Start Date</label>
                                    <input type="text" name="projectStartDate" readonly class="form-control"
                                           placeholder="" value="">
                                </div>
                                <div class="col-lg-2">
                                    <label class="form-control-label">End Date</label>
                                    <input type="text" name="projectEndDate" readonly class="form-control"
                                           placeholder="" value="">
                                </div>
                                <div class="col-lg-2">
                                    <label class="form-control-label">Duration</label>
                                    <input type="text" name="projectTotalDuration" readonly class="form-control"
                                           placeholder="" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-2">
                                    <label class="form-control-label">Number Of payments</label>
                                    <input type="text" name="projectNumberOfPayments" readonly class="form-control"
                                           placeholder="" value="">
                                </div>
                                <div class="col-lg-2">
                                    <label class="form-control-label">Payments Terms</label>
                                    <input type="text" name="projectPaymentsTerms" class="form-control" placeholder=""
                                           value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-2">
                                    <label class="form-control-label">Admin Cost</label>
                                    <input type="text" name="projectAdminCost" readonly class="form-control"
                                           placeholder="" value="">
                                </div>
                                <div class="col-lg-2">
                                    <label class="form-control-label">QRCS Admin Cost</label>
                                    <input type="text" name="projectQrcsAdminCost" readonly class="form-control"
                                           placeholder="" value="">
                                </div>
                                <div class="col-lg-2">
                                    <label class="form-control-label">Partner Admin Cost</label>
                                    <input type="text" name="projectPartnerAdminCost" readonly class="form-control"
                                           placeholder="" value="">
                                </div>
                                <div class="col-lg-2">
                                    <label class="form-control-label">Actual Progress Percentage</label>
                                    <input type="text" name="projectAcualProgressPercentage" readonly
                                           class="form-control" placeholder="" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label class="form-control-label">Offical name Of Recipient</label>
                                    <input type="text" name="projectOfficalNameOfRecipientEnglish" class="form-control"
                                           placeholder="">
                                </div>
                                <div class="col-lg-6">
                                    <label dir="rtl">إسم المستلم الرسمي</label>
                                    <input type="text" name="projectOfficalNameOfRecipientArabic" class="form-control"
                                           placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-3">
                                    <label class="form-control-label">Transfer To - Bank Name</label>
                                    <select class="form-control" name="projectSelectBankName"
                                            id="projectSelectBankName">
                                        <option value="">Select Bank</option>
                                        <option value="QNB-FİNANSBANK">QNB FİNANSBANK</option>
                                        <option value="Is-Bank">IS Bank</option>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-control-label">Bank Account Number</label>
                                    <select class="form-control" name="projectSelectBankAccountNumber"
                                            id="projectSelectBankAccountNumber">
                                        <option value="">Select Bank Account Number</option>
                                        <option value="1234567">1234567</option>
                                        <option value="7654321">7654321</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label class="form-control-label">Bank Address</label>
                                    <input type="text" name="projectBankAddress" class="form-control"
                                           placeholder="">
                                </div>
                                <div class="col-lg-6">
                                    <label>Swift Code</label>
                                    <input type="text" name="projectSwiftCode" class="form-control"
                                           placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label>Progress Reports</label>
                                    <div></div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input " id="projectProgressReport"
                                               name="projectProgressReport">
                                        <label class="custom-file-label" for="projectProgressReport">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-sm"></div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Secretary General Approval</label>
                                    <div class="kt-radio-inline">
                                        <label class="kt-radio  kt-radio--brand">
                                            <input type="radio" name="secretaryGeneralApproval"> Available
                                            <span></span>
                                        </label>
                                        <label class="kt-radio  kt-radio--brand">
                                            <input type="radio" name="secretaryGeneralApproval"> Not Available
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-control-label">Notes</label>
                                    <textarea type="text" name="secretaryGeneralApprovalNotes" class="form-control"
                                              placeholder=""></textarea>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-sm"></div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Project License</label>
                                    <div class="kt-radio-inline">
                                        <label class="kt-radio  kt-radio--brand">
                                            <input type="radio" name="projectLicense"> Available
                                            <span></span>
                                        </label>
                                        <label class="kt-radio  kt-radio--brand">
                                            <input type="radio" name="projectLicense"> Not Available
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-control-label">Notes</label>
                                    <textarea type="text" name="projectLicenseAvailableNotes" class="form-control"
                                              placeholder=""></textarea>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-sm"></div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Bank Account Certification</label>
                                    <div class="kt-radio-inline">
                                        <label class="kt-radio  kt-radio--brand">
                                            <input type="radio" name="projectBankAccountCertification"> Available
                                            <span></span>
                                        </label>
                                        <label class="kt-radio  kt-radio--brand">
                                            <input type="radio" name="projectBankAccountCertification"> Not Available
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-control-label">Notes</label>
                                    <textarea type="text" name="projectBankAccountCertificationNotes"
                                              class="form-control"
                                              placeholder=""></textarea>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-sm"></div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Executive Agreement adopted (Arabic)</label>
                                    <div class="kt-radio-inline">
                                        <label class="kt-radio  kt-radio--brand">
                                            <input type="radio" name="projectExecutiveAgreementAdopted"> Available
                                            <span></span>
                                        </label>
                                        <label class="kt-radio  kt-radio--brand">
                                            <input type="radio" name="projectprojectExecutiveAgreementAdopted"> Not
                                            Available
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label>Executive Agreement File</label>
                                    <div></div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input "
                                               id="projectExecutiveAgreementAdoptedFile"
                                               name="projectExecutiveAgreementAdoptedFile">
                                        <label class="custom-file-label" for="projectExecutiveAgreementAdoptedFile">Choose
                                            file</label>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <label class="form-control-label">Notes</label>
                                    <textarea type="text" name="projectprojectExecutiveAgreementAdoptedNotes"
                                              class="form-control"
                                              placeholder=""></textarea>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-sm"></div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Financial Agreement adopted (Arabic)</label>
                                    <div class="kt-radio-inline">
                                        <label class="kt-radio  kt-radio--brand">
                                            <input type="radio" name="projectFinancialAgreementAdopted"> Available
                                            <span></span>
                                        </label>
                                        <label class="kt-radio  kt-radio--brand">
                                            <input type="radio" name="projectFinancialAgreementAdopted"> Not Available
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label>Financial Agreement File</label>
                                    <div></div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input "
                                               id="projectFinancialAgreementAdoptedFile"
                                               name="projectFinancialAgreementAdoptedFile">
                                        <label class="custom-file-label" for="projectFinancialAgreementAdoptedFile">Choose
                                            file</label>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <label class="form-control-label">Notes</label>
                                    <textarea type="text" name="projectFinancialAgreementAdoptedNotes"
                                              class="form-control"
                                              placeholder=""></textarea>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th colspan="3" style="text-align: center">Previous Payments</th>
                                    <th colspan="3" style="text-align: center">Claims for work performed</th>
                                    <th rowspan="2" style="vertical-align: middle;text-align: center">Remaining $</th>
                                    <th rowspan="2" style="vertical-align: middle;text-align: center">Progress %</th>
                                    <th colspan="5" rowspan="2" style="vertical-align: middle;text-align: center">
                                        Notes
                                    </th>
                                </tr>
                                <tr>
                                    <th style="text-align: center">Payment No.</th>
                                    <th style="text-align: center">Date</th>
                                    <th style="text-align: center">Amount</th>
                                    <th style="text-align: center">Payment No.</th>
                                    <th style="text-align: center">Date</th>
                                    <th style="text-align: center">Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>nnn</td>
                                    <td>nnn</td>
                                    <td>nnn</td>
                                    <td>nnn</td>
                                    <td>nnn</td>
                                    <td>nnn</td>
                                    <td>nnn</td>
                                    <td>nnn</td>
                                    <td>Note Note Note Note Note</td>
                                </tr>
                                <tr>
                                    <td>nnn</td>
                                    <td>nnn</td>
                                    <td>nnn</td>
                                    <td>nnn</td>
                                    <td>nnn</td>
                                    <td>nnn</td>
                                    <td>nnn</td>
                                    <td>nnn</td>
                                    <td>Note Note Note Note Note</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="kt-portlet__foot">
                            <div class="row">
                                <div class="col-6 ">
                                    <a href="#" id="submitForm" type="submit" class="btn btn-sm btn-label-success btn-bold">
                                        <i class="la la-save"></i>Save
                                    </a>
                                </div>
                                <div class="col-5 kt-align-right">
                                    <a type="reset" class="btn btn-sm btn-bold btn-label-warning">
                                        <i class="la la-rotate-right"></i> Reset
                                    </a>
                                </div>
                                <div class="col-1 kt-align-right">
                                    <a type="reset" class="btn btn-bold btn-sm btn-label-danger">
                                        <i class="la la-close"></i>Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end:: Portlet -->
@stop
@section('script')
    @include('layouts.include.script.script_jquery_form')
    <script>
        $(document).ready(function () {

        });
    </script>
@stop
