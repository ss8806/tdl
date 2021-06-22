<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/mypage', 'Api\MypageController@index');
Route::middleware('auth:api')->post('/mypage/editName', 'Api\MypageController@editName');
Route::middleware('auth:api')->get('/todos', 'Api\TodoController@index');
Route::middleware('auth:api')->post('/todos', 'Api\TodoController@add');
Route::middleware('auth:api')->post('/todos/update', 'Api\TodoController@updateTodo');
Route::middleware('auth:api')->post('/todos/changeIcon', 'Api\TodoController@changeIcon');
Route::middleware('auth:api')->post('/todos/destroy', 'Api\TodoController@destroyTodo');


Route::group(['middleware' => ['api']], function () {
    
});