<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['libelle' , 'color'];
    protected $hidden=['created_at', 'updated_at'];
}
