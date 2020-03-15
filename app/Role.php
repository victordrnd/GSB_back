<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\RolePermission;
class Role extends Model
{
    protected $hidden = ['created_at', 'updated_at', 'pivot'];
    protected $fillable = ['libelle', 'niveau'];

    public function permissions(){
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    public function hasPermission($permission_id){
        return RolePermission::where('permission_id', $permission_id)->where('role_id', $this->id)->count();
    }
}
