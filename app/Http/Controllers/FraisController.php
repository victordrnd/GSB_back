<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Frais;
use App\Http\Requests\CreateFraisRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

class FraisController extends Controller
{

    public function getFrais($id)
    {
        try {
            $frais = Frais::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return Controller::responseJson(404, "Le frais $id n'existe pas", $e->getMessage());
        }
        return Controller::responseJson(200, "Le frais $id a été retourné", $frais);
    }

    public function getAll()
    {
        $frais = Frais::all();
        return Controller::responseJson(200, "Les frais ont été retournés", $frais);
    }


    public function createFrais(CreateFraisRequest $req)
    {
        $name = null;
        if($req->input('photo', false)){
            $name = 'frais-'.time().'.png';
            Storage::disk('local')->put("public/images/$name", base64_decode($req->photo));
        }
        $frais = Frais::create([
            'montant' => $req->montant,
            'description' => $req->input('description'),
            'user_id' => auth()->user()->id,
            'type_id' => $req->type_id,
            'status_id' => 1,
            'photo_url' => $name
        ]);
        return Controller::responseJson(200, "Le frais a correctement été crée", $frais);
    }


    public function getMyFrais()
    {
        $frais = Frais::where('user_id', auth()->user()->id)->with('type', 'status')->orderBy('created_at', 'desc')->get();
        return Controller::responseJson(200, "Vos frais ont été retourné", $frais);
    }


    public function getCountByDate()
    {
        $fraisCount = Frais::where('user_id', auth()->user()->id)
            ->groupBy(\DB::raw('DATE(created_at)'))
            ->orderBy('date', 'DESC')->get(array(
                \DB::raw('DATE(created_at) as date'),
                \DB::raw('COUNT(*) as count')
            ));
        return Controller::responseJson(200, "Succes", $fraisCount);
    }

    public function updateMyFrais(Request $req)
    {
        try{

            Frais::where('id', $req->id)->where('user_id', auth()->user()->id)->update($req->only('description', 'montant'));
            $frais = Frais::where('id', $req->id)->where('user_id', auth()->user()->id)->with('type', 'status')->firstOrFail();
        }catch(ModelNotFoundException $e){
            return Controller::responseJson(404, "Le frais n'a pas pu être mis à jour");
        }
        return Controller::responseJson(200, "Le frais a correctement été mis à jour", $frais);
    }

    public function deleteMyFrais($id)
    {
        try {
            $frais = Frais::where('id', $id)->where('user_id', auth()->user()->id)->first();
        } catch (ModelNotFoundException $e) {
            return Controller::responseJson(404, "Le frais demandé n'existe pas ou ne vous appartient pas");
        }
        Storage::delete("public/images/".$frais->photo_url);
        $frais->delete();
        return Controller::responseJson(200, "Le frais a correctement été supprimé");
    }
}
