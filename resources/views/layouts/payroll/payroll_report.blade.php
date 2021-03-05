@extends('layouts.app')
@section('style')
    @include('layouts.include.style.style_form')
    <link href="/css/dual-listbox.css" rel="stylesheet">
@stop
@section('content')
    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="col-lg-12">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h1 class="kt-portlet__head-title">
                            Payroll
                        </h1>
                    </div>
                </div>
                <!--begin::Form-->
                <form method="POST" action="{{route('payroll.store_payroll_report')}}"
                      class="kt-form kt-form--label-right" id="kt_form_2" novalidate="novalidate">
                    @csrf
                    <div class="kt-portlet__body">
                        <div class="kt-section">
                            <h3 class="kt-section__title kt-margin-b-20">
                                Payroll Information<span class="required"> *</span>
                            </h3>
                            <div class="kt-section__content">
                                <div class="form-group row">
                                    <div class="form-group col-lg-2">
                                        <label class="form-control-label">Report Name<span
                                                class="required"> *</span></label>
                                        <input required type="text" name="name_en" id="name_en" class="form-control" value="">
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <label class="form-control-label">Year<span class="required"> *</span></label>
                                        <select class="form-control" name="year" id="year">
                                            <option value="">Please Select</option>
                                            <option value="2019">2019</option>
                                            <option value="2020">2020</option>
                                            <option value="2021">2021</option>
                                            <option value="2022">2022</option>
                                            <option value="2023">2023</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <label class="form-control-label">Month<span class="required"> *</span></label>
                                        <select class="form-control" name="month" id="month">
                                            <option value="">Please Select</option>
                                            <option value="01">January</option>
                                            <option value="02">February</option>
                                            <option value="03">March</option>
                                            <option value="04">April</option>
                                            <option value="05">May</option>
                                            <option value="06">June</option>
                                            <option value="07">July</option>
                                            <option value="08">August</option>
                                            <option value="09">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label class="form-control-label">Description<span
                                                class="required"> *</span></label>
                                        <input required class="form-control" name="description" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="kt-separator kt-separator--border-dashed kt-separator--space-xl"></div>
                        <div class="kt-section">
                            <h3 class="kt-section__title">
                                List of Employees
                            </h3>
                            <div class="kt-section__content">
                                <div class="form-group row">
                                    <div class="col-lg-3 form-group-sub">
                                        <label class="form-control-label">Mission</label>
                                        <select class="form-control select2" name="mission_id" id="mission_id">
                                            <option value="" selected>Please Select</option>
                                            @foreach ($missions as $mission)
                                                <option value="{{$mission->id}}">{{$mission->name_en}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3 form-group-sub">
                                        <label class="form-control-label">Department</label>
                                        <select class="form-control select2" name="department_id" id="department_id">
                                            <option value="" selected>Please Select</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3 form-group-sub">
                                        <label class="form-control-label">Project</label>
                                        <select class="form-control select2" name="project_id" id="project_id">
                                            <option value="" selected>Please Select</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3col-md-1 align-self-end">
                                        <button type="button" id="filter" class="btn btn-brand"> Apply Filters</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="kt-portlet__body">
                                <h5 class="subtitle">Search<span class="source" data-source="dlb1"> For Employees</span>
                                </h5>
                                <select class="select1" name="users[]" id="user_id" multiple>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6"></div>
                            <div class="col-lg-6">
                                <a id="save" class="btn btn-label-primary btn-bold"><i class="la la-save"></i>Save</a>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="submit" data-ktwizard-type="action-submit"
                                            class="btn btn-sm btn-label-success btn-bold">
                                        <i class="la la-save"></i>
                                        @lang('common.submit')
                                    </button>
                                    <a href="/" class="btn btn-bold btn-sm btn-label-danger">
                                        <i class="la la-close"></i>
                                        @lang('common.cancel')
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!--end::Form-->
            </div>
            <!--end::Portlet-->
        </div>
    </div>
    <!-- end:: Content -->
@stop
@section('script')
    @include('layouts.include.script.script_jquery_form')
    {!! Html::script('assets/js/demo2/pages/crud/forms/validation/form-controls-payroll-report.js') !!}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.8.1/prism.min.js"></script>
    <script src="/js/dist/dual-listbox.js"></script>
    <script>
        var dlb1 = new DualListbox('.select1');

        var sources = document.querySelectorAll('.source');
        for (var i = 0; i < sources.length; i++) {
            var source = sources[i]
            source.addEventListener('click', function () {
                var code = document.querySelector('.' + source.dataset.source);
                code.classList.toggle('open')
            })
        }
    </script>

    <script>
        $(document).ready(function () {
            // IF mission filter is selected
            $("#mission_id").change(function () {
                // remove the previous data
                $("#department_id").html('<option value="">Please Select</option>');
                $("#project_id").html('<option value="">Please Select</option>');

                // bring department list for the selected mission
                if ($("#mission_id").val()) {
                    $.get('/payroll/getdepartment/' + $("#mission_id").val(), function (data) {
                        if (data) {
                            for (let i = 0; i < data.length; i++) {
                                $("#department_id").append('<option value="' + data[i].id + '">' + data[i].name_en + '</option>')
                            }
                        }
                    });
                }
            });

            // IF department filter is selected
            $("#department_id").change(function () {
                // remove the previous data
                $("#project_id").html('<option value="">Please Select</option>');

                // bring project list for the selected department
                if ($("#department_id").val()) {
                    $.get('/payroll/getproject/' + $("#department_id").val(), function (data) {
                        if (data) {
                            for (let i = 0; i < data.length; i++) {
                                $("#project_id").append('<option value="' + data[i].id + '">' + data[i].name_en + '</option>')
                            }
                        }
                    });
                }
            });

            $("#year").change(function () {

                // Reset mission, department and project filters once the year is changed
                $("#mission_id").prop("selectedIndex", 0);
                $("#mission_id").select2({
                    nitSelection: function (element, callback) {
                    }
                });

                $("#department_id").prop("selectedIndex", 0);
                $("#department_id").select2({
                    nitSelection: function (element, callback) {
                    }
                });

                $("#project_id").prop("selectedIndex", 0);
                $("#project_id").select2({
                    nitSelection: function (element, callback) {
                    }
                });

                if ($("#year").val() && $("#month").val()) {
                    get_user_list();
                }
            });
            $("#month").change(function () {
                if ($("#year").val() && $("#month").val()) {
                    get_user_list();
                }
            });

            function get_user_list() {
                $.get('get_user_list/' + $("#year").val() + '-' + $("#month").val() + '-01', function (data) {
                    if (data) {
                        $("#user_id").html('');
                        for (let i = 0; i < data.length; i++) {
                            if (data[i].first_name_ar) {
                                $("#user_id").append('<option value="' + data[i].id + '">' + data[i].first_name_en + " " + data[i].last_name_en + " - " +
                                    data[i].first_name_ar + " " + data[i].last_name_ar + " - " +
                                    data[i].position + '</option>');
                            } else {
                                $("#user_id").append('<option value="' + data[i].id + '">' + data[i].first_name_en + " " + data[i].last_name_en + " - " +
                                    data[i].position + '</option>');
                            }
                        }
                        $('.dual-listbox').empty();
                        new DualListbox('.select1');
                    }
                });
            }

            $("#filter").click(function () {
                if ($("#year").val() && $("#month").val()) {
                    if ($("#project_id").val()) {
                        $.get('users_by_project/' + $("#project_id").val() + '/' + $("#year").val() + '-' + $("#month").val() + '-01', function (data) {
                            if (data) {
                                $("#user_id").html('');
                                for (let i = 0; i < data[0].length; i++) {
                                    if (data[0][i].first_name_ar) {
                                        $("#user_id").append('<option value="' + data[0][i].id + '">' + data[0][i].first_name_en + " " + data[0][i].last_name_en + " - " +
                                            data[0][i].first_name_ar + " " + data[0][i].last_name_ar + " - " +
                                            data[0][i].position + '</option>');
                                    } else {
                                        $("#user_id").append('<option value="' + data[0][i].id + '">' + data[0][i].first_name_en + " " + data[0][i].last_name_en + " - " +
                                            data[0][i].position + '</option>');
                                    }
                                }

                                for (let i = 0; i < data[1].length; i++) {
                                    if (data[1][i].first_name_ar) {
                                        $("#user_id").append('<option value="' + data[1][i].id + '" selected>' + data[1][i].first_name_en + " " + data[1][i].last_name_en + " - " +
                                            data[1][i].first_name_ar + " " + data[1][i].last_name_ar + " - " +
                                            data[1][i].position + '</option>');
                                    } else {
                                        $("#user_id").append('<option value="' + data[1][i].id + '" selected>' + data[1][i].first_name_en + " " + data[1][i].last_name_en + " - " +
                                            data[1][i].position + '</option>');
                                    }
                                }
                                $('.dual-listbox').empty();
                                new DualListbox('.select1');
                            }
                        });
                    } else if ($("#department_id").val()) {
                        $.get('users_by_department/' + $("#mission_id").val() + '/' + $("#department_id").val() + '/' + $("#year").val() + '-' + $("#month").val() + '-01', function (data) {
                            if (data) {
                                $("#user_id").html('');
                                for (let i = 0; i < data[0].length; i++) {
                                    if (data[0][i].first_name_ar) {
                                        $("#user_id").append('<option value="' + data[0][i].id + '">' + data[0][i].first_name_en + " " + data[0][i].last_name_en + " - " +
                                            data[0][i].first_name_ar + " " + data[0][i].last_name_ar + " - " +
                                            data[0][i].position + '</option>');
                                    } else {
                                        $("#user_id").append('<option value="' + data[0][i].id + '">' + data[0][i].first_name_en + " " + data[0][i].last_name_en + " - " +
                                            data[0][i].position + '</option>');
                                    }
                                }

                                for (let i = 0; i < data[1].length; i++) {
                                    if (data[1][i].first_name_ar) {
                                        $("#user_id").append('<option value="' + data[1][i].id + '" selected>' + data[1][i].first_name_en + " " + data[1][i].last_name_en + " - " +
                                            data[1][i].first_name_ar + " " + data[1][i].last_name_ar + " - " +
                                            data[1][i].position + '</option>');
                                    } else {
                                        $("#user_id").append('<option value="' + data[1][i].id + '" selected>' + data[1][i].first_name_en + " " + data[1][i].last_name_en + " - " +
                                            data[1][i].position + '</option>');
                                    }
                                }
                                $('.dual-listbox').empty();
                                new DualListbox('.select1');
                            }
                        });
                    } else if ($("#mission_id").val()) {
                        $.get('users_by_mission/' + $("#mission_id").val() + '/' + $("#year").val() + '-' + $("#month").val() + '-01', function (data) {
                            if (data) {
                                $("#user_id").html('');
                                for (let i = 0; i < data[0].length; i++) {
                                    if (data[0][i].first_name_ar) {
                                        $("#user_id").append('<option value="' + data[0][i].id + '">' + data[0][i].first_name_en + " " + data[0][i].last_name_en + " - " +
                                            data[0][i].first_name_ar + " " + data[0][i].last_name_ar + " - " +
                                            data[0][i].position + '</option>');
                                    } else {
                                        $("#user_id").append('<option value="' + data[0][i].id + '">' + data[0][i].first_name_en + " " + data[0][i].last_name_en + " - " +
                                            data[0][i].position + '</option>');
                                    }
                                }

                                for (let i = 0; i < data[1].length; i++) {
                                    if (data[1][i].first_name_ar) {
                                        $("#user_id").append('<option value="' + data[1][i].id + '" selected>' + data[1][i].first_name_en + " " + data[1][i].last_name_en + " - " +
                                            data[1][i].first_name_ar + " " + data[1][i].last_name_ar + " - " +
                                            data[1][i].position + '</option>');
                                    } else {
                                        $("#user_id").append('<option value="' + data[1][i].id + '" selected>' + data[1][i].first_name_en + " " + data[1][i].last_name_en + " - " +
                                            data[1][i].position + '</option>');
                                    }
                                }
                                $('.dual-listbox').empty();
                                new DualListbox('.select1');
                            }
                        });
                    }
                }

            });

            $("#save").click(function () {
                var user = $("#user_id").val();
                $.post('/payroll/save_users_list', {user_id: user}, function (data) {
                });
            });
        });
    </script>
@stop
