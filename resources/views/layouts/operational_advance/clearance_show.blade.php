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
                            Clearance For Operational Advance
                        </h1>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="kt-form kt-form--label-right" id="kt_form_2" novalidate="novalidate">
                    <div class="kt-portlet__body">
                        <div class="kt-section">
                            <h3 class="kt-section__title">
                                Clearance  Operational Advance Information:
                            </h3>
                            <div class="kt-section__content">
                                <div class="form-group form-group-last">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td style="width: 50%"><b>Project Name:</b>&nbsp;&nbsp;{{$service->project->name_en}}</td>
                                            <td style="width: 50%"><b>Service Type:</b>&nbsp;&nbsp;{{$service->service_type_id == 375446? 'Material and Service Request': 'Payment Request'}}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%"><b>Project Code:</b>&nbsp;&nbsp;{{$service->project->code}}</td>
                                            <td style="width: 50%"><b>Service Date:</b>&nbsp;&nbsp;{{$service->created_at}}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%"><b>Service Code:</b>&nbsp;&nbsp;{{$service->parent->code}}</td>
                                            <td style="width: 50%"><b>Clearance Code:</b>&nbsp;&nbsp;{{$service->code}}</td>
                                        </tr>

                                        <tr>
                                            <td style="width: 50%"><b>Currency:</b>&nbsp;&nbsp;{{$service->currency->name_en}}</td>
                                            <td style="width: 50%"><b>Exchange Rate:</b>&nbsp;&nbsp;{{$service->user_exchange_rate}}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%"><b>Total USD:</b>&nbsp;&nbsp;<span class="money">{{$service->total_dollar}}</span></td>
                                            <td>{!! $service->currency->id != 87034? '<b>Total '.$service->currency->name_en .':</b>&nbsp;&nbsp;<span class="money">' . $service->total_currency .'</span>' : ''!!}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                        <div class="kt-section">
                            <h3 class="kt-section__title">
                                Operational Advance Information
                                <i data-toggle="kt-tooltip" data-width="auto" class="kt-section__help" title="" data-original-title="If different than the corresponding address"></i>
                            </h3>
                            <div class="kt-section__content">
                                <div class="form-group row">
                                    @if($service->receipt_file)
                                        <div class="col-lg-3 ">
                                            <a target="_blank" href="/file/invoice/{{$service->receipt_file}}" class="btn btn-bold btn-primary">View Invoice File</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                        <div class="kt-section">
                            <h3 class="kt-section__title">
                                Financial Clearance Items
                                <i data-toggle="kt-tooltip" data-width="auto" class="kt-section__help" title="" data-original-title="If different than the corresponding address"></i>
                            </h3>
                            <div class="kt-section__content">
                                <div id="kt_repeater_1">
                                    <div class="form-group form-group-last row" id="kt_repeater_3">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                            <th>Invoice Number</th>
                                            @if($service_invoices[0]->detailed_proposal_budget_id)
                                                <th>Budget Line</th>
                                            @endif
                                            <th>Invoice Data</th>
                                            <th>Item</th>
                                            <th>Unit</th>
                                            <th>Quantity</th>
                                            <th>Unit Cost</th>
                                            <th>Currency</th>
                                            <th>Exchange Rate</th>
                                            <th>Total Cost</th>
                                            <th>Note</th>
                                            </thead>
                                            <tbody>
                                            @foreach ($service_invoices as $service_invoice)
                                                <tr>
                                                    <td>{{$service_invoice->invoice_number}}</td>
                                                    @if($service_invoice->detailed_proposal_budget_id)
                                                        <td>{{$service_invoice->detailed_proposal_budget->budget_line . ' - ' . $service_invoice->detailed_proposal_budget->category_option->name_en}}</td>
                                                    @endif
                                                    <td>{{$service_invoice->invoice_date}}</td>
                                                    <td>{{$service_invoice->item->name_en}}</td>
                                                    <td>{{$service_invoice->unit->name_en}}</td>
                                                    <td>{{$service_invoice->quantity}}</td>
                                                    <td class="money">{{$service_invoice->unit_cost}}</td>
                                                    <td>{{$service_invoice->currency->name_en}}</td>
                                                    <td>{{$service_invoice->exchange_rate}}</td>
                                                    <td class="money">{{$service_invoice->quantity*$service_invoice->unit_cost}}</td>
                                                    <td>{{$service_invoice->note}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                        <div class="kt-section">
                            <h3 class="kt-section__title">
                                Service Total:
                            </h3>
                            <div class="kt-section__content">
                                <div class="form-group row">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        @if($service->currency_id != 87034 and $service->currency_id != "")
                                            <th>Total Currency {{$service->currency->name_en}}</th>
                                        @endif
                                        <th>Total USD</th>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            @if($service->currency_id != 87034 and $service->currency_id != "")
                                                <td class="money">{{$service->total_currency}}</td>
                                            @endif
                                            <td class="money">{{$service->total_dollar}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-12">
                                    @if($check_notification->authorized)
                                        <a href="javascript:;" id="accept" class="btn btn-sm btn-label-primary btn-bold"><i class="la la-check"></i> @lang('common.accept')</a>
                                        <a href="javascript:;" id="reject" class="btn btn-sm  btn-label-danger btn-bold"><i class="la la-ban"></i> @lang('common.reject')</a>
                                    @else
                                        <a href="javascript:;" id="confirm" class="btn  btn-sm  btn-label-primary btn-bold"><i class="la la-check"></i> Confirm</a>
                                    @endif

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

    <!-- Button trigger modal -->

    <!-- Modal -->
    <form id="reject-form" action="{{route ('clearance.action_operational_advance')}}" method="POST" hidden>
        @csrf
        <input hidden name="action" value="reject">
        <input hidden name="id" value="{{$service->id}}">
    </form>
    <form id="confirm-form" action="{{route ('clearance.action_operational_advance')}}" method="POST" hidden>
        @csrf
        <input hidden name="action" value="confirm">
        <input hidden name="id" value="{{$service->id}}">
    </form>
    <form id="accept-form" action="{{route ('clearance.action_operational_advance')}}" method="POST" hidden>
        @csrf
        <input hidden name="action" value="accept">
        <input hidden name="id" value="{{$service->id}}">
        <input hidden name="project_id" value="{{$service->project_id}}">
    </form>
@stop
@section('script')
    @include('layouts.include.script.script_jquery_form')
    <script>
        submit_form('accept', 'accept-form');
        submit_form('reject', 'reject-form');
        submit_form('confirm', 'confirm-form');
    </script>
@endsection

