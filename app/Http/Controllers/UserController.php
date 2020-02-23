<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
Use App\Services\UserService;
use App\Http\Resources\User as UserRessource;

class UserController extends Controller
{

  /**
  * Return all users from users table
  * @return array
  */
  public function showAll(){
    $users = User::with('role')->get();
    $users = UserRessource::collection($users);
    return Controller::responseJson(200, "Les utisateurs ont bien été retournés" , $users);
  }



  /**
  * Return user identified by $id
  * @param int $id
  * @return array
  */
  public function find($id){
    try{
      $user = User::findOrFail($id)->load('frais', 'activities');
      $user = new UserRessource($user);
    }catch(ModelNotFoundException $e){
      return Controller::responseJson(404, "L'utilisateur demandé n'existe pas", $e->getMessage());
    }
    return Controller::responseJson(200, "L'utilisateur a bien été retourné" , $user);
  }



  /**
  * update an existing user
  * @param int $id
  * @param string $firstname
  * @param string $lastname
  * @param string $email
  * @param date $birth_date
  * @return array
  */
  public function update(Request $request){
    //TODO : check if role_id change to add to fcm corresponding group and remove from old 
    try{
      $user = User::findOrFail($request->id);
    }
    catch(ModelNotFoundException $e){
      return JsonResponse::exception($e);
    }
    $user->update($request->all());
    return Controller::responseJson(200, "L'utilisateur a bien été mis à jour" , User::find($request->id));
  }




  /**
  * @param int $id
  * @return void
  */
  public function delete($id){
    User::destroy($id);
    return Controller::responseJson(200, "L'utilisateur a correctement été supprimé");
  }
}
