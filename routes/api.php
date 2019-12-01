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

  Route::group(['prefix' => 'users'], function () {
    Route::get('/', 'UserController@showAll');
    Route::get('/{id}', 'UserController@get');
    Route::post('/add', 'UserController@add');
    Route::post('/update', 'UserController@update');
    Route::post('/delete/{id}', 'UserController@delete');
  });


  Route::group(['prefix' => 'frais'], function(){
    Route::get('/', 'FraisController@getAll');
    Route::get('/show/{id}', 'FraisController@getFrais');
    Route::get('/my', 'FraisController@getMyFrais');
    Route::get('/my/count', 'FraisController@getCountByDate');
    Route::post('/my/update', 'FraisController@updateMyFrais');
    Route::get('/my/delete/{id}', 'FraisController@deleteMyFrais');
    Route::post('/create', 'FraisController@createFrais');
  });
});



