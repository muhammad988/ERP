<?php

namespace App\Http\Resources\ControlPanel\Hr\TypeOfContract;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class DepartmentCollection
 * @package App\Http\Resources\Project
 */
class TypeOfContractCollection extends ResourceCollection
{
    public $collects = TypeOfContractList::class;

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
    public function with($request):array
    {return [
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
