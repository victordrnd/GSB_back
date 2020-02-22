<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationGroup extends Model
{
    protected $fillable = ['libelle', 'slug','notification_key'];
}
