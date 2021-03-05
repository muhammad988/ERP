<div>
    <table style="font-size: 16px; text-align:center">
        <tbody>
        <tr>
            <td> {!! $title_3 !!}</td>
        </tr>
        </tbody>
    </table>
</div>
<div>

    <table cellpadding="3" border="1" style="text-align:center">
        <tbody>
        <tr>
            <td height="30" style="background-color:#e1e0dd">Project<br>المشروع</td>
            <td>{{$service->project->name_en}}</td>
            <td height="30" style="background-color:#e1e0dd">Financial Code<br>كود المالي</td>
            <td>{{$service->project->code}}</td>
            <td style="background-color:#e1e0dd">Date<br>التاريخ</td>
            <td>{{$service->created_at}}</td>
        </tr>
        <tr>
            <td height="30" style="background-color:#e1e0dd">Request Num<br>رقم الطلب</td>
            <td>{{$service->code}}</td>
            <td style="background-color:#e1e0dd">Requested From<br>الجهة الطالبة</td>
            <td>{{$service->project->sector->sector->name_en}}</td>
            <td></td>

            <td></td>

        </tr>
        <tr>
            <td  height="30" style="background-color:#e1e0dd">Service Method <br> نوع الطلب
            </td>
            <td>{{$service->service_method->name_en}}
            </td>
            <td   style="background-color:#e1e0dd">Service Receiver <br> مستلم الطلب
            </td>
            <td>{{$name}}
            </td>
            <td height="30" style="background-color:#e1e0dd">Made By<br>منسق الطلب</td>
            <td>{{$service->service_requester->full_name}}</td>
        </tr>
        <tr>
            <td style="background-color:#e1e0dd">Currency<br>العملة</td>
            <td>{{$service->currency->name_en}}</td>

            <td style="background-color:#e1e0dd"> @if ($service->user_exchange_rate != 1)Exchange Rate<br>سعر التحويل@endif</td>
            <td>  @if ($service->user_exchange_rate != 1){{$service->user_exchange_rate}} @endif</td>
            <td height="30" style="background-color:#e1e0dd">Signature<br>التوقيع</td>
            <td>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<div>
    <table cellpadding="3" border="1" style="text-align:center">
        <tbody>
        <tr style="background-color:#e1e0dd">
            <th width="2%">#</th>
            <th width="8%">No.<br>رقم البند</th>
            <th width="10%">Account Number<br>رقم الحساب</th>
            <th width="12%">Account Name<br>أسم الحساب</th>
            <th width="12%">Item <br>المادة</th>
            <th width="8%">Qty<br>الكمية</th>
            <th width="10%">Unit<br>الوحدة</th>
            <th width="10%">Price<br>السعر</th>
            <th width="10%">Total Price<br>السعر الكلي</th>
            <th width="18%">Notes<br>ملاحظات</th>
        </tr>
        @foreach ($service->service_items as $key => $item)
            <tr>
                <td>{{++$key}}</td>
                <td>{{$item->detailed_proposal_budget->budget_line}}</td>
                <td>{{$item->detailed_proposal_budget->category_option->account_number}}</td>
                <td>{{$item->detailed_proposal_budget->category_option->name_en}}</td>
                <td>{{$item->item->name_en}}</td>
                <td>{{$item->quantity}}</td>
                <td>{{$item->unit->name_en}}</td>
                <td>{{number_format ($item->unit_cost, 2)}} {{$item->currency->name_en}}</td>
                <td>{{number_format (($item->unit_cost * $item->quantity), 2)}} {{$item->currency->name_en}}</td>
                <td>{{$item->note}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div>
    <table cellpadding="3" border="1" style="text-align:center">
        <tbody>
        <tr>
            <td style="background-color:#e1e0dd">total ({{$service->currency->name_en}})<br>المجموع</td>
            <td>{{number_format ($service->total_currency, 2)}} {{$service->currency->name_en}}</td>

            @if ($service->user_exchange_rate != 1)
                <td align="center" valign="middle" height="30" style="background-color:#e1e0dd">Total (USD) <br/>المجموع</td>
                <td>{{number_format ($service->total_usd, 2)}} USD</td>
            @endif
{{--            <td style="background-color:#e1e0dd">Advance Owner<br>أمين العهدة</td>--}}
{{--            <td>{{$name}}</td>--}}
            @if (!is_null ($bank_info) )
                <td style="background-color:#e1e0dd">Bank Account Name</td>
                <td>{{$bank_info->bank_name}}  </td>
                <td style="background-color:#e1e0dd">Iban</td>
                <td>{{$bank_info->iban}}</td>
            @endif
        </tr>
        </tbody>
    </table>
</div>
{{--<div>--}}
{{--    <table cellpadding="3" border="1" style="text-align:center">--}}
{{--        <tbody>--}}
{{--        <tr style="background-color:#e1e0dd;">--}}
{{--            <td>Project Manager<br>مدير المشروع</td>--}}
{{--            <td>Head Of Department<br>مدير القسم</td>--}}
{{--            <td>Project Accountant<br>محاسب المشروع</td>--}}
{{--            <td>Project Accountant<br>محاسب المشروع</td>--}}
{{--            <td>Accountant Chief<br>مدير الحسابات</td>--}}
{{--            <td>Head Of Finance<br>المدير المالي</td>--}}
{{--            <td>Head Of Mission<br>رئيس البعثة</td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <td height="30"></td>--}}
{{--            <td></td>--}}
{{--            <td></td>--}}
{{--            <td></td>--}}
{{--            <td></td>--}}
{{--            <td></td>--}}
{{--            <td></td>--}}
{{--        </tr>--}}
{{--        </tbody>--}}
{{--    </table>--}}
{{--</div>--}}
