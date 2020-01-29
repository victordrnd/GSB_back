<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
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
}
