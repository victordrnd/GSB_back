<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Permission;
class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        \Carbon\Carbon::setLocale('FR');
        return [
            'id' => $this->id,
            'libelle' => $this->libelle,
            'niveau' => $this->niveau,
            'permissions' => new PermissionCollection(Permission::all(), $this)
        ];
    }
}
