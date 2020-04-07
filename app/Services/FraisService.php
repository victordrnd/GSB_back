<?php

namespace App\Services;

use App\Frais;
use App\NotificationGroup;
use App\Type;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Storage;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class FraisService
{
    public static function getAll($req)
    {
        return Frais::search($req)->orderBy($req->order_by ?? "created_at", 'DESC')->get()->map->format();
    }

    public static function find($id)
    {
        return Frais::find($id)->format();
    }

    public static function create(Request $req)
    {
        $name = "";
        if ($req->input('photo', false)) {
            $name = 'frais-'.time().'.png';
            $test = Storage::disk('local')->put("public/images/$name", base64_decode($req->photo));
        }
        $frais = Frais::create([
                'montant' => $req->montant,
                'description' => $req->input('description'),
                'user_id' => auth()->user()->id,
                'type_id' => $req->type_id,
                'status_id' => 1,
                'photo_url' => $name
            ]);
        //Gestion des notifications
        $notificationBuilder = new PayloadNotificationBuilder('GSB : Nouvelle demande de frais');
        $text = auth()->user()->firstname . " ". auth()->user()->lastname." a réalisé une nouvelle demande de frais";
        $notificationBuilder->setBody($text)
                            ->setSound('default')
                            ->setClickAction("http://localhost:4200/frais/".$frais->id);
            
        $notification = $notificationBuilder->build();
        $group = NotificationGroup::find(1);
        FCM::sendToGroup($group->notification_key,null,$notification,null);
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

    public static function changeStatus(Request $req)
    {
        $frais = Frais::find($req->id)->update([
            'status_id' => $req->status_id,
            'validated_by' => auth()->user()->id
        ]);
        $frais = Frais::findOrFail($req->id);

        $option = (new OptionsBuilder())->build();
        $notificationBuilder = new PayloadNotificationBuilder('Votre frais a été '.$frais->status->libelle);
        $notificationBuilder->setBody(auth()->user()->firstname .' '. auth()->user()->lastname." a mis à jour le status de votre frais de ".$frais->type->libelle. " vers ".$frais->status->libelle)
                    ->setSound('default');

        $notification = $notificationBuilder->build();
        $token = $frais->user->fcm_token;
        $downstreamResponse = FCM::sendTo($token, $option, $notification);

        return $frais->format();
    }

    public static function deleteMyFrais($id)
    {
        $frais = Frais::where('id', $id)->where('user_id', auth()->user()->id)->firstOrFail();
        Storage::delete("public/images/".$frais->photo_url);
        Activity::where('subject_id', $id)->where('subject_type', Frais::class)->delete();
        $frais->delete();
    }

    public function export($from, $to, $user_id = false){

        $q = Frais::query();
        $q->where('created_at', '>=', $from)->where('created_at', '<=', $to)
                        ->where('status_id', 2);
        $q->when($user_id, function($q1) use ($user_id){
            $q1->where('user_id', $user_id);
        });
        $frais = $q->with('status', 'type', 'validator')->get();
        return $frais;
    }

    public static function stats()
    {
        $total = Frais::count();
        $done = Frais::select(DB::raw('count(*) as count'))->where('status_id', '!=', 1)->first();
        $stats = Frais::select('status_id', DB::raw('count(*) as count'))->with('status')->groupBy('status_id')->get();
        $period = CarbonPeriod::create(Carbon::now()->subMonths(3), Carbon::now());
        $count_by_date = [];
        foreach($period as $day){
            $count = Frais::where(\DB::raw('DATE(created_at)'), $day->format('Y-m-d'))
                ->first([DB::raw('COUNT(*) as "count"')])->count;
            $count_by_date[] = $count;
        }
        return [
            'total' => $total,
            'done' => $done->count,
            'percentage' => round(($done->count / ($total ?: 1)) * 100),
            'stats' => $stats,
            "by_date" => [
                'from' => Carbon::now()->subMonths(3)->format('Y-m-d'),
                'to' => Carbon::now()->format('Y-m-d'),
                'values' => $count_by_date
            ]
        ];
    }


    public static function groupByType(){
        return Type::all()->map(function($el) {
            return [
                'name' => $el->libelle,
                'value' => Frais::where('type_id', $el->id)->count()
            ];
        });
        
    }
}
