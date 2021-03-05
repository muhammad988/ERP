<?php

namespace App\Http\Controllers\ControlPanel\Project;


use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;

use App\Model\ControlPanel\ImplementingPartner;
use App\Model\ControlPanel\ImplementingPartnerAccount;
use App\Http\Requests\ControlPanel\Project\ImplementingPartner\Store;
use App\Http\Requests\ControlPanel\Project\ImplementingPartner\Update;
use App\Http\Resources\ControlPanel\Project\ImplementingPartner\ImplementingPartnerCollection;
use App\Http\Resources\ControlPanel\Project\ImplementingPartner\ImplementingPartnerEdit ;

/**
 * Class ImplementingPartnerController
 * @package App\Http\Controllers\ControlPanel\Project
 */
class ImplementingPartnerController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index ():View
    {
        return view ('layouts.control_panel.project.implementing_partner.index', $this->data);
    }

    /**
     * @param Store $request
     * @return JsonResponse|null
     */
    public function store (Store $request) : ?JsonResponse
    {
        try {
            $implementing_partner =  ImplementingPartner::create ($request->all () + ['stored_by' => \Auth::user ()->full_name]);
            $items = [];
            foreach($request->account as $account) {
                    $account['stored_by']=\Auth::user ()->full_name;
                    $items[] = new ImplementingPartnerAccount($account);
            }
            $implementing_partner->implementing_partner_accounts()->saveMany($items);
            return $this->setStatusCode (200)->respond (['status' => true]);
        }catch(Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => ['Something is error']]);
        }
    }


    /**
     * @param ImplementingPartner $implementing_partner
     * @return JsonResponse
     */
    public function edit (ImplementingPartner $implementing_partner): JsonResponse
    {
        return $this->resources (new ImplementingPartnerEdit($implementing_partner));
    }

    public function update (Update $request)
    {
        try {
            $implementing_partner = ImplementingPartner::find ($request->id);
            $implementing_partner->modified_by = \Auth::user ()->full_name;
            $implementing_partner->update ($request->all ());
            $items = [];
            $itemIds = [];
            foreach($request->account as $account) {

                if(isset($account['id'])) {
                    // update the item
                    $account['modified_by']=\Auth::user ()->full_name;
                    ImplementingPartnerAccount::whereId($account['id'])
                        ->where('implementing_partner_id',$request->id)
                        ->update($account);
                    $itemIds[] = $account['id'];
                } else {
                    $account['stored_by']=\Auth::user ()->full_name;
                    $items[] = new ImplementingPartnerAccount($account);
                }
            }
            if(count($itemIds)) {
                ImplementingPartnerAccount::where('implementing_partner_id',$request->id)
                    ->whereNotIn('id', $itemIds)
                    ->delete();
            }
            if(count($items)) {
                $implementing_partner->implementing_partner_accounts()->saveMany($items);
            }
            return $this->setStatusCode (200)->respond (['status' => true]);
        }catch(Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => ['Something is error']]);
        }
    }


    /**
     * @param ImplementingPartner $implementing_partner
     * @return JsonResponse|null
     */
    public function destroy (ImplementingPartner $implementing_partner) : ?JsonResponse
    {

        try {
            $implementing_partner->delete ();
            return $this->setStatusCode (200)->respond (['deleted' => ['This implementing partner deleted']]);
        }catch(Exception $e) {
            return $this->setStatusCode (422)->respond (['delete' => ['This implementing partner is used elsewhere that can not be deleted']]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function get_all (Request $request): JsonResponse
    {
        $page = $request->input ('pagination.page');
        $search = $request->input ('query.generalSearch', null);
        $perpage = $request->input ('pagination.perpage', 10);
        $sortOrder = $request->input ('sort.sort', 'asc');
        $sortField = $request->input ('sort.field', 'name_en');
        $offset = ($page - 1) * $perpage;
        $query = ImplementingPartner::whereNotNull ('id');
        if(is_null ($search)) {
            $totalCount = $query->count ();
        } else {
            $query->whereRaw ("(name_en ilike '%$search%' or   name_ar ilike '%$search%')");
            $totalCount = $query->count ();
        }
        $query->offset ($offset)
            ->limit ($perpage)
            ->orderBy ($sortField, $sortOrder);
        $data = $query->get ();
        $request->offsetSet ('pages', ceil ($totalCount / $perpage));
        $request->offsetSet ('total', $totalCount);
        return $this->resources (new ImplementingPartnerCollection($data));
    }
}
