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
                <form class="kt-form kt-form--label-right" id="kt_form_2" novalidate="novalidate">
                    <div class="kt-portlet__body">
                        <div class="kt-section">
                            <h3 class="kt-section__title kt-margin-b-20">
                                Payroll Information<span class="required"> *</span>
                            </h3>
                            <div class="kt-section__content">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <th>Report Name</th>
                                        <th>Year</th>
                                        <th>Month</th>
                                        <Th>Description</Th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{$payroll_report->name_en}}</td>
                                            <td>{{\Carbon\Carbon::parse($payroll_report->month)->format('Y')}}</td>
                                            <td>{{\Carbon\Carbon::parse($payroll_report->month)->format('M')}}
                                                <input type="text" id="month" value="{{$payroll_report->month}}" hidden>
                                                <input type="text" id="payroll_report_id" value="{{$payroll_report->id}}" hidden>
                                            </td>
                                            <td>{{$payroll_report->description}}</td>
                                        </tr>
                                    </tbody>
                                </table>
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
                                        <label class="form-control-label">Mission<span class="required"> *</span></label>
                                        <select class="form-control select2" name="mission_id" id="mission_id" required>
                                            <option value="" selected>Please Select</option>
                                            @foreach ($missions as $mission)
                                                <option value="{{$mission->id}}">{{$mission->name_en}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3 form-group-sub">
                                        <label class="form-control-label">Department<span class="required"> *</span></label>
                                        <select class="form-control select2" name="department_id" id="department_id" required>
                                            <option value="" selected>Please Select</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3 form-group-sub">
                                        <label class="form-control-label">Project<span class="required"> *</span></label>
                                        <select class="form-control select2" name="project_id" id="project_id" required>
                                            <option value="" selected>Please Select</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3 form-group">
                                        <input type="button" id="filter" class="btn btn-brand align-items-end" value="Apply Filters">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="kt-portlet__body">
                                <h5 class="subtitle">Search<span class="source" data-source="dlb1"> For Employees</span></h5>
                                <select class="select1" id="user_id" multiple>
                                    @foreach ($payroll_report_users as $payroll_report_user)
                                        <option value="{{$payroll_report_user->id}}" selected>{{$payroll_report_user->first_name_en .' '. $payroll_report_user->last_name_en .' - '.
                                        $payroll_report_user->first_name_ar .' '. $payroll_report_user->last_name_ar .' - '.
                                        $payroll_report_user->position}}</option>
                                    @endforeach
                                    @foreach ($users as $user)
                                    <option value="{{$user->id}}">{{$user->first_name_en .' '. $user->last_name_en .' - '.
                                            $user->first_name_ar .' '. $user->last_name_ar .' - '.
                                            $user->position}}</option>
                                    @endforeach
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
                                    <a href="#" id="submitForm" type="submit"
                                        class="btn btn-label-primary btn-bold">
                                        <i class="la la-check"></i>Submit
                                    </a>
                                    <a href="#" id="submitForm" type="submit"
                                        class="btn btn-label-warning btn-bold">
                                        <i class="la la-remove"></i>Cancel
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.8.1/prism.min.js"></script>
    <script src="/js/dist/dual-listbox.js"></script>
    <script>
    var dlb1 = new DualListbox('.select1');

    var sources = document.querySelectorAll('.source');
    for(var i = 0; i < sources.length; i++) {
        var source = sources[i]
        source.addEventListener('click', function(){
            var code = document.querySelector('.' + source.dataset.source);
            code.classList.toggle('open')
        })
    }
    </script>

    <script>
        $(document).ready(function (){
            // IF mission filter is selected
            $("#mission_id").change(function (){
                // remove the previous data
                $("#department_id").html('<option value="">Please Select</option>');
                $("#project_id").html('<option value="">Please Select</option>');

                // bring department list for the selected mission
                if( $("#mission_id").val()){
                    $.get('/payroll/getdepartment/' + $("#mission_id").val(), function(data){
                        if (data){
                            for (let i = 0; i < data.length; i++) {
                                $("#department_id").append('<option value="'+ data[i].id +'">'+ data[i].name_en +'</option>')
                            }
                        }
                    });
                }
            });

            // IF department filter is selected
            $("#department_id").change(function (){
                // remove the previous data
                $("#project_id").html('<option value="">Please Select</option>');

                // bring project list for the selected department
                if( $("#department_id").val()){
                    $.get('/payroll/getproject/' + $("#department_id").val(), function(data){
                        if (data){
                            for (let i = 0; i < data.length; i++) {
                                $("#project_id").append('<option value="'+ data[i].id +'">'+ data[i].name_en +'</option>')
                            }
                        }
                    });
                }
            });

            $("#filter").click(function(){
                if($("#project_id").val()){
                $.get('/payroll/users_project/' + $("#project_id").val() + '/' + $("#month").val(), function(data){
                    if(data)
                    {
                        $("#user_id").html('');
                        console.log("Clean");
                        for (let i = 0; i < data[0].length; i++) {
                            if(data[0][i].first_name_ar)
                            {
                                $("#user_id").append('<option value="'+data[0][i].id+'">' +data[0][i].first_name_en +" "+  data[0][i].last_name_en +" - "+
                                data[0][i].first_name_ar +" "+ data[0][i].last_name_ar +" - "+
                                data[0][i].position + '</option>');
                            }
                            else
                            {
                                $("#user_id").append('<option value="'+data[0][i].id+'">' +data[0][i].first_name_en +" "+  data[0][i].last_name_en +" - "+
                                data[0][i].position + '</option>');
                            }
                        }

                        for (let i = 0; i < data[1].length; i++) {
                            if(data[1][i].first_name_ar)
                            {
                                $("#user_id").append('<option value="'+data[1][i].id+'" selected>' +data[1][i].first_name_en +" "+  data[1][i].last_name_en +" - "+
                                data[1][i].first_name_ar +" "+ data[1][i].last_name_ar +" - "+
                                data[1][i].position + '</option>');
                            }
                            else
                            {
                                $("#user_id").append('<option value="'+data[1][i].id+'" selected>' +data[1][i].first_name_en +" "+  data[1][i].last_name_en +" - "+
                                data[1][i].position + '</option>');
                            }
                        }
                        $('.dual-listbox').empty();
                        new DualListbox('.select1');
                    }
                });
            }
            else if($("#department_id").val()){
                $.get('/payroll/users_department/' + $("#mission_id").val() + '/' + $("#department_id").val() + '/' + $("#month").val(), function(data){
                    if(data)
                    {
                        $("#user_id").html('');
                        for (let i = 0; i < data[0].length; i++) {
                            if(data[0][i].first_name_ar)
                            {
                                $("#user_id").append('<option value="'+data[0][i].id+'">' +data[0][i].first_name_en +" "+  data[0][i].last_name_en +" - "+
                                data[0][i].first_name_ar +" "+ data[0][i].last_name_ar +" - "+
                                data[0][i].position + '</option>');
                            }
                            else
                            {
                                $("#user_id").append('<option value="'+data[0][i].id+'">' +data[0][i].first_name_en +" "+  data[0][i].last_name_en +" - "+
                                data[0][i].position + '</option>');
                            }
                        }

                        for (let i = 0; i < data[1].length; i++) {
                            if(data[1][i].first_name_ar)
                            {
                                $("#user_id").append('<option value="'+data[1][i].id+'" selected>' +data[1][i].first_name_en +" "+  data[1][i].last_name_en +" - "+
                                data[1][i].first_name_ar +" "+ data[1][i].last_name_ar +" - "+
                                data[1][i].position + '</option>');
                            }
                            else
                            {
                                $("#user_id").append('<option value="'+data[1][i].id+'" selected>' +data[1][i].first_name_en +" "+  data[1][i].last_name_en +" - "+
                                data[1][i].position + '</option>');
                            }
                        }
                        $('.dual-listbox').empty();
                        new DualListbox('.select1');
                    }
                });
            }
            else if($("#mission_id").val()){
                $.get('/payroll/users_mission/' + $("#mission_id").val() + '/' + $("#month").val(), function(data){
                    if(data)
                    {
                        $("#user_id").html('');
                        for (let i = 0; i < data[0].length; i++) {
                            if(data[0][i].first_name_ar)
                            {
                                $("#user_id").append('<option value="'+data[0][i].id+'">' +data[0][i].first_name_en +" "+  data[0][i].last_name_en +" - "+
                                data[0][i].first_name_ar +" "+ data[0][i].last_name_ar +" - "+
                                data[0][i].position + '</option>');
                            }
                            else
                            {
                                $("#user_id").append('<option value="'+data[0][i].id+'">' +data[0][i].first_name_en +" "+  data[0][i].last_name_en +" - "+
                                data[0][i].position + '</option>');
                            }
                        }

                        for (let i = 0; i < data[1].length; i++) {
                            if(data[1][i].first_name_ar)
                            {
                                $("#user_id").append('<option value="'+data[1][i].id+'" selected>' +data[1][i].first_name_en +" "+  data[1][i].last_name_en +" - "+
                                data[1][i].first_name_ar +" "+ data[1][i].last_name_ar +" - "+
                                data[1][i].position + '</option>');
                            }
                            else
                            {
                                $("#user_id").append('<option value="'+data[1][i].id+'" selected>' +data[1][i].first_name_en +" "+  data[1][i].last_name_en +" - "+
                                data[1][i].position + '</option>');
                            }
                        }


                        $('.dual-listbox').empty();
                        new DualListbox('.select1');
                    }
                });
            }

            });

            $("#save").click(function (){
                var user = $("#user_id").val();
                var payroll_report = $("#payroll_report_id").val();
                $.post('/payroll/save_user_list', {user_id:user, payroll_report_id:payroll_report}, function (data){
                });
            });
        });
    </script>
@stop