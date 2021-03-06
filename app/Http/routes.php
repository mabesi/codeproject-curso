<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('app');
});

Route::post('oauth/access_token',function(){
  return Response::json(Authorizer::issueAccessToken());
});

Route::group(['middleware' => 'oauth'], function(){

  Route::resource('client','ClientController',['except' => ['create','edit']]);

  Route::get('user/authenticated', 'UserController@authenticated');

  Route::get('project/{id}/file', 'ProjectFileController@index');
  Route::post('project/{id}/file', 'ProjectFileController@store');
  Route::get('project/{id}/file/{fileId}', 'ProjectFileController@show');
  Route::put('project/{id}/file/{fileId}', 'ProjectFileController@update');
  Route::delete('project/{id}/file/{fileId}', 'ProjectFileController@destroy');

  Route::get('project/{id}/note', 'ProjectNoteController@index');
  Route::post('project/{id}/note', 'ProjectNoteController@store');
  Route::get('project/{id}/note/{noteId}', 'ProjectNoteController@show');
  Route::put('project/{id}/note/{noteId}', 'ProjectNoteController@update');
  Route::delete('project/{id}/note/{noteId}', 'ProjectNoteController@destroy');

  Route::get('project/{id}/task', 'ProjectTaskController@index');
  Route::post('project/{id}/task', 'ProjectTaskController@store');
  Route::get('project/{id}/task/{taskId}', 'ProjectTaskController@show');
  Route::put('project/{id}/task/{taskId}', 'ProjectTaskController@update');
  Route::delete('project/{id}/task/{taskId}', 'ProjectTaskController@destroy');

  Route::get('project/{id}/member', 'ProjectController@showMembers');
  Route::get('project/{id}/member/{memberId}', 'ProjectController@showMember');
  Route::put('project/{id}/member/{memberId}', 'ProjectController@addMember');
  Route::delete('project/{id}/member/{memberId}', 'ProjectController@removeMember');

  Route::get('project', 'ProjectController@index');
  Route::post('project', 'ProjectController@store');
  Route::put('project/{id}', 'ProjectController@update');
  Route::get('project/{id}', 'ProjectController@show');
  Route::delete('project/{id}', 'ProjectController@destroy');

});
