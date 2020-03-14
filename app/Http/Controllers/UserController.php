<?php

namespace App\Http\Controllers;

use App\Activity;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
Use App\Services\UserService;
use App\Http\Resources\User as UserRessource;
use App\Role;

class UserController extends Controller
{

  /**
  * Return all users from users table
  * @return array
  */
  public function showAll(Request $req){
    $users = User::search($req)->with('role')->get();
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
  public function update($id,Request $request){
    //TODO : check if role_id change to add to fcm corresponding group and remove from old 
    try{
      $user = User::findOrFail($id);
    }
    catch(ModelNotFoundException $e){
      return JsonResponse::exception($e);
    }
    $user->fill($request->all());
    $user->save();
    return Controller::responseJson(200, "L'utilisateur a bien été mis à jour" , User::find($user->id));
  }




  /**
  * @param int $id
  * @return void
  */
  public function delete($id){
    $user = User::find($id);
    $user->activities()->delete();
    Activity::where('subject_id', $user->id)->where('subject_type', User::class)->delete();
    $user->frais()->delete();
    $user->groupes()->delete();
    $user->delete();
    return Controller::responseJson(200, "L'utilisateur a correctement été supprimé");
  }


  public function getAllRoles(){
    $roles = Role::all();
    return Controller::responseJson(200, "Les roles ont été retournés", $roles);
  }
}
