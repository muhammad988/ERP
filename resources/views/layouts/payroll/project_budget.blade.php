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
                            Project Budget
                        </h1>
                    </div>
                </div>
                <!--begin::Form-->
                <form method="POST" action="{{route('payroll.save_user_salary')}} " class="kt-form" id="kt_form">
                    @csrf
                    <div class="kt-portlet__body">
                        <div class="kt-section">
                            <h3 class="kt-section__title kt-margin-b-20">
                                Project Budget Information<span class="required"> *</span>
                            </h3>
                            <div class="kt-section__content">
                                <div class="form-group form-group-last">
                                    <input type="text" name="detailed_proposal_budget_id" id="detailed_proposal_budget_id" value="{{$budget_line->id}}" hidden>
                                    <input type="text" name="type" id="type" value="{{$type[1]}}" hidden>
                                    <input type="text" name="type_percentage" id="type_percentage" value="{{$type[2]}}" hidden>
                                    <input type="text" name="name" id="type_percentage" value="{{$type[3]}}" hidden>
                                        <table class="table table-bordered table-hover">

                                            <tbody>
                                                <tr>
                                                    <td width="50%"><b>Project Name:</b>&nbsp;&nbsp;{{$budget_line->project->name_en}}</td>
                                                    <td><b>Project Code:</b>&nbsp;{{$budget_line->project->code}}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Budget Line:</b>&nbsp;{{$budget_line->budget_line}}</td>
                                                    <td><b>Category Option:</b>&nbsp;{{$budget_line->category_option->name_en}}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Total Cost:</b>&nbsp;&nbsp;<span class="money">{{$budget_line->quantity*$budget_line->unit_cost*$budget_line->duration*$budget_line->chf/100}}</span> $</td>
                                                    <td><b>Allocated Salary:</b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    <div class="form-text text-muted"><!--must use this helper element to display error message for the options--></div>
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
                                        <label class="form-control-label">Mission<span class="required"> *</span></label>
                                        <select class="form-control select2" name="mission_id" id="mission_id" >
                                            <option value="" selected>Please Select</option>
                                            @foreach ($missions as $mission)
                                                <option value="{{$mission->id}}">{{$mission->name_en}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3 form-group-sub">
                                        <label class="form-control-label">Department<span class="required"> *</span></label>
                                        <select class="form-control select2" name="department_id" id="department_id" >
                                            <option value="" selected>Please Select</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3 form-group-sub">
                                        <label class="form-control-label">Project<span class="required"> *</span></label>
                                        <select class="form-control select2" name="project_id" id="project_id" >
                                            <option value="" selected>Please Select</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3col-md-1 align-self-end">
                                        <input type="button" id="filter" class="btn btn-brand" value="Apply Filters">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="kt-portlet__body">
                                <h5 class="subtitle">Search<span class="source" data-source="dlb1"> For Employees</span></h5>
                                <select class="select1" id="user_id" name="users[]" multiple>
                                    @foreach ($users as $user)
                                        <option value="{{$user->id}}"
                                            @if ($user->payroll_records->count())
                                                {{'selected'}}
                                            @endif>
                                            {{$user->first_name_en .' '.  $user->last_name_en .' - '.
                                            $user->first_name_ar .' '. $user->last_name_ar .' - '. $user->name_en
                                        }}</option>
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
                        @if ($project_vacancies->count())
                        <div class="col-lg-12">
                            <div class="kt-portlet__body">
                                <h5 class="subtitle">Search<span class="source" data-source="dlb1"> For Vacancies</span></h5>
                                <select class="select3"  id="project_vacancy_id"  name="vacancies[]"  multiple>
                                    @foreach ($project_vacancies as $project_vacancy)
                                        <option value="{{$project_vacancy->id}}"
                                            @if ($project_vacancy->payroll_records->count())
                                            {{'selected'}}
                                        @endif>
                                        {{$project_vacancy->name_en .' - '.  $project_vacancy->position .' - Quantity: '.
                                        $project_vacancy->quantity . ' -' . $type[0] . ': '. $project_vacancy->salary .' USD'}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                                <div class="col-lg-6"></div>
                                <div class="col-lg-6">
                                    <a id="save_vacancy" class="btn btn-label-primary btn-bold"><i class="la la-save"></i>Save</a>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-12">
{{--                                    <a href="#" id="submitForm" type="submit"--}}
{{--                                        class="btn btn-label-primary btn-bold">--}}
{{--                                        <i class="la la-check"></i>@lang('common.submit')--}}
{{--                                    </a>--}}
                                    <button type="submit" id="submit" data-ktwizard-type="action-submit" class="btn btn-label-primary btn-bold" > <i class="la la-check"></i> @lang('common.submit')</button>

                                    <a href="/"  id="submitForm" type="submit"
                                        class="btn btn-label-warning btn-bold">
                                        <i class="la la-remove"></i>@lang('common.cancel')
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
        var dlb1 = new DualListbox('.select3');

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
                    $.get('/payroll/get_user_by_project/' + $("#type").val() + '/' + $("#detailed_proposal_budget_id").val() + '/' + $("#project_id").val(), function(data){
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
                            new DualListbox('.select3');
                        }
                    });
                }
                else if($("#department_id").val()){
                    $.get('/payroll/get_user_by_department/' + $("#type").val() + '/' + $("#detailed_proposal_budget_id").val() + '/'  + $("#mission_id").val() + '/' + $("#department_id").val(), function(data){
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
                            new DualListbox('.select3');
                        }
                    });
                }
                else if($("#mission_id").val()){
                    $.get('/payroll/get_user_by_mission/' + $("#type").val() + '/' + $("#detailed_proposal_budget_id").val() + '/'  + $("#mission_id").val(), function(data){
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
                            new DualListbox('.select3');
                        }
                    });
                }
            });

            $("#save").click(function (){
                var user = $("#user_id").val();
                var detailed_proposal_budget = $("#detailed_proposal_budget_id").val();
                var $type_percentage = $("#type_percentage").val();
                $.post('/payroll/save_list_users/' + $type_percentage, {user_id:user, detailed_proposal_budget_id:detailed_proposal_budget}, function (data){
                });
            });

            $("#save_vacancy").click(function (){

                var project_vacancy_id = $("#project_vacancy_id").val();
                var detailed_proposal_budget = $("#detailed_proposal_budget_id").val();
                var $type_percentage = $("#type_percentage").val();

                $.post('/payroll/save_list_vacancies/' + $type_percentage, {project_vacancies:project_vacancy_id, detailed_proposal_budget_id:detailed_proposal_budget}, function (data){
                });
            });
        });
    </script>
@stop
