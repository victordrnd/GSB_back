<?php

namespace App\Http\Controllers;
use App\Activity;
use Illuminate\Http\Request;
class ActivityController extends Controller
{
    public function getAll(){
        $activities = Activity::orderBy('created_at', 'DESC')
            ->get()->map->format();
        return Controller::responseJson(200, "Les activités récentes ont été retournées", $activities);
    }
    
}
