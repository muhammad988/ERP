<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Model\Project\DetailedProposalBudget;
use App\Model\Project\Project;
use App\Model\Service\Service;
use App\Model\Service\ServiceInvoice;
use App\Model\Service\ServiceItem;
use Illuminate\Http\Request;


/**
 * Class ProposalController
 * @package App\Http\Controllers\Project
 */
class BudgetController extends Controller
{
    
    
    public function info (DetailedProposalBudget $budget)
    {
        $total = ($budget->duration * $budget->unit_cost * $budget->chf * $budget->quantity) / 100;
        $services = ServiceItem::where ('detailed_proposal_budget_id', $budget->id)->select ('service_id')->groupBy ('service_id')->get ();
        $currency = ['87035' => 1, '87036' => 2, '87034' => 3];
    
        $total_item = 0;
        $reserve = 0;
        $reserve_2 = 0;
        $expense = 0;
        foreach($services as $service) {
            if($service->service->status_id != 171 && !$service->service->completed) {
                $service_item = ServiceItem::where ('detailed_proposal_budget_id', $budget->id)->where ('service_id', $service->service_id)->get ();
                foreach($service_item as $key => $item) {
                    
                    if($item->exchange_rate) {
                        
                        $reserve += ($item->quantity * $item->unit_cost) / $item->exchange_rate;
                    }else {
                        $reserve += ($item->quantity * $item->unit_cost);
                    }
                }
                foreach(Service::where ('parent_id', $service->service_id)->get () as $key => $children) {
                    if($children->status_id == 170) {
                        $service_invoices = ServiceInvoice::where ('detailed_proposal_budget_id', $budget->id)->where ('service_id', $children->id)->get ();
                        foreach($service_invoices as $service_invoice) {
                            if($children->user_exchange_rate) {
                                if($currency[$children['currency_id']] <= $currency[$service->service['currency_id']]) {
                                    $expense += (($service_invoice->quantity * $service_invoice->unit_cost) / $service_invoice->exchange_rate) / $children->user_exchange_rate;
                                }else {
                                    $expense += (($service_invoice->quantity * $service_invoice->unit_cost) * $service_invoice->exchange_rate) / $children->user_exchange_rate;
                                }
                            }else {
                                if($currency[$children['currency_id']] <= $currency[$service->service['currency_id']]) {
                                    $expense += ($service_invoice->quantity * $service_invoice->unit_cost) / $service_invoice->exchange_rate;
                                }else {
                                    $expense += ($service_invoice->quantity * $service_invoice->unit_cost) * $service_invoice->exchange_rate;
                                }
                            }
                        }
                        $reserve-= $expense;
                    }
                    
                }
            }elseif($service->service->status_id != 171 && $service->service->completed) {
                foreach(Service::where ('parent_id', $service->service_id)->get () as $key => $children) {
                    if($children->status_id == 170) {
                        $service_invoices = ServiceInvoice::where ('detailed_proposal_budget_id', $budget->id)->where ('service_id', $children->id)->get ();
                        foreach($service_invoices as $service_invoice) {
                            if($children->user_exchange_rate) {
                                if($currency[$children['currency_id']] <= $currency[$service->service['currency_id']]) {
                                    $expense += (($service_invoice->quantity * $service_invoice->unit_cost) / $service_invoice->exchange_rate) / $children->user_exchange_rate;
                                }else {
                                    $expense += (($service_invoice->quantity * $service_invoice->unit_cost) * $service_invoice->exchange_rate) / $children->user_exchange_rate;
                                }
                            }else {
                                if($currency[$children['currency_id']] <= $currency[$service->service['currency_id']]) {
                                    $expense += ($service_invoice->quantity * $service_invoice->unit_cost) / $service_invoice->exchange_rate;
                                }else {
                                    $expense += ($service_invoice->quantity * $service_invoice->unit_cost) * $service_invoice->exchange_rate;
                                }
                            }
                        }
                    }elseif($children->status_id == 174){
                        $service_item = ServiceItem::where ('detailed_proposal_budget_id', $budget->id)->where ('service_id', $children->parent_id)->get ();
                        foreach($service_item as  $item) {
                            if($item->exchange_rate) {
                                $reserve += ($item->quantity * $item->unit_cost) / $item->exchange_rate;
                            }else {
                                $reserve += ($item->quantity * $item->unit_cost);
                            }
                        }
                    }
                }
                if($reserve!=0){
                    $reserve-= $expense;
                }
            }
        }

        
        return ['total' => $total, 'expense' => $expense , 'reserve' => $reserve, 'usable' => ($total - ($reserve + $expense )), 'remaining' => ($total - ($expense + $reserve_2))];
    }
    
