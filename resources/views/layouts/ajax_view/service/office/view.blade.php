<table class="table table-bordered table-hover">
    <thead>
    </thead>
    <tbody>
    <tr>
        <td><b>Project Name:</b>&nbsp;&nbsp;{{$service->project->name_en}}</td>
        <td><b>Service Type:</b>&nbsp;&nbsp;{{$service->service_type_id == 375446? 'Material and Service Request': 'Payment Request'}}</td>
    </tr>
    <tr>
        <td><b>Project Code:</b>&nbsp;&nbsp;{{$service->project->code}}</td>
        <td><b>Service Date:</b>&nbsp;&nbsp;{{$service->created_at}}</td>
    </tr>
    <tr>
        <td><b>Service Code:</b>&nbsp;&nbsp;{{$service->code}}</td>
        <td><b>Service Method:</b>&nbsp;&nbsp;{{$service->service_method->name_en}}</td>

    </tr>
    <tr>
        <td style="width: 50%">
            @if ($service->implementing_partner_id)
                <b>Implementing Partner:</b>&nbsp;&nbsp;{{$service->implementing_partner->name_en}}
            @endif
            @if ($service->supplier_id)
                <b>Supplier:</b>&nbsp;&nbsp;{{$service->supplier->name_en}}
            @endif
            @if ($service->service_provider_id)
                <b>Service Provider:</b>&nbsp;&nbsp;{{$service->service_provider->name_en}}
            @endif
            @if($service->recipient)
                <b>Recipient:</b>&nbsp;&nbsp;{{$service->service_recipient->first_name_en . ' ' . $service->service_recipient->last_name_en}}
            @endif
        </td>
    </tr>
    <tr>
        <td ><b>Payment Type:</b>&nbsp;&nbsp;{{$service->payment_type->name_en}}</td>
        <td >
            @if ($service->implementing_partner_account_id)
                <b>Bank Account:</b>&nbsp;&nbsp;{{$service->implementing_partner_account->bank_name .' - '. $service->implementing_partner_account->iban}}
            @endif
            @if ($service->supplier_account_id)
                <b>Bank Account:</b>&nbsp;&nbsp;{{$service->supplier_account->bank_name .' - '. $service->supplier_account->iban}}
            @endif
            @if ($service->service_provider_account_id)
                <b>Bank Account:</b>&nbsp;&nbsp;{{$service->service_provider_account->bank_name .' - '. $service->service_provider_account->iban}}
            @endif
        </td>
    </tr>
    <tr>
        <td ><b>Currency:</b>&nbsp;&nbsp;{{$service->currency->name_en}}</td>
        <td ><b>Exchange Rate:</b>&nbsp;&nbsp;{{$service->user_exchange_rate}}</td>
    </tr>
    <tr>
        <td ><b>Total USD:</b>&nbsp;&nbsp;<span class="money">{{$service->total_usd}}</span></td>
        <td>{!! $service->currency_id != 87034? '<b>Total '.$service->currency->name_en .':</b>&nbsp;&nbsp;<span class="money">' . $service->total_currency .'</span>' : ''!!}</td>
    </tr>
    </tbody>
</table>
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
    @foreach ($service->service_items as $key=>$service_item)
        <tr>
            <th>{{++$key}}</th>
            <td>{{$service_item->detailed_proposal_budget->budget_line . ' - ' . $service_item->detailed_proposal_budget->category_option->name_en}}</td>
            <td>{{$service_item->item->name_en}}</td>
            <td>{{$service_item->unit->name_en}}</td>
            <td>{{$service_item->quantity}}</td>
            <td class="money">{{$service_item->unit_cost}}</td>
            <td class="money">{{$service_item->unit_cost*$service_item->quantity}}</td>
            <td>{{$service_item->note}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
