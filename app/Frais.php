<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Victordrnd\Activitylog\Traits\LogsActivity;
use Carbon\Carbon;
class Frais extends Model
{
    use LogsActivity;
    protected $fillable = ['montant', 'description', 'user_id', 'type_id', 'status_id', 'validated_by', 'photo_url'];
    protected static $logFillable = true;
    protected static $recordEvents = ['created', 'updated'];
    protected static $logName = 'system';
    protected static $ignoreChangedAttributes = ['montant', 'description', 'user_id', 'type_id', 'photo_url', 'updated_at'];
    
    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function type(){
        return $this->belongsTo(Type::class);
    }

    public function status(){
        return $this->belongsTo(Status::class);
    }

    public function validator(){
        return $this->belongsTo(User::class, 'validated_by');
    }

    public function format(){
        Carbon::setLocale('fr');
        return [
            'id' => $this->id,
            'montant' => $this->montant,
            'description' =>  $this->description,
            'photo_url' => $this->photo_url,
            'validated_by' => $this->validator,
            'user' => $this->user,
            'type' => $this->type,
            'status' => $this->status,
            'status_id' => $this->status->id,
            'created_at' => $this->created_at->toDateTimeString(),
            'last_update' => $this->created_at->diffForHumans()
        ];
    }
}