    public function availability (DetailedProposalBudget $budget)
    {
        $total = ($budget->duration * $budget->unit_cost * $budget->chf * $budget->quantity) / 100;
        $total_item = 0;
        $services = ServiceItem::where ('detailed_proposal_budget_id', $budget->id)->select ('service_id')->groupBy ('service_id')->get ();
        foreach($services as $service) {
            if($service->service->status_id != 171 && !$service->service->completed) {
                $service_item = ServiceItem::where ('detailed_proposal_budget_id', $budget->id)->where ('service_id', $service->service_id)->get ();
                foreach($service_item as $key => $item) {
                    if($item->exchange_rate) {
                        $total_item += ($item->quantity * $item->unit_cost) / $item->exchange_rate;
                    }else {
                        $total_item += ($item->quantity * $item->unit_cost);
                    }
                }
            }elseif($service->service->status_id != 171 && $service->service->completed) {
                foreach(Service::where ('parent_id', $service->service_id)->get () as $key => $children) {
                    if($children->status_id == 170) {
                        $service_invoices = ServiceInvoice::where ('detailed_proposal_budget_id', $budget->id)->where ('service_id', $children->id)->get ();
                        foreach($service_invoices as $service_invoice) {
                            if($children->user_exchange_rate) {
                                $total_item += (($service_invoice->quantity * $service_invoice->unit_cost) / $service_invoice->exchange_rate) / $children->user_exchange_rate;
                            }else {
                                $total_item += ($service_invoice->quantity * $service_invoice->unit_cost) / $service_invoice->exchange_rate;
                            }
                        }
                    }elseif($children->status_id == 174) {
                        $service_item = ServiceItem::where ('detailed_proposal_budget_id', $budget->id)->where ('service_id', $service->service_id)->get ();
                        foreach($service_item as $item) {
                            if($item->exchange_rate) {
                                $total_item += ($item->quantity * $item->unit_cost) / $item->exchange_rate;
                            }else {
                                $total_item += ($item->quantity * $item->unit_cost);
                            }
                        }
                    }
                    
                }
            }
            
        }
        return $total - $total_item;
    }
    public function get_donor_budget (Request $request)
    {
        $total_monetary  = 0;
        $total_in_kind  = 0;
        $project=Project::find ($request->project_id);
        $in_kind= $project->detailed_proposal_budget()
            ->where ('donor_id',$request->donor_id)
            ->where ('in_kind',false)
            ->select('donors.name_en')
            ->selectRaw('sum ((unit_cost * chf * quantity * duration)/100) as total ')
            ->groupBy('donors.name_en')
            ->first();
      
        $monetary= $project->detailed_proposal_budget()
            ->where ('donor_id',$request->donor_id)
            ->whereRaw ('(in_kind=? or in_kind is null)',[true])
            ->select(['donors.name_en'])
            ->selectRaw('sum ((unit_cost * chf * quantity * duration)/100) as total ')
            ->groupBy('donors.name_en')
            ->first();
       
        if(!is_null ($monetary)){
            $total_monetary=$monetary->total;
        }
        if(!is_null ($in_kind)){
            $total_in_kind =$in_kind->total;
        }
        return ['total'=>$total_in_kind+$total_monetary,'in_kind'=>$total_in_kind,'monetary'=>$total_monetary];
    }
    
}
