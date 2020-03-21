<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateRolePermissionRequest;
use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;
use App\Role;
use App\RolePermission;

class RoleController extends Controller
{
  public function getAllRoles()
  {
    $roles = Role::with('permissions')->get();
    $roles = RoleResource::collection($roles);
    return Controller::responseJson(200, "Les roles ont été retournés", $roles);
  }


  public function addPermissionsToRole($id, UpdateRolePermissionRequest $req){
    foreach($req->permissions as $permission){
      RolePermission::create([
        'permission_id' => $permission['id'],
        'role_id' => $id
        ]);
    }
    return Controller::responseJson(200, 'Les permissions ont été ajoutés');
  }

  public function removePermissionsToRole($id,UpdateRolePermissionRequest $req){
    $ids = array_map(function($item) {
      return $item['id'];
    }, $req->permissions);
    RolePermission::where('role_id', $id)->whereIn('permission_id', $ids)->delete();
    return Controller::responseJson(200, 'Les permissions ont été supprimés');
  }
}
