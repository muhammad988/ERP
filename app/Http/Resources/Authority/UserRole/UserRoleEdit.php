<?php

namespace App\Http\Resources\Authority\UserRole;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DepartmentList
 * @package App\Http\Resources\Project
 */
class UserRoleEdit extends JsonResource
{


    public function toArray($request):array
    {
        return[
            'id' => $this->id ,
            'user_id' => $this->user_id,
            'role_id' => $this->role_id,
            'project_id' => $this->project_id,
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
