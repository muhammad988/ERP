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
                            Clearance For Service Request (Advance)
                        </h1>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="kt-form kt-form--label-right" id="kt_form_2" novalidate="novalidate">
                    <div class="kt-portlet__body">
                        <div class="kt-section">
                            <h3 class="kt-section__title">
                                Service Request Information:
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
                                            <td style="width: 50%"><b>Service Method:</b>&nbsp;&nbsp;{{$service->service_method->name_en}}</td>
                                            <td style="width: 50%">
                                                @if ($service->service_method_id == 66894)
                                                    <b>Implementing Partner:</b>&nbsp;&nbsp;{{$service->implementing_partner->name_en}}
                                                @else
                                                    @if ($service->service_method_id == 311432)
                                                        <b>Supplier:</b>&nbsp;&nbsp;{{$service->supplier->name_en}}
                                                    @else
                                                        @if ($service->service_method_id == 137368)
                                                            <b>Service Provider:</b>&nbsp;&nbsp;{{$service->service_provider->name_en}}
                                                        @else
                                                            <b>Recipient:</b>&nbsp;&nbsp;{{$service->service_recipient->first_name_en . ' ' . $service->service_recipient->last_name_en}}
                                                            @if ($service->supplier_id)
                                                                &nbsp;&nbsp;-&nbsp;&nbsp;<b>Supplier:</b>&nbsp;&nbsp;{{$service->supplier->name_en}}
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%"><b>Payment Type:</b>&nbsp;&nbsp;{{$service->payment_type->name_en}}</td>
                                            <td style="width: 50%">
                                                @if ($service->service_method_id == 66894 and $service->payment_type_id == 310675)
                                                    <b>Bank Account:</b>&nbsp;&nbsp;{{$service->implementing_partner_account->bank_name .' - '. $service->implementing_partner_account->iban}}
                                                @else
                                                    @if ($service->service_method_id == 311432 and $service->payment_type_id == 310675)
                                                        <b>Bank Account:</b>&nbsp;&nbsp;{{$service->supplier_account->bank_name .' - '. $service->supplier_account->iban}}
                                                    @else
                                                        @if ($service->service_method_id == 137368 and $service->payment_type_id == 310675)
                                                            <b>Bank Account:</b>&nbsp;&nbsp;{{$service->service_provider_account->bank_name .' - '. $service->service_provider_account->iban}}
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%"><b>Currency:</b>&nbsp;&nbsp;{{$service->currency->name_en}}</td>
                                            <td style="width: 50%"><b>Exchange Rate:</b>&nbsp;&nbsp;{{$service->user_exchange_rate}}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%"><b>Total USD:</b>&nbsp;&nbsp;<span class="money">{{$service->total_usd}}</span></td>
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
                                Service Information
                                <i data-toggle="kt-tooltip" data-width="auto" class="kt-section__help" title="" data-original-title="If different than the corresponding address"></i>
                            </h3>

                            <div class="kt-section__content">
                                <div class="form-group row">
                                    <div class="col-lg-2">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">View Service Items</button>
                                    </div>
                                    @if($service->receipt_file)
                                        <div class="col-lg-2">
                                            <a target="_blank" href="/file/invoice/{{$service->receipt_file}}" class="btn btn-bold btn-primary">View File</a>
                                        </div>
                                    @endif
                                    <div class="col-lg-2">
                                        <a href="{{route('clearance.export_financial_file',$service->id)}} " class="btn btn-bold btn-primary">export Financial File</a>
                                    </div>
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
                                            <th>Budget Line</th>
                                            <th>Invoice Number</th>
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
                                                    <td>{{$service_invoice->detailed_proposal_budget->budget_line}}</td>
                                                    <td>{{$service_invoice->invoice_number}}</td>
                                                    <td>{{$service_invoice->invoice_date}}</td>
                                                    <td>{{$service_invoice->item->name_en}}</td>
                                                    <td>{{$service_invoice->unit->name_en}}</td>
                                                    <td>{{$service_invoice->quantity}}</td>
                                                    <td>{{$service_invoice->unit_cost}}</td>
                                                    <td>{{$service_invoice->currency->name_en}}</td>
                                                    <td>{{$service_invoice->exchange_rate}}</td>
                                                    <td>{{$service_invoice->quantity*$service_invoice->unit_cost}}</td>
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
                                            <td class="money">{{$service->total_usd}}</td>
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
                                        <a href="javascript:;" id="confirm" class="btn  btn-sm  btn-label-primary btn-bold"><i class="la la-check"></i>Confirm</a>
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
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Service Items</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Budget Line</th>
                            <th>Item</th>
                            <th>Unit</th>
                            <th>Quantity</th>
                            <th>Unit Cost</th>
                            <th>Total Cost</th>
                            <th>Note</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($service_items as $key=>$service_item)
                            <tr>
                                <th>{{++$key}}</th>
                                <td>{{$service_item->detailed_proposal_budget->budget_line . ' - ' . $service_item->detailed_proposal_budget->category_option->name_en}}</td>
                                <td>{{$service_item->item->name_en}}</td>
                                <td>{{$service_item->unit->name_en}}</td>
                                <td>{{$service_item->quantity}}</td>
                                <td>{{$service_item->unit_cost}}</td>
                                <td>{{$service_item->unit_cost*$service_item->quantity}}</td>
                                <td>{{$service_item->note}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <form id="reject-form" action="{{route ('clearance.action')}}" method="POST" hidden>
        @csrf
        <input hidden name="action" value="reject">
        <input hidden name="id" value="{{$service->id}}">
    </form>
    <form id="confirm-form" action="{{route ('clearance.action')}}" method="POST" hidden>
        @csrf
        <input hidden name="action" value="confirm">
        <input hidden name="id" value="{{$service->id}}">
    </form>
    <form id="accept-form" action="{{route ('clearance.action')}}" method="POST" hidden>
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
