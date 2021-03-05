<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Model\Hr\User;
use App\Model\NotificationCycle;
use App\Model\NotificationReceiver;
use App\Model\NotificationType;
use App\Model\Project\ProjectAccount;
use App\Model\ProjectNotification;
use App\Model\ProjectNotificationStructure;
use PDF;
use Auth;
use Illuminate\Http\Request;

class TransferController extends Controller
{

    public function create ()
    {
        $this->data['projects'] = \DB::table ('projects')
            ->join ('sectors_departments', 'sectors_departments.id', '=', 'projects.sector_id')
            ->join ('departments_missions', 'departments_missions.id', '=', 'sectors_departments.department_id')
            ->join ('mission_budgets', 'mission_budgets.mission_id', '=', 'departments_missions.mission_id')
            ->where ('departments_missions.mission_id', \Auth::user ()->mission_id)
            ->orderBy ('projects.name_en')
            ->pluck  ('projects.name_en', 'projects.id')
            ->prepend(trans ('common.please_select'), '');
        return view ('layouts.project.transfer.create', $this->data);
    }

    public function store (Request $request)
    {
        $new_2 = new ProjectAccount();
        $new_2->amount = $request->fromAmountTransfer;
        $new_2->project_id = $request->project_id;
        $new_2->transferred_from = $request->transferred_from;
        $new_2->status_id = $this->in_progress;
        $new_2->explanation_from = $request->fromExplanation;
        $new_2->explanation_to = $request->toExplanation;
        $new_2->save ();
        $this->notification ($new_2->id,$request->project_id, 'project_budget_transfer', 'transfer.show', 0, 375842, false, true);
    }
      public function show ($id)
    {
        $this->data['check_notification'] = ProjectNotification::where ('url_id', $id)->where ('receiver', Auth::id ())->where ('status_id', $this->in_progress)->first ();

        $this->data['info'] = ProjectAccount::find($id);
        return view ('layouts.project.transfer.show', $this->data);

    }
         public function action (Request $request)
    {
        $check_notification = ProjectNotification::where ('url_id', $request->id)->where ('receiver', Auth::id ())->where ('status_id', $this->in_progress)->latest ('id')->first ();
        if(is_null ($check_notification)) {
            return redirect ('home');
        }
        if($request->action == 'accept') {
            $this->notification ($request->id,$request->project_id, 'project_budget_transfer', 'transfer.show', 0, 375842,  false, false);
        }elseif($request->action == 'reject') {
            $type_id = NotificationType::where ('module_name', 'project_budget_transfer')->latest ('id')->first ()->id;
            $this->new_notification_project_authorized ($request->id, $type_id, 'transfer.show', '375844', 171, $check_notification->requester, $check_notification->requester, 1, false);
            $check_notification->status_id=170;
            $check_notification->update();
            $project= ProjectAccount::find ($request->id);
            $project->status_id=171;
            $project->update ();
        }elseif($request->action == 'confirm') {
            $check_notification->status_id=170;
            $check_notification->update();
        }
        return redirect ('home');

    }

