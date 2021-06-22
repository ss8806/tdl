<?php
Route::get('/', function () {
  return view('index');
});

Route::get('/todos', function () {
    return view('index');
})->middleware('auth');

Route::get('/mypage', function () {
  return view('index');
})->middleware('auth');

Route::get('/login', function () {
  return view('index');
})->name('login');

Route::get('/register', function () {
  return view('index');
});
Route::post('/register', 'Auth\RegisterController@register');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout');

// endpoint
//Route::post('/add', 'TodosController@add')->name('add')->middleware('auth');
//Route::post('/todos/destroy', 'TodoController@destoryTodo')->name('delete')->middleware('auth');