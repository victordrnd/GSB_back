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

    public function getAll()
    {
        $frais = $this->fraisService::getAll();
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


    public function stats(){
        $stats = $this->fraisService::stats();
        return Controller::responseJson(200, "Les statistiques ont été retournées", $stats);
    }
}
