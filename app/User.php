<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
  use Notifiable;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['firstname', 'lastname', 'email', 'password', 'phone', 'country'];

  protected $hidden = ['password'];




  public function frais(){
    return $this->hasMany(Frais::class);
  }

  public function roles(){
    return $this->belongsToMany(Role::class , 'user_role');
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
