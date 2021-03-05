<?php
namespace App\Http\Resources\ControlPanel\Project\Unit;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class DonorCollection
 * @package App\Http\Resources\Item
 */
class UnitCollection extends ResourceCollection
{

    public $collects = Unit::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request):array
    {
        return parent::toArray($request);

    }

    /**
     * @param Request $request
     * @return array
     */
    public function with($request):array
    {
        return [
            'meta' => [
                'page' => $request->input('pagination.page'),
                'pages' => $request->input('pages'),
                'perpage' => $request->input('pagination.perpage'),
                'total' => $request->input('total'),
                'sort' => $request->input('pagination.sort'),
                'field' => $request->input('pagination.field'),
                'query' => $request->input('pagination.query'),
            ],
        ];
    }
}
