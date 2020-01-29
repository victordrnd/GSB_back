<?php

namespace App\Http\Controllers;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function getAll(){

        $activities = Activity::with('causer', 'subject', 'subject.type', 'subject.status', 'subject.user')->get();
        return Controller::responseJson(200, "Les activités récentes ont été retournées", $activities);
    }
}
