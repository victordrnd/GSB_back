<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'fullname' => $this->firstname .' '. $this->lastname, 
            'email' => $this->email,
            'phone' => $this->phone,
            'avatar' => null,
            'role' => $this->role,
            'frais' => $this->whenLoaded('frais'),
            'frais_amount' => $this->frais->sum(function ($item) {
                return $item->montant;
            }),
            'frais_count' => $this->frais->count(),
            'frais_success' => $this->frais->count() != 0 ? (($this->frais->sum(function ($item) {
                if ($item->validated_by && $item->status_id != 3) {
                    return 1;
                } else {
                    return 0;
                }
            })) / $this->frais->count() * 100) : 100,
            'groups_count' => $this->groupes->count(),
            'groups' => $this->groupes,
            'activities' => $this->relationLoaded('activities') ? $this->whenLoaded('activities')->map->format() : null,
            'created_at' => $this->created_at->toDateTimeString()
        ];
    }
}
