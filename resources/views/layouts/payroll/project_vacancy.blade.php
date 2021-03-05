@extends('layouts.app')
@section('style')
    @include('layouts.include.style.style_form')
@stop
@section('content')
    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="col-lg-12">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h1 class="kt-portlet__head-title">
                            Project Vacancies
                        </h1>
                    </div>
                </div>
                <!--begin::Form-->
{{--                <form class="kt-form kt-form--label-right" id="kt_form_2" novalidate="novalidate">--}}
                    <form method="POST" action="{{route('save_project_vacancy')}} " class="kt-form kt-form--label-right" id="kt_form_2" novalidate="novalidate">
                        @csrf
                        <input hidden value="{{$project->id}}" name="project_id">
                    <div class="kt-portlet__body">
                        <div class="kt-section">
                            <h3 class="kt-section__title">
                                Project Information:
                            </h3>
                            <div class="kt-section__content">
                                <div class="form-group form-group-last">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="width: 50%"><b>Project Name:</b>&nbsp;&nbsp;{{$project->name_en}}</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 50%"><b>Project Code:</b>&nbsp;&nbsp;{{$project->code}}</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 50%"><b>Project Budget:</b>&nbsp;&nbsp;<span class="money">{{$project->project_budget}}</span> USD</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

                        <div class="kt-section">
                            <h3 class="kt-section__title">
                                Project Vacancies<i data-toggle="kt-tooltip" data-width="auto" class="kt-section__help" title="" data-original-title="If different than the corresponding address"></i>
                            </h3>
                            <div class="kt-section__content">
                                    <div class="form-group form-group-last kt_repeater_vacancy" >
                                        <div data-repeater-list="vacancy" class="col-lg-12">
                                            @if($vacancies->count())
                                            @foreach ($vacancies as $vacancy)
                                            <div data-repeater-item="" class="form-group">
                                                <div class="form-group row">
                                                    <input hidden value="{{$vacancy->id}}" name="id">

                                                    <div class="col-md-2">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label class="kt-label m-label--single">Description<span class="required"> *</span></label>
                                                        </div>
                                                        <div class="kt-form__control form-group-sub">
                                                            <input required id="name_en" name="name_en" type="text" class="form-control" placeholder="name" value="{{$vacancy->name_en}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Position<span class="required"> *</span></label>
                                                        </div>
                                                        <div class="kt-form__control  form-group-sub">
                                                            <select class="form-control select2-new" name="position_id" required>
                                                                <option value="">Please Select</option>
                                                                @foreach ($positions as $position)
                                                                    <option value="{{$position->id}}" {{$vacancy->position_id == $position->id? 'selected':''}}>{{$position->name_en}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label class="kt-label m-label--single">Department<span class="required"> *</span></label>
                                                        </div>
                                                        <div class="kt-form__control  form-group-sub">
                                                            <select  class="form-control select2-new" name="department_id" required>
                                                                <option value="" selected>Please Select</option>
                                                                @foreach ($departments as $department)
                                                                    <option value="{{$department->id}}" {{$vacancy->department_id == $department->id? 'selected':''}}>{{$department->name_en}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label  class="kt-label m-label--single">Salary<span class="required"> *</span></label>
                                                        </div>
                                                        <div class="kt-form__control  form-group-sub">
                                                            <input  id="salary" name="basic_salary" type="text" class="form-control" placeholder="salary" value="{{$vacancy->basic_salary}}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Quantity<span class="required"> *</span></label>
                                                        </div>
                                                        <div class="kt-form__control  form-group-sub">
                                                            <input name="quantity" type="text" class="form-control money" placeholder="quantity" value="{{$vacancy->quantity}}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Management Allowance</label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <input name="management_allowance" type="text" class="form-control money" placeholder="management" value="{{$vacancy->management_allowance}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Transportation Allowance</label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <input name="transportation_allowance" type="text" class="form-control money" placeholder="transportation" value="{{$vacancy->transportation_allowance}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="form-group row">
                                                <div class="col-md-2">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>House Allowance</label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <input name="house_allowance" type="text" class="form-control money" placeholder="house" value="{{$vacancy->house_allowance}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Cell Phone Allowance</label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <input name="cell_phone_allowance" type="text" class="form-control money" placeholder="cell phone" value="{{$vacancy->cell_phone_allowance}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Cost Of Living Allowance</label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <input name="cost_of_living_allowance" type="text" class="form-control money" placeholder="cost of living" value="{{$vacancy->cost_of_living_allowance}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Fuel Allowance</label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <input name="fuel_allowance" type="text" class="form-control money" placeholder="fuel" value="{{$vacancy->fuel_allowance}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Appearance Allowance</label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <input name="appearance_allowance" type="text" class="form-control money" placeholder="appearance" value="{{$vacancy->appearance_allowance}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Work Nature Allowance</label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <input name="work_nature_allowance" type="text" class="form-control money" placeholder="work nature" value="{{$vacancy->work_nature_allowance}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="row ">
                                                    <div class="col-md-11">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Note</label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <textarea class="form-control" name="note" id="note" cols="30" rows="1">{{$vacancy->note}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 align-self-center">
                                                    <a href="javascript:;" data-repeater-delete="" class="btn-sm btn btn-label-danger btn-bold">
                                                        <i class="la la-trash-o"></i>
                                                        Delete
                                                    </a>
                                                </div>
                                                </div>
                                                <div class="col-md-12 kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                                            </div>
                                            @endforeach
                                            @else
                                            <div data-repeater-item="" class="form-group">
                                                <div class="form-group row">
                                                <input hidden value="" name="id">
                                                <div class="col-md-2">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label class="kt-label m-label--single">Description<span class="required"> *</span></label>
                                                        </div>
                                                        <div class="kt-form__control  form-group-sub">
                                                            <input required id="name_en" name="name_en" type="text" class="form-control" placeholder="name" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Position<span class="required"> *</span></label>
                                                        </div>
                                                        <div class="kt-form__control  form-group-sub">
                                                            <select class="form-control select2-new" name="position_id" required>
                                                                <option value="">Please Select</option>
                                                                @foreach ($positions as $position)
                                                                    <option value="{{$position->id}}">{{$position->name_en}}</option>
                                                                @endforeach
                                                            </select>
                                                            <span class="form-text text-muted"></span>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label class="kt-label m-label--single">Department<span class="required"> *</span></label>
                                                        </div>
                                                        <div class="kt-form__control  form-group-sub">
                                                            <select class="form-control select2-new" name="department_id" required>
                                                                <option value="" selected>Please Select</option>
                                                                @foreach ($departments as $department)
                                                                    <option value="{{$department->id}}">{{$department->name_en}}</option>
                                                                @endforeach
                                                            </select>
                                                            <span class="form-text text-muted"></span>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label class="kt-label m-label--single">Salary<span class="required"> *</span></label>
                                                        </div>
                                                        <div class="kt-form__control  form-group-sub">
                                                            <input id="salary" name="basic_salary" type="text" class="form-control money" placeholder="salary" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Quantity<span class="required"> *</span></label>
                                                        </div>
                                                        <div class="kt-form__control  form-group-sub">
                                                            <input name="quantity" type="text" class="form-control money" placeholder="quantity" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Management Allowance</label>
                                                        </div>
                                                        <div class="kt-form__control ">
                                                            <input name="management_allowance" type="text" class="form-control money" placeholder="management">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Transportation Allowance</label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <input name="transportation_allowance" type="text" class="form-control money" placeholder="transportation">
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="form-group row">
                                                <div class="col-md-2">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>House Allowance</label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <input name="house_allowance" type="text" class="form-control money" placeholder="house">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Cell Phone Allowance</label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <input name="cell_phone_allowance" type="text" class="form-control money" placeholder="cell phone" >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Cost Of Living Allowance</label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <input name="cost_of_living_allowance" type="text" class="form-control money" placeholder="cost of living">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Fuel Allowance</label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <input name="fuel_allowance" type="text" class="form-control money" placeholder="fuel">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Appearance Allowance</label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <input name="appearance_allowance" type="text" class="form-control money" placeholder="appearance">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Work Nature Allowance</label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <input name="work_nature_allowance" type="text" class="form-control money" placeholder="work nature">
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="row ">
                                                    <div class="col-md-11">
                                                    <div class="kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Note</label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <textarea class="form-control" name="note" id="note" cols="30" rows="1"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 align-self-center">
                                                    <a href="javascript:;" data-repeater-delete="" class="btn-sm btn btn-label-danger btn-bold">
                                                        <i class="la la-trash-o"></i>
                                                        Delete
                                                    </a>
                                                </div>
                                                </div>
                                                <div class="col-md-12 kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                                            </div>
                                            @endif

                                        </div>
                                        <div class="form-group form-group-last row">
                                            <div class="col-lg-4">
                                                <a href="javascript:;" data-repeater-create="" class="btn btn-bold btn-sm btn-label-brand">
                                                    <i class="la la-plus"></i> Add
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="submit"  id="submit" data-ktwizard-type="action-submit" class="btn  btn-sm  btn-label-primary btn-bold "><i class="la la-check"></i> @lang('common.submit')</button>
                                    <button onClick="window.location.reload();" type="reset" class="btn btn-sm btn-bold btn-label-warning"><i class="la la-rotate-right"></i>Reset</button>
                                    <a href="/" class="btn btn-bold btn-sm btn-label-danger"> <i class="la la-close"></i>@lang('common.cancel') </a>
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
{!! Html::script('assets/js/demo2/pages/crud/forms/validation/form-controls-vacancy.js') !!}
    <script>
        $(document).ready(function () {
            $('.select2-new').select2();
        });
    </script>
@endsection
