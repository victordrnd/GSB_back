<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Frais extends Model
{
    
    protected $fillable = ['montant', 'description', 'user_id', 'type_id', 'status_id', 'validated_by'];


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function type(){
        return $this->hasOne(Type::class);
    }

    public function status(){
        return $this->hasOne(Status::class);
    }
}
