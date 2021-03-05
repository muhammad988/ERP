<table style="border:1px solid #000">
    <tr >
        <th style="background: #5867dd; color:#ffffff; " valign="center" align="center" >الرمز المالي</th>
        <th height=19 style="background: #5867dd; color:#ffffff; " valign="center" align="center">اسم</th>
        <th style="background: #5867dd; color:#ffffff; " valign="center" align="center">مركز</th>
        <th style="background: #5867dd; color:#ffffff; " valign="center" align="center">منصب</th>
        <th style="background: #5867dd; color:#ffffff; " valign="center" align="center">تاريخ</th>
{{--        <th style="background: #5867dd; color:#ffffff; " valign="center" align="center">Last Name En</th>--}}
        <th style="background: #5867dd; color:#ffffff; " valign="center" align="center">الدوام المفترض</th>
{{--        <th style="background: #5867dd; color:#ffffff; " valign="center" align="center">Last Name Ar</th>--}}
        <th style="background: #5867dd; color:#ffffff; " valign="center" align="center">دخول مفترض</th>
        <th style="background: #5867dd; color:#ffffff; " valign="center" align="center">خروج مفترض</th>
        <th style="background: #5867dd; color:#ffffff; " valign="center" align="center">الدخول</th>
        <th style="background: #5867dd; color:#ffffff; " valign="center" align="center">الخروج</th>
        <th style="background: #5867dd; color:#ffffff; " valign="center" align="center">الساعات المحتسبة</th>
        <th style="background: #5867dd; color:#ffffff; " valign="center" align="center">الدوام المحتسب</th>
    </tr>
    @foreach($fingerprint_report as $key=>$item)
        @php
        $data= work_hours($item->start_date,$item->end_date,$item->user_id,['d' => $item->assumed_work_status]);
@endphp
        <tr>

            <td height=20 @if( isset($data['type']['b']))  style="background:#ffb822;" @elseif(isset($data['type']['c']) ||  isset($data['type']['a']))   style="background:#e91111;" @elseif(isset($data['type']['d']))   style="background:#0abb87;"
                @endif>{{$item->financial_code}}
            </td>
            <td height=20 @if( isset($data['type']['b']))  style="background:#ffb822;" @elseif(isset($data['type']['c']) ||  isset($data['type']['a']))   style="background:#e91111;" @elseif(isset($data['type']['d']))   style="background:#0abb87;"
                @endif>{{$item->user_full_name_ar}}
            </td>
            <td @if( isset($data['type']['b']))  style="background:#ffb822;" @elseif(isset($data['type']['c']) ||  isset($data['type']['a']))   style="background:#e91111;" @elseif(isset($data['type']['d']))   style="background:#0abb87;"
                @endif>{{$item->center}}
            </td>

            <td @if( isset($data['type']['b']))  style="background:#ffb822;"
                @elseif(isset($data['type']['c']) ||  isset($data['type']['a']))   style="background:#e91111;" @elseif(isset($data['type']['d']))   style="background:#0abb87;" @endif>{{$item->position_name_ar}}
            </td>
            <td @if( isset($data['type']['b']))  style="background:#ffb822;"
                @elseif(isset($data['type']['c']) ||  isset($data['type']['a']))   style="background:#e91111;" @elseif(isset($data['type']['d']))   style="background:#0abb87;" @endif>{{$item->start_date}}
            </td>
            <td @if( isset($data['type']['b']))  style="background:#ffb822;"
                @elseif(isset($data['type']['c']) ||  isset($data['type']['a']))   style="background:#e91111;" @elseif(isset($data['type']['d']))   style="background:#0abb87;" @endif>{{$item->assumed_work_status}}
            </td>
            <td @if( isset($data['type']['b']))  style="background:#ffb822;"
                @elseif(isset($data['type']['c']) ||  isset($data['type']['a']))   style="background:#e91111;" @elseif(isset($data['type']['d']))   style="background:#0abb87;" @endif>{{$item->assumed_entry}}
            </td>
            <td @if( isset($data['type']['b']))  style="background:#ffb822;"
                @elseif(isset($data['type']['c']) ||  isset($data['type']['a']))   style="background:#e91111;" @elseif(isset($data['type']['d']))   style="background:#0abb87;" @endif>{{$item->assumed_exit}}
            </td>
            <td  @if( isset($data['type']['b']))  style="background:#ffb822;"
                @elseif(isset($data['type']['c']) ||  isset($data['type']['a']))   style="background:#e91111;" @elseif(isset($data['type']['d']))   style="background:#0abb87;" @endif>{{ $item->start_date != $item->end_date ? $item->entry : ""}}
            </td>
            <td  @if( isset($data['type']['b']))  style="background:#ffb822;"
                @elseif(isset($data['type']['c']) ||  isset($data['type']['a']))   style="background:#e91111;" @elseif(isset($data['type']['d']))   style="background:#0abb87;" @endif>{{ $item->start_date != $item->end_date ? $item->exit : ""}}
            </td>
            <td  @if( isset($data['type']['b']))  style="background:#ffb822;"
                @elseif(isset($data['type']['c']) ||  isset($data['type']['a']))   style="background:#e91111;" @elseif(isset($data['type']['d']))   style="background:#0abb87;" @endif>{{$item->start_date != $item->end_date ?  gmdate("H:i:s",$data['time']) : '' }}
            </td>
            <td @if(isset($data['type']['b']) )  style="background:#ffb822;"
                @elseif(isset($data['type']['c']) ||  isset($data['type']['a']))   style="background:#e91111;" @elseif(isset($data['type']['d']))   style="background:#0abb87;" @endif>{{ current($data['type'])}}
            </td>
        </tr>
    @endforeach
</table>
