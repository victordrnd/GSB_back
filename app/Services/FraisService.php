<?php

namespace App\Services;

use App\Frais;
use Illuminate\Http\Request;

class FraisService
{
    public static function getAll()
    {
        return Frais::orderBy('created_at', 'DESC')->get()->map->format();
    }

    public static function find($id)
    {
        return Frais::where('id',$id)->first()->format();
    }

    public static function create(Request $req)
    {
        $name = "";
        if ($req->input('photo', false)) {
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
        return $frais;
    }

    public static function getMyFrais()
    {
        return Frais::where('user_id', auth()->user()->id)->with('type', 'status')->orderBy('created_at', 'desc')->get();
    }

    public static function getCountByDate()
    {
        return Frais::where('user_id', auth()->user()->id)
            ->groupBy(\DB::raw('DATE(created_at)'))
            ->orderBy('date', 'DESC')->get(array(
                \DB::raw('DATE(created_at) as date'),
                \DB::raw('COUNT(*) as count')
            ));
    }

    public static function updateMyFrais(Request $req)
    {
        Frais::where('id', $req->id)->where('user_id', auth()->user()->id)->first()->update($req->only('description', 'montant'));
        return Frais::where('id', $req->id)->where('user_id', auth()->user()->id)->with('type', 'status')->firstOrFail();
    }

    public static function changeStatus(Request $req){
        $frais = Frais::find($req->frais_id)->update([
            'status_id' => $req->status_id,
            'validated_by' => auth()->user()->id
        ]);

        return Frais::where('id', $req->frais_id)->with('type', 'status')->first();
    }

    public static function deleteMyFrais($id)
    {
        $frais = Frais::where('id', $id)->where('user_id', auth()->user()->id)->firstOrFail();
        Storage::delete("public/images/".$frais->photo_url);
        $frais->delete();
    }
}
