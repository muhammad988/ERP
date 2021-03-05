<?php

namespace App\Http\Controllers\ControlPanel\Project;


use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;

use App\Model\ControlPanel\ServiceProvider;
use App\Model\ControlPanel\ServiceProviderAccount;
use App\Http\Requests\ControlPanel\Project\ServiceProvider\Store;
use App\Http\Requests\ControlPanel\Project\ServiceProvider\Update;
use App\Http\Resources\ControlPanel\Project\ServiceProvider\ServiceProviderCollection;
use App\Http\Resources\ControlPanel\Project\ServiceProvider\ServiceProviderEdit ;

/**
 * Class ServiceProviderController
 * @package App\Http\Controllers\ControlPanel\Project
 */
class ServiceProviderController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index ():View
    {
        return view ('layouts.control_panel.project.service_provider.index', $this->data);
    }

    /**
     * @param Store $request
     * @return JsonResponse|null
     */
    public function store (Store $request) : ?JsonResponse
    {
        try {
            $service_provider =  ServiceProvider::create ($request->all () + ['stored_by' => \Auth::user ()->full_name]);
            foreach ($request->account as $account){
                $account['stored_by']=\Auth::user ()->full_name;
                $item[]=new ServiceProviderAccount($account);
            }
            $service_provider->service_provider_accounts()->saveMany($item);
            return $this->setStatusCode (200)->respond (['status' => true]);
        }catch(Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => ['Something is error']]);
        }
    }


    /**
     * @param ServiceProvider $service_provider
     * @return JsonResponse
     */
    public function edit (ServiceProvider $service_provider): JsonResponse
    {
        return $this->resources (new ServiceProviderEdit($service_provider));
    }

    /**
     * @param Update $request
     * @return JsonResponse|null
     */
    public function update (Update $request): ?JsonResponse
    {
        try {
            $service_provider = ServiceProvider::find ($request->id);
            $service_provider->modified_by = \Auth::user ()->full_name;
            $service_provider->update ($request->all ());
            $items = [];
            $itemIds = [];
            foreach($request->account as $account) {

                if(isset($account['id'])) {
                    // update the item
                    $account['modified_by']=\Auth::user ()->full_name;
                    ServiceProviderAccount::whereId($account['id'])
                        ->where('service_provider_id',$request->id)
                        ->update($account);
                    $itemIds[] = $account['id'];
                } else {
                    $account['stored_by']=\Auth::user ()->full_name;
                    $items[] = new ServiceProviderAccount($account);
                }
            }
            if(count($itemIds)) {
                ServiceProviderAccount::where('service_provider_id',$request->id)
                    ->whereNotIn('id', $itemIds)
                    ->delete();
            }
            if(count($items)) {
                $service_provider->service_provider_accounts()->saveMany($items);
            }
            return $this->setStatusCode (200)->respond (['status' => true]);
        }catch(Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => ['Something is error']]);
        }
    }


    /**
     * @param ServiceProvider $service_provider
     * @return JsonResponse|null
     */
    public function destroy (ServiceProvider $service_provider) : ?JsonResponse
    {

        try {
            $service_provider->delete ();
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
        $query = ServiceProvider::whereNotNull ('id');
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
        return $this->resources (new ServiceProviderCollection($data));
    }
}
