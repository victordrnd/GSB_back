<?php

namespace App\Http\Resources;

use App\Permission;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PermissionCollection extends ResourceCollection
{
    private $role;
    public function __construct($resource, $role = null)
    {
        
        parent::__construct($resource);
        $this->role = $role;
    }

    public function toArray($request)
    {
        return $this->collection->map(function(Permission $model) use ($request){
            return (new PermissionResource($model, $this->role));
            //return $resource->role($this->role)->toArray($request);
        });
        // return  PermissionResource::collection($this->collection);
    }
}
