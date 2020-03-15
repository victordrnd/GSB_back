<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Role;
class PermissionResource extends JsonResource
{

    public function __construct($resource, $role)
    {
        $this->role = $role;
        parent::__construct($resource);
    }
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
            'slug' => $this->slug,
            'direction' => $this->role->hasPermission($this->id) > 0 ? 'right' : 'left'
        ];
    }
}
