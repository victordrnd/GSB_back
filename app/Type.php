<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = ['libelle'];
    protected $hidden =['created_at', 'updated_at'];
}
