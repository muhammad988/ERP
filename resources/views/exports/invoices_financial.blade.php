<html>

<head>
    <style>
        .xl71 {
            text-align: center;
            background: #A9D08E;
        }

        .xl72 {
            background: #ff1001;
        }

        .xl75 {
            background: #FFD966;
        }
    </style>
</head>

<body>

<table>

    <tr class=xl71>
        <td height=19 class=xl71>Class</td>
        <td height=19 class=xl71>Name</td>
        <td height=19 class=xl71>Account</td>
        <td height=19 class=xl71>Account Name</td>
        <td class=xl71>Description </td>
        <td class=xl71>Debit {{$service_parent->currency->name_en}}</td>
        <td class=xl71>Credit {{$service_parent->currency->name_en}}</td>
    </tr>

    @php
        $array = ['87035'=> 1, '87036'=> 2, '87034'=> 3];
        $total = 0;
    @endphp
    @foreach($service->service_invoices as $key=>$invoice)
        <tr>
            <td height=20   align=left>{{$service_parent->Project->name_en}}</td>
            <td height=20   align=left>{{$name}}</td>
            <td height=20   align=left>{{$invoice->detailed_proposal_budget->category_option->account_number}}</td>
            <td height=20   align=left>{{$invoice->detailed_proposal_budget->category_option->name_en}}</td>
            <td align=left >{{ "PR.#".$service->code."|Inv.#".$invoice->invoice_number."|Inv.Date".  \Carbon\Carbon::parse ($invoice->invoice_date)->format ('d/m/Y')."|".$invoice->note ."|BL.#"
            .$invoice->detailed_proposal_budget->budget_line  }}</td>
            @if($array[$invoice->currency_id] <= $array[$service_parent->currency_id])
                <td align=left  >{{($invoice->unit_cost * $invoice->quantity)/$invoice->exchange_rate  }}</td>
            @else
                <td align=left  >{{($invoice->unit_cost * $invoice->quantity)*$invoice->exchange_rate  }}</td>
            @endif
            <td align=left  > </td>
        </tr>
    @endforeach
    @foreach($service->service_invoices as $key=>$invoice)
        <tr>
            <td height=20   align=left>{{$service_parent->Project->name_en}}</td>
            <td height=20   align=left>{{$name}}</td>
            <td height=20   align=left>{{$invoice->detailed_proposal_budget->category_option->account_number}}</td>
            <td height=20   align=left>{{$invoice->detailed_proposal_budget->category_option->name_en}}</td>
            <td align=left >{{ "PR.#".$service->code."|Inv.#".$invoice->invoice_number."|Inv.Date".  \Carbon\Carbon::parse ($invoice->invoice_date)->format ('d/m/Y')."|".$invoice->note ."|BL.#"
            .$invoice->detailed_proposal_budget->budget_line  }}</td>
            <td align=left  ></td>
            @if($array[$invoice->currency_id] <= $array[$service_parent->currency_id])
                <td align=left  >{{($invoice->unit_cost * $invoice->quantity)/$invoice->exchange_rate  }}</td>
            @else
                <td align=left  >{{($invoice->unit_cost * $invoice->quantity)*$invoice->exchange_rate  }}</td>
            @endif
        </tr>
    @endforeach
    <tr></tr>
    <tr></tr>
    <tr>
        <td ></td>
        <td ></td>
        <td ></td>
        <td ></td>
        <td></td>
        <td>{{$service->total_currency  }}</td>
        <td >{{$service->total_currency  }}</td>
    </tr>
</table>

</body>

</html>
