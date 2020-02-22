<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Victordrnd\Activitylog\Traits\LogsActivity;

class User extends Authenticatable implements JWTSubject
{
  use Notifiable;
  use LogsActivity;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['firstname', 'lastname', 'email', 'password', 'phone', 'fcm_token','web_fcm_token', 'avatar', 'role_id'];

  protected $hidden = ['password'];
  protected static $logFillable = true;
  protected static $recordEvents = ['created'];
  protected static $logName = 'system';
  protected static $ignoreChangedAttributes = ['fistname', 'lastname', 'email', 'phone', 'fcm_token','web_fcm_token', 'avatar', 'role_id', 'updated_at'];



  public function frais()
  {
    return $this->hasMany(Frais::class);
  }

  public function role()
  {
    return $this->belongsTo(Role::class, 'role_id');
  }

  public function hasPermission($permission)
  {
    return $this->role->permissions->contains('slug', $permission);
  }





  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */


  public function getJWTIdentifier()
  {
    return $this->getKey();
  }


  public function getJWTCustomClaims()
  {
    return [];
  }
}
