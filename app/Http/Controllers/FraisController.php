<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Frais;
use App\Http\Requests\CreateFraisRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;
class FraisController extends Controller
{

    public function getFrais($id){
        try{
            $frais = Frais::findOrFail($id);

        }catch(ModelNotFoundException $e){
            return Controller::responseJson(404, "Le frais $id n'existe pas", $e->getMessage());
        }
        return Controller::responseJson(200, "Le frais $id a été retourné" , $frais);
    }

    public function getAll(){
        $frais = Frais::all();
        return Controller::responseJson(200, "Les frais ont été retournés" , $frais);
    }


    public function createFrais(CreateFraisRequest $req){
        $frais = Frais::create([
            'montant' => $req->montant,
            'description' => $req->description,
            'user_id' => auth()->user()->id,
            'type_id' => $req->type_id,
            'status_id' => 1
        ]);
        return Controller::responseJson(200 , "Le frais a correctement été crée" , $frais);
    }


    public function getMyFrais(){
        $frais = Frais::where('user_id', auth()->user()->id)->get();
        return Controller::responseJson(200, "Vos frais ont été retourné", $frais);
    }


    public function getCountByDate(){
        $fraisCount = Frais::where('user_id', auth()->user()->id)
                            ->groupBy(\DB::raw('DATE(created_at)'))
                            ->orderBy('date', 'DESC')->get(array(
                                \DB::raw('DATE(created_at) as date'),
                                \DB::raw('COUNT(*) as count')
                            ));
        return Controller::responseJson(200, "Succes", $fraisCount);
    }


}
