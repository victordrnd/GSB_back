<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Frais;
use App\Http\Requests\CreateFraisRequest;
use App\Http\Requests\UpdateFraisRequest;
use App\Http\Requests\StatusFraisRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use App\Services\FraisService;
use App\Type;
use Victordrnd\Activitylog\Models\Activity;
class FraisController extends Controller
{
    protected $fraisService;

     
    public function __construct(FraisService $fraisService){
        $this->fraisService = $fraisService;
    }

    public function getFrais($id)
    {
        try {
            $frais = $this->fraisService::find($id);
        } catch (ModelNotFoundException $e) {
            return Controller::responseJson(404, "Le frais $id n'existe pas", $e->getMessage());
        }
        return Controller::responseJson(200, "Le frais $id a été retourné", $frais);
    }

    public function getAll(Request $req)
    {
        $frais = $this->fraisService::getAll($req);
        return Controller::responseJson(200, "Les frais ont été retournés", $frais);
    }


    public function createFrais(CreateFraisRequest $req)
    {
        try{
           $frais = $this->fraisService::create($req);
         }catch(\Exception $e){
             return Controller::responseJson(422, "Une erreur est survenue");
        }
        return Controller::responseJson(200, "Le frais a correctement été crée", $frais);
    }


    public function getMyFrais()
    {
        $frais =$this->fraisService::getMyFrais();
        return Controller::responseJson(200, "Vos frais ont été retourné", $frais);
    }


    public function getCountByDate()
    {
        $fraisCount = $this->fraisService::getCountByDate();
        return Controller::responseJson(200, "Succes", $fraisCount);
    }


    public function update(Frais $frais, Request $req){
        $frais = $this->fraisService::update($frais, $req);
        return Controller::responseJson(200, "L'utilisateur a été mis à jour", $frais);
    }
    public function updateMyFrais(UpdateFraisRequest $req)
    {
        try{
            $frais = $this->fraisService::updateMyFrais($req);
        }catch(ModelNotFoundException $e){
            return Controller::responseJson(404, "Le frais n'a pas pu être mis à jour");
        }
        return Controller::responseJson(200, "Le frais a correctement été mis à jour", $frais);
    }


    public function changeStatus(StatusFraisRequest $req){
        try{
            $frais = $this->fraisService::changeStatus($req);
        }catch(ModelNotFoundException $e){
            return Controller::responseJson(404, "Le frais n'a pas pu être mis à jour");
        }
        return Controller::responseJson(200, "Le frais a correctement été validé", $frais);
    }

    public function deleteMyFrais($id)
    {
        try {
            $frais = $this->fraisService::deleteMyFrais($id);
        } catch (ModelNotFoundException $e) {
            return Controller::responseJson(404, "Le frais demandé n'existe pas ou ne vous appartient pas");
        }
        return Controller::responseJson(200, "Le frais a correctement été supprimé");
    }


    public function export(Request $req){
        if($req->user_id){
            $frais = $this->fraisService->export($req->from, $req->to, $req->user_id);
        }else{
            $frais = $this->fraisService->export($req->from, $req->to);
        }
        return Controller::responseJson(200, "Les frais ont été exportés", $frais);
    }

    public function stats(){
        $stats = $this->fraisService::stats();
        return Controller::responseJson(200, "Les statistiques ont été retournées", $stats);
    }

    public function groupByType(){
        $types = $this->fraisService::groupByType();
        return Controller::responseJson(200, "Les statistiques ont été retournées", $types);
    }

    public function getAllTypes(){
        return Controller::responseJson(200, "Les frais ont été retourné", Type::all());
    }
}