    public function notification ($url_id=0,$to_id = '', $type = 0, $url = 'NULL', $count = 0, $message_id = '0', $last = false, $my=true)
    {
        $structure = ProjectNotificationStructure::where ('project_id', $to_id)->first ();

        $notification_check = ProjectNotification::where ('url_id', $url_id)->where ('receiver', Auth::id ())->where ('status_id', $this->in_progress)->latest ('id')->first ();
        if(\is_null ($notification_check) && !$my) {
            return false;
        }

        $notification = ProjectNotification::where ('url_id', $url_id)->where ('receiver', Auth::id ())->where ('status_id', $this->in_progress)->latest ('id')->first ();
        if($my) {
            $notification = ProjectNotification::where ('url_id', $url_id)->latest ('id')->first ();
        }
        if(\is_null ($notification)) {
            $requester = Auth::id ();
            $delegated_user_id=null;
            $type_id = NotificationType::where ('module_name', $type)->latest ('id')->first ()->id;
            $notification_first = ProjectNotification::where ('url_id', $url_id)->where ('receiver', Auth::id ())->where ('status_id', $this->in_progress)->latest ('id')->first ();
            if(!\is_null ($notification_first)) {
                $notification_first->status_id = 170;
                $notification_first->modified_by = Auth::user ()->full_name;
                $notification_first->update ();
            }
        }else {
            $requester = $notification->requester;
            $delegated_user_id= $notification->delegated_user_id;
            $receiver = $notification->receiver;
            $type_id = $notification->notification_type_id;
            if($receiver != Auth::id ()) {
                return false;
            }
            $notification->status_id = 170;
            $notification->modified_by = Auth::user ()->full_name;
            $notification->update ();
        }
        $cycles = NotificationCycle::where ('notification_type_id', $type_id)->orderBy ('orderby')->get ();
        $count_notification = count (ProjectNotification::where ('url_id', $url_id)->where ('notification_type_id', $type_id)->where ('receiver', Auth::id ())->where ('message_id', 375842)->groupBy ('step')->select ('step')->get ()) - 1;

            if($count_notification < 0){
                $count_notification=0;
            }
//            echo $cycles[$count_notification + $count];
        if(isset($cycles[$count_notification + $count]) && $cycles[$count_notification + $count]->notification_receiver_id == 375431) {
            if($cycles[$count_notification + $count]->number_of_superiors == 0) {
                if($delegated_user_id!=null ){
                    $parent_user = User::find ($notification->delegated_user_id)->parent_id;
                }else{
                    $parent_user = Auth::user ()->parent_id;
                }
                $next_user = User::where ('position_id', '!=', 32)->find ($parent_user);
                if(\is_null ($next_user)) {
                    $this->notification ($url_id ,$to_id , $type, $url, $count + 1, $message_id);
                    return true;
                }
                $user_id= $this->delegation_or_disabled ($next_user->id,0);
                if($user_id) {
                    $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $cycles[$count_notification + $count]->authorized);
                }else{
                    $this->notification ($url_id ,$to_id , $type, $url, $count + 1, $message_id);

                }
            }else {
                $count_notification_step = ProjectNotification::where ('url_id', $url_id)->where ('step', 375431)->count ();
                if($count_notification_step == $cycles[$count_notification + $count]->number_of_superiors) {
                    $this->notification ($url_id ,$to_id , $type, $url, $count + 1, $message_id);
                }else {
                    if($count_notification_step == 0) {
                        $parent_user = User::find ($requester)->parent_id;
                    }else {
                        $parent_user = Auth::user ()->parent_id;
                    }
                    $next_user = User::where ('position_id', '!=', 32)->find ($parent_user);
                    if(is_null ($next_user)) {
                        $this->notification ($url_id ,$to_id , $type, $url, $count + 1, $message_id);
                        return true;
                    }
                    $user_id = $this->delegation_or_disabled ($next_user->id, 0);
                    if($this->check_notification ($user_id, $url_id) || $this->check_notification ($next_user->id, $url_id)) {
                        $this->notification ($url_id ,$to_id , $type, $url, $count + 1, $message_id);
                        return true;
                    }
                    if($user_id == $next_user->id) {
                        $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, true);
                    }else {
                        $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, true, $next_user->id);
                    }
                }
            }
        }
        else {
            if(isset($cycles[$count_notification + $count])) {
                    $receiver_name = NotificationReceiver::where ('id', $cycles[$count_notification + $count]->notification_receiver_id)->first ();
                    $receiver_id = $structure[$receiver_name->name_en];
                    if(is_null ($receiver_id)) {
                        $this->notification ($url_id ,$to_id , $type, $url, $count + 1, $message_id);
                    }else {
                        $user_id = $this->delegation_or_disabled ($receiver_id);
                        if(is_null ($user_id)) {
                            $this->notification ($url_id ,$to_id , $type, $url, $count + 1, $message_id);
                            return true;
                        }
                        if($cycles[$count_notification + $count]->authorized) {
                            if($this->check_notification ($receiver_id, $url_id) || $this->check_notification ($user_id, $url_id)) {
                                $this->notification ($url_id ,$to_id , $type, $url, $count + 1, $message_id);
                                return true;
                            }
                            if($user_id == $receiver_id) {
                                $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $cycles[$count_notification + $count]->authorized);
                            }else {
                                $delegated_user_id = $receiver_id;
                                $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $cycles[$count_notification + $count]->authorized, $delegated_user_id);
                            }
                        }elseif(!$cycles[$count_notification + $count]->authorized) {
                            if($user_id == $receiver_id) {
                                $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $cycles[$count_notification + $count]->authorized);
                                $user_id = $this->delegation_or_disabled ($requester);
                                if(!is_null ($user_id) && $user_id == $requester) {
                                    $this->new_notification_project_authorized ($url_id, $type_id, $url, '375843', $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, false);
                                }else {
                                    $this->new_notification_project_authorized ($url_id, $type_id, $url, '375843', $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, false, $delegated_user_id);
                                }
                            }else {
                                $delegated_user_id = $receiver_id;
                                $user_id = $this->delegation_or_disabled ($requester);
                                if(!is_null ($user_id) && $user_id == $requester) {
                                    $this->new_notification_project_authorized ($url_id, $type_id, $url, '375843', $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, false);
                                }else {
                                    $this->new_notification_project_authorized ($url_id, $type_id, $url, '375843', $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, false, $requester);
                                }
                                $this->new_notification_project_authorized ($url_id, $type_id, $url, $message_id, $this->in_progress, $requester, $user_id, $cycles[$count_notification + $count]->notification_receiver_id, $cycles[$count_notification + $count]->authorized, $delegated_user_id);
                            }
                            ProjectAccount::where ('id', $url_id)->update (['status_id' => 170]);
                        }
                    }
            }else {
                $user_id = $this->delegation_or_disabled ($requester);
                if(!is_null ($user_id) && $user_id == $requester) {
                    $this->new_notification_project_authorized ($url_id, $type_id, $url, '457086', $this->in_progress, $requester, $user_id, 0, false);
                }else {
                    $this->new_notification_project_authorized ($url_id, $type_id, $url, '457086', $this->in_progress, $requester, $user_id, 0, false, $requester);
                }
                ProjectAccount::where ('id', $url_id)->update (['status_id' => 170]);
                return true;
            }
        }

    }

    public function transfer_pdf ()
    {
        $tableAr1 = '
<style>
table{
width: 100%;
border-collapse: collapse;
font-size: 10px;
}
th.arabic{
border: 1px solid black;
border-collapse: collapse;
padding-left: 8px;
background-color: #595959;
color: white;
text-align: center;
}
td.arabic{
border: 1px solid black;
border-collapse: collapse;
padding-left: 8px;
text-align: center;
}
</style>
<div>
<h3 style="text-align: center">نموذج طلب سلفة من مشروع إلى مشروع</h3>
</div>
    <table>
    <tr>
    <th class="arabic col-1">مسلسل</th>
   <td class="arabic col-1">3</td>
    <th class="arabic col-1">تاريخ الطلب</th>
    <td class="arabic col-1">1/1/2019</td>
</tr>
<tr>
<th></th>
</tr>
</table>
<table>
<tr>
<th class="arabic">البيان</th>
<td class="arabic" colspan="3"> البيان البيان البيان البيان</td>
</tr>
<tr>
<th></th>
</tr>
</table>';
    $tableThEn1 = '
<style>
table{
width: 100%;
border-collapse: collapse;
font-size: 10px;
margin-bottom: 0px;
}
th.english{
border: 1px solid black;
border-collapse: collapse;
padding-left: 8px;
background-color: #d9d9d9;
color: black;
text-align: center;
vertical-align: middle;
}
td.english{
border: 1px solid black;
border-collapse: collapse;
padding-left: 8px;
text-align: center;
}
</style>
<table>
<tr>
<th class="english">Explanation</th>
<th class="english">Balance after Deduction from Project</th>
<th class="english">Amount Transfer from Project </th>
<th class="english">Approved Budget  amount </th>
<th class="english">Transfer from Project  name</th>
<th class="english">Transfer from Project Number</th>
<th class="english">Department</th>
<th class="english"></th>
</tr>
</table>
    ';
        $tablethAr2 = '
    <style>
table{
width: 100%;
border-collapse: collapse;
font-size: 10px;
}
th.arabic{
border: 1px solid black;
border-collapse: collapse;
padding-left: 8px;
background-color: #595959;
color: white;
text-align: center;
}
td.arabic{
border: 1px solid black;
border-collapse: collapse;
padding-left: 8px;
text-align: center;
}
</style>
<table>
<tr>
<th class="arabic">رمزالإدارة</th>
<th class="arabic">اسم الإدارة</th>
<th class="arabic">من رقم مشروع</th>
<th class="arabic">إسم المشروع المستلف منه</th>
<th class="arabic">الموازنة المعتمدة</th>
<th class="arabic">المبلغ السلفة منه</th>
<th class="arabic">موازنة المشروع المستلف منه بعد السلفة</th>
<th class="arabic">البيان</th>
</tr>
</table>
    ';
        PDF::setHeaderCallback (function ($pdf) {
            // disable auto-page-break
            $pdf->SetAutoPageBreak (false, PDF_MARGIN_BOTTOM);
            // set bacground image
            $img_file = K_PATH_IMAGES . 'back-ground.png';
            $pdf->Image ($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
            // restore auto-page-break status
            $pdf->SetAutoPageBreak (true, PDF_MARGIN_BOTTOM);


        });

// Custom Footer
        PDF::setFooterCallback (function ($pdf) {
            // Position at 15 mm from bottom
            $pdf->SetY (-15);
            $pdf->SetX (-15);
            // Set font
            $pdf->SetFont ('helvetica', 'I', 8);
            $pdf->SetTextColor (128, 128, 128);
            $pdf->SetFooterMargin (PDF_MARGIN_FOOTER);

            // Page number
            $pdf->Cell (0, 10, 'Page ' . $pdf->getAliasNumPage () . '/' . $pdf->getAliasNbPages (), 0, false, 'C', 0, '', 0, false, 'T', 'M');

        });
        // set some language dependent data:
        $lg = [];
        $lg['a_meta_charset'] = 'UTF-8';
        $lg['a_meta_dir'] = 'rtl';
        $lg['a_meta_language'] = 'fa';
        $lg['w_page'] = 'page';
//    PDF::setLanguageArray($lg);
        PDF::SetMargins (PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        PDF::SetFont ('helvetica', 8);
        PDF::AddPage ('L', 'A4');
        PDF::setRTL (true);
        PDF::SetFont ('aefurat', '', 18);
        PDF::writeHTML ($tableAr1, true, false, true, false, '');
        PDF::setRTL (false);
        PDF::writeHTML ($tableThEn1, true, false, true, false, '');
        $y = PDF::getY ();
        PDF::setRTL (true);
//    PDF::writeHTMLCell(400,'','',$y,$tablethAr2,0,0,0,true,'J',true);
        PDF::writeHTML ($tablethAr2, true, false, true, false, '');
        PDF::SetTitle ('Project MHPSS-2109 Submission');
        PDF::Output ('Project_MHPSS-2109_Submission.pdf');
    }
}
