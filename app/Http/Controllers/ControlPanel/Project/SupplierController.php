<?php

namespace App\Http\Controllers\ControlPanel\Project;


use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;

use App\Model\ControlPanel\Supplier;
use App\Model\ControlPanel\SupplierAccount;
use App\Http\Requests\ControlPanel\Project\Supplier\Store;
use App\Http\Requests\ControlPanel\Project\Supplier\Update;
use App\Http\Resources\ControlPanel\Project\Supplier\SupplierCollection;
use App\Http\Resources\ControlPanel\Project\Supplier\SupplierEdit ;

/**
 * Class SupplierController
 * @package App\Http\Controllers\ControlPanel\Project
 */
class SupplierController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index ():View
    {
        return view ('layouts.control_panel.project.supplier.index', $this->data);
    }

    /**
     * @param Store $request
     * @return JsonResponse|null
     */
    public function store (Store $request) : ?JsonResponse
    {
        try {
            $supplier =  Supplier::create ($request->all () + ['stored_by' => \Auth::user ()->full_name]);
            $item=[];
           foreach ($request->account as $account){
               $account['stored_by']=\Auth::user ()->full_name;
               $item[]=new SupplierAccount($account);
           }
            $supplier->supplier_accounts()->saveMany($item);
            return $this->setStatusCode (200)->respond (['status' => true]);
        }catch(Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => ['Something is error']]);
        }
    }


    /**
     * @param Supplier $supplier
     * @return JsonResponse
     */
    public function edit (Supplier $supplier): JsonResponse
    {
        return $this->resources (new SupplierEdit($supplier));
    }

    /**
     * @param Update $request
     * @return JsonResponse|null
     */
    public function update (Update $request): ?JsonResponse
    {
        try {
            $supplier = Supplier::find ($request->id);
            $supplier->modified_by = \Auth::user ()->full_name;
            $supplier->update ($request->all ());
            $items = [];
            $itemIds = [];
            foreach($request->account as $account) {

                if(isset($account['id'])) {
                    // update the item
                    $account['modified_by']=\Auth::user ()->full_name;
                    SupplierAccount::whereId($account['id'])
                        ->where('supplier_id',$request->id)
                        ->update($account);
                    $itemIds[] = $account['id'];
                } else {
                    $account['stored_by']=\Auth::user ()->full_name;
                    $items[] = new SupplierAccount($account);
                }
            }
            if(count($itemIds)) {
                SupplierAccount::where('supplier_id',$request->id)
                    ->whereNotIn('id', $itemIds)
                    ->delete();
            }
            if(count($items)) {
                $supplier->supplier_accounts()->saveMany($items);
            }
            return $this->setStatusCode (200)->respond (['status' => true]);
        }catch(Exception $e) {
            return $this->setStatusCode (422)->respond (['error' => ['Something is error']]);
        }
    }


    /**
     * @param Supplier $supplier
     * @return JsonResponse|null
     */
    public function destroy (Supplier $supplier) : ?JsonResponse
    {
        try {
            $supplier->delete ();
            return $this->setStatusCode (200)->respond (['deleted' => ['This supplier deleted']]);
        }catch(Exception $e) {
            return $this->setStatusCode (422)->respond (['delete' => ['This supplier is used elsewhere that can not be deleted']]);
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
        $query = Supplier::whereNotNull ('id');
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
        return $this->resources (new SupplierCollection($data));
    }
}
