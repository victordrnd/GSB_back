<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;
use App\Role;
class RoleController extends Controller
{
    public function getAllRoles(){
        $roles = Role::with('permissions')->get();
        $roles = RoleResource::collection($roles);
        return Controller::responseJson(200, "Les roles ont été retournés", $roles);
      }
}
