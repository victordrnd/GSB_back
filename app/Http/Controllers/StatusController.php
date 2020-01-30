<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Status;
class StatusController extends Controller
{
    
    public function getAll(){
        return Controller::responseJson(200, "Les status ont été retourné", Status::all());
    }
}
