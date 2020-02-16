<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Victordrnd\Activitylog\Models\Activity as ActivityModel;
use Carbon\Carbon;

class Activity extends ActivityModel
{
    protected $table = 'activity_log';
    public function format(){
        Carbon::setLocale('fr');
        return [
            'id' => $this->id,
            'action' => $this->description,
            'subject' => $this->subject_type == 'App\\Frais' ? $this->subject->load('status', 'type') : $this->subject,
            'subject_type' => $this->subject_type == 'App\\Frais' ? 'frais' : 'user',
            'causer' => $this->causer,
            //'properties' => $this->properties,
            'created_at' => $this->created_at->toDateTimeString(),
            'last_updated' => $this->created_at->diffForHumans()
        ];
    }
}
