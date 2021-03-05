<?php

namespace App\Http\Resources\Authority\UserRole;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DepartmentList
 * @package App\Http\Resources\Project
 */
class UserRoleList extends JsonResource
{


    public function toArray($request):array
    {
        return[
            'id' => $this->id ,
            'user' => $this->first_name .' '. $this->last_name,
            'role' => $this->role_name,
            'project' => $this->project_name,
            'view' => $this->view,
            'add' => $this->add,
            'update' => $this->update,
            'disable' => $this->disable,
            'delete' => $this->delete,

        ] ;
    }
//    public function withResponse($request, $response)
//    {
//        $response->header('X-Value', 'True');
//    }
}
