<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//   return $request->user();
// });
Route::post('auth/signup',     'AuthController@signup');
Route::post('auth/login',      'AuthController@login');


 Route::group(['middleware' => 'jwt.verify'], function () {


  Route::get('/auth/current',  'AuthController@getCurrentUser');
  Route::get('/auth/permissions', 'AuthController@currentUserPermission');



  Route::group(['prefix' => 'users'], function () {
    Route::post('/', 'UserController@showAll')->middleware('can:users.view');
    Route::get('/{id}', 'UserController@find');
    //Route::post('/add', 'UserController@add')->middleware('can:users.create');
    Route::post('/{id}', 'UserController@update')->middleware('can:users.edit');
    Route::delete('/delete/{id}', 'UserController@delete')->middleware('can:users.delete');
  });


  Route::group(['prefix' => 'frais'], function(){
    Route::post('/', 'FraisController@getAll')->middleware('can:frais.view');
    Route::get('/show/{id}', 'FraisController@getFrais');
    Route::get('/my', 'FraisController@getMyFrais')->middleware('can:my.frais.view');
    Route::get('/my/count', 'FraisController@getCountByDate')->middleware('can:my.frais.view');
    Route::post('/my/update', 'FraisController@updateMyFrais')->middleware('can:my.frais.edit');
    Route::get('/my/delete/{id}', 'FraisController@deleteMyFrais')->middleware('can:my.frais.delete');
    Route::post('/create', 'FraisController@createFrais')->middleware('can:my.frais.create');
    Route::get('/stats',   'FraisController@stats');
    Route::get('/types/count', 'FraisController@groupByType');
    Route::get('/types',   'FraisController@getAllTypes');

    Route::post('/export',  'FraisController@export');
    Route::post('/update/status', 'FraisController@changeStatus');
  });

  Route::group(['prefix' => 'activity'], function(){
    Route::get('/', 'ActivityController@getAll');
  });

  Route::group(['prefix' => 'status'], function(){
    Route::get('/', 'StatusController@getAll');
  });

  Route::group(['prefix' => 'roles'], function () {
    Route::get('/', 'RoleController@getAllRoles');

    Route::post('/{id}/add',  'RoleController@addPermissionsToRole')->where('id', '[0-9]+');;
    Route::post('/{id}/remove',  'RoleController@removePermissionsToRole')->where('id', '[0-9]+');;
  });
});



