@extends('layouts.app')
@section('style')
    @include('layouts.include.style.style_form')
    {!! Html::style('assets/plugins/global/plugins.bundle.css') !!}
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
                            Payroll - Project Budget Allocation
                        </h1>
                    </div>
                </div>
                <!--begin::Form-->

                <div class="kt-portlet__body">
                    <div class="kt-section">
                        <h3 class="kt-section__title kt-margin-b-20">
                            Project Budget Information<span class="required"> *</span>
                        </h3>
                        <div class="kt-section__content">
                            <div class="form-group form-group-last">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td width="50%"><b>Project
                                                Name:</b>&nbsp;&nbsp;{{$budget_line->project->name_en}}</td>
                                        <td><b>Project Code:</b>&nbsp;&nbsp;{{$budget_line->project->code}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Budget Line:</b>&nbsp;&nbsp;{{$budget_line->budget_line}}</td>
                                        <td><b>Category
                                                Option:</b>&nbsp;&nbsp;{{$budget_line->category_option->name_en}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Total Cost:</b>&nbsp;&nbsp;<span
                                                class="money">{{$budget_line->quantity*$budget_line->unit_cost*$budget_line->duration*$budget_line->chf/100}}</span>
                                            USD
                                        </td>
{{--                                        <td><b>Allocated Salary:</b><span class="money" id="allocated">{{availability ($budget_line->id)}}</span></td>--}}
                                    </tr>
                                    <tr>
                                        <td><b>Used:</b><span class="money" id="used">{{($budget_line->quantity*$budget_line->unit_cost*$budget_line->duration*$budget_line->chf/100)-availability ($budget_line->id)}}</span></td>
                                        <td><b>Remaining:</b><span class="money" id="remaining">{{availability ($budget_line->id)}}</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="kt-separator kt-separator--border-dashed kt-separator--space-xl"></div>

                    <div class="kt-section">
                        <h3 class="kt-section__title">
                            List of Employees
                        </h3>
                        <div class="kt-section__content">
                            @for ($i = 0; $i <= $number_of_years; $i++)
                                <div class="form-group">
                                    <h3>{{$first_year+$i}}</h3>
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <th>Employee Name</th>
                                        <th>Position</th>
                                        <th>{{$type[0]}}</th>
                                        @foreach ($months as $dt)
                                            @if ($dt->format('Y') == (string)$first_year+$i)
                                                <th>{{$dt->format('M')}}</th>
                                            @endif
                                        @endforeach
                                        </thead>
                                        <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{$user->first_name_en .' '. $user->last_name_en}}</td>
                                                <td>{{$user->position}}</td>
                                                <td>{{$user->salary}}</td>
                                                @foreach ($months as $dt)
                                                    @if ($dt->format('Y') == (string)$first_year+$i)
                                                        <td>
                                                            <input
                                                                @if(!salary_month($budget_line->id , $dt->format('Y-m-d') , $user->id))
                                                                    readonly
                                                                    @endif
                                                                onblur="check(`{{$user->id}}`,`{{$dt->format('Y-m-d')}}`,`{{$user->salary}}`)"
                                                                id="value-{{$user->id}}-{{$dt->format('Y-m-d')}}"
                                                                name="payroll_{{$type[1]}}_{{$user->id}}_{{$dt->format('Y_m_d')}}"
                                                                type="text" class="form-control money"
                                                                placeholder="{{$dt->format('m')}}"
                                                                value="@foreach($user->payroll_records as $payroll_record) @if($dt->format("Y-m-d")==$payroll_record->month and $payroll_record->detailed_proposal_budget_id==$budget_line->id){{$payroll_record[$type[2]]}}@endif @endforeach">
                                                            <span
                                                                id="error-value-{{$user->id}}-{{$dt->format('Y-m-d')}}"
                                                                class="form-text text-danger"></span>
                                                        </td>
                                                    @endif
                                                @endforeach
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    @if ($project_vacancies->count())
                                        <br>
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                            <th>Vacancy Description</th>
                                            <th>Position</th>
                                            <th>Quantity</th>
                                            <th>{{$type[0]}}</th>
                                            <th>Total {{$type[0]}}</th>
                                            @foreach ($months as $dt)
                                                @if ($dt->format('Y') == (string)$first_year+$i)
                                                    <th>{{$dt->format('M')}}</th>
                                                @endif
                                            @endforeach
                                            </thead>
                                            <tbody>
                                            @foreach ($project_vacancies as $project_vacancy)
                                                <tr>
                                                    <td>{{$project_vacancy->name_en}}</td>
                                                    <td>{{$project_vacancy->position}}</td>
                                                    <td>{{$project_vacancy->quantity}}</td>
                                                    <td>{{$project_vacancy->salary}}</td>
                                                    <td>{{$project_vacancy->salary*$project_vacancy->quantity}}</td>
                                                    @foreach ($months as $dt)
                                                        @if ($dt->format('Y') == (string)$first_year+$i)
                                                            <td>
                                                                <input
                                                                    onblur="check_vacancy(`{{$project_vacancy->id}}`,`{{$dt->format('Y-m-d')}}`,`{{$project_vacancy->salary*$project_vacancy->quantity}}`)"
                                                                    id="value-{{$project_vacancy->id}}-{{$dt->format('Y-m-d')}}"
                                                                    name="payroll_{{$type[1]}}_{{$project_vacancy->id}}_{{$dt->format("Y_m_d")}}"
                                                                    type="text" class="form-control money"
                                                                    placeholder="{{$dt->format("m")}}"
                                                                    value="@foreach($project_vacancy->payroll_records as $payroll_record) @if($dt->format("Y-m-d")==$payroll_record->month and $payroll_record->detailed_proposal_budget_id==$budget_line->id){{$payroll_record[$type[2]]}}@endif @endforeach">
                                                                <span
                                                                    id="error-value-{{$project_vacancy->id}}-{{$dt->format('Y-m-d')}}"
                                                                    class="form-text text-danger"></span>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                                <br>
                            @endfor
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-12">
                                    <a href="#" id="submit"
                                       class="btn btn-sm btn-label-success btn-bold"> @lang('common.submit')</a>
                                    <a href="/" class="btn btn-bold btn-sm btn-label-danger"> <i
                                            class="la la-close"></i>@lang('common.cancel') </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{route('payroll.store_salary_allocation')}} " id="submit-form">
                    @csrf
                    <input hidden value="{{$budget_line->project->id}}" name="project_id">
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
    <script>
        submit_form('submit', 'submit-form');

        function check_vacancy(vacancy_id, month, salary) {
            let value = $(`#value-${vacancy_id}-${month}`);
            let submit = $(`#submit`);
            let error = $(`#error-value-${vacancy_id}-${month}`);
            let type = `{{$type[2]}}`;
            let type_name = `{{$type[3]}}`;
            if(value.val() > 100){
                value.addClass('is-invalid');
                error.html('Allocated Salary can not exceed 100 percent');
                return false
            }else {
                $.ajax({
                    url: `{{route ('payroll.check_vacancy')}}`,
                    method: 'POST',
                    data: {
                        id: vacancy_id,
                        type: type,
                        salary: salary,
                        value: value.val(),
                        month: month,
                        type_name: type_name,
                        budget_line_id: `{{$budget_line->id}}`
                    },
                    success: function () {
                        value.removeClass('is-invalid');
                        error.html(null);
                        submit.attr('disabled', false);
                        submit.removeClass('disabled');
                    },
                    error: function (data) {
                        value.addClass('is-invalid');
                        error.html(data.responseJSON.error);
                        submit.attr('disabled', true);
                        submit.addClass('disabled');
                        toastr.error(data.responseJSON.error);
                    }
                });
            }
        }

        function check(user_id, month, salary) {
            let value = $(`#value-${user_id}-${month}`);
            let submit = $(`#submit`);
            let error = $(`#error-value-${user_id}-${month}`);
            let type = `{{$type[2]}}`;
            let type_name = `{{$type[3]}}`;
            if(value.val() > 100){
                value.addClass('is-invalid');
                error.html('Allocated Salary can not exceed 100 percent');
                return false
            }else {
            $.ajax({
                url: `{{route ('payroll.check_salary')}}`,
                method: 'POST',
                data: {
                    id: user_id,
                    type: type,
                    type_name: type_name,
                    salary: salary,
                    value: value.val(),
                    month: month,
                    budget_line_id: `{{$budget_line->id}}`
                },
                success: function () {
                    value.removeClass('is-invalid');
                    error.html(null);
                    submit.attr('disabled', false);
                    submit.removeClass('disabled');
                },
                error: function (data) {
                    value.addClass('is-invalid');
                    error.html(data.responseJSON.error);
                    submit.attr('disabled', true);
                    submit.addClass('disabled');
                    toastr.error(data.responseJSON.error);
                }
            });
        }
        }
    </script>
@stop
