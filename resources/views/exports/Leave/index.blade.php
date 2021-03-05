<table style="border:1px solid #000">
    <tr >
        <th style="background: #5867dd; color:#ffffff; " valign="center" align="center" >Id</th>
        <th style="background: #5867dd; color:#ffffff; " valign="center" align="center" >Financial Code</th>
        <th height=19 style="background: #5867dd; color:#ffffff; " valign="center" align="center">Department</th>
        <th style="background: #5867dd; color:#ffffff; " valign="center" align="center">Position</th>
        <th style="background: #5867dd; color:#ffffff; " valign="center" align="center">Location</th>
        <th style="background: #5867dd; color:#ffffff; " valign="center" align="center">User Name En</th>
{{--        <th style="background: #5867dd; color:#ffffff; " valign="center" align="center">Last Name En</th>--}}
        <th style="background: #5867dd; color:#ffffff; " valign="center" align="center">User Name Ar</th>
{{--        <th style="background: #5867dd; color:#ffffff; " valign="center" align="center">Last Name Ar</th>--}}
        <th style="background: #5867dd; color:#ffffff; " valign="center" align="center">Type</th>
        <th style="background: #5867dd; color:#ffffff; " valign="center" align="center">Start Date</th>
        <th style="background: #5867dd; color:#ffffff; " valign="center" align="center">End Date</th>
        <th style="background: #5867dd; color:#ffffff; " valign="center" align="center">Start Time</th>
        <th style="background: #5867dd; color:#ffffff; " valign="center" align="center">End Time</th>
        <th style="background: #5867dd; color:#ffffff; " valign="center" align="center">Leave Days</th>
        <th style="background: #5867dd; color:#ffffff; " valign="center" align="center">Status</th>
        <th style="background: #5867dd; color:#ffffff; " valign="center" align="center">Created At</th>
        <th style="background: #5867dd; color:#ffffff; " valign="center" align="center">File</th>
        <th style="background: #5867dd; color:#ffffff; " valign="center" align="center">Project</th>
    </tr>
    @foreach($leaves as $key=>$leave)
        <tr>
            <td height=20 @if( $leave->status_id == 174)  style=" background:#ffb822;" @elseif($leave->status_id == 171)   style="background:#fd397a;" @elseif($leave->status_id == 170)   style="background:#0abb87;"
                @endif>{{$leave->id}}
            </td>
            <td height=20 @if( $leave->status_id == 174)  style="background:#ffb822;" @elseif($leave->status_id == 171)   style="background:#fd397a;" @elseif($leave->status_id == 170)   style="background:#0abb87;"
                @endif>{{$leave->user_financial_code}}
            </td>
            <td height=20 @if( $leave->status_id == 174)  style="background:#ffb822;" @elseif($leave->status_id == 171)   style="background:#fd397a;" @elseif($leave->status_id == 170)   style="background:#0abb87;"
                @endif>{{$leave->department_name}}
            </td>
            <td @if( $leave->status_id == 174)  style="background:#ffb822;" @elseif($leave->status_id == 171)   style="background:#fd397a;" @elseif($leave->status_id == 170)   style="background:#0abb87;"
                @endif>{{$leave->position_name}}
            </td>

            <td @if( $leave->status_id == 174)  style="background:#ffb822;"
                @elseif($leave->status_id == 171)   style="background:#fd397a;" @elseif($leave->status_id == 170)   style="background:#0abb87;" @endif>{{$leave->user->organisation_unit->name_en}}
            </td>
            <td @if( $leave->status_id == 174)  style="background:#ffb822;"
                @elseif($leave->status_id == 171)   style="background:#fd397a;" @elseif($leave->status_id == 170)   style="background:#0abb87;" @endif>{{$leave->user_full_name_en}}
            </td>
{{--            <td @if( $leave->status_id == 174)  style="background:#ffb822;"--}}
{{--                @elseif($leave->status_id == 171)   style="background:#fd397a;" @elseif($leave->status_id == 170)   style="background:#0abb87;" @endif >{{$leave->user->last_name_en}}--}}
{{--            </td>--}}
{{--            <td @if( $leave->status_id == 174)  style="background:#ffb822;"--}}
{{--                @elseif($leave->status_id == 171)   style="background:#fd397a;" @elseif($leave->status_id == 170)   style="background:#0abb87;" @endif>{{$leave->user->first_name_ar}}--}}
{{--            </td>--}}
            <td @if( $leave->status_id == 174)  style="background:#ffb822;"
                @elseif($leave->status_id == 171)   style="background:#fd397a;" @elseif($leave->status_id == 170)   style="background:#0abb87;" @endif>{{$leave->user_full_name_ar}}
            </td>
            <td @if( $leave->status_id == 174)  style="background:#ffb822;"
                @elseif($leave->status_id == 171)   style="background:#fd397a;" @elseif($leave->status_id == 170)   style="background:#0abb87;" @endif>{{$leave->leave_type_name}}
            </td>
            <td  @if( $leave->status_id == 174)  style="background:#ffb822;"
                @elseif($leave->status_id == 171)   style="background:#fd397a;" @elseif($leave->status_id == 170)   style="background:#0abb87;" @endif>{{ Carbon\Carbon::parse($leave->start_date)->format('m/d/Y')}}
            </td>
            <td  @if( $leave->status_id == 174)  style="background:#ffb822;"
                @elseif($leave->status_id == 171)   style="background:#fd397a;" @elseif($leave->status_id == 170)   style="background:#0abb87;" @endif>{{Carbon\Carbon::parse($leave->end_date)->format('m/d/Y')}}
            </td>
            <td  @if( $leave->status_id == 174)  style="background:#ffb822;"
                @elseif($leave->status_id == 171)   style="background:#fd397a;" @elseif($leave->status_id == 170)   style="background:#0abb87;" @endif>{{$leave->start_time}}
            </td>
            <td  @if( $leave->status_id == 174)  style="background:#ffb822;"
                @elseif($leave->status_id == 171)   style="background:#fd397a;" @elseif($leave->status_id == 170)   style="background:#0abb87;" @endif>{{$leave->end_time}}
            </td>
            <td  @if( $leave->status_id == 174)  style="background:#ffb822;"
                @elseif($leave->status_id == 171)   style="background:#fd397a;" @elseif($leave->status_id == 170)   style="background:#0abb87;" @endif>{{$leave->leave_days}}
            </td>
            <td @if( $leave->status_id == 174)  style="background:#ffb822;"
                @elseif($leave->status_id == 171)   style="background:#fd397a;" @elseif($leave->status_id == 170)   style="background:#0abb87;" @endif>{{$leave->status_name}}
            </td>
            <td @if( $leave->status_id == 174)  style="background:#ffb822;"
                @elseif($leave->status_id == 171)   style="background:#fd397a;" @elseif($leave->status_id == 170)   style="background:#0abb87;" @endif>{{$leave->created_at}}
            </td>
            <td @if( $leave->status_id == 174)  style="background:#ffb822;" @elseif($leave->status_id == 171)   style="background:#fd397a;" @elseif($leave->status_id == 170)   style="background:#0abb87;" @endif> @if(!is_null ($leave->file)) {{env('APP_URL').'/storage/'. $leave->file}} @endif
            </td>
            {{--            <td @if( $leave->status_id == 174)  style="background:#ffb822;"--}}
            {{--                @elseif($leave->status_id == 171)   style="background:#fd397a;" @elseif($leave->status_id == 170)   style="background:#fd397a;" @endif>{{ str_limit(strip_tags($leave->reason),255 )  }}--}}
            {{--            </td>--}}
            <td @if( $leave->status_id == 174)  style="background:#ffb822;"
                @elseif($leave->status_id == 171)   style="background:#fd397a;" @elseif($leave->status_id == 170)   style="background:#0abb87;" @endif>{{$leave->project}}
            </td>
        </tr>
    @endforeach
</table>
