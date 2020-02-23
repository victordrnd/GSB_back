<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\NotificationGroup;
use App\NotificationGroupMember;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
  public function login(Request $request)
  {
    $validator  = Validator::make($request->all(), [
      'email' => 'required|exists:users,email|email',
      'password' => 'required|string',
      'fcm_token' => 'sometimes|string'
    ]);
    if ($validator->fails()) {
      return Controller::responseJson(422, 'Une erreur est survenue', $validator->errors());
    }
    $credentials = $request->only(['email', 'password']);
    if (!$token = auth()->setTTL(525600)->attempt($credentials)) {
      return $this->responseJson(Controller::$HTTP_UNAUTHORIZED, 'Les identifiants sont incorrects');
    }
    if($request->has('fcm_token')){
      $user = User::where('email', $request->email)->first()->update([
        'fcm_token' => $request->fcm_token
      ]);
    }
    if($request->has('web_fcm_token') && $request->filled('web_fcm_token')){
      $user = User::where('email', $request->email)->first();
      if($user->web_fcm_token != $request->web_fcm_token){
        $user->web_fcm_token = $request->web_fcm_token;
        $user->save();
        $group = NotificationGroup::find(1);
        \FCMGroup::addToGroup($group->libelle, $group->notification_key, [$request->web_fcm_token]);
        NotificationGroupMember::create($group->id, $user->id);
      }
    }
    $user = User::where('id',auth()->user()->id)->first();
    $user['permissions'] = $user->role->permissions()->pluck('slug');
    unset($user['role']['permissions']);
    $data =  [
      'user' => $user,
      'token' => $token,
      'expire' => auth()->factory()->getTTL() * 60
    ];
    return $this->responseJson(200, 'Identifiants valides', $data);
  }


  public function signup(Request $request)
  {
    $validator  = Validator::make($request->all(), [
      'firstname' => 'required|string',
      'lastname' => 'required|string',
      'email' => 'required|unique:users,email|email',
      'password' => 'required|string',
      'phone' => 'string',
      'fcm_token' => 'sometimes|string'
    ]);
    if ($validator->fails()) {
      return Controller::responseJson(422, 'Certains champs sont manquants', $validator->errors());
    }
    $password = $request->password;
    $request->merge(['password' => Hash::make($password)]);
  
    $user = new User();
    $user->fill($request->all());
    $user->role_id = 1;
    $user->save();

    $credentials = [
      'email' => $request->email,
      'password' =>  $password
    ];
    if (!$token = auth()->setTTL(525600)->attempt($credentials)) {
      return $this->responseJson(Controller::$HTTP_NOK, 'Les identifiants sont incorrects');
    }
    
    $data =  [
      'user' => auth()->user(),
      'token' => $token,
    ];
    return $this->responseJson(Controller::$HTTP_OK, "L'enregistrement a réussi", $data);
  }


  public function getCurrentUser()
  {
    $data =  [
      'user' => auth()->user()
    ];
    return Controller::responseJson(200, "L'utilisateur a été retourné", $data);
  }
}
