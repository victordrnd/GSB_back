<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $hidden = ['created_at', 'updated_at', 'pivot'];
    protected $fillable = ['libelle', 'niveau'];

    public function permissions(){
        return $this->belongsToMany(Permission::class, 'role_permission');
    }
}
