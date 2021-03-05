@extends('layouts.app')
@section('style')
    @include('layouts.include.style.style_form')
    {!! Html::style('assets/app/custom/wizard/wizard-v1.demo2.css') !!}
@stop
@section('content')
    <!-- begin:: Content -->
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <!--begin::Portlet-->
        <form method="POST" action="{{route('transfer.store')}} " class="kt-form kt-form--label-right" id="formTransfer">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="kt-portlet">
                        <div class="row col-lg-12">
                            <div class=" col-lg-6 kt-portlet__head">
                                <div class="kt-portlet__head-label col-lg-3">
                                    <h4 class="kt-portlet__head-title">
                                        From Project:
                                    </h4>
                                </div>
                                <div class="kt-portlet__head-label col-lg-9 ">
                                    <div class="kt-portlet__head-title col-lg-12">
                                        {!! Form::select ('transferred_from',$projects , null ,['class'=>'form-control kt-bootstrap-select','id'=>'selectFromProject']) !!}
                                    </div>
                                </div>
                            </div>
                            <div style="border-left: 1px solid #ebedf2"></div>
                            <div class=" col-lg-5 kt-portlet__head">
                                <div class="kt-portlet__head-label col-lg-3">
                                    <h4 class="kt-portlet__head-title">
                                        To Project:
                                    </h4>
                                </div>
                                <div class="kt-portlet__head-label col-lg-9 ">
                                    <div class="kt-portlet__head-title col-lg-12">
                                        {!! Form::select ('project_id',$projects , null ,['class'=>'form-control kt-bootstrap-select','id'=>'selectToProject']) !!}

                                        {{--                                    <select class="form-control kt-bootstrap-select" name="selectToProject"--}}
                                        {{--                                            id="selectToProject">--}}
                                        {{--                                        <option value="">Select project</option>--}}
                                        {{--                                        <option value="project1">Project 1</option>--}}
                                        {{--                                        <option value="project2">Project 2</option>--}}
                                        {{--                                        <option value="project3">Project 3</option>--}}
                                        {{--                                    </select>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--begin::Form-->
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-6">
                                <label>Department Code</label>
                                <input type="text" name="fromDepartmentCode" class="form-control col-4" placeholder="50" readonly>
                            </div>
                            <div style="border-left: 1px solid #ebedf2"></div>
                            <div class="col-lg-5">
                                <label>Department Code</label>
                                <input type="text" name="toDepartmentCode" class="form-control col-5" placeholder="50" readonly>
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-6">
                                <label class="">Department</label>
                                <input type="text" class="form-control col-lg-10" readonly name="fromDepartmentName" placeholder="Relief and Development - Turkey">
                            </div>
                            <div style="border-left: 1px solid #ebedf2"></div>
                            <div class="col-lg-5">
                                <label class="">Department</label>
                                <input type="text" class="form-control col-lg-12" readonly name="toDepartmentName" placeholder="Relief and Development - Turkey">
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-6">
                                <label>Project Code</label>
                                <input type="text" id="from_code" name="fromProjectCode" class="form-control col-4" placeholder="FSL-2018-TR" readonly>
                            </div>
                            <div style="border-left: 1px solid #ebedf2"></div>
                            <div class="col-lg-5">
                                <label>Project Code</label>
                                <input type="text" id="to_code" name="toProjectCode" class="form-control col-5" placeholder="Shelter-2018-TR" readonly>
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-6">
                                <label class="">Project Name</label>
                                <input type="text" class="form-control col-lg-10" id="from_name" readonly name="fromProjectName" placeholder="Name">
                            </div>
                            <div style="border-left: 1px solid #ebedf2"></div>
                            <div class="col-lg-5">
                                <label class="">Project Name</label>
                                <input type="text" class="form-control col-lg-12" id="to_name" readonly name="toProjectName" placeholder="Name">
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-6">
                                <label class="">Approved Project Budget</label>
                                <input type="number" class="form-control col-lg-10" id="from_budget" readonly name="fromApprovedProjectBudget" value="0">
                            </div>
                            <div style="border-left: 1px solid #ebedf2"></div>
                            <div class="col-lg-5">
                                <label class="">Approved Project Budget</label>
                                <input type="number" class="form-control col-lg-12" id="to_budget" readonly name="toApprovedProjectBudget" value="0">
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-6">
                                <label class="">Amount Transfer from Project</label>
                                <input type="number" class="form-control col-lg-10" name="fromAmountTransfer" id="from_amount_transfer" placeholder="Specify Requested amount">
                            </div>
                            <div style="border-left: 1px solid #ebedf2"></div>
                            <div class="col-lg-5">
                                <label class="">Amount Transfer to Project</label>
                                <input type="number" class="form-control col-lg-12" readonly name="toAmountTransfer" id="to_amount_transfer" placeholder="">
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-6">
                                <label class="">Balance after Deduction from Project</label>
                                <input type="text" class="form-control col-lg-10" readonly name="fromBalanceAfterDeduction" id="fromBalanceAfterDeduction">
                            </div>
                            <div style="border-left: 1px solid #ebedf2"></div>
                            <div class="col-lg-5">
                                <label class="">Balance after addition To Project</label>
                                <input type="text" class="form-control col-lg-12" readonly name="toBalanceAfterAddtion" id="toBalanceAfterAddtion">
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-6">
                                <label class="">Explanation</label>
                                <textarea type="text" class="form-control col-lg-10" name="fromExplanation"></textarea>
                            </div>
                            <div style="border-left: 1px solid #ebedf2"></div>
                            <div class="col-lg-5">
                                <label class="">Explanation</label>
                                <textarea type="text" class="form-control col-lg-12" name="toExplanation"></textarea>
                            </div>
                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <a href="#" id="transferSubmit" type="submit"
                                           class="btn btn-sm btn-label-success btn-bold">
                                            <i class="la la-save"></i>Submit
                                        </a>
                                    </div>
                                    <div class="col-lg-6 kt-align-right">
                                        <a href="#" type="reset" class="btn btn-bold btn-sm btn-label-danger">
                                            <i class="la la-close"></i>Cancel
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
        </form>
        <!--end::Form-->
    </div>
    </div>
    </div>
    </div>
    <!-- end:: Content -->
@stop
@section('script')
    @include('layouts.include.script.script_jquery_form')
    <script>
        let fromAmountToAmount = function () {
            $('#from_amount_transfer').blur(function () {
                let fromAmountTransfer = $('#from_amount_transfer').val();
                $('#to_amount_transfer').val(fromAmountTransfer);
                let approvedFromBudget = $('#from_budget').val();
                let approvedToBudget = parseFloat($('#to_budget').val());
                let amountTransferFrom = $('#from_amount_transfer').val();
                let amountTrasferTo = parseFloat($('#to_amount_transfer').val());
                let additionAmount = approvedToBudget + amountTrasferTo;
                $('#fromBalanceAfterDeduction').val(approvedFromBudget - amountTransferFrom);
                $('#toBalanceAfterAddtion').val(additionAmount);
            })
        };
        let fromProject = function () {
            $('#selectFromProject').change(function () {
                let fromProjectValue = $('#selectFromProject').val();
                $.ajax({
                    url: `/project/info/${fromProjectValue}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function (project) {
                        $('#from_name').val(project.name_en);
                        $('#from_code').val(project.code);
                        $('#from_budget').val(project.project_budget);
                    }
                });
            });
            $('#selectToProject').change(function () {
                let toProjectValue = $('#selectToProject').val();
                $.ajax({
                    url: `/project/info/${toProjectValue}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function (project) {
                        $('#to_name').val(project.name_en);
                        $('#to_code').val(project.code);
                        $('#to_budget').val(project.project_budget);
                    }
                });
                // $('#toProjectName').val(toProjectValue)
            })
        };
        let formValidation = function () {
            $('#formTransfer').validate({
                rules: {
                    fromProjectName: {
                        required: true
                    },
                    toProjectName: {
                        required: true
                    },
                    fromAmountTransfer: {
                        required: true
                    }
                },
                messages: {
                    fromProjectName: 'Please Select From Which project you wish to transfer from',
                    toProjectName: 'Please Select To Which project you wish to transfer to',
                    fromAmountTransfer: 'Please enter Amount requiered'
                },
                invalidHandler: function (form, validator) {

                    if (!validator.numberOfInvalids())
                        return;

                    $('html, body').animate({
                            scrollTop: $(validator.errorList[0].element).offset().top,
                        }, 1000, console.log($(validator.errorList[0].element).offset().top)
                    );

                }
            })
        };
        let transferSubmit = function () {
            $('#transferSubmit').click(function () {
                $('#formTransfer').submit();
            })
        };
        let balanceAfterDeduction = function () {
            let appovedFromBudget = $('#fromApprovedProjectBudget').val();
            let amountTransferFrom = $('#fromAmountTransfer').val();
            $('#fromBalanceAfterDeduction').val(appovedFromBudget - amountTransferFrom)
        };
        $(document).ready(function () {
            fromAmountToAmount();
            formValidation();
            transferSubmit();
            fromProject();
        })
    </script>

@stop
